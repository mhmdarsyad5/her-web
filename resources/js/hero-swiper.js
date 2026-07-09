import Swiper from 'swiper';
import { Autoplay, Pagination, EffectFade } from 'swiper/modules';

document.addEventListener('DOMContentLoaded', () => {
    new Swiper('.heroSwiper', {
        modules: [Autoplay, Pagination, EffectFade],

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

        pagination: {
            el: '.heroSwiper .swiper-pagination',
            clickable: true,
        },

        preventClicks: false,
        preventClicksPropagation: false,
    });
});
