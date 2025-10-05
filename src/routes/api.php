    <?php

    use App\Http\Controllers\Admin\TableReservationController;
    use App\Http\Controllers\TableController;
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\Admin\AuthController;

    Route::get('tables', [TableController::class, 'index'])->name('tables.index');
    Route::post('/tables/{table}/reserve', [TableController::class, 'reserve']);

    Route::prefix('admin')->group(function () {
        Route::post('/login', [AuthController::class, 'login'])->name('login');

        Route::middleware('auth:sanctum')->group(function () {
            Route::post('/logout', [AuthController::class, 'logout']);
            Route::get('/user', [AuthController::class, 'user']);
            Route::post('/tables/{table}/close', [TableReservationController::class, 'close']);
            Route::post('/tables/{table}/cancel', [TableReservationController::class, 'cancel']);
            Route::post('/tables/{table}/reserve', [TableReservationController::class, 'reserve']);
            Route::get('/', [TableReservationController::class, 'index']);
        });
    });
