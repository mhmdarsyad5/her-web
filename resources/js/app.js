import 'swiper/css';
import 'swiper/css/pagination';
import 'swiper/css/effect-fade';

import './hero-swiper';
import './product-swiper';
import './contact-form';
import copyBadge from './copy-badge';
import './partners'; // 👈 TAMBAHKAN INI

import Alpine from 'alpinejs';
import waFloat from './wa-float';


window.Alpine = Alpine;
window.copyBadge = copyBadge;


document.addEventListener('alpine:init', () => {
    Alpine.data('waFloat', waFloat);
});

Alpine.start();

document.addEventListener('DOMContentLoaded', () => {

    // =====================================================
    // MOBILE MENU
    // =====================================================
    const mobileMenuButton = document.getElementById('mobileMenuButton');
    const mobileMenu = document.getElementById('mobileMenu');

    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    }

    // GLOBAL AJAX SEARCH (PAGES + PRODUCTS)
    // =====================================================
    const searchInput = document.getElementById('searchInput');
    const pagesGrid = document.getElementById('articlesGrid');
    const productGrid = document.getElementById('productGrid');
    const paginationWrapper = document.getElementById('paginationWrapper');

    let timer;

    let activeCategorySlug = 'all';

    const categoryPills = document.querySelectorAll('.category-pill');
    if (categoryPills.length > 0) {
        categoryPills.forEach(pill => {
            pill.addEventListener('click', function() {
                // Return to inactive state for all pills
                categoryPills.forEach(p => {
                    p.classList.remove('active');
                });
                // Set active state for clicked pill
                this.classList.add('active');

                activeCategorySlug = this.getAttribute('data-slug');
                
                // Trigger search manually
                clearTimeout(timer);
                triggerAjaxSearch();
            });
        });
    }

    // Product Segment buttons logic
    const segmentBtns = document.querySelectorAll('.segment-btn');
    let activeSegment = 'all';

    if (segmentBtns.length > 0) {
        segmentBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                segmentBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                activeSegment = this.getAttribute('data-segment');

                // Trigger search
                clearTimeout(timer);
                triggerAjaxSearch();
            });
        });
    }

    if (searchInput) {
        searchInput.addEventListener('keyup', () => {
            clearTimeout(timer);
            timer = setTimeout(() => {
                triggerAjaxSearch();
            }, 400);
        });
    }

    const skeletonHtml = Array.from({ length: 6 }, () => `
        <div class="overflow-hidden rounded-2xl border border-zinc-200 bg-white animate-pulse">
            <div class="h-52 bg-zinc-200"></div>
            <div class="p-5 sm:p-6 space-y-3">
                <div class="h-4 w-3/4 rounded bg-zinc-200"></div>
                <div class="h-3 w-full rounded bg-zinc-200"></div>
                <div class="h-3 w-5/6 rounded bg-zinc-200"></div>
            </div>
        </div>
    `).join('');

    function triggerAjaxSearch() {
        const keyword = searchInput ? searchInput.value.trim() : '';

        /**
         * ==========================
         * SEARCH PAGES
         * ==========================
         */
        if (pagesGrid) {
            pagesGrid.innerHTML = skeletonHtml;
            if (paginationWrapper) paginationWrapper.innerHTML = '';

            fetch(`/cari/artikel?keyword=${encodeURIComponent(keyword)}&category=${encodeURIComponent(activeCategorySlug)}`)
                .then(res => res.json())
                .then(data => {
                    if (data.html?.trim()) {
                        pagesGrid.innerHTML = data.html;
                        if (paginationWrapper) {
                            paginationWrapper.innerHTML = data.pagination ?? '';
                        }
                    } else {
                        pagesGrid.innerHTML = data.empty;
                        if (paginationWrapper) paginationWrapper.innerHTML = '';
                    }
                })
                .catch(err => console.error('Pages search error:', err));
        }

        /**
         * ==========================
         * SEARCH PRODUCTS
         * ==========================
         */
        if (productGrid) {
            productGrid.innerHTML = skeletonHtml;
            if (paginationWrapper) paginationWrapper.innerHTML = '';

            fetch(`/cari/produk?keyword=${encodeURIComponent(keyword)}&segment=${encodeURIComponent(activeSegment)}`)
                .then(res => res.json())
                .then(data => {
                    if (data.html?.trim()) {
                        productGrid.innerHTML = data.html;
                        if (paginationWrapper) {
                            paginationWrapper.innerHTML = data.pagination ?? '';
                        }
                    } else {
                        productGrid.innerHTML = data.empty;
                        if (paginationWrapper) paginationWrapper.innerHTML = '';
                    }
                })
                .catch(err => console.error('Products search error:', err));
        }
    }
});
