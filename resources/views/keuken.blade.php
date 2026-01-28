<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keuken App</title>
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
        .drop-hover {
            border-color: #FEA116 !important;
            background-color: rgba(254, 161, 22, 0.1) !important;
        }

        .timer {
            position: absolute;
            bottom: 0;
            right: 0;
            background-color: #f1f1f1;
            font-weight: bold;
            font-size: 12px;
            padding: 5px;
            border-radius: 5px;
        }

        .timer.green {
            color: green;
        }

        .timer.red {
            color: red;
        }

        .timer.orange {
            color: orange;
        }

        .timer.black {
            color: black;
        }
    </style>
</head>
<body class="bg-[#f7f7f7]">
<div class="w-full h-auto py-[2rem]">
    <div class="max-w-7xl mx-auto px-[2rem]">
        <div class="w-full h-auto rounded-t-[10px] flex overflow-hidden">
            <div class="w-1/2 h-full bg-orange-500 py-[1rem]">
                <h2 class="text-center font-bold text-white">Bestellingen te maken</h2>
            </div>
            <div class="w-1/2 h-full bg-green-500 py-[1rem]">
                <h2 class="text-center font-bold text-white">Bestellingen klaar</h2>
            </div>
        </div>
        <div class="flex bg-white">
            <!-- Bestellingen te maken -->
            <ul class="w-1/2 h-full zone" id="in-progress">
                @if($orders->isEmpty())
                    <div class="w-full flex flex-col gap-[0.5rem] items-center pl-[1rem] pr-[1rem] pt-[1rem]">
                        <svg width="50px" height="50px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="opacity-20">
                            <path d="M14.9348 13.1725C15.3654 13.3446 15.5817 13.8402 15.3237 14.2255C15.0294 14.665 14.6493 15.0442 14.2032 15.3386C13.522 15.7881 12.7196 16.0185 11.9037 15.9988C11.0878 15.9792 10.2975 15.7104 9.6387 15.2287C9.20726 14.9131 8.8458 14.5161 8.573 14.0629C8.33384 13.6656 8.57376 13.181 9.01216 13.0299C9.45056 12.8788 9.91919 13.1274 10.2157 13.4839C10.3367 13.6294 10.4756 13.7603 10.63 13.8732C11.0122 14.1527 11.4708 14.3087 11.9441 14.3201C12.4175 14.3315 12.883 14.1978 13.2782 13.937C13.4379 13.8316 13.583 13.7076 13.7108 13.5681C14.0241 13.2262 14.5042 13.0005 14.9348 13.1725Z" fill="black"/>
                            <path d="M10 9C10 8.44772 9.55228 8 9 8C8.44772 8 8 8.44772 8 9V10C8 10.5523 8.44772 11 9 11C9.55228 11 10 10.5523 10 10V9Z" fill="black"/>
                            <path d="M16 9C16 8.44772 15.5523 8 15 8C14.4477 8 14 8.44772 14 9V10C14 10.5523 14.4477 11 15 11C15.5523 11 16 10.5523 16 10V9Z" fill="black"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12ZM12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4Z" fill="black"/>
                        </svg>
                        <h3 class="font-bold opacity-25">Alle bestellingen afgerond.</h3>
                    </div>
                @else
                    @foreach($orders as $order)
                            <li class="min-w-[400px] m-[1rem] p-[1rem] bg-[#f7f7f7] card order-li relative hover:cursor-pointer" data-order-id="{{ $order->id }}" data-created-at="{{ $order->created_at }}">
                                <p class="font-bold text-black text-[12px] absolute right-[1rem] top-[1rem] opacity-50 order-id">#{{ $order->id }}</p>
                                <h2 class="text-[18px] mb-[1rem]">Tafelnummer: {{ $order->table_number }}</h2>
                                <h4 class="text-[14px] opacity-50 font-bold mb-[0.5rem]">Bestelling:</h4>

                                @php
                                    $items = preg_replace('/\s?\(.*?\)/', '', $order->items);
                                    $itemsArray = explode(',', $items);
                                    $itemCounts = [];
                                    foreach ($itemsArray as $item) {
                                        $item = trim($item);
                                        if (isset($itemCounts[$item])) {
                                            $itemCounts[$item]++;
                                        } else {
                                            $itemCounts[$item] = 1;
                                        }
                                    }
                                    $formattedItems = [];
                                    foreach ($itemCounts as $item => $count) {
                                        $formattedItems[] = "{$item} x{$count}";
                                    }
                                    $chunkedItems = array_chunk($formattedItems, 3);
                                @endphp

                                @foreach($chunkedItems as $row)
                                    <div class="flex">
                                        @foreach($row as $item)
                                            <p class="text-[14px] pending-order-item">{{ $item }},&nbsp;&nbsp;&nbsp;</p>
                                        @endforeach
                                    </div>
                                @endforeach

                                <div class="timer black" id="timer-{{ $order->id }}">
                                    Tijd: <span id="time-{{ $order->id }}">0m 0s</span>
                                </div>
                            </li>
                    @endforeach
                @endif
            </ul>

            <div class="w-[1px] min-h-[100vh] bg-[#f1f1f1]"></div>

            <!-- Bestellingen klaar (Completed) -->
            <ul class="w-1/2 h-full min-h-[80vh] zone" id="done">
                @foreach($ordersDone as $orderDone)
                        <li class="min-w-[400px] m-[1rem] p-[1rem] bg-[#f7f7f7] card order-li relative" data-order-id="{{ $orderDone->id }}">
                        <p class="font-bold text-black text-[12px] absolute right-[1rem] top-[1rem] opacity-50 order-id">#{{ $orderDone->id }}</p>
                            <h2 class="text-[18px] mb-[1rem]">Tafelnummer: {{ $orderDone->table_number }}</h2>
                            <h4 class="text-[14px] opacity-50 font-bold mb-[0.5rem]">Bestelling:</h4>

                            @php
                                $items = preg_replace('/\s?\(.*?\)/', '', $orderDone->items);
                                $itemsArray = explode(',', $items);
                                $itemCounts = [];
                                foreach ($itemsArray as $item) {
                                    $item = trim($item);
                                    if (isset($itemCounts[$item])) {
                                        $itemCounts[$item]++;
                                    } else {
                                        $itemCounts[$item] = 1;
                                    }
                                }
                                $formattedItems = [];
                                foreach ($itemCounts as $item => $count) {
                                    $formattedItems[] = "{$item} x{$count}";
                                }
                                $chunkedItems = array_chunk($formattedItems, 3);
                            @endphp

                            @foreach($chunkedItems as $row)
                                <div class="flex">
                                    @foreach($row as $item)
                                        <p class="text-[14px] pending-order-item">{{ $item }},&nbsp;&nbsp;&nbsp;</p>
                                    @endforeach
                                </div>
                            @endforeach

                            <div class="timer green" id="timer-{{ $orderDone->id }}">
                                Gereed
                            </div>
                        </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

<script type="module">
    import Draggable from 'https://cdn.jsdelivr.net/npm/@shopify/draggable/build/esm/Draggable/Draggable.mjs';

    document.addEventListener('DOMContentLoaded', function () {
        const containers = document.querySelectorAll('#in-progress, #done');

        const draggable = new Draggable(containers, {
            draggable: '.order-li',
        });

        let overTarget = null;

        draggable.on('drag:over:container', (event) => {
            overTarget = event.overContainer;
        });

        draggable.on('drag:out:container', () => {
            overTarget = null;
        });

        draggable.on('drag:stop', async (event) => {
            if (overTarget && overTarget.id === 'done') {
                const orderId = event.source.dataset.orderId;

                // Verplaats item
                overTarget.appendChild(event.source);

                // Update status naar 'Completed' in backend
                await fetch('/dashboard/kitchen/complete', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        order_id: orderId
                    })
                });
            }
            
            overTarget = null;

            window.location.reload();
        });

        // Timer Logic
        const orders = document.querySelectorAll('#in-progress .order-li');
        orders.forEach(order => {
            const orderId = order.dataset.orderId;
            const createdAt = new Date(order.dataset.createdAt);
            const timerElement = document.getElementById(`timer-${orderId}`);
            const timeSpan = document.getElementById(`time-${orderId}`);

            function updateTimer() {
                const now = new Date();
                const elapsed = now - createdAt;
                const minutes = Math.floor(elapsed / 60000);
                const seconds = Math.floor((elapsed % 60000) / 1000);
                timeSpan.textContent = `${minutes}m ${seconds}s`;

                if (minutes >= 40) {
                    timerElement.classList.remove('orange', 'black');
                    timerElement.classList.add('red');
                } else if (minutes >= 20) {
                    timerElement.classList.remove('red', 'black');
                    timerElement.classList.add('orange');
                } else {
                    timerElement.classList.remove('red', 'orange');
                    timerElement.classList.add('black');
                }
            }

            setInterval(updateTimer, 1000);
        });
    });
</script>
</body>
</html>
