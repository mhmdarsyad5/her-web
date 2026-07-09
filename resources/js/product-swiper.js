import Swiper from 'swiper';
import { Autoplay, Pagination, Navigation } from 'swiper/modules';

document.addEventListener('DOMContentLoaded', () => {
    const swiperEl = document.querySelector('.productSwiper');
    if (!swiperEl) return;

    const slides = swiperEl.querySelectorAll('.swiper-slide');
    const slideCount = slides.length;

    new Swiper('.productSwiper', {
        modules: [Autoplay, Pagination, Navigation],
        
        slidesPerView: 1.2,
        spaceBetween: 16,
        grabCursor: true,
        
        breakpoints: {
            // mobile / tablet
            640: {
                slidesPerView: 2,
                spaceBetween: 24,
            },
            // desktop
            1024: {
                slidesPerView: 3,
                spaceBetween: 32,
            }
        },

        // Dynamic config based on slide count
        loop: slideCount > 3,
        autoplay: slideCount > 3 ? {
            delay: 5000,
            disableOnInteraction: false,
        } : false,

        navigation: {
            nextEl: '.product-next',
            prevEl: '.product-prev',
        },

        pagination: {
            el: '.product-pagination',
            clickable: true,
            dynamicBullets: false,
        },
        
        preventClicks: false,
        preventClicksPropagation: false,
    });
});
