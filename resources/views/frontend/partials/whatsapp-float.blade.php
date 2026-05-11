<div x-data="waFloat" x-init="init()" x-show="show" x-cloak x-transition.opacity.duration.200ms
    class="fixed z-50 bottom-28 right-4 md:bottom-6 md:right-6">

    <!-- FLOAT WRAPPER -->
    <div class="wa-float-wrapper">

        <!-- Close -->
        <!-- <button
            @click="close()"
            class="wa-float-close">
            <x-heroicon-o-x-mark class="w-4 h-4" />
        </button> -->

        <!-- WA ICON -->
        <img src="{{ setting('icon_whatsapp')
    ? asset('storage/' . setting('icon_whatsapp'))
    : asset('default-wa-icon.png') }}" alt="Chat via WhatsApp" @click="window.open(
                'https://wa.me/{{ preg_replace('/[^0-9]/', '', setting('whatsapp_number', '6281234567890')) }}',
                '_blank'
            )" class="wa-float-img">

    </div>
</div>