<!-- resources/views/filament/layouts/app.blade.php (override panel layout) -->
<x-filament::layouts.app>
    <x-slot name="topbar">
        <div class="flex items-center gap-2">
            @include('filament.components.sidebar-toggle')
            {{ $topbar }}
        </div>
    </x-slot>


    {{ $slot }}
</x-filament::layouts.app>
