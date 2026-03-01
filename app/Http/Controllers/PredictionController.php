<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PredictionController extends Controller
{
    public function predict(Request $request)
    {
        $validated = $request->validate([
            'features' => ['required', 'array', 'min:1'],
            'features.*' => ['numeric'],
        ]);

        $mlUrl = rtrim(config('services.ml.url'), '/');

        $resp = Http::timeout(5)->post($mlUrl . '/predict', $validated);

        if (!$resp->successful()) {
            return response()->json([
                'error' => 'ML service failed',
                'details' => $resp->json(),
            ], 502);
        }

        return response()->json($resp->json());
    }
}
?>
