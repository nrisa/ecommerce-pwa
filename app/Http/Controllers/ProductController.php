<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('product', compact('products'));
    }
    
    public function show($id)
    {
        $userId = Auth::id();
        $product = Product::findOrFail($id);
        $userData = Auth::user()->alamat;
    
        return view('pay', compact('product', 'userData'));
    }

    public function create()
    {
        return view('product');
    }

    public function store(Request $request)
    {
        // Validasi input
        $data = $request->validate([
            'nama' => 'required',
            'harga' => 'required|numeric',
            'deskripsi' => 'required',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Simpan foto ke folder public/storage
        if($request->hasFile('foto')){
            $image = $request->file('foto');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('product'), $imageName);
            $data['foto'] = $imageName;
        }

        // Buat produk baru
        Product::create($data);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('product', compact('product'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $data = $request->validate([
            'nama' => 'required',
            'harga' => 'required|numeric',
            'deskripsi' => 'required',
        ]);

        // Jika ada foto baru, simpan ke folder public/product
        if($request->hasFile('foto')){
            $image = $request->file('foto');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('product'), $imageName);
            $data['foto'] = $imageName;
        }

        // Update data produk
        $product = Product::findOrFail($id);
        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $cart = Transaction::where('product_id', $id)->delete();
        
        // Hapus foto jika ada
        if ($product->foto) {
            $imagePath = public_path('product/') . $product->foto;
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }

}
