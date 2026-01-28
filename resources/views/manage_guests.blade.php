<x-app-layout>
    <x-slot name="header">
    <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight pt-[0.5rem]">
                Gasten
            </h2>

                <div class="w-1/3 flex justify-end gap-[1rem]">
                    <div class="relative w-56">
                        <input type="text" id="search" class="w-full pl-10 pr-4 py-2 text-sm border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50 placeholder-gray-500" placeholder="Zoeken op naam...">
                        <i class="bi bi-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500"></i>
                    </div>
                </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-[1.5rem]">
            <div class="w-full h-auto flex flex-col gap-[4rem]">
                <div class="w-full h-full">

                    <!-- Success Message -->
                    @if(session('success'))
                    <div class="mb-4">
                        <ul class="mt-3 list-disc list-inside text-sm text-green-600">
                            <li>{{ session('success') }}</li>
                        </ul>
                    </div>
                    @endif
                </div>
                <div class="w-full h-full">
                    <!-- gasten lijst -->
                    <div class="mt-8 item">
                        <h2 class="text-3xl font-semibold mb-6">Overzicht</h2>
                        <table class="min-w-full bg-white border-none rounded-[10px] overflow-hidden hidden hide-if-empty">
                            <thead>
                                <tr class="text-left bg-[#FEA116] rounded-[10px]">
                                    <th class="py-3 px-4 text-sm text-white font-bold">Id</th>
                                    <th class="py-3 px-4 text-sm font-bold text-white">Naam</th>
                                    <th class="py-3 px-4 text-sm font-bold text-white">Email</th>
                                    <th class="py-3 px-4 text-sm font-bold text-white">Telefoon</th>
                                    <th class="py-3 px-4"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($guests as $guest)
                                <tr class="border-t border-gray-100">
                                    <td class="py-3 px-4">{{ $guest->id }}</td>
                                    <td class="py-3 px-4">{{ $guest->name }}</td>
                                    <td class="py-3 px-4">{{ $guest->email }}</td>
                                    <td class="py-3 px-4">{{ $guest->phone_number }}</td>
                                    <td>
                                        <a href="/manage_guest/delete/{{ $guest->id }}" onclick="return confirmDelete()">
                                            <i class="bi bi-trash text-red-500 cursor-pointer"></i>
                                        </a>
                                    </td> 
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Paginatielinks -->
                        <div class="mt-4">
                            {{ $guests->links() }}
                        </div>

                        <div class="w-full h-auto rounded-[10px] py-[1rem] px-[2rem] bg-white mb-[2rem]" id="no-results-guests-sumup">
                            <p class="opacity-50 text-[12px]">Geen gasten gevonden...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    let searchInput = $('#search');
    let items = $('.item'); 

searchInput.on('input', function() {
    let searchText = searchInput.val().toLowerCase();
    let rowFound = false; 

    items.find('tbody tr').each(function() {
        let name = $(this).find('td:nth-child(2)').text().toLowerCase(); 
        name = name.trim();

        if (name.includes(searchText)) {
            $(this).show();
            rowFound = true; // Mark that at least one row matches
        } else {
            $(this).hide();
        }
    });

    // Show or hide the "no results" message
    if (rowFound) {
        $('#no-results-guests-sumup').hide();
        items.find('table').removeClass('hidden');
    } else {
        $('#no-results-guests-sumup').show();
        items.find('table').addClass('hidden');
    }
});

    
    function confirmDelete() {
        return confirm('Weet je zeker dat je dit account wilt verwijderen?');
    }
    function checkTableContent() {
        if ($('table.hide-if-empty tbody tr').length === 0) {
            $('table.hide-if-empty').hide();
            $('#no-results-guests-sumup').show();
        } else {
            $('table.hide-if-empty').show();
            $('#no-results-guests-sumup').hide();
        }
    }
    
    checkTableContent();
</script>