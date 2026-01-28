<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\OpeningHour;
use App\Models\DinnerTable;
use Mailgun\Mailgun;

class ReservationController extends Controller
{
    /**
     * Show the reservation form (step 1).
     */
    public function getReservations()
    {
        $reservations = Reservation::all();
        $tables = DinnerTable::all();
        return view("reservations", compact("reservations", "tables"));
    }
    public function view()
    {
        $openingHours = OpeningHour::all();
        $reservations = Reservation::all();
        return view('reservering', compact('reservations', 'openingHours'));
    }

    public function show_reservations()
    {
        $reservations = Reservation::all();
        $opening_hours = OpeningHour::all();
        $tables = DinnerTable::all();
        return view('show_reservations', compact('reservations', 'opening_hours', 'tables'));
    }
    public function guest_reservations()
    {
        $tables = DinnerTable::all();
        $opening_hours = OpeningHour::all();
        if(auth()->user()->role_id == 2 || auth()->user()->role_id == 3)
        {
            $reservations = Reservation::all();
            return view('dashboard', compact('reservations', 'tables', 'opening_hours'));
        } else
        {
            $reservations = Reservation::where('email', auth()->user()->email)->get();
            return view('dashboard', compact('reservations', 'tables'));
        }
    }


    /**
     * Handle form submission for step 1 (persoongegevens).
     */
    public function step1(Request $request)
    {

        // Valideer de formuliergegevens
        $request->validate([
            'volledige_naam' => 'required|string|max:255',
            'email' => 'required|email',
            'telefoonnummer' => 'required|string|max:15',
            'aantal_gasten' => 'required|integer',
            'datum' => 'required|date|after_or_equal:today', 
            'tijd' => 'required|date_format:H:i',

        ]);


        // Zet de formuliergegevens in de sessie
        session([
            'reservation' => [
                'name' => $request->volledige_naam,
                'email' => $request->email,
                'phone' => $request->telefoonnummer,
                'number_of_guests' => $request->aantal_gasten,
                'reservation_date' => $request->datum,
                'reservation_time' => $request->tijd,
            ],
        ]);

        // Haal de gereserveerde tafels op voor de geselecteerde datum
        $reservedTableIds = Reservation::where('reservation_date', $request->datum)
        ->where(function ($query) use ($request) {
            $startTime = $request->tijd;
            $endTime = date('H:i', strtotime($startTime . ' +3 hours'));

        $query->where(function ($subQuery) use ($startTime, $endTime) {
            $subQuery->where('reservation_time', '<', $endTime) 
                ->whereRaw("DATE_ADD(reservation_time, INTERVAL 3 HOUR) > ?", [$startTime]); 
        });
    })
    ->pluck('dinner_table_id')
    ->toArray();

    $required_seats = ($request->aantal_gasten == 6) ? [6] 
    : (($request->aantal_gasten == 5) ? [5, 6] 
    : (($request->aantal_gasten == 3) ? [4]
    : (($request->aantal_gasten == 1) ? [2]
    : (($request->aantal_gasten < 3) ? [2, 4] : [4, 5, 6]))));

    //check if there is a table available for the amount of guests
    $availableTables = DinnerTable::whereNotIn('id', $reservedTableIds)
        ->whereIn('seats', $required_seats)
        ->get();

    if ($availableTables->isEmpty()) {
        return redirect()->back()->with('error', 'Er zijn geen beschikbare tafels voor deze datum en tijd.');
    }


        $tables = DinnerTable::all();

        // Zet de tafels en gereserveerde tafel-ID's in de sessie
        session([
            'tables' => $tables,
            'reservedTableIds' => $reservedTableIds,
            'required_seats' => $required_seats,
        ]);

        // Verplaats naar stap 2
        return redirect('/reservering')->with('step', 2);
    }


    /**
     * Handle form submission for step 2 (tafel selecteren).
     */
    public function step2(Request $request)
    {
        $request->validate([
            'tafel' => 'required|integer|min:1',
        ]);
        
        $reservation = session('reservation');
        
        if(Reservation::where('reservation_date', $reservation['reservation_date'])
            ->where('email', $reservation['email'])->first() != null){
            session()->forget('reservation');
            return redirect('/')->with('error','U kunt niet meer dan 1 reservering per dag maken');
        }

        $reservation['dinner_table_id'] = $request->tafel; // add table_id to the reservation
        session(['reservation' => $reservation]);

        $validatedReservation = [
            'name' => $reservation['name'],
            'email' => $reservation['email'],
            'phone' => $reservation['phone'],
            'number_of_guests' => intval($reservation['number_of_guests']),
            'reservation_date' => $reservation['reservation_date'],
            'reservation_time' => $reservation['reservation_time'],
            'dinner_table_id' => $reservation['dinner_table_id'],
        ];

  
        $mgClient = Mailgun::create(env('MAILGUN_SECRET'));
        // $recipient = $user->email;
        $recipient = 'bramkoskamp@gmail.com';
    
        $result = $mgClient->messages()->send(env('MAILGUN_DOMAIN'), [
            'from' => 'chezleo@gmail.com',
            'to' => $recipient,
            'subject' => 'Reservering Chezleo',
            'html' => view('email.email', ['reservering' => $validatedReservation])->render(),
        ]);
        
        Reservation::create($validatedReservation);

        session()->forget('reservation');

        

        if ($result != null) {
            return redirect('/')->with('success', 'Uw reservering is bevestigd!');
        } else {
            return redirect()->back()->with('error', 'Fout met het versturen van de email.');
        }


        
        // return redirect('/')->with('success', 'Uw reservering is bevestigd!');
    }
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:15',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required',
            'table' => 'required|integer|exists:dinner_tables,id',
        ]);
        $reservation = Reservation::findOrFail($request->id);
        $openingHours = OpeningHour::where('day_of_week', now()->parse($request->date)->dayOfWeek)->first();
        
        if (Reservation::where('dinner_table_id', $request->table)
            ->where('reservation_date', $request->date)
            ->where('id', '!=', $request->id)
            ->where(function ($query) use ($request) {
                $query->whereBetween('reservation_time', [
                    $request->time,
                    date('H:i', strtotime($request->time . ' +3 hours'))
                ])->orWhereBetween('reservation_time', [
                    date('H:i', strtotime($request->time . ' -3 hours')),
                    $request->time
                ]);
            })
            ->doesntExist() == false
        ) {
            return redirect()->back()->with('error', 'Deze tafel is al gereserveerd op de gekozen datum en tijd.');
        } else if (!$openingHours || $request->time < $openingHours->open || $request->time > $openingHours->close) // zet er " . ' -3 hours'" achter voor als de reservering 3 uur voor sluitingstijd moet gemaakt worden
        {
            return redirect()->back()->with('error', 'Het restaurant is gesloten op de gekozen datum en tijd.');
        } else {
                $reservation->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'reservation_date' => $request->date,
                    'reservation_time' => $request->time,
                    'dinner_table_id' => $request->table,
                ]);
                return redirect()->back()->with('success', 'Reservering details bijgewerkt!');
        }
    }
    public function editGuestReservation(Request $request)
    {
        $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required',
            'table' => 'required|integer|exists:dinner_tables,id',
        ]);

        $reservation = Reservation::findOrFail($request->id);
        $openingHours = OpeningHour::where('day_of_week', now()->parse($request->date)->dayOfWeek)->first();

            if(Reservation::where('dinner_table_id', $request->table)
            ->where('reservation_date', $request->date)
            ->where('id', '!=', $request->id)
            ->where(function ($query) use ($request)
             {
                $query->whereBetween('reservation_time', [
                    $request->time,
                    date( 'H:i', strtotime($request->time . ' +3 hours'))
                ])->orWhereBetween('reservation_time', [
                    date( 'H:i', strtotime($request->time . ' -3 hours')),
                    $request->time
                ]);
            })
            ->doesntExist() == false)
            {
                return redirect()->back()->with('error', 'Deze tafel is al gereserveerd op de gekozen datum en tijd.');
            } else if (!$openingHours || $request->time < $openingHours->open || $request->time > $openingHours->close) // zet er " . ' -3 hours'" achter voor als de reservering 3 uur voor sluitingstijd moet gemaakt worden
            {
                return redirect()->back()->with('error', 'Het restaurant is gesloten op de gekozen datum en tijd.');
            } else {
                $reservation->update([
                    'reservation_date' => $request->date,
                    'reservation_time' => $request->time,
                    'dinner_table_id' => $request->table,
                ]);
                return redirect()->back()->with('success', 'Reservering details bijgewerkt!');
            }

    }
    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();
        return redirect()->back()->with('success', 'Reservering is succesvol verwijderd!');
    }
}
