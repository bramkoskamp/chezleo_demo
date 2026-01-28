<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight pt-[0.5rem]">
                Medewerkers
            </h2>

            <div class="w-1/3 flex justify-end gap-[1rem]">
                <div class="relative w-56">
                    <input type="text" id="search" class="w-full pl-10 pr-4 py-2 text-sm border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50 placeholder-gray-500" placeholder="Zoeken op naam...">
                    <i class="bi bi-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500"></i>
                </div>
            </div>
        </div>
    </x-slot>

    <div id="deleteModal" class="fixed w-full h-screen z-[999] top-0 left-0 items-center justify-center bg-black bg-opacity-25 hidden">
        <div class="bg-white p-[2rem] rounded-[10px]">
            <h2 class="text-xl font-bold mb-[2rem]">Weet je zeker dat je deze medewerker wilt verwijderen?</h2>
            <div class="w-full flex justify-center gap-[0.5rem]">
                <button onclick="closeModal()" class="px-[2rem] py-[0.75rem] rounded-[5px] font-bold bg-gray-200 text-gray-700">Annuleren</button>
                <a id="confirmDelete" href="#" class="px-[2rem] py-[0.75rem] rounded-[5px] font-bold bg-red-500 text-white">Verwijderen</a>
            </div>
        </div>
    </div>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-[1.5rem]">
            @if(session('success'))
            <div class="p-4 mb-6 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
            @elseif (session('error'))
            <div class="p-4 mb-6 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
            @endif
            <div class="w-full h-auto flex gap-[4rem]">
                <div class="w-1/3 h-full">
                    <h2 class="text-3xl font-semibold mb-6">Nieuwe medewerker toevoegen</h2>

                    <!-- Formulier om een medewerker aan te maken -->
                    <x-validation-errors class="mb-4" />

                    <form method="POST" action="{{ route('register-employee') }}" class="bg-white p-6 rounded-[10px]">
                        @csrf

                        <div class="mb-3">
                            <label for="name" value="{{ __('Name') }}" class="block text-gray-700">Volledige naam</label>
                            <input type="text" id="name" name="name" class="mt-2 rounded-[5px] block w-full p-2 border border-gray-300" :value="old('name')" required autofocus autocomplete="name" />
                        </div>

                        <div class="mb-3">
                            <label for="email" class="block text-gray-700" value="{{ __('Email') }}">Email</label>
                            <input type="email" id="email" name="email" class="mt-2 block w-full p-2 border border-gray-300 rounded-[5px]" :value="old('email')" required autocomplete="username" />
                        </div>

                        <div class="mb-3">
                            <label for="phone_number" class="block text-gray-700" value="{{ __('Email') }}">Telefoonnummer</label>
                            <input type="tel" id="phone_number" name="phone_number" class="mt-2 block w-full p-2 border border-gray-300 rounded-[5px]" :value="old('phone_number')" required autocomplete="phone_number" />
                        </div>

                        <div class="mb-3">
                            <label for="password" class="block text-gray-700" value="{{ __('Password') }}">Wachtwoord</label>
                            <input type="password" id="password" name="password" class="mt-2 block w-full p-2 border border-gray-300 rounded-[5px]" required autocomplete="new-password">
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="block text-gray-700" value="{{ __('Password') }}">Herhaal Wachtwoord</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="mt-2 block w-full p-2 border border-gray-300 rounded-[5px]" required autocomplete="new-password">
                        </div>

                        @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                        <div class="mt-4">
                            <x-label for="terms">
                                <div class="flex items-center">
                                    <x-checkbox name="terms" id="terms" required />

                                    <div class="ms-2">
                                        {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Privacy Policy').'</a>',
                                        ]) !!}
                                    </div>
                                </div>
                            </x-label>
                        </div>
                        @endif

                        <button type="submit" class="bg-[#FEA116] mt-[1rem] text-white px-[2rem] py-[0.75rem] rounded-[5px]  font-bold text-[14px]">Medewerker toevoegen</button>
                    </form>
                </div>
                <div class="w-2/3 h-full">
                    <!-- medewerkers lijst -->
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
                                @foreach($employees as $employee)
                                <tr class="border-t border-gray-100">
                                    <td class="py-3 px-4">{{ $employee->id }}</td>
                                    <td class="py-3 px-4">{{ $employee->name }}</td>
                                    <td class="py-3 px-4">{{ $employee->email }}</td>
                                    <td class="py-3 px-4">{{ $employee->phone_number }}</td>
                                    <td>
                                        <a href="/profile/edit/{{ $employee->id }}">
                                            <i class="bi bi-pencil text-[#FEA116] cursor-pointer"></i>
                                        </a>
                                        <a href="#"
                                            onclick="openModal('{{ $employee->id }}')"
                                            class="mr-[1.5rem] ml-[0.5rem]">
                                            <i class="bi bi-trash text-red-500 cursor-pointer"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Paginatielinks -->
                        <div class="mt-4">
                            {{ $employees->links() }}
                        </div>

                        <div class="w-full h-auto rounded-[10px] py-[1rem] px-[2rem] bg-white mb-[2rem]" id="no-results-employees-sumup">
                            <p class="opacity-50 text-[12px]">Geen medewerkers gevonden...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    let searchInput = $('#search');
    let items = $('.item'); // Select the parent container of the table

    searchInput.on('input', function() {
        let searchText = searchInput.val().toLowerCase();
        let rowFound = false;

        items.find('tbody tr').each(function() {
            let name = $(this).find('td:nth-child(2)').text().toLowerCase();
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

    function openModal(employeeId) {
        const modal = document.getElementById('deleteModal');
        const confirmButton = document.getElementById('confirmDelete');

        // Stel de juiste link in
        confirmButton.href = `/profile/delete/${employeeId}`;

        // Toon de modal
        modal.classList.remove('hidden');
    }

    function closeModal() {
        const modal = document.getElementById('deleteModal');
        modal.classList.add('hidden');
    }

    function checkTableContent() {
        if ($('table.hide-if-empty tbody tr').length === 0) {
            $('table.hide-if-empty').hide();
            $('#no-results-employees-sumup').show();
        } else {
            $('table.hide-if-empty').show();
            $('#no-results-employees-sumup').hide();
        }
    }

    checkTableContent();
</script>