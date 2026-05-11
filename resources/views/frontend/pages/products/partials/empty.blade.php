<div class="col-span-full py-24 text-center">

    <x-heroicon-o-shopping-bag
        class="mx-auto h-14 w-14 text-neutral-400" />

    <h3 class="mt-6 text-base font-semibold text-neutral-900">
        {!! setting('product_empty_title', 'Belum ada artikel') !!}
    </h3>

    <p class="mt-2 text-sm text-neutral-600 max-w-md mx-auto">
        {!! setting(
        'product_empty_description',
        'Artikel baru akan muncul di sini setelah dipublikasikan.'
        ) !!}
    </p>
</div>
