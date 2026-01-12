<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException; // Import Exception untuk timeout

class EscapeRoomController extends Controller
{

    private $csvUrl;

    public function __construct()
    {
        $this->csvUrl = env('ESCAPE_ROOM_CSV_URL');
    }
    // URL Google Sheets
    //private $csvUrl = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vRg0QkYlakL9LjHs2rd6LTy0v4MQzHz-czKvHQbYZ66vOG-j9sN1fXaRCEbwW4D2ANlXVzzTowNTVV8/pub?gid=0&single=true&output=csv';



    public function index()
    {
        return view('escape-room');
    }

    /**
     * Mengambil dan memproses data dari Google Sheets, menggunakan caching.
     * Data hanya diunduh jika tidak ada di cache (misal 1 jam).
     */
    private function getTeamData()
    {
        // Gunakan cache untuk menyimpan data selama 60 menit (3600 detik)
        return Cache::remember('escape_room_codes', 3600, function () {
            try {
                // Perkuat timeout client HTTP (misal 10 detik)
                $response = Http::timeout(10)->get($this->csvUrl);

                // Cek status keberhasilan HTTP dan kegagalan klien
                if ($response->successful()) {
                    $csvData = $response->body();
                    $rows = array_map('str_getcsv', explode("\n", $csvData));

                    // Filter baris kosong dan ambil header
                    $rows = array_filter($rows, function ($row) {
                        return count($row) > 1 && trim(implode('', $row)) !== '';
                    });
                    $header = array_map('trim', array_shift($rows));

                    $teamData = [];
                    foreach ($rows as $row) {
                        if (count($row) === count($header)) {
                            $item = array_combine($header, $row);

                            // Normalisasi data: uppercase dan trim
                            $originalTeamName = trim($item['NAMA-TIM'] ?? '');
                            $normalizedTeamName = strtoupper($originalTeamName);
                            $escapeCode = strtoupper(trim($item['ESCAPE-CODE'] ?? ''));

                            if ($originalTeamName && $escapeCode) {
                                $teamData[$normalizedTeamName] = [
                                    'display_name' => $originalTeamName,
                                    'code' => $escapeCode
                                ];
                            }
                        }
                    }
                    return $teamData;
                }

                // Jika respons HTTP tidak sukses (misal 404, 500), log error
                logger()->error("Failed to load team data from Google Sheets. HTTP Status: " . $response->status());

            } catch (ConnectionException $e) {
                // Tangani khusus jika terjadi timeout saat koneksi
                logger()->error("Connection timeout when accessing Google Sheets: " . $e->getMessage());
            } catch (\Exception $e) {
                // Tangani error umum lainnya
                logger()->error("Failed to load team data from Google Sheets: " . $e->getMessage());
            }

            return []; // Kembalikan array kosong jika terjadi kegagalan
        });
    }


    /**
     * Endpoint API untuk validasi kode (dipanggil oleh JavaScript).
     */
    public function checkCode(Request $request)
    {
        $request->validate([
            'team_name' => 'required|string',
            'code_input' => ['required', 'regex:/^[A-Z]{5}$/'],
        ]);

        $teamNameNormalized = strtoupper(trim($request->team_name));
        $codeInput = strtoupper(trim($request->code_input));

        $allTeams = $this->getTeamData();
        $team = $allTeams[$teamNameNormalized] ?? null;

        // Jika team tidak ditemukan
        if (!$team) {
            return response()->json([
                'success' => false,
                'message' => 'Incorrect Team or Code.',
                'correct_code' => null
            ], 401);
        }

        $correctCode = $team['code'];

        // Jika benar
        if ($correctCode === $codeInput) {
            return response()->json([
                'success' => true,
                'message' => 'Code Verified Successfully!',
                'correct_code' => $correctCode
            ]);
        }

        // Jika salah → tetap kirim correct_code agar FE bisa warnai per digit
        return response()->json([
            'success' => false,
            'message' => 'Incorrect Team or Code.',
            'correct_code' => $correctCode
        ], 401);
    }

    /**
     * Endpoint API untuk mendapatkan hanya daftar nama tim (untuk Autocomplete).
     */
    public function getTeamNames()
    {
        $allTeams = $this->getTeamData();

        if (empty($allTeams)) {
            // Jika data kosong karena kegagalan pengambilan data (timeout/error)
            return response()->json(['message' => 'Gagal memuat data tim dari sumber eksternal.'], 503); // Service Unavailable
        }

        $teamNames = array_map(function ($team) {
            return $team['display_name'];
        }, $allTeams);

        return response()->json(array_values($teamNames));
    }
}
