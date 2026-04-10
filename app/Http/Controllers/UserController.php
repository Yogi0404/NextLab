<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function exportPdfUser(Request $request)
    {
        $query = Peminjaman::with('alat')
            ->where('user_id', auth()->id());

        if ($request->from && $request->to) {
            $query->whereBetween('tanggal_pinjam', [$request->from, $request->to]);
        }

        $data = $query->get();

        $pdf = PDF::loadView('user.pdf', compact('data'));

        return $pdf->download('riwayat.pdf');
    }

    public function index()
    {
        $adminsPetugas = User::whereIn('role', ['admin', 'petugas'])
            ->orderByRaw("FIELD(role, 'admin', 'petugas')")
            ->get();

        $usersOnly = User::where('role', 'user')->get();

        return view('admin.user.index', compact('adminsPetugas', 'usersOnly'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,petugas,user',
        ]);

        \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('user.index')
            ->with('success', 'User berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = \App\Models\User::findOrFail($id);
        return view('admin.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = \App\Models\User::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required', // 🔥 optional tapi bagus
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role, // 🔥 INI KUNCINYA
        ];

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('user.index')
            ->with('success', 'User berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = \App\Models\User::findOrFail($id);
        $user->delete();

        return redirect()->route('user.index')
            ->with('success', 'User berhasil dihapus!');
    }
}
