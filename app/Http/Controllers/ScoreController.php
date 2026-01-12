<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ScoreController extends Controller
{
    public function index(Request $request)
    {
        $result = null;
        // 1. Tangkap nama tim dari URL (misal: ?team=GARUDA)
        $selectedTeamName = $request->query('team'); 

        try {
            $response = Http::get('https://sheetdb.io/api/v1/0ylr577ytdtnt', [
                'sheet' => 'Total Poin'
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                if (!empty($data)) {
                    // 2. JIKA ada nama tim di URL, cari tim yang namanya sama
                    if ($selectedTeamName) {
                        $found = collect($data)->first(function ($item) use ($selectedTeamName) {
                            // Sesuaikan 'NAMA-TIM' dengan header kolom di Google Sheets Anda
                            return strtoupper(trim($item['NAMA-TIM'] ?? '')) === strtoupper(trim($selectedTeamName));
                        });

                        if ($found) {
                            $result = (object) $found;
                        }
                    } 
                    
                    // 3. JIKA tim tidak ditemukan atau tidak ada parameter ?team, 
                    // tampilkan data default (misalnya peringkat 1 atau baris pertama)
                    if (!$result) {
                        $result = (object) $data[0];
                    }
                }
            }
        } catch (\Exception $e) {
            logger("SheetDB Error: " . $e->getMessage());
        }

        return view('scoreboard', compact('result'));
    }
}