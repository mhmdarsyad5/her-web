import 'swiper/css';
import 'swiper/css/pagination';
import 'swiper/css/effect-fade';

import './hero-swiper';
import './product-swiper';
import './contact-form';
import copyBadge from './copy-badge';
import './partners'; // 👈 TAMBAHKAN INI
import './dss';

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

    const loaderHtml = `
        <div class="col-span-full flex flex-col items-center justify-center py-24 gap-4 w-full">
            <div class="relative w-12 h-12">
                <div class="absolute inset-0 rounded-full border-4 border-zinc-150"></div>
                <div class="absolute inset-0 rounded-full border-4 border-t-primary-900 animate-spin"></div>
            </div>
            <span class="text-xs font-semibold text-zinc-500 tracking-wide animate-pulse">Memuat data...</span>
        </div>
    `;

    function triggerAjaxSearch(page = 1) {
        const keyword = searchInput ? searchInput.value.trim() : '';

        /**
         * ==========================
         * SEARCH PAGES
         * ==========================
         */
        if (pagesGrid) {
            pagesGrid.innerHTML = loaderHtml;
            if (paginationWrapper) paginationWrapper.innerHTML = '';

            fetch(`/cari/artikel?keyword=${encodeURIComponent(keyword)}&category=${encodeURIComponent(activeCategorySlug)}&page=${page}`)
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
            productGrid.innerHTML = loaderHtml;
            if (paginationWrapper) paginationWrapper.innerHTML = '';

            fetch(`/cari/produk?keyword=${encodeURIComponent(keyword)}&segment=${encodeURIComponent(activeSegment)}&page=${page}`)
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

    // Intercept pagination clicks for AJAX results
    if (paginationWrapper) {
        paginationWrapper.addEventListener('click', function(e) {
            const link = e.target.closest('a');
            if (link) {
                e.preventDefault();
                const url = new URL(link.href);
                const page = url.searchParams.get('page') || 1;
                triggerAjaxSearch(page);

                // Scroll smoothly to top of the catalog section
                const section = document.getElementById('productsSection') || document.getElementById('blogSection') || document.querySelector('section');
                if (section) {
                    section.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }
        });
    }
});
