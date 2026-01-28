<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Orders') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-[1.5rem]">
            <h2 class="text-3xl font-semibold mb-6">Edit status</h2>

<form action="{{ route('orders.update', $orders->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="status">Status:</label>
        <select name="status" id="status" class="form-control" required>
            <option value="">-- Selecteer een order status --</option>
            @foreach ($statuses as $status)
                <option value="{{ $status->status }}">{{ $status->status }}</option>
            @endforeach
        </select>
    </div>

    <!-- Submit -->
    <button type="submit" class="btn btn-primary mt-4">Status bewerken</button>
</form>
</div>
</div>
</x-app-layout>
