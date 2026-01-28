<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Menu') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-[1.5rem]">
            <h2 class="text-3xl font-semibold mb-6">Edit menu item</h2>
<h1>Edit Menu Item</h1>

<form action="{{ route('menu_dashboard.update', $menu->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label>Category</label>
        <input type="text" name="category" class="form-control" value="{{ $menu->category }}" required>
    </div>
    <div class="form-group">
        <label>Name</label>
        <input type="text" name="name" class="form-control" value="{{ $menu->name }}" required>
    </div>
    <div class="form-group">
        <label>Description</label>
        <textarea name="description" class="form-control">{{ $menu->description }}</textarea>
    </div>
    <div class="form-group">
        <label>Price</label>
        <input type="number" name="price" step="0.01" class="form-control" value="{{ $menu->price }}" required>
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
</form>
</x-app-layout>
