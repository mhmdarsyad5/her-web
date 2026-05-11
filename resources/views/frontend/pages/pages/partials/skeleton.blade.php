@for ($i = 0; $i < 6; $i++)
    <div
    class="
            overflow-hidden
            rounded-2xl
            border border-neutral-200
            bg-white
            animate-pulse
        ">

    {{-- IMAGE --}}
    <div class="h-52 bg-neutral-200"></div>

    {{-- CONTENT --}}
    <div class="p-5 sm:p-6 space-y-3">
        <div class="h-4 w-3/4 rounded bg-neutral-200"></div>
        <div class="h-3 w-full rounded bg-neutral-200"></div>
        <div class="h-3 w-5/6 rounded bg-neutral-200"></div>
    </div>

    </div>
    @endfor
