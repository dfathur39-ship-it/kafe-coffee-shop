@php
    $product = $product ?? null;
    $isEdit = ! empty($product?->id);
@endphp

<div class="grid gap-6 lg:grid-cols-2">
    <div class="space-y-4">
        <div>
            <label for="nama_produk" class="block text-sm font-medium text-stone-700 dark:text-stone-300">Nama Menu <span class="text-red-500">*</span></label>
            <input type="text" id="nama_produk" name="nama_produk" value="{{ old('nama_produk', $product?->nama_produk) }}" required
                   placeholder="Contoh: Cappuccino Velvet"
                   class="input-field mt-1">
        </div>

        <div>
            <label for="harga" class="block text-sm font-medium text-stone-700 dark:text-stone-300">Harga (Rp) <span class="text-red-500">*</span></label>
            <input type="number" id="harga" name="harga" value="{{ old('harga', $product?->harga) }}" min="0" step="500" required
                   placeholder="32000"
                   class="input-field mt-1">
        </div>

        <div>
            <label for="category_id" class="block text-sm font-medium text-stone-700 dark:text-stone-300">Kategori <span class="text-red-500">*</span></label>
            <select id="category_id" name="category_id" required class="input-field mt-1">
                <option value="">— Pilih Kategori —</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" @selected(old('category_id', $product?->category_id) == $cat->id)>{{ $cat->nama_kategori }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="deskripsi" class="block text-sm font-medium text-stone-700 dark:text-stone-300">Deskripsi</label>
            <textarea id="deskripsi" name="deskripsi" rows="4" placeholder="Jelaskan menu secara singkat..."
                      class="input-field mt-1">{{ old('deskripsi', $product?->deskripsi) }}</textarea>
        </div>

        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label for="stok_status" class="block text-sm font-medium text-stone-700 dark:text-stone-300">Status Stok</label>
                <select id="stok_status" name="stok_status" class="input-field mt-1">
                    <option value="tersedia" @selected(old('stok_status', $product?->stok_status ?? 'tersedia') === 'tersedia')>Tersedia</option>
                    <option value="habis" @selected(old('stok_status', $product?->stok_status) === 'habis')>Habis</option>
                </select>
            </div>
            <div class="flex items-end pb-2">
                <label class="flex items-center gap-2 text-sm text-stone-700 dark:text-stone-300">
                    <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $product?->is_featured ?? false))
                           class="rounded border-stone-300 text-amber-600 focus:ring-amber-500 dark:border-stone-600 dark:bg-stone-800">
                    Produk unggulan (landing page)
                </label>
            </div>
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium text-stone-700 dark:text-stone-300">
            Foto / Gambar Menu @if(! $isEdit)<span class="text-red-500">*</span>@endif
        </label>
        <p class="mt-1 text-xs text-stone-500 dark:text-stone-400">JPG, PNG, WebP — maks. 2 MB. Disimpan di Supabase Storage (cloud).</p>

        <label for="foto-menu"
               class="mt-3 flex cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed border-amber-200 bg-amber-50/50 p-6 transition hover:border-amber-400 hover:bg-amber-50 dark:border-stone-600 dark:bg-stone-800/50 dark:hover:border-amber-600 dark:hover:bg-stone-800">
            <div id="foto-placeholder" class="{{ !empty($product?->foto) ? 'hidden' : '' }} text-center">
                <span class="text-4xl">📷</span>
                <p class="mt-2 text-sm font-medium text-stone-600 dark:text-stone-300">Klik untuk upload foto</p>
                <p class="text-xs text-stone-500 dark:text-stone-400">atau drag & drop</p>
            </div>
            <img id="foto-preview"
                 src="{{ $product?->foto_url ?? '' }}"
                 alt="Preview"
                 class="{{ empty($product?->foto) ? 'hidden' : '' }} max-h-48 w-full rounded-lg object-cover">
            <input type="file" id="foto-menu" name="foto" accept="image/jpeg,image/png,image/webp"
                   class="sr-only" @if(! $isEdit) required @endif>
        </label>

        @if($isEdit && $product?->foto)
            <p class="mt-2 truncate text-xs text-stone-500 dark:text-stone-400">
                URL: <code class="break-all text-amber-700 dark:text-amber-400">{{ $product->foto_url }}</code>
            </p>
        @endif
    </div>
</div>
