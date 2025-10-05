<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReservationRequest;
use App\Models\Table;
use App\Services\Admin\TableClosedService;
use App\Services\Client\TableReservationService;

class TableReservationController extends Controller
{
    public function index()
    {
        return Table::all();
    }

    public function reserve(ReservationRequest $request, Table $table, TableReservationService $service)
    {
        $service->reserve($table, $request->validated());

        return response()->json([
            'message' => "Столик {$table->id} забронирован администратором",
        ]);
    }

    public function close(Table $table, TableClosedService $service)
    {
        $service->close($table);

        return response()->json([
            'message' => "Столик {$table->id} закрыт",
        ]);
    }

    public function cancel(Table $table, TableClosedService $service)
    {
        $service->cancel($table);

        return response()->json([
            'message' => "Столик {$table->id} отменен",
        ]);
    }
}
