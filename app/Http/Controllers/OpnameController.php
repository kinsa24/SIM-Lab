<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Opname;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OpnameController extends Controller
{
    public function index()
    {
        $barangs  = Barang::orderBy('nama')->get();
        $riwayat  = Opname::with(['barang', 'user'])->latest()->take(20)->get();
        return view('admin.opname.index', compact('barangs', 'riwayat'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id'   => ['required', 'exists:barangs,id'],
            'stok_fisik'  => ['required', 'integer', 'min:0'],
            'keterangan'  => ['nullable', 'string', 'max:255'],
        ]);

        $barang     = Barang::findOrFail($request->barang_id);
        $stokSistem = $barang->stok;
        $stokFisik  = (int) $request->stok_fisik;
        $selisih    = $stokFisik - $stokSistem;

        Opname::create([
            'barang_id'   => $barang->id,
            'user_id'     => Auth::id(),
            'stok_sistem' => $stokSistem,
            'stok_fisik'  => $stokFisik,
            'selisih'     => $selisih,
            'keterangan'  => $request->keterangan,
        ]);

        // Update stok barang sesuai hasil fisik
        $barang->stok = $stokFisik;
        $barang->save();

        return back()->with('success', 'Opname berhasil disimpan. Stok ' . $barang->nama . ' diperbarui menjadi ' . $stokFisik . '.');
    }
}
