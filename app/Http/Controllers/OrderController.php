<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Status;
use App\Models\DinnerTable;
use App\Models\Menu;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = \App\Models\Order::all();
        $menus = \App\Models\Menu::all();
        $tables = \App\Models\DinnerTable::all();
        $statuses = \App\Models\Status::all();

        return view('orders.index', compact('orders', 'menus', 'tables', 'statuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tables = DinnerTable::all();
        $menus = Menu::all();

        // Debug output
        dd($tables); // Dit toont de inhoud van $tables in de browser
    
        return view('orders.create', compact('tables', 'menus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    Log::info('Bestelling ontvangen:', $request->all());

    $validator = Validator::make($request->all(), [
        'table_number' => 'required|integer|exists:dinner_tables,id',
        'items' => 'array|min:1',
        'items.*.id' => 'required|integer|exists:menus,id',
        'items.*.name' => 'required|string',
        'items.*.price' => 'required|numeric|min:0',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => 'Validatie mislukt.',
            'errors' => $validator->errors(),
        ], 422);
    }

    try {
        // Converteer items naar een leesbare tekstweergave
        $formattedItems = collect($request->items)
            ->map(function ($item) {
                return "{$item['name']} (" . number_format($item['price'], 2) . ")";
            })
            ->implode(', ');

        // Bestelling opslaan
        $order = new Order();
        $order->table_number = $request->table_number;
        $order->items = $formattedItems;
        $order->status = 'Pending'; 
        $order->save();

        return response()->json([
            'success' => true,
            'message' => 'Bestelling succesvol opgeslagen!',
            'order_id' => $order->id,
            'items' => $order->items,
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Er is iets misgegaan bij het opslaan van de bestelling.',
            'error' => $e->getMessage(),
        ], 500);
    }
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $orders = \App\Models\Order::findOrFail($id); // Directly use findOrFail on the model
        $statuses = \App\Models\Status::all();
    
        return view('orders.edit', compact('orders', 'statuses'));
    }
        

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $orders = \App\Models\Order::findOrFail($id);
        $statuses = \App\Models\Status::all();

        $validated = $request->validate([
            'status' => 'required|in:pending,preparing,ready,served',
        ]); 

        $orders->update($validated);

        return redirect()->route('orders.index')->with('success', 'Status succesvol bijgewerkt!');
    }

    /**
     * Remove the specified resource from storage.
     */

     public function destroy($id)
     {
         $order = Order::findOrFail($id);
         $order->delete(); 
     
         return redirect()->route('orders.index')->with('success', 'Order deleted successfully');
     }     
}
