<div class="col-span-full flex flex-col items-center justify-center py-20 text-center w-full">

    <x-heroicon-o-photo
        class="w-16 h-16 text-neutral-400 mb-6" />

    <h3 class="text-lg font-semibold text-neutral-800">
        {{ strip_tags(
            setting(
                'gallery_empty_title',
                'Tidak ada galeri yang ditemukan.'
            )
        ) }}
    </h3>

    <p class="text-neutral-600 mt-2 max-w-md">
        {{ strip_tags(
            setting(
                'gallery_empty_description',
                'Coba gunakan kata kunci pencarian yang berbeda atau periksa kembali nanti.'
            )
        ) }}
    </p>

</div>
