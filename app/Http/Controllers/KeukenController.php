<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Keuken;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class KeukenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::where('status', 'Pending')
        ->whereDate('created_at', Carbon::today())
        ->get();
    
        $ordersDone = Order::where('status', 'Completed')
        ->whereDate('created_at', Carbon::today())
        ->get();
    
        // Geef de bestellingen door aan de view
        return view('keuken', compact('orders', 'ordersDone'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Keuken $keuken)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Keuken $keuken)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Keuken $keuken)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Keuken $keuken)
    {
        //
    }

    public function markOrderAsCompleted(Request $request)
    {
        $request->validate([
            'order_id' => 'required|integer|exists:orders,id',
        ]);

        $order = Order::find($request->order_id);

        if ($order) {
            $order->status = 'Completed';
            $order->save();

            return response()->json(['success' => true, 'message' => 'Bestelling gemarkeerd als klaar.']);
        }

        return response()->json(['success' => false, 'message' => 'Geen bestelling gevonden...'], 404);
    }
}
