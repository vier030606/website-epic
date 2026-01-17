<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ScoreController extends Controller
{
    // public function index(Request $request)
    // {
    //     $result = null;
    //     // 1. Tangkap nama tim dari URL (misal: ?team=GARUDA)
    //     $selectedTeamName = $request->query('team'); 

    //     try {
    //         $response = Http::get('https://sheetdb.io/api/v1/kpfuvg4jmwri7', [
    //             'sheet' => 'Total Poin'
    //         ]);

    //         if ($response->successful()) {
    //             $data = $response->json();
                
    //             if (!empty($data)) {
    //                 // 2. JIKA ada nama tim di URL, cari tim yang namanya sama
    //                 if ($selectedTeamName) {
    //                     $found = collect($data)->first(function ($item) use ($selectedTeamName) {
    //                         // Sesuaikan 'NAMA-TIM' dengan header kolom di Google Sheets Anda
    //                         return strtoupper(trim($item['KELOMPOK'] ?? '')) === strtoupper(trim($selectedTeamName));
    //                     });

    //                     if ($found) {
    //                         $result = (object) $found;
    //                     }
    //                 } 
                    
    //                 // 3. JIKA tim tidak ditemukan atau tidak ada parameter ?team, 
    //                 // tampilkan data default (misalnya peringkat 1 atau baris pertama)
    //                 if (!$result) {
    //                     $result = (object) $data[0];
    //                 }
    //             }
    //         }
    //     } catch (\Exception $e) {
    //         logger("SheetDB Error: " . $e->getMessage());
    //     }

    //     return view('scoreboard', compact('result'));
    // }

    public function index(Request $request)
{
    $result = null;
    // Get team name from URL or Session (if you followed the POST guide earlier)
    $teamName = $request->input('team') ?? session('current_team', 'GUEST'); 
    // dd($teamName);
    try {
        // $response = Http::get('https://sheetdb.io/api/v1/rlg5trqmknfs1', [
        //     'sheet' => 'REKAP ECT RALLY GAMES SEMENTARA'
        // ]);
        // $data = $response->json();
        //             file_put_contents(
        //                 storage_path('app/rally.json'),
        //                 json_encode($response->json(), JSON_PRETTY_PRINT)
        //             );
        $json = file_get_contents(storage_path('app/rally.json'));
        $data = json_decode($json, true);
          
           
            if (!empty($data)) {
                // Find the team in the 'KELOMPOK' column
                $found = collect($data)->first(function ($item) use ($teamName) {
                    return strtoupper(trim($item['KELOMPOK'] ?? '')) === strtoupper(trim($teamName));
                });

                if ($found) {
                    $result = (object) $found;
                } else {
                    // Fallback to the first row if team not found
                    $result = (object) $data[0];
                }
            }

    } catch (\Exception $e) {
        logger("SheetDB Error: " . $e->getMessage());
        // Minimal fallback to prevent crash
        $result = (object) ['POIN RALLY' => 0, 'RALLY TOTAL' => 0];
    }

    // Pass BOTH result and teamName to the view
    return view('scoreboard', [
        'result' => $result,
        'teamName' => $teamName
    ]);
}
}