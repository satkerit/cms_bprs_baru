<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class PrayerTimeController extends Controller
{
    /**
     * Get prayer times for a specific location
     */
    public function getPrayerTimes(Request $request)
    {
        $latitude = $request->input('latitude', -6.2088);
        $longitude = $request->input('longitude', 106.8456);
        $method = $request->input('method', 2);

        if (!is_numeric($latitude) || $latitude < -90 || $latitude > 90) {
            return response()->json(['success' => false, 'message' => 'Invalid latitude'], 422);
        }
        if (!is_numeric($longitude) || $longitude < -180 || $longitude > 180) {
            return response()->json(['success' => false, 'message' => 'Invalid longitude'], 422);
        }

        $cacheKey = "prayer_times_{$latitude}_{$longitude}_" . date('Y-m-d');
        
        $prayerTimes = Cache::remember($cacheKey, 86400, function () use ($latitude, $longitude, $method) {
            try {
                $response = Http::timeout(10)->get('https://api.aladhan.com/v1/timings', [
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'method' => $method,
                    'timestamp' => time(),
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    return [
                        'success' => true,
                        'timings' => $data['data']['timings'] ?? [],
                        'date' => $data['data']['date'] ?? [],
                    ];
                }

                return ['success' => false, 'message' => 'Failed to fetch prayer times'];
            } catch (\Exception $e) {
                return ['success' => false, 'message' => $e->getMessage()];
            }
        });

        return response()->json($prayerTimes);
    }
}
