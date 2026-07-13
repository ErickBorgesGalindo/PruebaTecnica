<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\Profile;
use App\Exports\ProductsExport;
use App\Exports\UsersExport;
use App\Exports\ProfilesExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function productsPdf()
    {
        $products = Product::all();
        $pdf = Pdf::loadView('exports.products', compact('products'));
        return $pdf->download('productos.pdf');
    }

    public function productsExcel()
    {
        return Excel::download(new ProductsExport, 'productos.xlsx');
    }

    public function usersPdf()
    {
        $users = User::all();
        $pdf = Pdf::loadView('exports.users', compact('users'));
        return $pdf->download('usuarios.pdf');
    }

    public function usersExcel()
    {
        return Excel::download(new UsersExport, 'usuarios.xlsx');
    }

    public function profilesPdf()
    {
        $profiles = Profile::all();
        $pdf = Pdf::loadView('exports.profiles', compact('profiles'));
        return $pdf->download('perfiles.pdf');
    }

    public function profilesExcel()
    {
        return Excel::download(new ProfilesExport, 'perfiles.xlsx');
    }
}