<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        $barangs = Barang::orderBy('nama')->get();
        return view('barang.index', compact('barangs'));
    }

    public function create()
    {
        return view('barang.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => ['required', 'string', 'unique:barangs,kode'],
            'nama' => ['required', 'string', 'max:255'],
            'stok' => ['required', 'integer', 'min:0'],
        ]);

        Barang::create($request->only('kode', 'nama', 'kategori', 'satuan', 'stok', 'stok_min', 'keterangan'));

        return redirect('/barang')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function edit(Barang $barang)
    {
        return view('barang.edit', compact('barang'));
    }

    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            'kode' => ['required', 'string', 'unique:barangs,kode,' . $barang->id],
            'nama' => ['required', 'string', 'max:255'],
            'stok' => ['required', 'integer', 'min:0'],
        ]);

        $barang->update($request->only('kode', 'nama', 'kategori', 'satuan', 'stok', 'stok_min', 'keterangan'));

        return redirect('/barang')->with('success', 'Barang berhasil diupdate.');
    }

    public function destroy(Barang $barang)
    {
        $barang->delete();
        return redirect('/barang')->with('success', 'Barang berhasil dihapus.');
    }
}
