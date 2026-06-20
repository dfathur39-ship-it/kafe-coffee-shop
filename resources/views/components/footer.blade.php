<footer id="kontak" class="border-t border-amber-100 bg-stone-900 text-stone-300 dark:border-stone-800 dark:bg-stone-950">
    <div class="mx-auto grid max-w-7xl gap-8 px-4 py-12 sm:px-6 md:grid-cols-3 lg:px-8">
        <div>
            <h3 class="text-lg font-semibold text-white">☕ {{ config('app.name') }}</h3>
            <p class="mt-3 text-sm leading-relaxed">Kedai kopi modern dengan biji pilihan dan suasana nyaman untuk bekerja maupun bersantai.</p>
        </div>
        <div>
            <h4 class="font-semibold text-white">Jam Buka</h4>
            <p class="mt-3 text-sm">Senin – Jumat: 07.00 – 22.00</p>
            <p class="text-sm">Sabtu – Minggu: 08.00 – 23.00</p>
        </div>
        <div>
            <h4 class="font-semibold text-white">Kontak</h4>
            <p class="mt-3 text-sm">Jl. Kopi Nusantara No. 42, Jakarta</p>
            <p class="text-sm">📞 0812-3456-7890</p>
            <p class="text-sm">✉️ hello@kafe.test</p>
        </div>
    </div>
    <div class="border-t border-stone-800 py-4 text-center text-xs text-stone-500">
        &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
    </div>
</footer>
