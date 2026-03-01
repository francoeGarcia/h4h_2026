<?php
use App\Http\Controllers\PredictionController;

Route::middleware('auth:sanctum')->post('/predict', [PredictionController::class, 'predict']);
?>
