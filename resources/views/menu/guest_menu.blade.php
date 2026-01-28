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
    </style>

</head>
<div class="max-w-7xl mx-auto px-[1.5rem] lg:py-[4rem] py-[1rem] flex flex-col lg:gap-[3rem] gap-[2rem]">
    <div class="w-full h-auto flex lg:flex-row flex-col lg:justify-between gap-[2rem]">
        @foreach($menu->groupBy('category') as $category => $products)
        <div id="{{ $category }}" class="w-full lg:w-[50%] category-section {{ $category === 'Drank' ? '' : 'hidden' }}">
            <h1 class="text-lg font-bold text-white text-center leading-[1] py-[1rem] rounded-t-[10px] bg-[#FEA116]">{{ $category }}</h1>
            @foreach($products as $product)
            <div class="px-[2rem] py-[1.5rem] border-t-[1px] flex flex-col justify-center bg-white relative">
                <span class="text-black productprice absolute right-[2rem] text-[12px]">€{{ number_format($product->price, 2) }}</span>
                <div class="max-w-[80%]">
                    <h2 class="text-lg font-bold text-black leading-[1] mb-[0.5rem] productnaam"> {{ $product->name }}</h2>
                    <p class="text-gray-600 text-sm hidden productdescription"> {{ $product->description }} </p>
                    <p class="text-gray-600 text-sm"> {{ $product->description }} </p>
                </div>
            </div>
            @endforeach
        </div>
        @endforeach

        @foreach($menu->groupBy('category') as $category => $products)
        <div id="{{ $category }}" class="w-full lg:w-[50%] category-section {{ $category === 'Diner' ? '' : 'hidden' }}">
            <h1 class="text-lg font-bold text-white text-center leading-[1] py-[1rem] rounded-t-[10px] bg-[#FEA116]">{{ $category }}</h1>
            @foreach($products as $product)
            <div class="px-[2rem] py-[1.5rem] border-t-[1px] flex flex-col justify-center bg-white relative">
                <span class="text-black productprice absolute right-[2rem] text-[12px]">€{{ number_format($product->price, 2) }}</span>
                <div class="max-w-[80%]">
                    <h2 class="text-lg font-bold text-black leading-[1] mb-[0.5rem] productnaam"> {{ $product->name }}</h2>
                    <p class="text-gray-600 text-sm hidden productdescription"> {{ $product->description }} </p>
                    <p class="text-gray-600 text-sm"> {{ $product->description }} </p>
                </div>
            </div>
            @endforeach
        </div>
        @endforeach
    </div>
    <div class="w-full h-auto flex lg:flex-row flex-col lg:justify-between gap-[2rem]">
        @foreach($menu->groupBy('category') as $category => $products)
        <div id="{{ $category }}" class="w-full lg:w-[50%] category-section {{ $category === 'Lunch' ? '' : 'hidden' }}">
            <h1 class="text-lg font-bold text-white text-center leading-[1] py-[1rem] rounded-t-[10px] bg-[#FEA116]">{{ $category }}</h1>
            @foreach($products as $product)
            <div class="px-[2rem] py-[1.5rem] border-t-[1px] flex flex-col justify-center bg-white relative">
                <span class="text-black productprice absolute right-[2rem] text-[12px]">€{{ number_format($product->price, 2) }}</span>
                <div class="max-w-[80%]">
                    <h2 class="text-lg font-bold text-black leading-[1] mb-[0.5rem] productnaam"> {{ $product->name }}</h2>
                    <p class="text-gray-600 text-sm hidden productdescription"> {{ $product->description }} </p>
                    <p class="text-gray-600 text-sm"> {{ $product->description }} </p>
                </div>
            </div>
            @endforeach
        </div>
        @endforeach

        @foreach($menu->groupBy('category') as $category => $products)
        <div id="{{ $category }}" class="w-full lg:w-[50%] category-section {{ $category === 'Dessert' ? '' : 'hidden' }}">
            <h1 class="text-lg font-bold text-white text-center leading-[1] py-[1rem] rounded-t-[10px] bg-[#FEA116]">{{ $category }}</h1>
            @foreach($products as $product)
            <div class="px-[2rem] py-[1.5rem] border-t-[1px] flex flex-col justify-center bg-white relative">
                <span class="text-black productprice absolute right-[2rem] text-[12px]">€{{ number_format($product->price, 2) }}</span>
                <div class="max-w-[80%]">
                    <h2 class="text-lg font-bold text-black leading-[1] mb-[0.5rem] productnaam"> {{ $product->name }}</h2>
                    <p class="text-gray-600 text-sm hidden productdescription"> {{ $product->description }} </p>
                    <p class="text-gray-600 text-sm"> {{ $product->description }} </p>
                </div>
            </div>
            @endforeach
        </div>
        @endforeach
    </div>
</div>

</html>