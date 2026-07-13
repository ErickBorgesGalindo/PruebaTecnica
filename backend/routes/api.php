<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\AuditLogController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/forgot-password', [AuthController::class, 'forgotPassword']);

Route::get('/health', function () {
    try {
        \MongoDB\Laravel\Connection::getDefaultConnection();
        $db = \DB::connection('mongodb')->getMongoDB();
        $db->selectCollection('users')->countDocuments();
        return response()->json(['status' => 'ok', 'mongodb' => 'connected']);
    } catch (\Exception $e) {
        return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
    }
});

Route::middleware('auth:api')->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/me', [AuthController::class, 'me']);

    Route::apiResource('products', ProductController::class);
    Route::apiResource('users', UserController::class);
    Route::apiResource('profiles', ProfileController::class);

    Route::get('/users/{id}/profiles', [UserProfileController::class, 'userProfiles']);
    Route::apiResource('user-profiles', UserProfileController::class)->only(['index', 'store', 'destroy']);

    Route::get('/audit-logs', [AuditLogController::class, 'index']);
});

Route::get('/export/products/pdf', [ExportController::class, 'productsPdf']);
Route::get('/export/products/excel', [ExportController::class, 'productsExcel']);
Route::get('/export/users/pdf', [ExportController::class, 'usersPdf']);
Route::get('/export/users/excel', [ExportController::class, 'usersExcel']);
Route::get('/export/profiles/pdf', [ExportController::class, 'profilesPdf']);
Route::get('/export/profiles/excel', [ExportController::class, 'profilesExcel']);