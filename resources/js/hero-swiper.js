import Swiper from 'swiper';
import { Autoplay, Pagination, EffectFade, Navigation } from 'swiper/modules';

document.addEventListener('DOMContentLoaded', () => {
    new Swiper('.heroSwiper', {
        modules: [Autoplay, Pagination, EffectFade, Navigation],

        loop: true,
        speed: 700,

        effect: 'fade',
        fadeEffect: {
            crossFade: true,
        },

        autoplay: {
            delay: 6000,
            disableOnInteraction: false,
        },

        navigation: {
            nextEl: '.hero-next',
            prevEl: '.hero-prev',
        },

        pagination: {
            el: '.heroSwiper .swiper-pagination',
            clickable: true,
        },

        // Hapus baris ini: virtualTranslate: true,

        preventClicks: false,
        preventClicksPropagation: false,
    });
});
