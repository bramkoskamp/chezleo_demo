<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */

    public function index()
    {
        $employees = User::where('role_id', 2)->paginate(9);

        // Return the view with the users data
        return view('manage_employees', compact('employees'));
    }

    public function show_guests()
    {
        $guests = User::where('role_id', 1)->paginate(9);

        return view ('manage_guests', compact('guests'));
    }

    public function edit($id): View
    {
        $user = User::findOrFail($id);
        return view('profile.edit', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request, $id): RedirectResponse
    {

        $validatedData = $request->validated();

        $user = User::findOrFail($id);
        $user->update($validatedData);
       
        return Redirect::route('profile.edit', ['id' => $id])->with('status', 'Account is bijgewerkt');
    }

    public function delete($id)
    {
        User::findOrFail($id)->delete();

        return Redirect::route('profile.index');
    }
    
    public function deleteGuest($id)
    {
        User::findOrFail($id)->delete();

        return Redirect::route('guests_profile.index');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

}
