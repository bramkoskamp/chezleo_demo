<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Menu') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-[1.5rem]">
            <h2 class="text-3xl font-semibold mb-6">Menu</h2>

            <a href="{{ route('menu_dashboard.create') }}" class=" bg-[#FEA116] text-white px-[2rem] py-[0.75rem] font-bold rounded-[5px] text-[14px]">Voeg product toe</a>
            <div class="mt-8">
                <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
                    <thead>
                        <tr class="text-left bg-gray-200">
                            <th class="py-3 px-4 text-sm font-semibold text-gray-700">Category</th>
                            <th class="py-3 px-4 text-sm font-semibold text-gray-700">Name</th>
                            <th class="py-3 px-4 text-sm font-semibold text-gray-700">Description</th>
                            <th class="py-3 px-4 text-sm font-semibold text-gray-700">Price</th>
                            <th class="py-3 px-4 text-sm font-semibold text-gray-700"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($menu as $item)
                        <tr>
                            <td class="py-3 px-4 border-b border-gray-300">{{ $item->category }}</td>
                            <td class="py-3 px-4 border-b border-gray-300">{{ $item->name }}</td>
                            <td class="py-3 px-4 border-b border-gray-300">{{ $item->description }}</td>
                            <td class="py-3 px-4 border-b border-gray-300">€{{ number_format($item->price, 2) }}</td>
                            <td class="border-b border-gray-300">
                                <a href="/menu_dashboard/{{ $item->id }}/edit">
                                    <i class="bi bi-pencil text-blue-500 cursor-pointer"></i>
                                </a>
                                <form action="{{ route('menu_dashboard.destroy', $item->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn" onclick="return confirm('Are you sure?')"><i class="bi bi-trash ms-5 text-red-500 cursor-pointer"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="pagination mt-8">
                    {{ $menu->links() }}
                </div>
            </div>
        </div>
</x-app-layout>