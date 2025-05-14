<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class ScoreController extends Controller
{
    // 1. Check score by registration number
    public function check(Request $request)
    {
        $request->validate([
            'sbd' => 'required|string|max:20'
        ]);

        $score = DB::table('scores')
            ->where('sbd', $request->sbd)
            ->first();

        return response()->json($score ?? ['message' => 'Not found'], $score ? 200 : 404);
    }

    // 2. Get statistics of score levels by subject
    public function levelStats()
    {
        $data = DB::table('scores')->selectRaw("
            SUM(CASE WHEN toan >= 8 THEN 1 ELSE 0 END) AS toan_8_up,
            SUM(CASE WHEN toan >= 6 AND toan < 8 THEN 1 ELSE 0 END) AS toan_6_8,
            SUM(CASE WHEN toan >= 4 AND toan < 6 THEN 1 ELSE 0 END) AS toan_4_6,
            SUM(CASE WHEN toan < 4 THEN 1 ELSE 0 END) AS toan_under_4,

            SUM(CASE WHEN vat_li >= 8 THEN 1 ELSE 0 END) AS ly_8_up,
            SUM(CASE WHEN vat_li >= 6 AND vat_li < 8 THEN 1 ELSE 0 END) AS ly_6_8,
            SUM(CASE WHEN vat_li >= 4 AND vat_li < 6 THEN 1 ELSE 0 END) AS ly_4_6,
            SUM(CASE WHEN vat_li < 4 THEN 1 ELSE 0 END) AS ly_under_4,

            SUM(CASE WHEN hoa_hoc >= 8 THEN 1 ELSE 0 END) AS hoa_8_up,
            SUM(CASE WHEN hoa_hoc >= 6 AND hoa_hoc < 8 THEN 1 ELSE 0 END) AS hoa_6_8,
            SUM(CASE WHEN hoa_hoc >= 4 AND hoa_hoc < 6 THEN 1 ELSE 0 END) AS hoa_4_6,
            SUM(CASE WHEN hoa_hoc < 4 THEN 1 ELSE 0 END) AS hoa_under_4
        ")->first();

        return response()->json($data);
    }

    // 3. Get top 10 students from Group A (Toán + Lý + Hóa)
    public function topGroupA()
    {
        $topStudents = DB::table('scores')
            ->select(
                'sbd',
                'toan',
                'vat_li',
                'hoa_hoc',
                DB::raw('(toan + vat_li + hoa_hoc) AS tong_diem')
            )
            ->whereNotNull('toan')
            ->whereNotNull('vat_li')
            ->whereNotNull('hoa_hoc')
            ->orderByDesc('tong_diem')
            ->limit(10)
            ->get();

        return response()->json($topStudents);
    }
}
