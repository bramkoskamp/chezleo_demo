<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Menu') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-[1.5rem]">
            <h2 class="text-3xl font-semibold mb-6">Add new menu item</h2>

<form action="{{ route('menu_dashboard.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label>Category</label>
        <input type="text" name="category" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Name</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Description</label>
        <textarea name="description" class="form-control"></textarea>
    </div>
    <div class="form-group">
        <label>Price</label>
        <input type="number" name="price" step="0.01" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Save</button>
</form>
</x-app-layout>