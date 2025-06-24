<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use Illuminate\Support\Facades\Storage;


class UserController extends Controller
{
    // Show all users
    public function index()
    {
        $users = User::with(['country', 'state', 'city'])->latest()->get();
        return view('users.index', compact('users'));
    }

    // Show form
    public function create()
    {
        $countries = Country::all();
        return view('users.create', compact('countries'));
    }

    // Store user
    public function store(Request $request)
    {
        $request->validate([
            'firstname' => 'required',
            'lastname'  => 'required',
            'email'     => 'required|email|unique:users,email',
            'address'   => 'required',
            'country_id'=> 'required',
            'state_id'  => 'required',
            'city_id'   => 'required',
            'image'     => 'nullable|image|mimes:jpeg,png,jpg|max:20480',
        ]);

        $data = $request->all();

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $data['image'] = $imagePath;
        }

        User::create($data);
        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    // Edit form
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $countries = Country::all();
        $states = State::where('country_id', $user->country_id)->get();
        $cities = City::where('state_id', $user->state_id)->get();

        return view('users.edit', compact('user', 'countries', 'states', 'cities'));
    }

    // Update user
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'firstname' => 'required',
            'lastname'  => 'required',
            'email'     => 'required|email|unique:users,email,' . $id,
            'address'   => 'required',
            'country_id'=> 'required',
            'state_id'  => 'required',
            'city_id'   => 'required',
            'image'     => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            // Delete old image
            if ($user->image && Storage::disk('public')->exists($user->image)) {
                Storage::disk('public')->delete($user->image);
            }
            $data['image'] = $request->file('image')->store('images', 'public');
        }

        $user->update($data);
        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    // Delete user
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->image && Storage::disk('public')->exists($user->image)) {
            Storage::disk('public')->delete($user->image);
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    // AJAX: Get states
    public function getStates($country_id)
    {
        $states = State::where('country_id', $country_id)->get();
        return response()->json($states);
    }

    // AJAX: Get cities
    public function getCities($state_id)
    {
        $cities = City::where('state_id', $state_id)->get();
        return response()->json($cities);
    }
}

