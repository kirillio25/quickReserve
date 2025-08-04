<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservationRequest;
use App\Models\Table;
use App\Models\Reservation;
use App\Services\ReservationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TableController extends Controller
{
    public function index()
    {
        return Table::all();
    }

    public function reserve(ReservationRequest $request, Table $table, ReservationService $service)
    {
        $service->reserve($table, $request->validated());
        return response()->json(['message' => "Table {$table->id} reserved"]);
    }
}
