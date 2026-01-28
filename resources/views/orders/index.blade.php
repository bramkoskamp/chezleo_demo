<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Orders') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-[1.5rem]">
            <h2 class="text-3xl font-semibold mb-6">Orders</h2>

    <a href="{{ route('menu.menu') }}" class="btn bg-blue-500 text-white px-4 py-2 rounded"><i class="bi bi-plus"></i> Add New order</a>
    <div class="mt-8">
    <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
        <thead>
            <tr class="text-left bg-gray-200">
                <th class="py-3 px-4 text-sm font-semibold text-gray-700">Tafel</th>
                <th class="py-3 px-4 text-sm font-semibold text-gray-700">Menu item</th>
                <th class="py-3 px-4 text-sm font-semibold text-gray-700">Aantal</th>
                <th class="py-3 px-4 text-sm font-semibold text-gray-700">Status</th>
                <th class="py-3 px-4"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td class="py-3 px-4 border-b border-gray-300">{{ $order->table_number }}</td>
                    <td class="py-3 px-4 border-b border-gray-300">
                        
                    </td>
                    <td class="py-3 px-4 border-b border-gray-300">
                        
                    </td>
                    <td class="py-3 px-4 border-b border-gray-300">{{ $order->status }}</td>
                    <td class="border-b border-gray-300">
                        <a href="/orders/{{ $order->id }}/edit">
                            <i class="bi bi-pencil text-blue-500 cursor-pointer"></i>
                        </a>
                        <form action="{{ route('orders.destroy', $order->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn" onclick="return confirm('Are you sure?')"><i class="bi bi-trash ms-5 text-red-500 cursor-pointer"></i></button>
                    </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>
</x-app-layout>