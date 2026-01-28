<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

use Illuminate\Http\Request;

use App\Models\Menu;
use App\Models\DinnerTable;
use App\Models\Category;
use App\Models\Reservation;
use App\Models\Review;

class MenuController extends Controller
{
    public function menu()
    {
        $menu = Menu::all();
        $reviews = Review::all();
        return view("index", compact("menu", "reviews"));
    }
    public function index()
    {
        $menu = Menu::all();
        $tables = DinnerTable::all(); 
        $categories = Category::all();

        return view('menu.guest_menu', compact('menu', 'tables', 'categories'));
    }
    
    public function create()
    {
        return view('menu.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|string',
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric|min:1'
        ]);
    
        if($request['price'] < 0.01)
        {
            return redirect()->back()->withErrors(['price' => 'Prijs moet meer dan €0 zijn.']);
        }

        Menu::create($request->all());
        return redirect()->route('menu.menu')->with('success', 'Menu item created successfully');
    }
    
    public function show($id)
    {
        $menu = Menu::findOrFail($id);
        return view('menu_dashboard.show', compact('menu'));
    }
    
    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        return view('menu.edit', compact('menu'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category' => 'required|string',
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric|min:1',
        ]);
    
        $menu = Menu::find($id);
        if (!$menu) {
            return redirect()->route('menu.menu')->with('error', 'Menu item not found.');
        }

        if($request['price'] < 0.01)
        {
            return redirect()->back()->withErrors(['price' => 'Prijs moet meer dan €0 zijn.']);
        }
    
        $menu->update([
            'category' => $request->category,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price
        ]);
    
        return redirect()->route('menu.menu')->with('success', 'Menu item updated successfully');
    }
    
    
    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete(); 
    
        return redirect()->route('menu.menu')->with('success', 'Menu item deleted successfully');
    }    


    public function showMenu()
    {
        $menu = Menu::all();
        $tables = DinnerTable::all();
        $catogories = Category::all();

        $now = Carbon::now();

        $reservedTables = Reservation::whereDate('reservation_date', Carbon::now())
                  ->whereTime('reservation_time', '>=', Carbon::now()->subHours(3)->format('H:i:s'))
                  ->get();

        return view('menu.menu', compact('menu', 'tables', 'catogories', 'reservedTables'));
    }
}
