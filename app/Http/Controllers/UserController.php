<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $currentUserId = Auth::id();
        $users = User::where('id', '!=', $currentUserId)->get();
        
        return view('admin.users', compact('users'), ['user' => Auth::user()]);
    }

    public function profile()
    {
        return view('admin/profile', ['user' => Auth::user()]);
    }

    public function update(Request $request, $id)
    {
        User::findOrFail($id)->update($request->all());
        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'age' => 'required|integer',
            'gender' => 'required',
            'address' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'birthday' => 'required|date',
            'contact_number' => 'required',
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'age' => $request->age,
            'gender' => $request->gender,
            'address' => $request->address,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'birthday' => $request->birthday,
            'contact_number' => $request->contact_number,
        ]);

        return redirect()->route('users.view')->with('success', 'Registration successful!');
    }
}