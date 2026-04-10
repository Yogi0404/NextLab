<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Alat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;



class PeminjamanController extends Controller
{

    public function edit($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $users = User::all();
        $alat = Alat::all();

        return view('admin.peminjaman.edit', compact('peminjaman', 'users', 'alat'));
    }

    public function update(Request $request, $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        $request->validate([
            'user_id' => 'required',
            'alat_id' => 'required',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date',
            'status' => 'required'
        ]);

        $peminjaman->update([
            'user_id' => $request->user_id,
            'alat_id' => $request->alat_id,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'status' => $request->status,
        ]);

        return redirect()->route('peminjaman.index')->with('success', 'Data berhasil diupdate');
    }
    public function destroy($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        $peminjaman->delete();

        return redirect()->route('peminjaman.index')
            ->with('success', 'Data berhasil dihapus');
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'alat_id' => 'required',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date',
            'jumlah' => 'required|integer|min:1',
        ]);

        $alat = Alat::findOrFail($request->alat_id);

        if ($alat->stok_tersedia < $request->jumlah) {
            return back()->with('error', 'Stok tidak mencukupi!');
        }

        Peminjaman::create([
            'user_id' => $request->user_id,
            'alat_id' => $request->alat_id,
            'jumlah' => $request->jumlah,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'status' => 'dipinjam',
        ]);

        $alat->stok_tersedia -= $request->jumlah;
        $alat->save();

        return redirect()->back()->with('success', 'Peminjaman berhasil!');
    }

    public function kembalikan($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $alat = $peminjaman->alat;

        $peminjaman->status = 'dikembalikan';
        $peminjaman->save();

        $alat->stok_tersedia += $peminjaman->jumlah;
        $alat->save();

        return back()->with('success', 'Alat berhasil dikembalikan!');
    }


    public function index()
    {
        $peminjaman = Peminjaman::with(['user', 'alat'])->latest()->get();
        return view('admin.peminjaman.index', compact('peminjaman'));
    }
    public function indexpetugas()
    {
        $peminjamans = \App\Models\Peminjaman::with(['user', 'alat'])->latest()->get();

        return view('petugas.peminjaman.index', compact('peminjamans'));
    }



    public function approve($id)
    {
        $peminjaman = Peminjaman::with('alat')->findOrFail($id);
        $alat = $peminjaman->alat;
        // cek alat ada
        if (!$alat) {
            return back()->with('error', 'Alat tidak ditemukan');
        }

        // cek stok
        if ($alat->stok_tersedia < $peminjaman->jumlah) {
            return back()->with('error', 'Stok tidak cukup!');
        }

        // kurangi stok
        $alat->stok_tersedia -= $peminjaman->jumlah;
        $alat->save();

        // update status
        $peminjaman->status = 'dipinjam';
        $peminjaman->save();

        return back()->with('success', 'Peminjaman disetujui');
    }

    public function reject($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        $peminjaman->update([
            'status' => 'ditolak'
        ]);

        return back()->with('success', 'Peminjaman ditolak');
    }


    public function create()
    {
        $users = User::all();
        $alats = Alat::all();

        return view('admin.peminjaman.create', compact('users', 'alats'));
    }

    public function show($id)
    {
        $peminjaman = \App\Models\Peminjaman::with(['user', 'alat'])->findOrFail($id);

        return view('admin.peminjaman.show', compact('peminjaman'));
    }


    public function viewpengembalian()
    {
        $peminjamans = Peminjaman::with(['user', 'alat'])
            ->whereIn('status', ['dikembalikan', 'request_kembali'])
            ->latest()
            ->get();

        return view('petugas.pengembalian.index', compact('peminjamans'));
    }

    public function requestKembali($id)
    {
        $data = Peminjaman::findOrFail($id);

        if ($data->status != 'dipinjam') {
            return back()->with('error', 'Tidak valid');
        }

        $data->update([
            'status' => 'request_kembali'
        ]);

        return back()->with('success', 'Pengembalian diajukan!');
    }

    public function approveKembali($id)
    {
        $peminjaman = \App\Models\Peminjaman::findOrFail($id);

        // ubah status
        $peminjaman->status = 'dikembalikan';
        $peminjaman->save();

        // balikin stok 🔥
        $alat = $peminjaman->alat;
        $alat->stok_tersedia += $peminjaman->jumlah;
        $alat->save();

        return redirect()->back()->with('success', 'Pengembalian disetujui!');
    }
    public function tolakKembali($id)
    {
        $peminjaman = \App\Models\Peminjaman::findOrFail($id);

        // balik ke status sebelumnya
        $peminjaman->status = 'dipinjam';
        $peminjaman->save();

        return redirect()->back()->with('success', 'Pengembalian ditolak!');
    }
    public function userPinjam(Request $request)
    {
        $request->validate([
            'alat_id' => 'required',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date',
            'jumlah' => 'required|integer|min:1',
        ]);

        $alat = Alat::findOrFail($request->alat_id);

        if ($alat->stok_tersedia < $request->jumlah) {
            return back()->with('error', 'Stok tidak cukup!');
        }

        Peminjaman::create([
            'user_id' => Auth::id(), // 🔥 auto user login
            'alat_id' => $request->alat_id,
            'jumlah' => $request->jumlah,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Pengajuan peminjaman berhasil!');
    }

    public function userRequestKembali($id)
    {
        $data = Peminjaman::where('user_id', Auth::id())
            ->findOrFail($id);

        if ($data->status != 'dipinjam') {
            return back()->with('error', 'Tidak bisa ajukan pengembalian!');
        }

        $data->update([
            'status' => 'request_kembali'
        ]);

        return back()->with('success', 'Pengembalian diajukan!');
    }

    public function userRiwayat(Request $request)
    {
        $query = Peminjaman::with('alat')
            ->where('user_id', auth()->id());

        // FILTER TANGGAL
        if ($request->from && $request->to) {
            $query->whereBetween('tanggal_pinjam', [$request->from, $request->to]);
        }

        // FILTER STATUS
        if ($request->status && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        $data = $query->latest()->get();

        // DENDA
        foreach ($data as $p) {

            if (!$p->tanggal_kembali) {
                $p->telat_hari = 0;
                $p->denda_hitung = 0;
                continue;
            }

            $deadline = \Carbon\Carbon::parse($p->tanggal_kembali);

            $now = $p->status == 'dikembalikan'
                ? \Carbon\Carbon::parse($p->updated_at)
                : \Carbon\Carbon::now();

            if ($now->gt($deadline) && in_array($p->status, ['dipinjam', 'request_kembali'])) {

                $telat = $deadline->diffInDays($now);

                $p->telat_hari = $telat;
                $p->denda_hitung = $telat * 10000;
            } else {
                $p->telat_hari = 0;
                $p->denda_hitung = 0;
            }
        }

        return view('user.riwayat.index', compact('data'));
    }

    public function userAlat()
    {
        $alats = Alat::all();

        return view('user.alat.index', compact('alats'));
    }

    public function laporan(Request $request)
    {
        $query = Peminjaman::with(['user', 'alat']);

        // 🔍 SEARCH (nama user / alat)
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->whereHas('user', function ($q2) use ($request) {
                    $q2->where('name', 'like', '%' . $request->search . '%');
                })
                    ->orWhereHas('alat', function ($q2) use ($request) {
                        $q2->where('nama_alat', 'like', '%' . $request->search . '%');
                    });
            });
        }

        // 📅 FILTER TANGGAL
        if ($request->from && $request->to) {
            $query->whereBetween('tanggal_pinjam', [$request->from, $request->to]);
        }

        // 📌 FILTER STATUS
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $peminjamans = $query->latest()->get();

        return view('admin.laporan.index', compact('peminjamans'));
    }

    public function denda()
    {
        $peminjamans = Peminjaman::with(['user', 'alat'])
            ->whereIn('status', ['dipinjam', 'request_kembali', 'dikembalikan'])
            ->latest()
            ->get();

        foreach ($peminjamans as $p) {

            // skip kalau tanggal kosong / aneh
            if (!$p->tanggal_kembali || $p->tanggal_kembali == '0000-00-00') {
                $p->telat_hari = 0;
                $p->denda_hitung = 0;
                continue;
            }

            $deadline = Carbon::parse($p->tanggal_kembali);

            // kalau sudah dikembalikan pakai updated_at / sekarang
            $tanggalReal = $p->status == 'dikembalikan'
                ? Carbon::parse($p->updated_at)
                : Carbon::now();

            // CEK TELAT
            if ($tanggalReal->gt($deadline)) {

                // hitung hari telat (dibulatkan)
                $telat = $deadline->diffInDays($tanggalReal);

                $p->telat_hari = (int) $telat;
                $p->denda_hitung = $p->telat_hari * 10000;
            } else {
                $p->telat_hari = 0;
                $p->denda_hitung = 0;
            }
        }

        return view('admin.denda.index', compact('peminjamans'));
    }


    public function formBayar($id)
    {
        $p = Peminjaman::with(['user', 'alat'])->findOrFail($id);

        // 🔥 PAKAI LOGIKA YANG SAMA PERSIS
        if (!$p->tanggal_kembali || $p->tanggal_kembali == '0000-00-00') {
            $p->telat_hari = 0;
            $p->denda_hitung = 0;
        } else {

            $deadline = \Carbon\Carbon::parse($p->tanggal_kembali);

            $tanggalReal = $p->status == 'dikembalikan'
                ? \Carbon\Carbon::parse($p->updated_at)
                : \Carbon\Carbon::now();

            if ($tanggalReal->gt($deadline)) {

                $telat = $deadline->diffInDays($tanggalReal);

                $p->telat_hari = (int) $telat;
                $p->denda_hitung = $p->telat_hari * 10000; // 🔥 SAMAIN

            } else {
                $p->telat_hari = 0;
                $p->denda_hitung = 0;
            }
        }

        return view('admin.denda.bayar', compact('p'));
    }


    public function formBayarU($id)
    {
        $p = Peminjaman::with(['user', 'alat'])->findOrFail($id);

        // 🔥 PAKAI LOGIKA YANG SAMA PERSIS
        if (!$p->tanggal_kembali || $p->tanggal_kembali == '0000-00-00') {
            $p->telat_hari = 0;
            $p->denda_hitung = 0;
        } else {

            $deadline = \Carbon\Carbon::parse($p->tanggal_kembali);

            $tanggalReal = $p->status == 'dikembalikan'
                ? \Carbon\Carbon::parse($p->updated_at)
                : \Carbon\Carbon::now();

            if ($tanggalReal->gt($deadline)) {

                $telat = $deadline->diffInDays($tanggalReal);

                $p->telat_hari = (int) $telat;
                $p->denda_hitung = $p->telat_hari * 10000; 

            } else {
                $p->telat_hari = 0;
                $p->denda_hitung = 0;
            }
        }

        return view('user.riwayat.bayar', compact('p'));
    }

    public function exportpdfpetugas(Request $request)
    {
        $query = \App\Models\Peminjaman::with(['user', 'alat']);

        // FILTER DARI
        if ($request->dari) {
            $query->whereDate('tanggal_pinjam', '>=', $request->dari);
        }
        if ($request->status && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        // FILTER SAMPAI
        if ($request->sampai) {
            $query->whereDate('tanggal_pinjam', '<=', $request->sampai);
        }

        $peminjamans = $query->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView(
            'petugas.laporan.pdf',
            compact('peminjamans')
        );

        return $pdf->download('laporan.pdf');
    }

    public function prosesBayar(Request $request, $id)
    {
        $p = Peminjaman::findOrFail($id);

        // 🔥 bersihin input (10.000 → 10000)
        $nominal = str_replace(['Rp', '.', ' '], '', $request->nominal);

        if (!is_numeric($nominal) || $nominal <= 0) {
            return back()->with('error', 'Nominal tidak valid!');
        }

        // 🔥 === LOGIKA SAMA PERSIS KAYAK denda() ===
        if (!$p->tanggal_kembali || $p->tanggal_kembali == '0000-00-00') {
            $denda = 0;
        } else {

            $deadline = \Carbon\Carbon::parse($p->tanggal_kembali);

            $tanggalReal = $p->status == 'dikembalikan'
                ? \Carbon\Carbon::parse($p->updated_at)
                : \Carbon\Carbon::now();

            if ($tanggalReal->gt($deadline)) {

                $telat = $deadline->diffInDays($tanggalReal);
                $denda = (int) $telat * 10000; // 🔥 SAMAIN TOTAL

            } else {
                $denda = 0;
            }
        }
        // 🔥 =======================================

        // ❌ kalau kurang
        if ($nominal < $denda) {
            return back()->with('error', 'Nominal kurang dari denda!');
        }

        // ✅ hitung kembalian
        $kembalian = $nominal - $denda;

        // 🔥 simpan
        $p->denda = $denda; // bukan nominal bayar!
        $p->status_pembayaran = 'lunas';
        $p->status = 'dikembalikan';
        $p->save();

        return redirect()->route('peminjaman.struk', $p->id)
            ->with([
                'dibayar' => $nominal,
                'kembalian' => $kembalian
            ]);
    }
    public function prosesBayaruser(Request $request, $id)
    {
        $p = Peminjaman::findOrFail($id);

        // 🔥 bersihin input (10.000 → 10000)
        $nominal = str_replace(['Rp', '.', ' '], '', $request->nominal);

        if (!is_numeric($nominal) || $nominal <= 0) {
            return back()->with('error', 'Nominal tidak valid!');
        }

        // 🔥 === LOGIKA SAMA PERSIS KAYAK denda() ===
        if (!$p->tanggal_kembali || $p->tanggal_kembali == '0000-00-00') {
            $denda = 0;
        } else {

            $deadline = \Carbon\Carbon::parse($p->tanggal_kembali);

            $tanggalReal = $p->status == 'dikembalikan'
                ? \Carbon\Carbon::parse($p->updated_at)
                : \Carbon\Carbon::now();

            if ($tanggalReal->gt($deadline)) {

                $telat = $deadline->diffInDays($tanggalReal);
                $denda = (int) $telat * 10000; // 🔥 SAMAIN TOTAL

            } else {
                $denda = 0;
            }
        }
        // 🔥 =======================================

        // ❌ kalau kurang
        if ($nominal < $denda) {
            return back()->with('error', 'Nominal kurang dari denda!');
        }

        // ✅ hitung kembalian
        $kembalian = $nominal - $denda;

        // 🔥 simpan
        $p->denda = $denda; // bukan nominal bayar!
        $p->status_pembayaran = 'lunas';
        $p->status = 'dikembalikan';
        $p->save();

        return redirect()->route('peminjaman.strukUser', $p->id)
            ->with([
                'dibayar' => $nominal,
                'kembalian' => $kembalian
            ]);
    }

    public function struk($id)
    {
        $p = Peminjaman::with(['user', 'alat'])->findOrFail($id);

        return view('admin.denda.struk', compact('p'));
    }
    public function strukUser($id)
    {
        $p = Peminjaman::with(['user', 'alat'])->findOrFail($id);

        return view('user.riwayat.struk', compact('p'));
    }
    public function exportPdf(Request $request)
    {
        $query = Peminjaman::with(['user', 'alat']);

        // 🔍 FILTER (biar sama kayak tampilan)
        if ($request->search) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            })->orWhereHas('alat', function ($q) use ($request) {
                $q->where('nama_alat', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->from && $request->to) {
            $query->whereBetween('tanggal_pinjam', [$request->from, $request->to]);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $peminjamans = $query->latest()->get();

        $pdf = Pdf::loadView('admin.laporan.pdf', compact('peminjamans'));

        return $pdf->download('laporan-peminjaman.pdf');
    }

    public function dashboardPetugas()
    {
        $totalPeminjaman = Peminjaman::count();
        $dipinjam = Peminjaman::where('status', 'dipinjam')->count();
        $requestKembali = Peminjaman::where('status', 'request_kembali')->count();
        $selesai = Peminjaman::where('status', 'dikembalikan')->count();

        $latest = Peminjaman::with(['user', 'alat'])->latest()->take(5)->get();

        // 🔥 CHART PER BULAN
        $months = [];
        $data = [];

        for ($i = 1; $i <= 12; $i++) {

            $date = Carbon::create(null, $i, 1);

            $months[] = $date->format('M');

            $count = Peminjaman::whereYear('tanggal_pinjam', date('Y'))
                ->whereMonth('tanggal_pinjam', $i)
                ->count();

            $data[] = $count;
        }

        return view('petugas.dashboard', compact(
            'totalPeminjaman',
            'dipinjam',
            'requestKembali',
            'selesai',
            'latest',
            'months',
            'data'
        ));
    }

    public function dashboardUser()
    {
        $userId = auth()->id();

        $dipinjam = Peminjaman::where('user_id', $userId)
            ->where('status', 'dipinjam')
            ->count();

        $requestKembali = Peminjaman::where('user_id', $userId)
            ->where('status', 'request_kembali')
            ->count();

        $total = Peminjaman::where('user_id', $userId)->count();

        $latest = Peminjaman::with('alat')
            ->where('user_id', $userId)
            ->latest()
            ->limit(5)
            ->get();

        return view('user.dashboard', compact(
            'dipinjam',
            'requestKembali',
            'total',
            'latest'
        ));
    }


    public function dashboardAdmin()
    {
        // CARD
        $totalUser = User::count();
        $totalAlat = Alat::count();
        $totalPeminjaman = Peminjaman::count();
        $belumKembali = Peminjaman::where('status', 'dipinjam')->count();

        $latest = Peminjaman::latest()->take(5)->get();

        // 📊 CHART PER BULAN (LAST 6 MONTHS)
        $months = [];
        $data = [];

        for ($i = 5; $i >= 0; $i--) {

            $date = Carbon::now()->subMonths($i);

            $months[] = $date->format('M');

            $count = Peminjaman::whereYear('tanggal_pinjam', $date->year)
                ->whereMonth('tanggal_pinjam', $date->month)
                ->sum('jumlah'); // pakai jumlah biar lebih meaningful

            $data[] = $count;
        }

        return view('admin.dashboard', compact(
            'totalUser',
            'totalAlat',
            'totalPeminjaman',
            'belumKembali',
            'latest',
            'months',
            'data'
        ));
    }

    public function laporanpetugas(Request $request)
    {
        $query = Peminjaman::with(['user', 'alat']);
        if ($request->status && $request->status != 'all') {
            $query->where('status', $request->status);
        }
        // FILTER TANGGAL
        if ($request->dari && $request->sampai) {
            $query->whereBetween('tanggal_pinjam', [
                $request->dari,
                $request->sampai
            ]);
        }

        $peminjamans = $query->latest()->get();

        return view('petugas.laporan.index', compact('peminjamans'));
    }
}
