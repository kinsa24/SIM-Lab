<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Barang;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers  = User::count();
        $totalBarang = Barang::count();
        $stokKritis  = Barang::whereColumn('stok', '<=', 'stok_min')->count();
        $stokHabis   = Barang::where('stok', 0)->count();
        $totalPinjam = 0;
        $lastOpname  = null;

        $barangMenipis = Barang::whereColumn('stok', '<=', 'stok_min')
                                ->where('stok', '>', 0)
                                ->orderBy('stok')
                                ->take(5)
                                ->get();

        return view('dashboard', compact(
            'totalUsers', 'totalBarang', 'stokKritis', 'stokHabis',
            'totalPinjam', 'lastOpname', 'barangMenipis'
        ));
    }
}
