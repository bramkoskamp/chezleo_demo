<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Orders') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-[1.5rem]">
            <h2 class="text-3xl font-semibold mb-6">Nieuwe Bestelling</h2>

<form action="{{ route('orders.store') }}" method="POST">
    @csrf

    <!-- Tafelnummers -->
    <div class="form-group">
        <label for="table_number">Tafelnummer:</label>
        <select name="table_number" id="table_number" class="form-control" required>
            <option value="">-- Selecteer een tafel --</option>
            @foreach ($tables as $table)
                <option value="{{ $table->id }}">Tafel {{ $table->id }}</option>
            @endforeach
        </select>
    </div>

    <!-- Menu-items -->
    <div class="form-group mt-4">
        <label for="menu_items">Menu Items:</label>
        <div id="menu_items">
            @foreach ($menus as $menu)
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="menu_item" value="{{ $menu['id'] }}" id="menu_item_{{ $menu['id'] }}">
                    <label class="form-check-label" for="menu_item_{{ $menu['id'] }}">
                        {{ $menu['name'] }} (€{{ number_format($menu['price'], 2) }})
                    </label>
                    <input type="number" class="form-control mt-1" name="items[{{ $menu['id'] }}][quantity]" placeholder="Aantal" min="1" value="1">
                    <input type="hidden" name="items[{{ $menu['id'] }}][price]" value="{{ $menu['price'] }}">
                </div>
            @endforeach
        </div>
    </div>

    <!-- Submit -->
    <button type="submit" class="btn btn-primary mt-4">Bestelling Aanmaken</button>
</form>
</div>
</div>
</x-app-layout>
