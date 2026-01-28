@php use Carbon\Carbon; @endphp
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight pt-[0.5rem]">
                {{ __('Bonnen/rekeningen') }}
            </h2>

            <div class="w-1/2 lg:w-1/3 flex justify-end gap-[1rem]">
                <div class="relative">
                    <input type="text" id="search" class="w-full pl-10 pr-4 py-2 text-sm border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50 placeholder-gray-500" placeholder="Zoeken op naam...">
                    <i class="bi bi-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500"></i>
                </div>
                <input id="datepicker" type="date" class="relative w-32 px-3 py-1.5 text-sm border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50 placeholder-gray-500" placeholder="Zoeken op datum...">
            </div>
        </div>
    </x-slot>
    <div class="flex flex-wrap gap-[1rem]">
        <div class="py-10 lg:w-1/3 w-full mx-auto flex flex-col">
            <h2 class="text-xl text-gray-800 leading-tight font-bold mb-[2rem] ms-[1rem]">Onbetaalde Rekeningen</h2>
            <div class="flex flex-wrap gap-[1rem] item-container">
                @foreach($onbetaaldeReserveringen as $reservering)

                <div>
                    <div class="flex gap-6 flex-wrap item-container">

                        @php
                        $reservationStart = Carbon::parse($reservering->reservation_date . ' ' . $reservering->reservation_time);

                        $reservationEnd = $reservationStart->copy()->addHours(3);

                        $isPayed = $reservering->is_payed;

                        $reservationOrders = $orders->filter(function($order) use ($reservering, $reservationStart, $reservationEnd) {

                        $orderTime = Carbon::parse($order->created_at);

                        return $order->table_number == $reservering->dinner_table_id &&
                        $orderTime->between($reservationStart, $reservationEnd);

                        });
                        @endphp
                        <div class="bg-white rounded-[10px] p-[2rem] min-w-72 item {{ ($reservationOrders->isNotEmpty() ? '' : 'hidden') }}" data-date="{{$reservering->reservation_date}}">
                            <!-- Header -->
                            <div class="text-center border-b pb-2">
                                <h1 class="text-1xl font-bold text-gray-700">Chez Léo</h1>
                                <p class="text-gray-500">Restaurant Bon</p>
                                <p class="font-bold text-1xl text-[#FEA116]">Tafel {{$reservering->dinner_table_id}}
                                    @php
                                    $reservationEndTime = \Carbon\Carbon::parse($reservering->reservation_time)->addHours(3);
                                    $isReservationOver = $reservationEndTime->isPast();
                                    @endphp

                                    @if ($isReservationOver || $isPayed == 'Paid')
                                    <a href="{{ route('receipt.download', $reservering->id)}}"><i class="bi bi-download"></i></a>
                                    @endif
                                </p>
                            </div>

                            <!-- Customer Details -->
                            <div class="my-[1rem] name_container">
                                <p class="text-gray-600 name"><span class="font-semibold">Naam:</span> {{$reservering->name}} </p>
                                <p class="text-gray-600"><span class="font-semibold">E-mail:</span> {{$reservering->email}} </p>
                                <p class="text-gray-600"><span class="font-semibold">Datum:</span> {{Carbon::parse($reservering->reservation_date)->format('d-m-y')}} <span class="underline">{{Carbon::parse($reservering->reservation_time)->format('H:i')}}&nbsp;</span></p>
                            </div>

                            <!-- Products -->
                            <div class="mt-6">
                                <h2 class="text-md font-semibold text-gray-700 border-b pb-2">Bestelling</h2>
                                <ul class="divide-y divide-gray-200 mt-2">
                                    @php $totalPrice = 0;
                                    $groupedItems = [];
                                    @endphp

                                    @foreach($orders as $order)
                                    @if($order->table_number == $reservering->dinner_table_id)
                                    @php
                                    $groupedItems = [];
                                    foreach (explode(',', $order->items) as $item) {

                                    preg_match('/^(.*)\s\(([\d.]+)\)$/', trim($item), $matches); //Regex om de naam en prijs van het item te scheiden door () tekens
                                    $name = $matches[1] ?? $item; // Naam van het item
                                    $price = $matches[2] ?? 0; // Prijs van het item

                                    if (!isset($groupedItems[$name])) { //kijkt of er al een item met dezelfde naam is zo niet word het toegevoegd
                                    $groupedItems[$name] = ['count' => 0, 'price' => $price];
                                    }
                                    $groupedItems[$name]['count']++;
                                    }
                                    @endphp

                                    @foreach($groupedItems as $name => $details)
                                    @php $totalPrice += $details['price'] * $details['count']; @endphp

                                    @if($loop->index < 2)
                                        <li class="flex justify-between py-[1rem]">
                                        <span class="text-gray-600">{{ $name }} {{ $details['count'] > 1 ? $details['count'] . 'x' : '' }}</span>
                                        <span class="text-gray-800 font-semibold">€{{ number_format($details['price'] * $details['count'], 2, ',', '.') }}</span>
                                        </li>
                                        @else
                                        <li class="justify-between py-[1rem] hidden extra_elements{{$reservering->id}}">
                                            <span class="text-gray-600">{{ $name }} {{ $details['count'] > 1 ? $details['count'] . 'x' : '' }}</span>
                                            <span class="text-gray-800 font-semibold">€{{ number_format($details['price'] * $details['count'], 2, ',', '.') }}</span>
                                        </li>
                                        @endif

                                        @endforeach
                                        @endif
                                        @endforeach
                                </ul>

                                @if(count($groupedItems) > 3)
                                <button class="underline text-blue-600 cursor-pointer showMoreButton{{ $reservering->id }}" onclick="showMoreProducts({{ $reservering->id }})">
                                    Toon meer producten
                                </button>
                                @endif
                            </div>

                            <div class="mt-2 border-t pt-2">
                                <div class="flex justify-between">
                                    <span class="text-md font-semibold text-gray-700">Totaal:</span>
                                    <span class="text-md font-bold text-gray-800">€{{ number_format($totalPrice, 2, ',', '.') }}</span>
                                </div>
                            </div>
                            @if ($isPayed == 'Open')
                            <form action="{{ route('receipt.checkout', $reservering->id) }}" method="POST">
                                @csrf
                                <button class="w-fit px-[2rem] underline leading-[1] my-[0.50rem] py-[0.75rem] rounded-[5px] mt-[1rem] text-[#FEA116] text-center font-bold mb-[1rem] cursor-pointer">
                                    Markeren als Betaald
                                </button>
                            </form>
                            @elseif ($isPayed == 'Paid')
                            <div class="flex align-center justify-center pt-4">
                                <p class="font-bold text-1xl text-[#FEA116]">Betaald</p>
                            </div>
                            @endif
                        </div>

                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="py-10 lg:w-1/3 w-full mx-auto flex flex-col">
            <h2 class="text-xl text-gray-800 leading-tight font-bold mb-[2rem] ms-[1.5rem]">Betaalde Rekeningen</h2>
            <div class="flex gap-6 flex-wrap item-container">
                @foreach($betaaldeReserveringen as $reservering)

                <div>
                    <div class="flex item-container">

                        @php
                        $reservationStart = Carbon::parse($reservering->reservation_date . ' ' . $reservering->reservation_time);

                        $reservationEnd = $reservationStart->copy()->addHours(3);

                        $isPayed = $reservering->is_payed;

                        $reservationOrders = $orders->filter(function($order) use ($reservering, $reservationStart, $reservationEnd) {

                        $orderTime = Carbon::parse($order->created_at);

                        return $order->table_number == $reservering->dinner_table_id &&
                        $orderTime->between($reservationStart, $reservationEnd);

                        });
                        @endphp
                        <div class="bg-white rounded-[10px] p-[2rem] min-w-72 item {{ ($reservationOrders->isNotEmpty() ? '' : 'hidden') }}" data-date="{{$reservering->reservation_date}}">
                            <!-- Header -->
                            <div class="text-center border-b pb-2">
                                <h1 class="text-1xl font-bold text-gray-700">Chez Léo</h1>
                                <p class="text-gray-500">Restaurant Bon</p>
                                <p class="font-bold text-1xl text-[#FEA116]">Tafel {{$reservering->dinner_table_id}}
                                    @php
                                    $reservationEndTime = \Carbon\Carbon::parse($reservering->reservation_time)->addHours(3);
                                    $isReservationOver = $reservationEndTime->isPast();
                                    @endphp

                                    @if ($isReservationOver || $isPayed == 'Paid')
                                    <a href="{{ route('receipt.download', $reservering->id)}}"><i class="bi bi-download"></i></a>
                                    @endif
                                </p>
                            </div>

                            <!-- Customer Details -->
                            <div class="my-[1rem] name_container">
                                <p class="text-gray-600 name"><span class="font-semibold">Naam:</span> {{$reservering->name}} </p>
                                <p class="text-gray-600"><span class="font-semibold">E-mail:</span> {{$reservering->email}} </p>
                                <p class="text-gray-600"><span class="font-semibold">Datum:</span> {{Carbon::parse($reservering->reservation_date)->format('d-m-y')}} <span class="underline">{{Carbon::parse($reservering->reservation_time)->format('H:i')}}&nbsp;</span></p>
                            </div>

                            <!-- Products -->
                            <div class="mt-6">
                                <h2 class="text-md font-semibold text-gray-700 border-b pb-2">Bestelling</h2>
                                <ul class="divide-y divide-gray-200 mt-2">
                                    @php $totalPrice = 0;
                                    $groupedItems = [];
                                    @endphp

                                    @foreach($orders as $order)
                                    @if($order->table_number == $reservering->dinner_table_id)
                                    @php
                                    $groupedItems = [];
                                    foreach (explode(',', $order->items) as $item) {

                                    preg_match('/^(.*)\s\(([\d.]+)\)$/', trim($item), $matches); //Regex om de naam en prijs van het item te scheiden door () tekens
                                    $name = $matches[1] ?? $item; // Naam van het item
                                    $price = $matches[2] ?? 0; // Prijs van het item

                                    if (!isset($groupedItems[$name])) { //kijkt of er al een item met dezelfde naam is zo niet word het toegevoegd
                                    $groupedItems[$name] = ['count' => 0, 'price' => $price];
                                    }
                                    $groupedItems[$name]['count']++;
                                    }
                                    @endphp

                                    @foreach($groupedItems as $name => $details)
                                    @php $totalPrice += $details['price'] * $details['count']; @endphp

                                    @if($loop->index < 2)
                                        <li class="flex justify-between py-[1rem]">
                                        <span class="text-gray-600">{{ $name }} {{ $details['count'] > 1 ? $details['count'] . 'x' : '' }}</span>
                                        <span class="text-gray-800 font-semibold">€{{ number_format($details['price'] * $details['count'], 2, ',', '.') }}</span>
                                        </li>
                                        @else
                                        <li class="justify-between py-[1rem] hidden extra_elements{{$reservering->id}}">
                                            <span class="text-gray-600">{{ $name }} {{ $details['count'] > 1 ? $details['count'] . 'x' : '' }}</span>
                                            <span class="text-gray-800 font-semibold">€{{ number_format($details['price'] * $details['count'], 2, ',', '.') }}</span>
                                        </li>
                                        @endif

                                        @endforeach
                                        @endif
                                        @endforeach
                                </ul>

                                @if(count($groupedItems) > 3)
                                <button class="underline text-blue-600 cursor-pointer showMoreButton{{ $reservering->id }}" onclick="showMoreProducts({{ $reservering->id }})">
                                    Toon meer producten
                                </button>
                                @endif
                            </div>

                            <div class="mt-2 border-t pt-2">
                                <div class="flex justify-between">
                                    <span class="text-md font-semibold text-gray-700">Totaal:</span>
                                    <span class="text-md font-bold text-gray-800">€{{ number_format($totalPrice, 2, ',', '.') }}</span>
                                </div>
                            </div>
                            @if ($isPayed == 'Open')
                            <form action="{{ route('receipt.checkout', $reservering->id) }}" method="POST">
                                @csrf
                                <button class="w-fit px-[2rem] mx-[3rem] my-[0.50rem] py-[0.75rem] rounded-[5px] bg-[#FEA116] text-white text-center font-bold mb-[1rem] cursor-pointer">
                                    Afrekenen
                                </button>
                            </form>
                            @elseif ($isPayed == 'Paid')
                            <div class="flex align-center justify-center pt-4">
                                <p class="font-bold text-1xl text-[#FEA116]">Betaald</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                @endforeach
            </div>
        </div>
    </div>


</x-app-layout>

<script>
    function showMoreProducts(id) {
        let extra_elements = document.querySelectorAll('.extra_elements' + id);
        let button = document.querySelector('.showMoreButton' + id);

        extra_elements.forEach(element => {
            if (element.classList.contains('hidden')) {
                element.classList.remove('hidden');
                element.classList.add('flex');
                button.innerHTML = 'Toon minder';

            } else {
                element.classList.remove('flex');
                element.classList.add('hidden');
                button.innerHTML = 'Toon meer producten';
            }
        });
    }

    let searchInput = $('#search');
    let items = $('.item');

    searchInput.on('input', function() {
        let searchText = searchInput.val().toLowerCase();

        items.each(function() {
            let name = $(this).find('.name').text().toLowerCase();
            console.log(name);

            name = name.replace('naam:', '').trim();

            if (name.includes(searchText)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });


    document.getElementById('datepicker').addEventListener('change', function() {
        let selectedDate = this.value;
        let item = document.querySelectorAll('.item');

        item.forEach(receipt_div => {
            if (receipt_div.getAttribute('data-date') == selectedDate) {
                receipt_div.style.display = 'block';
            } else {
                receipt_div.style.display = 'none';
            }
        });
    });
</script>