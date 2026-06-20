<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Services\SupabaseStorageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct(private SupabaseStorageService $supabaseStorage) {}

    public function index(): View
    {
        $products = Product::with('category')->latest()->paginate(15);

        return view('admin.products.index', compact('products'));
    }

    public function create(): View
    {
        $categories = Category::orderBy('nama_kategori')->get();

        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request, requirePhoto: true);
        $data['foto'] = $this->supabaseStorage->upload($request->file('foto'));

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Menu berhasil ditambahkan ke Supabase.');
    }

    public function edit(Product $product): View
    {
        $categories = Category::orderBy('nama_kategori')->get();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $data = $this->validated($request);

        if ($request->hasFile('foto')) {
            $this->deletePhoto($product->foto);
            $data['foto'] = $this->supabaseStorage->upload($request->file('foto'));
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Menu berhasil diperbarui.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $this->deletePhoto($product->foto);
        $product->delete();

        return back()->with('success', 'Menu berhasil dihapus.');
    }

    private function deletePhoto(?string $foto): void
    {
        if (blank($foto)) {
            return;
        }

        if (str_starts_with($foto, 'http')) {
            $this->supabaseStorage->delete($foto);

            return;
        }

        Storage::disk('public')->delete($foto);
    }

    private function validated(Request $request, bool $requirePhoto = false): array
    {
        $rules = [
            'category_id' => ['required', 'exists:categories,id'],
            'nama_produk' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'harga' => ['required', 'numeric', 'min:0'],
            'stok_status' => ['required', 'in:tersedia,habis'],
            'is_featured' => ['nullable', 'boolean'],
            'foto' => [$requirePhoto ? 'required' : 'nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ];

        return $request->validate($rules) + ['is_featured' => $request->boolean('is_featured')];
    }
}
