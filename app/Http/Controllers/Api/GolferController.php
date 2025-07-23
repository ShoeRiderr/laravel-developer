<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GolferLatLonRequest;
use App\Http\Resources\GolferResource;
use App\Models\Golfer;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class GolferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(GolferLatLonRequest $request)
    {
        $lat = $request->query('lat');
        $lon = $request->query('lon');

        return GolferResource::collection(Golfer::closest($lat, $lon)->limit(500)->get());
    }

    public function downloadCsv(GolferLatLonRequest $request): StreamedResponse
    {
        $lat = $request->query('lat');
        $lon = $request->query('lon');

        $golfers = Golfer::closest($lat, $lon)
            ->limit(500)
            ->get();

        // This can go to a service class in the future
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="golfers.csv"',
        ];

        return response()->stream(function () use ($golfers) {
            $handle = fopen('php://output', 'w');

            // CSV headers
            fputcsv($handle, ['id', 'name', 'lat', 'lon', 'distance']);

            // CSV rows
            foreach ($golfers as $golfer) {
                fputcsv($handle, [
                    $golfer->id,
                    $golfer->name,
                    $golfer->lat,
                    $golfer->lon,
                    $golfer->distance ?? null,
                ]);
            }

            fclose($handle);
        }, 200, $headers);
    }
}
