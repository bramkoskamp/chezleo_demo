<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class EmployeeRegisterController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register-employee');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'phone_number' => ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        if (User::where('email', $request->email)->first() != null) {
            return redirect(RouteServiceProvider::EMPLOYEE_HOME)->with('error', 'Dit emailadres is al in gebruik!');
        } else if (User::where('phone_number', $request->phone_number)->first() != null) {
            return redirect(RouteServiceProvider::EMPLOYEE_HOME)->with('error', 'Dit telefoonnummer is al in gebruik!');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
            'role_id' => 2,
        ]);

        event(new Registered($user));


        return redirect(RouteServiceProvider::EMPLOYEE_HOME)->with('success', 'Medewerkersaccount is aangemaakt!');	

    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class.',email,'.$id],
            'phone_number' => ['required', 'string', 'max:255'],
            ]);

        $user = User::findOrFail($id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
        ]);

        return redirect(RouteServiceProvider::EMPLOYEE_HOME)->with('success', 'Medewerkersaccount is aangepast!');
    }
}
