import Swiper from 'swiper';
import { Autoplay, Pagination, EffectFade } from 'swiper/modules';

document.addEventListener('DOMContentLoaded', () => {
    const swiperEl = document.querySelector('.heroSwiper');
    if (!swiperEl) return;

    const slideCount = swiperEl.querySelectorAll('.swiper-slide').length;

    new Swiper('.heroSwiper', {
        modules: [Autoplay, Pagination, EffectFade],

        loop: slideCount > 1,
        speed: 700,

        effect: 'fade',
        fadeEffect: {
            crossFade: true,
        },

        autoplay: slideCount > 1 ? {
            delay: 6000,
            disableOnInteraction: false,
        } : false,

        pagination: {
            el: '.heroSwiper .swiper-pagination',
            clickable: true,
        },

        preventClicks: false,
        preventClicksPropagation: false,
    });
});
