<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\Receipt;
use App\Models\Reservation;

use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReceiptController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reserveringen = Reservation::all();
        $orders = Order::all();

        $betaaldeReserveringen = $reserveringen->filter(function($reservering) {
            return $reservering->is_payed == 'Paid';
        });
        
        $onbetaaldeReserveringen = $reserveringen->filter(function($reservering) {
            return $reservering->is_payed == 'Open';
        });

        return view('receipt/receipt_overlay', compact('reserveringen', 'orders', 'betaaldeReserveringen', 'onbetaaldeReserveringen'));
    }

    public function downloadReceipt(Order $order, Reservation $reservation)
    {

        $orders = Order::all();

        foreach($orders as $order)
        {
            $order = Order::where('table_number', $reservation->dinner_table_id)
                    ->whereDate('created_at', $reservation->reservation_date)
                    ->whereTime('created_at','>=', $reservation->reservation_time)
                    ->whereTime('created_at', '<=', Carbon::parse($reservation->reservation_time)->addHours(3))
                    ->get();
        }
        
        $reservering = Reservation::where('id', $reservation->id)->first();

        $pdf = Pdf::loadView('receipt\order', [
                'orders' => $order,
                'reservering' => $reservering    
        ]);

        // download van de pdf
        // return $pdf->download("order-receipt-{$order->id}.pdf");

        // het laten zien van de pdf
        return $pdf->stream("order-receipt-{$reservation->id}.pdf");

    }

    public function checkout(Request $request, Reservation $reservation)
    {
        if ($reservation->is_payed == 'Paid') {
            return back()->with('error', 'Deze reservering is al betaald.');
        }

        $reservation->is_payed = 'Paid';
        $reservation->save();
    
        return back()->with('success', 'De reservering is succesvol betaald.');
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
    public function show(Receipt $receipt)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Receipt $receipt)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Receipt $receipt)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Receipt $receipt)
    {
        //
    }
}
