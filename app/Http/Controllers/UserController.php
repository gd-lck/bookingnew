<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();
    
        if ($search = $request->search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('telepon', 'like', "%{$search}%");
            });
        }
    
        if ($request->filled('role')) {
            $query->role($request->role); 
        }
    
        $users = $query->paginate(10);
    
        return view('admin.user.index', compact('users'));
    }

    public function store(Request $request){
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'telepon' => ['required', 'regex:/^[0-9]{10,15}$/'],
            'alamat' => ['required', 'string', 'max:255'],
            'password' => ['required', Rules\Password::defaults()],
        ]);

       
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole('admin');

        return redirect()->back()->with('success', 'Admin berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,$id",
            'telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:255',
        ]);

        $user = User::findOrFail($id);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
        ]);

    return redirect()->back()->with('success', 'User berhasil diperbarui.');
    }

    public function destroy($id)
    {
    $user = User::findOrFail($id);

    if (auth()->id() == $user->id) {
        return redirect()->back()->with('error', 'tidak bisa menghapus diri sendiri');
    }

    $user->delete();

    return redirect()->back()->with('success', 'User berhasil dihapus.');
    }
    
}
