<?php

namespace App\Http\Controllers;

use App\Models\VisitorCount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VisitorCountController extends Controller
{
    public function incrementCount(Request $request)
    {
        try {
            // ĐƠN GIẢN: Dùng session thay cookie
            if (!$request->session()->has('visited')) {
                $today = now()->format('Y-m-d');

                // CÁCH ĐƠN GIẢN NHẤT - không dùng DB::raw
                $existing = VisitorCount::where('date', $today)->first();

                if ($existing) {
                    // Tăng count lên 1
                    $existing->update([
                        'count' => $existing->count + 1
                    ]);
                } else {
                    // Tạo mới
                    VisitorCount::create([
                        'date' => $today,
                        'count' => 1
                    ]);
                }

                $request->session()->put('visited', true);

                return response()->json([
                    'success' => true,
                    'action' => 'counted'
                ]);
            }

            return response()->json([
                'success' => true,
                'action' => 'already_counted'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Server error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getTodayCount()
    {
        try {
            $today = now()->format('Y-m-d');
            $todayRecord = VisitorCount::where('date', $today)->first();
            $totalCount = VisitorCount::sum('count');

            return response()->json([
                'today_count' => $todayRecord ? $todayRecord->count : 0,
                'total_count' => $totalCount ?: 0
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'today_count' => 0,
                'total_count' => 0
            ]);
        }
    }
}
