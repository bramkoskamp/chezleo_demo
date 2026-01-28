@php use \Carbon\Carbon; $isMedewerker =Auth::user()->role_id == 3 || Auth::user()->role_id == 2; @endphp
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight pt-[0.5rem]">
                {{ __('Overzicht') }}
            </h2>

            @if(auth()->user()->role_id == 2 || auth()->user()->role_id == 3)
            <div class="w-1/3 flex justify-end gap-[1rem]">
                <div class="relative w-56">
                    <input type="text" id="search" class="w-full pl-10 pr-4 py-2 text-sm border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50 placeholder-gray-500" placeholder="Zoeken op naam...">
                    <i class="bi bi-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500"></i>
                </div>
            </div>
            @endif
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-[1.5rem] item">
            @if(session('success'))
            <div class="p-4 mb-6 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
            @elseif (session('error'))
            <div class="p-4 mb-6 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
            @endif

            @if ($isMedewerker)
            <h1 class="text-2xl font-semibold mx-4 mt-2">Huidige Reserveringen</h1>
            <h1 class="text-xl font-semibold mx-4 mt-1">Selecteer datum:</h1>
            <input type="date" name="datum" value="{{ request('datum', date('Y-m-d')) }}" class="border p-2 rounded-md mx-4">
            @php
            $dayOfWeek = date('N', strtotime(request('datum', date('Y-m-d'))));
            @endphp

            @if ($dayOfWeek == 1 || $dayOfWeek == 2)
            <div class="mx-4 mt-2 text-red-500 font-semibold">Het restaurant is gesloten op maandag en dinsdag.</div>
            @else
            <div class="overflow-x-auto">
                <table class="min-w-[100%] table-auto mt-3 align-center">
                    <thead>
                        <tr class="border-b bg-gray-100">
                            <th class="px-2 py-1 text-left text-xs">Tafel</th>
                            @foreach ($opening_hours as $opening_hour)
                            @if ($opening_hour->day_of_week == date('N', strtotime(request('datum', date('Y-m-d')))))
                            @for ($time = strtotime($opening_hour->open); $time <= strtotime($opening_hour->close); $time = strtotime('+30 minutes', $time))
                                <th class="px-2 py-1 text-center text-xs w-16">{{ date('H:i', $time) }}</th>
                                @endfor
                                @endif
                                @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tables as $table)
                        <tr class="border-b">
                            <td class="px-2 py-1 font-medium text-xs">{{ $table->id }}</td>
                            @foreach ($opening_hours as $opening_hour)
                            @if ($opening_hour->day_of_week == date('N', strtotime(request('datum', date('Y-m-d')))))
                            @for ($time = strtotime($opening_hour->open); $time <= strtotime($opening_hour->close); $time = strtotime('+30 minutes', $time))
                                @php check($table, $time, request('datum', date('Y-m-d'))); @endphp
                                @endfor
                                @endif
                                @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
            @else

            <h1 class=" text-2xl font-semibold mb-[1rem] mt-[1rem]">Reserveringen Gepland</h1>
            @if($reservations->where('reservation_date', '>=', Carbon::now()->format('Y-m-d'))->count() == 0)
            <div class="rounded-[10px] py-[1rem] px-[2rem] bg-white">
                <p class="opacity-50 text-[12px]">Er zijn geen aankomende reserveringen gevonden.</p>
            </div>
            @else
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="text-left bg-[#FEA116] text-white font-bold">
                            <th class="py-3 px-4 rounded-tl-[10px]">Naam</th>
                            <th class="py-3 px-4">Tafelnummer</th>
                            <th class="py-3 px-4">Datum</th>
                            <th class="py-3 px-4">Tijd</th>
                            <th class="py-3 px-4 rounded-tr-[10px]">Acties</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reservations as $reservation)
                        @if ($reservation->reservation_date >= Carbon::now()->format('Y-m-d'))
                        <tr class="border-t-[1px] border-[#f7f7f7] bg-white">
                            <td class="py-3 px-4">{{ $reservation->name }}</td>
                            <td class="py-3 px-4">{{ $reservation->dinner_table_id }}</td>
                            <td class="py-3 px-4">{{ Carbon::parse($reservation->reservation_date)->format('d-m-Y') }}</td>
                            <td class="py-3 px-4">{{ Carbon::parse($reservation->reservation_time)->format('H:i') }}</td>
                            @if (Carbon::parse($reservation->reservation_date . ' ' . $reservation->reservation_time)->diffInHours(Carbon::now()) <= 24)
                                <td class="text-red-500 pl-[1.4rem]">Bellen naar +31 (0) 6 12 34 56 78 voor wijzigingen.</td>
                                @else
                                <td class="py-3 px-4 flex justify-start align-center min-h-[57.5px]">
                                    <button onclick="openModal({{$reservation}})">
                                        <i class="bi bi-pencil text-[#FEA116] cursor-pointer"></i>
                                    </button>
                                    <form method="POST" class="flex align-center" action="/dashboard/delete/{{ $reservation->id }}" onsubmit="return confirmDelete()">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit">
                                            <i class="bi bi-trash ml-[1rem] text-red-500 cursor-pointer"></i>
                                        </button>
                                    </form>
                                </td>
                                @endif
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif

            <h1 class="text-2xl font-semibold mb-[1rem] mt-[3rem]">Reserveringsgeschiedenis</h1>
            @if($reservations->where('reservation_date', '<', Carbon::now()->format('Y-m-d'))->count() == 0)
                <div class="rounded-[10px] py-[1rem] px-[2rem] bg-white">
                    <p class="opacity-50 text-[12px]">Er kan geen reserveringsgeschiedenis gevonden worden.</p>
                </div>
                @else
                <div class="overflow-x-auto">
                    <table method="POST" class="min-w-full">
                        @csrf
                        <thead>
                            <tr class="text-left bg-[#FEA116] text-white font-bold">
                                <th class="py-3 px-4 rounded-tl-[10px]">Naam</th>
                                <th class="py-3 px-4">Tafelnummer</th>
                                <th class="py-3 px-4">Datum</th>
                                <th class="py-3 px-4 rounded-tr-[10px]">Tijd</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reservations as $reservation)
                            @if ($reservation->reservation_date < Carbon::now()->format('Y-m-d'))
                                <tr class="border-t-[1px] border-[#f7f7f7] bg-white">
                                    <td class="py-3 px-4">{{ $reservation->name }}</td>
                                    <td class="py-3 px-4">{{ $reservation->dinner_table_id }}</td>
                                    <td class="py-3 px-4">{{ Carbon::parse($reservation->reservation_date)->format('d-m-Y') }}</td>
                                    <td class="py-3 px-4">{{ Carbon::parse($reservation->reservation_time)->format('H:i') }}</td>
                                </tr>
                                @endif
                                @endforeach
                        </tbody>
                    </table>
                </div>
                    @endif
                    @endif
                </div>
        </div>

        <div id="reservationModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white w-1/3 rounded-[10px] p-[3rem]">
                <h2 class="text-xl font-bold mb-[2rem]">Reservering Bewerken</h2>
                <form id="reservationForm" method="POST" action="dashboard/update" class="space-y-4">
                    @csrf
                    <input type="hidden" name="id" id="reservationId">
                    <div class="flex flex-col gap-[0.5rem]">
                        <label>Datum</label>
                        <input
                            type="date"
                            name="date"
                            id="reservationDate"
                            class="bg-[#f7f7f7] rounded-[5px] py-[0.75rem] px-[1rem] border-none outline-none" />
                    </div>
                    <div class="flex flex-col gap-[0.5rem]">
                        <label>Tijd</label>
                        <input
                            type="time"
                            name="time"
                            id="reservationTime"
                            class="bg-[#f7f7f7] rounded-[5px] py-[0.75rem] px-[1rem] border-none outline-none" />
                    </div>
                    <div class="flex flex-col gap-[0.5rem] pb-[2rem]">
                        <label>Tafelnummer</label>
                        <select
                            name="table"
                            id="reservationTable"
                            class="bg-[#f7f7f7] rounded-[5px] py-[0.75rem] px-[1rem] border-none outline-none">
                            @foreach($tables as $table)
                            <option value="{{ $table->id }}">Tafel {{ $table->id }} ({{$table->seats}}-persoonstafel)</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex flex-col justify-center">
                        <button
                            type="submit"
                            class="px-[2rem] py-[0.75rem] font-bold bg-[#FEA116] text-white rounded-[5px]">
                            Aanpassingen opslaan
                        </button>
                        <button
                            type="button"
                            onclick="closeModal()"
                            class="mt-[1rem] text-red-500">
                            Annuleren
                        </button>
                    </div>
                </form>
            </div>
        </div>
</x-app-layout>

@php
use App\Models\Reservation;
function check($table, $time, $date) {
$reservations = Reservation::where('dinner_table_id', $table->id)->where('reservation_date', $date)->get();
$time = strtotime(date('H:i', $time));
foreach ($reservations as $reservation) {
$start = strtotime($reservation->reservation_time);
$end = strtotime('+3 hours', strtotime($reservation->reservation_time));
if ($time >= $start && $time < $end) {
    echo '<td class="bg-red-500 text-white w-16 h-8 text-center font-semibold text-xs relative" 
                data-tooltip="Reservering: ' . htmlspecialchars($reservation->name) . ' (' . date('H:i', $start) . ' - ' . date('H:i', $end) . ')">
    NB
    </td>';
    return;
    }
    }
    echo '<td class="bg-green-500 text-white w-16 h-8 text-center font-semibold text-xs">B</td>';
    }
    @endphp

    <script>
        let searchInput = $('#search');
        let items = $('.item');

        searchInput.on('input', function() {
            let searchText = searchInput.val().toLowerCase();
            let rowFound = false;

            items.find('table tbody tr').each(function() {
                let name = $(this).find('td:nth-child(1)').text().toLowerCase();
                name = name.trim();

                if (name.includes(searchText)) {
                    $(this).show();
                    rowFound = true;
                } else {
                    $(this).hide();
                }
            });

            if (rowFound) {
                $('#no-results-guests-sumup').hide();
                items.find('table').removeClass('hidden');
            } else {
                $('#no-results-guests-sumup').show();
                items.find('table').addClass('hidden');
            }
        });

        function confirmDelete() {
            return confirm('Weet je zeker dat je deze reservering wilt verwijderen?');
        }

        function openModal(reservation) {
            // Vul de formuliervelden in met de reserveringsgegevens
            document.getElementById('reservationId').value = reservation.id;
            document.getElementById('reservationDate').value = reservation.reservation_date;
            document.getElementById('reservationTime').value = reservation.reservation_time;
            document.getElementById('reservationTable').value = reservation.dinner_table_id;

            // Toon het modaal
            document.getElementById('reservationModal').classList.remove('hidden');
        }

        function closeModal() {
            // Verberg het modaal
            document.getElementById('reservationModal').classList.add('hidden');
        }

        if (document.querySelector('input[name="datum"]') != null) {
            document.querySelector('input[name="datum"]').addEventListener('change', function() {
                setTimeout(() => {
                    var date = document.querySelector('input[name="datum"]').value;
                    window.location.href = '?datum=' + date;
                }, 2500);
            });
        }
    </script>