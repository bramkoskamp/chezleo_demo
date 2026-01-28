<style>
    [class^="bi-"]::before,
    [class*=" bi-"]::before {
        vertical-align: -.250em !important;
    }
    
    .disabled {
        pointer-events: none;
        opacity: 0.5;
    }
    .enabled {
        pointer-events: all;
        opacity: 1;
    }

</style>
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight pt-[0.5rem]">
                {{ __('Bestelling') }}
            </h2>

            <div class="w-1/3 flex justify-end gap-[1rem]">
                <div class="relative w-56">
                    <input type="text" id="search" class="w-full pl-10 pr-4 py-2 text-sm border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50 placeholder-gray-500" placeholder="Zoeken op productnaam...">
                    <i class="bi bi-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500"></i>
                </div>
            </div>
        </div>
    </x-slot>
    <div id="deleteModal" class="fixed w-full px-[1rem] h-screen z-[999] top-0 left-0 flex items-center justify-center bg-black bg-opacity-25 hidden">
        <div class="bg-white p-[2rem] rounded-[10px]">
            <h2 class="text-xl font-bold mb-[2rem] lg:text-start text-center">Weet je zeker dat je dit product wilt verwijderen?</h2>
            <div class="w-full flex justify-center gap-[0.5rem]">
                <button onclick="closeModal()" class="px-[2rem] py-[0.75rem] rounded-[5px] font-bold bg-gray-200 text-gray-700">Annuleren</button>
                <a id="confirmDelete" href="#" class="px-[2rem] py-[0.75rem] rounded-[5px] font-bold bg-red-500 text-white">Verwijderen</a>
            </div>
        </div>
    </div>
    <div class="w-full h-screen px-[1rem] bg-[#00000025] fixed z-[999] top-0 flex items-center justify-center" id="edit-product-overlay">
        <div class="p-[3rem] bg-white rounded-[10px]">
            <h2 class="text-xl font-bold mb-[2rem]">Product Bewerken</h2>
            <div class="min-w-[400px] lg:min-w-[500px]">
                <form action="{{ route('menu_dashboard.update', ['id' => $menu->first()->id]) }}" method="POST" class="flex flex-col gap-[1rem]" id="edit-product-form">
                    @csrf
                    @method('PUT')
                    <div class="form-group flex flex-col gap-[0.5rem]">
                        <label for="category">Selecteer een categorie</label>
                        <select name="category" id="editProductCatogory" class="bg-[#f7f7f7] rounded-[5px] py-[0.75rem] px-[1rem] border-none outline-none" required>
                            <option value="" disabled selected>Geen categorie geselecteerd...</option>
                            <?php foreach ($catogories as $category): ?>
                                <option value="<?= htmlspecialchars($category['category_name']) ?>">
                                    <?= htmlspecialchars($category['category_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group flex flex-col gap-[0.5rem]">
                        <label>Productnaam</label>
                        <input type="text" name="name" class="bg-[#f7f7f7] rounded-[5px] py-[0.75rem] px-[1rem] border-none outline-none" id="editProductName" required>
                    </div>
                    <div class="form-group flex flex-col gap-[0.5rem]">
                        <label>Productbeschrijving</label>
                        <textarea name="description" class="bg-[#f7f7f7] rounded-[5px] py-[0.75rem] px-[1rem] border-none outline-none" id="editProductDescription" required></textarea>
                    </div>
                    <div class="form-group flex flex-col gap-[0.5rem] mb-[2rem]">
                        <label>Verkoopprijs</label>
                        <input type="number" name="price" step="0.01" class="bg-[#f7f7f7] rounded-[5px] py-[0.75rem] px-[1rem] border-none outline-none" id="editProductPrice" min="1" required>
                    </div>
                    <button type="submit" class="bg-[#FEA116] text-white font-bold px-[2rem] py-[0.75rem] rounded-[5px]">Aanpassingen opslaan</button>
                    <p class="text-red-500 text-center cursor-pointer" id="close-edit-product-overlay">Annuleren</p>
                </form>
            </div>
        </div>
    </div>
    <div class="w-full h-screen px-[1rem] bg-[#00000025] fixed z-[999] top-0 flex items-center justify-center" id="add-product-overlay">
        <div class="p-[3rem] bg-white rounded-[10px]">
            <h2 class="text-xl font-bold mb-[2rem]">Product Toevoegen</h2>
            <div class="lg:min-w-[500px] min-w-[400px]">
            <form action="{{ route('menu_dashboard.store') }}" method="POST" class="flex flex-col gap-[1rem]" id="edit-product-form">
                @csrf
                <div class="form-group flex flex-col gap-[0.5rem]">
                    <label for="category">Selecteer een categorie</label>
                    <select name="category" id="category" class="bg-[#f7f7f7] rounded-[5px] py-[0.75rem] px-[1rem] border-none outline-none" required>
                        <option value="" disabled selected>Geen categorie geselecteerd...</option>
                        <?php foreach ($catogories as $category): ?>
                            <option value="<?= htmlspecialchars($category['category_name']) ?>">
                                <?= htmlspecialchars($category['category_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group flex flex-col gap-[0.5rem]">
                    <label>Productnaam</label>
                    <input type="text" name="name" class="bg-[#f7f7f7] rounded-[5px] py-[0.75rem] px-[1rem] border-none outline-none" required>
                </div>
                <div class="form-group flex flex-col gap-[0.5rem]">
                    <label>Productbeschrijving</label>
                    <textarea name="description" class="bg-[#f7f7f7] rounded-[5px] py-[0.75rem] px-[1rem] border-none outline-none" required></textarea>
                </div>
                <div class="form-group flex flex-col gap-[0.5rem] mb-[2rem]">
                    <label>Verkoopprijs</label>
                    <input type="number" name="price" step="0.01" class="bg-[#f7f7f7] rounded-[5px] py-[0.75rem] px-[1rem] border-none outline-none" min="1" required>
                </div>
                <button type="submit" class="bg-[#FEA116] text-white font-bold px-[2rem] py-[0.75rem] rounded-[5px]">Product opslaan</button>
                <p class="text-red-500 text-center cursor-pointer" id="close-add-product-overlay">Annuleren</p>
            </form>
            </div>
        </div>
    </div>
    <div class="max-w-7xl mx-auto px-[1.5rem] lg:py-9 relative">
        @if(Auth::user()->role_id == 3)
        <div class="w-fit px-[2rem] py-[0.75rem] rounded-[5px] bg-[#FEA116] text-white text-center font-bold mb-[1rem] mt-[1rem] cursor-pointer" id="open-add-product-overlay">
            <p>Product toevoegen</p>
        </div>
        @endif
        <div class="w-full h-auto flex lg:flex-row flex-col gap-[4rem]">
            <div class="w-full h-full mt-[10rem] lg:mt-[0rem]">
                <div id="menu-section">
                    <div>
                        <nav class="bg-[#FEA116] tab-class text-center wow fadeInUp p-[1.2rem] font-bold rounded-t-[10px]" data-wow-delay="0.1s">
                            <ul class="flex whitespace-nowrap justify-evenly nav nav-pills">
                                @foreach(['Drank', 'Lunch', 'Diner', 'Dessert'] as $category)
                                <li class="nav-item">
                                    <a href="javascript:void(0)" onclick="showCategory('{{ $category }}', this)" 
                                    class="border-b-2 border-transparent hover:border-[#f7f7f7] {{ $category === 'Drank' ? 'text-[#fff] active' : 'text-white' }}">
                                    {{ $category }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </nav>
                    </div>
                    @foreach($menu->groupBy('category') as $category => $products)
                    <div id="{{ $category }}" class="category-section {{ $category === 'Drank' ? '' : 'hidden' }}">
                        @foreach($products as $product)
                        <div class="flex justify-center gap-6 product">
                            <div class="bg-white border-t-[1px] border-[#f7f7f7] py-[0.5rem] overflow-hidden w-full cursor-pointer flex {{ Auth::user()->role_id == 1 ? ' ' : 'justify-center' }}">
                                <div class="flex w-2/3">
                                    <div class="px-4 py-[1rem] findproductid" id="{{ $product->id }}">
                                        <h2 class="text-lg font-bold text-black leading-[1] productnaam"> {{ $product->name }}</h2>
                                        <span class="text-sm text-black my-[1rem] productprice">€{{ number_format($product->price, 2) }}</span>
                                        <p class="text-gray-600 text-sm hidden productcatogory"> {{ $product->category_name }} </p>
                                        <p class="text-gray-600 text-sm hidden productdescription"> {{ $product->description }} </p>
                                        @if(Auth::user()->role_id == 1)
                                        <p class="text-gray-600 text-sm"> {{ $product->description }} </p>
                                        @endif
                                    </div>
                                </div>
                                @if(Auth::user()->role_id == 2 || Auth::user()->role_id == 3)
                                    <div class="flex w-1/3 items-center justify-end mr-[1rem]">
                                        @if(Auth::user()->role_id == 3)
                                        <td>
                                            <div class="mr-[0.5rem]">
                                                <i class="bi bi-pencil text-[#FEA116] cursor-pointer open-edit-product-overlay"></i>
                                            </div>
                                            <button class="mr-[1.5rem] ml-[0.5rem]" onclick="openModal('{{ $product->id }}')">
                                                <i class="bi bi-trash text-red-500 cursor-pointer"></i>
                                            </button>
                                        </td>
                                        @endif
                                        <button class="add-to-order" data-id="{{ $product->id }}" data-name="{{ $product->name }}" data-price="{{ $product->price }}">
                                            <i class="bi bi-plus-circle text-orange-500 text-2xl bg-white rounded-full"></i>
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endforeach
                </div>
            </div>
            @if(Auth::user()->role_id == 2 || Auth::user()->role_id == 3)
            <div class="w-full lg:min-w-[33%] lg:max-w-[33%] h-full">

            <div class="flex w-full">
                        <!-- Tafelnummers -->
                        <form action="{{ route('orders.store') }}" method="POST" class="w-[50%] lg:w-full absolute lg:static z-[1] top-[6.0rem]">
                            @csrf
                            <div class="form-group w-full -mt-[2rem] lg:mt-[0rem]">
                                <label for="table_number" class="mb-[0.5rem]">Selecteer een tafelnummer:</label>
                                <select name="table_number" id="table_number" class="form-control" required class="w-full bg-white">
                                    <option value="" class="w-full">Geen tafel geselecteerd...</option>
                                    @foreach ($reservedTables as $table)
                                    <option value="{{ $table->dinner_table_id }}">Tafel {{ $table->dinner_table_id }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                    </div>

                <!-- Bestelling Overzicht -->
                <div>
                    <h2 class="text-xl font-bold mb-4">Overzicht Bestelling</h2>
                    <div id="hide-if-empty-orders">
                        <table id="order-summary" class="table-auto border-collapse w-full">
                            <thead class="overflow-hidden">
                                <tr class="text-white bg-[#FEA116] rounded-l-[10px]">
                                    <th class="font-bold px-4 py-2" style="border-radius: 5px 0 0 0;">Product</th>
                                    <th class="font-bold px-4 py-2">Prijs</th>
                                    <th class="font-bold px-4 py-2" style="border-radius: 0 5px 0 0;"></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white" id="order-sumup"></tbody>
                        </table>
                    </div>
                    <div class="w-full h-auto rounded-[10px] py-[1rem] px-[2rem] bg-white mb-[2rem]" id="no-results-order-sumup">
                        <p class="opacity-50 text-[12px]">Hier is nog niets te zien...</p>
                    </div>

                </div>
                <div>
                        <div id="alert" class="mb-4 w-full bg-[#ff8080] text-white px-[2rem] py-[0.75rem] font-bold rounded-[5px] mt-[2rem] border-2 border-red-700 opacity-90 flex justify-center items-center hidden">
                            <p id="tekst" class="text-red-700">Alert</p>
                        </div>
                
                        <div id="alert2" class="mb-4 w-full bg-[#abf28f] text-white px-[2rem] py-[0.75rem] font-bold rounded-[5px] mt-[2rem] border-2 border-green-700 opacity-90 flex justify-center items-center hidden">
                            <p id="tekst2" class="text-green-700">Alert</p>
                        </div>
                
                        <button id="confirm-order" class="w-full bg-[#fea116] text-white px-[2rem] py-[0.75rem] mb-[2rem] font-bold rounded-[5px] mt-[2rem]">
                            Bestelling doorvoeren
                        </button>
                    </div>
                </form>
            </div>
            @endif
    </div>
</x-app-layout>

<script>
    let orderItems = [];
    $("#hide-if-empty-orders").hide();

    document.querySelectorAll('.add-to-order').forEach(button => {
        button.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');
            const price = parseFloat(this.getAttribute('data-price'));

            orderItems.push({ id, name, price });

            console.log('Huidige orderItems:', orderItems);

            updateOrderSummary();

        });
    });

    function openModal(productId) {
        const modal = document.getElementById('deleteModal');
        const confirmButton = document.getElementById('confirmDelete');
        
        confirmButton.href = `/menu/delete/${productId}`;
        
        modal.classList.remove('hidden');
    }

    function closeModal() {
        const modal = document.getElementById('deleteModal');
        modal.classList.add('hidden');
    }


    $("#add-product-overlay").hide();
    $("#edit-product-overlay").hide();
    $("#close-add-product-overlay").on("click", function() {
        $("#add-product-overlay").hide();
    });
    $("#open-add-product-overlay").on("click", function() {
        $("#add-product-overlay").show();
    });
    $("#close-edit-product-overlay").on("click", function() {
        $("#edit-product-overlay").hide();
    });
    $(".open-edit-product-overlay").on("click", function() {
        let catogoryMenuItem = $(this).parent().parent().parent().parent().find(".productcatogory").val();
        let nameMenuItem = $(this).parent().parent().parent().parent().find(".productnaam").text();
        let descriptionMenuItem = $(this).parent().parent().parent().parent().find(".productdescription").text();
        let priceMenuItem = $(this).parent().parent().parent().parent().find(".productprice").text();
        let idMenuItem = $(this).closest('.product').find('.findproductid').attr('id');
        priceMenuItem = priceMenuItem.replace("€", "");

        // Zorg ervoor dat de route geen extra "/edit" bevat
        let routeUrl = `/menu_dashboard/${idMenuItem}`;
        $("#edit-product-form").attr("action", routeUrl);

        console.log("Form action:", $("#edit-product-form").attr("action"));

        // Vul de velden in
        $("#editProductCatogory").val(catogoryMenuItem);
        $("#editProductName").val(nameMenuItem);
        $("#editProductDescription").val(descriptionMenuItem);
        $("#editProductPrice").val(priceMenuItem);

        $("#edit-product-overlay").show();
    });

    function checkTbodyAndExecute(callback) {
        const tbody = document.getElementById("order-sumup");

        if (tbody.querySelectorAll('tr').length === 0) {
            $("#hide-if-empty-orders").hide();
            $("#no-results-order-sumup").show();
        } else {
            $("#hide-if-empty-orders").show();
            $("#no-results-order-sumup").hide();
        }
    }

    function mergeDuplicateItems() {
        const tbody = document.getElementById("order-sumup");

        const itemCounts = {};

        // Haal alle tr-elementen op
        const rows = Array.from(tbody.querySelectorAll('tr'));

        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            if (cells.length > 0) {
                const itemName = cells[0].innerText.trim();
                if (itemCounts[itemName]) {
                    itemCounts[itemName].count += 1;
                    tbody.removeChild(row);
                } else {
                    itemCounts[itemName] = { count: 1, row };
                }
            }
        });

        Object.values(itemCounts).forEach(({ count, row }) => {
            const cells = row.querySelectorAll('td');
            if (count > 1 && cells.length > 0) {
                let itemText = cells[0].innerText;
                let currentQuantity = parseInt(itemText.match(/\d+/));
                
                if (currentQuantity) {
                    itemText = itemText.replace(currentQuantity, currentQuantity + count);
                } else {
                    itemText = `${itemText} ${count}x`;
                }
                
                cells[0].innerText = itemText;

                const priceCell = row.querySelector('.product-price');
                if (priceCell) {
                    const price = parseFloat(priceCell.innerText.replace('€', '').trim());
                    const totalPrice = price * count;
                    priceCell.innerText = `€${totalPrice.toFixed(2)}`;
                }
            }
        });
    }

    // Update de tabelweergave
    function updateOrderSummary() {
        const tbody = document.querySelector('#order-summary tbody');
        tbody.innerHTML = ''; // Wis bestaande rijen

        orderItems.forEach((item, index) => {
            const row = document.createElement('tr');
            row.id = `order-sumup-single-item-${index}`; // Unieke ID voor de rij
            row.innerHTML = `
                <td class="border-t border-[#f7f7f7] px-4 py-[0.5rem]">${item.name}</td>
                <td class="border-t border-[#f7f7f7] px-4 py-[0.5rem] product-price">€${item.price.toFixed(2)}</td>
                <td class="border-t border-[#f7f7f7] text-center">
                    <button class="delete-item text-start text-red-500" data-index="${index}">
                        <i class="bi bi-trash text-red-500 cursor-pointer"></i>
                    </button>
                </td>
            `;
            tbody.appendChild(row);
        });

        checkTbodyAndExecute();

        // Voeg eventlisteners toe aan verwijderknoppen
        document.querySelectorAll('.delete-item').forEach(button => {
            button.addEventListener('click', function () {
                const index = parseInt(this.getAttribute('data-index'));
                if (!isNaN(index)) {
                    orderItems.splice(index, 1); // Verwijder item uit array
                    updateOrderSummary(); // Herlaad de tabel en herbereken de totaalprijs
                }
            });
        });

        mergeDuplicateItems();

        // Bereken de totaalprijs
        let total = 0;
        document.querySelectorAll(".product-price").forEach((element) => {
            let price = parseFloat(element.textContent.replace('€', '').trim());
            if (!isNaN(price)) {
                total += price;
            }
        });

        totalExBtw = total - ((total / 100) * 9)
        // Plaats het totaal in de #order-totaalprijs
        document.getElementById("order-totaalprijs").textContent = `€ ${total.toFixed(2)}`;
        document.getElementById("order-totaalprijs-ex-btw").textContent = `€ ${totalExBtw.toFixed(2)}`
    }

    // check voor de order tijd
    function checkTabs() {
        var currentTime = new Date();
        var currentHour = currentTime.getHours();

        if (currentHour >= 16) {
            enableTab('Diner');
            enableTab('Dessert');
            disableTab('Lunch');
        } 
        if (currentHour >= 9 && currentHour < 16)
        {
            enableTab('Lunch')
            disableTab('Diner');
            disableTab('Dessert');
        }

    }

    function disableTab(category) {
        // Zoek de tab met de opgegeven categorie
        var tab = document.querySelector('a[href="javascript:void(0)"][onclick*="' + category + '"]');
        if (tab) {
            // Voeg de klasse 'disabled' toe zodat de tab niet klikbaar is
            tab.classList.remove('enabled');
            tab.classList.add('disabled');
        }
    }
    function enableTab(category) {
        // Zoek de tab met de opgegeven categorie
        var tab = document.querySelector('a[href="javascript:void(0)"][onclick*="' + category + '"]');
        if (tab) {
            // Voeg de klasse 'enabled' toe zodat de tab klikbaar is
            tab.classList.remove('disabled');
            tab.classList.add('enabled');
        }
    }

    window.onload = checkTabs;

    // Bevestig bestelling
    document.getElementById('confirm-order').addEventListener('click', function () {
    const tableNumber = document.getElementById('table_number').value;

    if (!tableNumber) {

        document.getElementById("alert").classList.remove("hidden");
        document.getElementById("alert2").classList.add("hidden");

        document.getElementById("tekst").textContent = "Voer een tafelnummer in.";
        return;
    }
    if (orderItems.length === 0) {

        document.getElementById("alert").classList.remove("hidden");
        document.getElementById("alert2").classList.add("hidden");

        document.getElementById("tekst").textContent = "Voeg minstens één item toe aan de bestelling.";
        
        return;
    } else {
        document.getElementById("alert").classList.add("hidden");

    }

    console.log('Preparing to send order:', {
        table_number: tableNumber,
        items: orderItems
    });

    fetch('/orders/store', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            table_number: tableNumber,
            items: orderItems
        }),
    })
    .then(response => response.json())
    .then(data => {
        console.log('Response from server:', data);
        if (data.success) {
            document.getElementById("alert2").classList.remove("hidden");
            document.getElementById("tekst2").textContent = "Bestelling succesvol opgeslagen!";
            orderItems = []; // Reset de bestelling
            updateOrderSummary();
            document.getElementById('table_number').value = ''; // Reset invoer
        } else {
            alert('Fout bij het opslaan van de bestelling.');
        }
    })
    .catch(error => {
    });
});

    // Categorieën wisselen
    function showCategory(category, element) {
        // Verberg alle secties
        document.querySelectorAll('.category-section').forEach(section => {
            section.classList.add('hidden');
        });

        // Toon de actieve sectie
        const activeSection = document.getElementById(category);
        if (activeSection) activeSection.classList.remove('hidden');

        // Reset alle links
        document.querySelectorAll('.nav-item a').forEach(link => {
            link.classList.remove('active');
            link.classList.add('text-white');
            link.style.color = ''; // Reset tekstkleur
            link.style.borderBottom = ''; // Reset border
        });

        // Markeer de actieve link
        if (element) {
            element.classList.add('active');
            element.classList.remove('text-white');
            element.style.color = '#fff';
            element.style.borderBottom = '2px solid #f7f7f7';
        }
    }

    let searchInput = $('#search');
    let items = $('.product');
    searchInput.on('input', function() {
        let searchText = searchInput.val().toLowerCase();
        console.log(items);
        items.each(function() {
            let name = $(this).find('.productnaam').text().toLowerCase();
            console.log(name);
            name = name.trim();
            if (name.includes(searchText)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
</script>