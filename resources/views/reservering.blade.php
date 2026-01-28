<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservering</title>
    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&family=Pacifico&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Template Stylesheet -->
    @vite(['resources/css/bootstrap.min.css', 'resources/css/style.css', 'resources/js/main.js'])

    <style>
        /* Standaard hover-effect */
        .tafel-label:hover {
            background-color: rgba(0, 0, 0, 0.1);
        }

        /* Visuele markering voor geselecteerde tafel */
        .tafel-radio:checked+.tafel-label {
            background-color: #FEA116;
            /* Oranje achtergrondkleur */
            border-color: #FEA116;
            /* Oranje randkleur */
            color: white;
            /* Witte tekst */
        }

        /* Optioneel: Stijl voor het label als het niet geselecteerd is */
        .tafel-label {
            transition: background-color 0.3s, border-color 0.3s;
        }
        
        @media (max-width: 700px) {
            .form_table {
            overflow: hidden;
            }
        }   
    </style>

</head>

<body class="bg-[#f7f7f7]">
    <div class="w-full h-auto py-[2rem]">
        <div class="max-w-7xl mx-auto px-[1.5rem]">
            <a href="/">
                <h1 class="text-primary m-0"><i class="fa fa-utensils me-3"></i>Chez Leo</h1>
            </a>
        </div>
    </div>
    <div class="w-full h-auto">
        <div class="max-w-7xl mx-auto px-[1.5rem] flex flex-col items-center py-[3rem]">
            <!-- Error Messages -->
            @if($errors->any())
            <div class="p-4 mb-6 bg-red-100 text-red-800 rounded-md">
                <ul>
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            @if(session('error'))
            <div class="p-4 mb-6 bg-red-100 text-red-800 rounded-md">
                {{ session('error') }}
            </div>
            @endif

            <!-- Step 1: Persoongegevens -->
            @if(session('step') == 1 || !session('step'))

            <div class="p-[2rem] bg-white rounded-[10px] max-w-screen mb-[6rem]">
                <form action="/reservering/step1" method="POST">
                    @csrf
                    <div class="w-full h-auto flex gap-[1rem] mb-[1rem] flex-col sm:flex-row">
                        <div class="w-full sm:w-1/2 h-full mb-4 sm:mb-0">
                            <p class="text-[15px] opacity-[85%] mb-[0.5rem]">Uw volledige naam</p>
                            <input type="text" name="volledige_naam" class="w-full focus:outline-none h-auto py-[0.75rem] px-[1rem] bg-[#edecec]  rounded-[3px] {{ Auth::user() ? 'opacity-50' : '' }}" value="{{ Auth::user() ? Auth::user()->name : old('voornaam') }}" {{ Auth::user() ? 'readonly' : '' }}>
                        </div>
                        <div class="w-full sm:w-1/2 h-full mb-4 sm:mb-0">
                            <p class="text-[15px] opacity-[85%] mb-[0.5rem]">Telefoonnummer</p>
                            <input type="tel" name="telefoonnummer" class="w-full focus:outline-none h-auto py-[0.75rem] px-[1rem] bg-[#edecec]  rounded-[3px] {{ Auth::user() ? 'opacity-50' : '' }}" value="{{  Auth::user() ? Auth::user()->phone_number : old('telefoonnummer') }}" pattern="[0-9]{10}" inputmode="numeric" title="Voer alleen cijfers in" {{ Auth::user() ? 'readonly' : '' }}>
                        </div>
                    </div>
                    <div class="w-full h-auto flex gap-[1rem] mb-[1rem] flex-col sm:flex-row">
                        <div class="w-full sm:w-2/3 h-full mb-4 sm:mb-0">
                            <p class="text-[15px] opacity-[85%] mb-[0.5rem]">Email</p>
                            <input type="email" name="email" class="w-full focus:outline-none h-auto py-[0.75rem] px-[1rem] bg-[#edecec]  rounded-[3px] {{ Auth::user() ? 'opacity-50' : '' }}" value="{{  Auth::user() ? Auth::user()->email : old('email') }}" {{ Auth::user() ? 'readonly' : '' }}>
                        </div>
                        <div class="w-full sm:w-1/3 h-full mb-4 sm:mb-0">
                            <p class="text-[15px] opacity-[85%] mb-[0.5rem]">Aantal personen</p>
                            <input type="number" name="aantal_gasten" min="1" max="6" class="w-full focus:outline-none h-auto py-[0.75rem] px-[1rem] bg-[#edecec] rounded-[3px]" value="{{ old('aantal_gasten') }}">
                        </div>
                    </div>
                    <div class="w-full h-auto flex gap-[1rem] mb-[1rem] flex-col sm:flex-row">
                        <div class="w-full sm:w-2/3 h-full mb-4 sm:mb-0">
                            <p class="text-[15px] opacity-[85%] mb-[0.5rem]">Voor welke datum wilt u reserveren?</p>
                            <input type="date" name="datum" class="w-full focus:outline-none h-auto py-[0.75rem] px-[1rem] bg-[#edecec]  rounded-[3px]" value="{{ old('datum') }}" min="{{ date('Y-m-d') }}">
                        </div>
                        <div class="w-full sm:w-1/3">
                            <p class="text-[15px] opacity-[85%] mb-[0.5rem]">Tijd</p>
                            <select name="tijd" class="w-full focus:outline-none h-auto py-[0.75rem] px-[1rem] bg-[#edecec]  rounded-[3px]">
                                <option value="">Kies eerst een datum</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="w-full h-auto py-[0.75rem] rounded-[5px] bg-[#FEA116] font-bold text-white">
                        Kies een tafel
                    </button>
                </form>
            </div>

            @endif

            <!-- Step 2: Selecteer Tafel -->
            @if(session('step') == 2)
            <h2 class="text-2xl font-bold mb-24">Selecteer een Tafel</h2>
            <form method="POST" action="{{ route('step2') }}" class="flex flex-col items-center sm:items-end form_table">
            @csrf
                <input type="hidden" name="datum" value="{{ session('reservation')['reservation_date'] }}">

                <div class="sm:w-full w-96 bg-gray-200 p-[2rem] rounded-[25px] relative">
                    @if(session('tables'))
                    <!-- Layout met dynamische tafels -->

                    <!-- RAAM labels -->
                    <div class="h-[432px] w-[30px] bg-gray-300 absolute z-[1] -left-[3rem] top-0 flex items-center justify-center">
                        <h3 class="text-gray-400 font-bold rotate-[-90deg] leading-[1]">RAAM</h3>
                    </div>
                    <div class="h-[432px] w-[30px] bg-gray-300 absolute z-[1] -right-[3rem] top-0 flex items-center justify-center">
                        <h3 class="text-gray-400 font-bold rotate-[90deg] leading-[1]">RAAM</h3>
                    </div>
                    <div class="sm:w-[432px] sm:h-[30px] w-[200px] h-[15px] bg-gray-300 absolute z-[1] left-0 right-0 mx-auto sm:-top-[3rem]  -top-[1rem] flex items-center justify-center">
                        <h3 class="text-gray-400 font-bold leading-[1]">RAAM</h3>
                    </div>
                    <div class="sm:w-[432px] sm:h-[30px] w-[200px] h-[15px] bg-green-500 absolute z-[1] left-[10%] -bottom-[3rem] flex items-center justify-center">
                        <h3 class="text-green-600 font-bold leading-[1]">INGANG</h3>
                    </div>

                    <div class="w-full h-auto flex items-center justify-between mt-4">
                        @foreach(session('tables')->slice(0, 6) as $table)
                        @php
                        $isReserved = in_array($table->id, session('reservedTableIds', []));
                        $matchesRequiredSeats = in_array($table->seats, session('required_seats', []));
                        @endphp

                        <div class="relative">
                            <input type="radio" name="tafel" id="table-{{ $table->id }}" value="{{ $table->id }}"
                                class="peer hidden" @if($isReserved) disabled @endif>
                            <div class="sm:w-[120px] sm:h-[120px] w-[48px] h-[48px] bg-gray-400 flex flex-col items-center justify-center border-2 border-transparent rounded-[5px] transition-all duration-300 peer-checked:border-orange-500 @if($isReserved || !$matchesRequiredSeats) opacity-50 pointer-events-none @endif">
                                <label for="table-{{ $table->id }}" class="text-center cursor-pointer sm:p-2">
                                    <p class="text-gray-600 sm:font-bold sm:text-xl text-[13px]" id="{{ $table->id }}">Tafel {{ $table->id }}</p>
                                    <p class="text-gray-500 sm:text-sm text-[8px]">{{ $table->seats }}-persoonstafel</p>
                                </label>
                            </div>
                        </div>

                        @endforeach
                    </div>

                    <!-- 2e rij tafels -->
                    <div class="w-full h-auto flex items-center justify-between mt-[3rem]">
                        <div class="flex sm:gap-[5rem] gap-[5px] h-auto justify-start">
                            @foreach(session('tables')->slice(6, 2) as $table)
                            @php
                            $isReserved = in_array($table->id, session('reservedTableIds', []));
                            $matchesRequiredSeats = in_array($table->seats, session('required_seats', []));
                            @endphp

                            <div class="relative">
                                <input type="radio" name="tafel" id="table-{{ $table->id }}" value="{{ $table->id }}"
                                    class="peer hidden" @if($isReserved) disabled @endif>
                                <div class="sm:w-[120px] sm:h-[120px] w-[48px] h-[48px] bg-gray-400 flex flex-col items-center justify-center border-2 border-transparent rounded-[5px] transition-all duration-300 peer-checked:border-orange-500 @if($isReserved || !$matchesRequiredSeats) opacity-50 pointer-events-none @endif">
                                    <label for="table-{{ $table->id }}" class="text-center cursor-pointer p-2">
                                        <p class="text-gray-600 sm:font-bold sm:text-xl text-[13px]" id="{{ $table->id }}">Tafel {{ $table->id }}</p>
                                        <p class="text-gray-500 sm:text-sm text-[8px]">{{ $table->seats }}-persoonstafel</p>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="flex sm:gap-[3rem] gap-[10px] sm:w-1/3 h-auto sm:p-4 justify-center">
                            @foreach(session('tables')->slice(8, 2) as $table)
                            @php
                            $isReserved = in_array($table->id, session('reservedTableIds', []));
                            $matchesRequiredSeats = in_array($table->seats, session('required_seats', []));
                            @endphp


                            <div class="relative">
                                <input type="radio" name="tafel" id="table-{{ $table->id }}" value="{{ $table->id }}"
                                    class="peer hidden" @if($isReserved) disabled @endif>
                                <div class="sm:w-[120px] sm:h-[120px] w-[48px] h-[48px] bg-gray-400 flex flex-col items-center justify-center border-2 border-transparent rounded-full transition-all duration-300 peer-checked:border-orange-500 @if($isReserved || !$matchesRequiredSeats) opacity-50 pointer-events-none @endif">
                                    <label for="table-{{ $table->id }}" class="text-center cursor-pointer p-2">
                                        <p class="text-gray-600 sm:font-bold sm:text-xl text-[13px]" id="{{ $table->id }}">Tafel {{ $table->id }}</p>
                                        <p class="text-gray-500 sm:text-sm text-[8px]">{{ $table->seats }}-persoonstafel</p>
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="flex sm:gap-[5rem] gap-[5px] h-auto justify-end">
                            @foreach(session('tables')->slice(10, 2) as $table)
                            @php
                            $isReserved = in_array($table->id, session('reservedTableIds', []));
                            $matchesRequiredSeats = in_array($table->seats, session('required_seats', []));
                            @endphp


                            <div class="relative">
                                <input type="radio" name="tafel" id="table-{{ $table->id }}" value="{{ $table->id }}"
                                    class="peer hidden" @if($isReserved) disabled @endif>
                                <div class="sm:w-[120px] sm:h-[120px] w-[48px] h-[48px] bg-gray-400 flex flex-col items-center justify-center border-2 border-transparent rounded-[5px] transition-all duration-300 peer-checked:border-orange-500 @if($isReserved || !$matchesRequiredSeats) opacity-50 pointer-events-none @endif">
                                    <label for="table-{{ $table->id }}" class="text-center cursor-pointer p-2">
                                        <p class="text-gray-600 sm:font-bold sm:text-xl text-[13px]" id="{{ $table->id }}">Tafel {{ $table->id }}</p>
                                        <p class="text-gray-500 sm:text-sm text-[8px]">{{ $table->seats }}-persoonstafel</p>
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="w-full h-auto flex justify-between mt-[3rem] me-4">
                        <div class="flex sm:gap-[5rem] sm:me-4 gap-[10px] me-1">
                            @foreach(session('tables')->slice(12, 2) as $table)
                            @php
                            $isReserved = in_array($table->id, session('reservedTableIds', []));
                            $matchesRequiredSeats = in_array($table->seats, session('required_seats', []));
                            @endphp
                            <div class="relative">
                                <input type="radio" name="tafel" id="table-{{ $table->id }}" value="{{ $table->id }}"
                                    class="peer hidden" @if($isReserved) disabled @endif>
                                <div class="sm:w-[230px] sm:h-[120px] w-[100px] h-[72px] bg-gray-400 flex sm:flex-col items-center justify-center border-2 border-transparent rounded-[5px] transition-all duration-300 peer-checked:border-orange-500 @if($isReserved || !$matchesRequiredSeats) opacity-50 pointer-events-none @endif">
                                    <label for="table-{{ $table->id }}" class="text-center cursor-pointer p-2">
                                        <p class="text-gray-600 sm:font-bold sm:text-xl text-[13px]" id="{{ $table->id }}">Tafel {{ $table->id }}</p>
                                        <p class="text-gray-500 sm:text-sm text-[8px]">{{ $table->seats }}-persoonstafel</p>
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="sm:w-[45%] sm:min-h-[300px] w-[25%] min-h-[100px] bg-gray-300 rounded-[5px] flex items-center justify-center">
                            <h3 class="text-gray-400 font-bold">KEUKEN</h3>
                        </div>
                    </div>
                    @else
                    <p>Geen tafels beschikbaar</p>
                    @endif
                </div>
                <button type="submit" class="sm:mt-4 mt-20 bg-blue-500 text-white sm:px-[2rem] px-2 text-sm py-2 rounded sm:float-right w-fit">Reserveren</button>
            </form>
            @endif
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
    <script>
        const openingHours = @json($openingHours); //data uit de controller voor de openingstijden per dag


        document.querySelector('input[name="datum"]').addEventListener('change', function() {
            let selectedDate = new Date(this.value);
            let dayOfWeek = selectedDate.getDay();
            let today = new Date();

            let selectedHours = openingHours.find(hours => hours.day_of_week == dayOfWeek);

            if (selectedHours && (selectedHours.open != '00:00:00' && selectedHours.close != '00:00:00')) {
                const openingTime = moment(selectedHours.open, 'HH:mm');
                const closingTime = moment(selectedHours.close, 'HH:mm').subtract(3, 'hours');
                const timeSelect = document.querySelector('select[name="tijd"]');
                timeSelect.innerHTML = '';

                // maak de options op basis van de geselecteerde dag en daar de openingstijden van.
                while (openingTime <= closingTime) {
                    const option = document.createElement('option');
                    option.value = openingTime.format('HH:mm');
                    option.textContent = openingTime.format('HH:mm');

                    // Check if the selected date is today and the time is in the past
                    if (selectedDate.toDateString() === today.toDateString() && openingTime.isBefore(moment())) {
                        openingTime.add(30, 'minutes');
                        continue;
                    }

                    timeSelect.appendChild(option);
                    openingTime.add(30, 'minutes');
                }
            } else {
                const timeSelect = document.querySelector('select[name="tijd"]');
                timeSelect.innerHTML = '<option value="">Niet open vandaag</option>';
            }
        });
    </script>
</body>

</html>