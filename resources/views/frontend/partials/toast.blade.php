{{-- resources/views/frontend/partials/toast.blade.php --}}
<div
    x-data="{ show: true }"
    x-show="show"
    x-init="setTimeout(() => show = false, 5000)"
    x-transition:enter="transform ease-out duration-300 transition"
    x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
    x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
    x-transition:leave="transition ease-in duration-100"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="pointer-events-auto fixed bottom-6 right-6 z-50 w-full max-w-sm overflow-hidden rounded-xl bg-white shadow-2xl ring-1 ring-black/5"
>
    <div class="p-4 sm:p-5">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-green-100">
                    <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
            </div>
            <div class="ml-4 flex-1 pt-0.5">
                <p class="text-sm font-semibold text-zinc-900">
                    Berhasil!
                </p>
                <p class="mt-1 text-sm leading-relaxed text-zinc-500">
                    {{ session('success') }}
                </p>
            </div>
            <div class="ml-4 flex flex-shrink-0">
                <button
                    type="button"
                    @click="show = false"
                    class="inline-flex rounded-md bg-white text-zinc-400 hover:text-zinc-500 focus:outline-none focus:ring-2 focus:ring-primary-500/20"
                >
                    <span class="sr-only">Tutup</span>
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>
