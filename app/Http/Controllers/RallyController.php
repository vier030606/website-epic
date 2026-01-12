<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;

class RallyController extends Controller 
{
    // URL Google Sheets CSV
    private $csvUrl = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vSxOPMetp-uBxegf-4cbeGMJarl5kyukltpEqXC_YNMLvoJ3Rwm3bHCR0CBQ8EvPPsHX6ALANW8TOjo/pub?gid=1268112569&single=true&output=csv';

    public function index()
    {
       
        // Fetch the teams using your existing logic
        $allTeams = $this->getTeamData();
        
        // Extract only the display names
        $teamNames = array_values(array_map(function ($team) {
            return $team['display_name'];
        }, $allTeams));

        // Pass them to the view 'rally'
        return view('rally', compact('teamNames'));
    }

    private function getTeamData()
    {
        // Cache selama 1 jam
    
        //return Cache::remember('rally_code_data', 3600, function () {
            try {
                
                $response = Http::timeout(10)->get($this->csvUrl);

                if ($response->successful()) {
                    $csvData = $response->body();
                    $rows = array_map('str_getcsv', explode("\n", $csvData));

                    // Filter baris kosong
                    $rows = array_filter($rows, function ($row) {
                        return count($row) >= 2 && trim(implode('', $row)) !== '';
                    });

                    $header = array_map('trim', array_shift($rows));
                    
                    $teamData = [];
                    foreach ($rows as $row) {
                        
                        if (count($row) >= count($header)) {
                            $item = array_combine($header, array_slice($row, 0, count($header)));

                            // Ambil kolom berdasarkan header baru
                            $originalTeamName = trim($item['NAMA KELOMPOK'] ?? '');
                            $normalizedTeamName = strtoupper($originalTeamName);
                            
                            // MEMBERSIHKAN PASSWORD: Hapus simbol '•' dan spasi agar hanya tersisa angka
                            $rawPassword = $item['PASSWORD'] ?? '';
                            $cleanPassword = preg_replace('/[^0-9]/', '', $rawPassword);

                            if ($originalTeamName && $cleanPassword) {
                                $teamData[$normalizedTeamName] = [
                                    'display_name' => $originalTeamName,
                                    'code' => $cleanPassword
                                ];
                            }
                        }
                    }
                    return $teamData;
                }
            } catch (\Exception $e) {
                logger()->error("Failed to load team data: " . $e->getMessage());
            }

            return [];
       // });
    }

    public function checkCode(Request $request)
    {
        // VALIDASI: Sekarang hanya menerima 5 digit angka
        $request->validate([
            'team_name' => 'required|string',
            'code_input' => ['required', 'regex:/^[0-9]{5}$/'], 
        ]);

        $teamNameNormalized = strtoupper(trim($request->team_name));
        $codeInput = trim($request->code_input);

        $allTeams = $this->getTeamData();
        $team = $allTeams[$teamNameNormalized] ?? null;

        if (!$team) {
            return response()->json([
                'success' => false,
                'message' => 'Team not found.'
            ], 404);
        }

        $correctCode = $team['code'];

        if ($correctCode === $codeInput) {
            return response()->json([
                'success' => true,
                'message' => 'Code Verified Successfully!',
                'team' => $team['display_name']
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Incorrect Code.',
            'correct_code' => $correctCode // Tetap dikirim untuk handle FE jika perlu
        ], 401);
    }

    public function getTeamNames()
{
    $allTeams = $this->getTeamData();

    if (empty($allTeams)) {
        return response()->json([]); // Kembalikan array kosong, jangan 503 agar JS tidak error
    }

    // Ambil hanya display_name dan pastikan index-nya numerik
    $teamNames = array_values(array_map(function ($team) {
        return $team['display_name'];
    }, $allTeams));

    return response()->json($teamNames);
}
}