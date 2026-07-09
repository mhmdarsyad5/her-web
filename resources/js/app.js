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

    const activeClasses = ['text-white', 'font-bold', 'bg-gradient-to-r', 'from-zinc-950', 'via-primary-900', 'to-zinc-900', 'shadow-md', 'shadow-primary-900/10', 'scale-105', 'border-transparent'];
    const inactiveClasses = ['border-zinc-200', 'text-zinc-700', 'bg-white', 'hover:border-zinc-300', 'hover:text-zinc-900'];

    function updateSegmentButtonClasses() {
        if (segmentBtns.length === 0) return;
        segmentBtns.forEach(btn => {
            const isActive = btn.classList.contains('active');
            if (isActive) {
                activeClasses.forEach(c => btn.classList.add(c));
                inactiveClasses.forEach(c => btn.classList.remove(c));
            } else {
                inactiveClasses.forEach(c => btn.classList.add(c));
                activeClasses.forEach(c => btn.classList.remove(c));
            }
        });
    }

    // Run once on load to style the default active button
    updateSegmentButtonClasses();

    if (segmentBtns.length > 0) {
        segmentBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                segmentBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                activeSegment = this.getAttribute('data-segment');
                updateSegmentButtonClasses();

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

    function triggerAjaxSearch() {
        const keyword = searchInput ? searchInput.value.trim() : '';

        /**
         * ==========================
         * SEARCH PAGES
         * ==========================
         */
        if (pagesGrid) {
            fetch('/cari/artikel/skeleton')
                .then(res => res.text())
                .then(html => {
                    pagesGrid.innerHTML = html;
                    if (paginationWrapper) paginationWrapper.innerHTML = '';
                });

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

            fetch('/cari/produk/skeleton')
                .then(res => res.text())
                .then(html => {
                    productGrid.innerHTML = html;
                    if (paginationWrapper) paginationWrapper.innerHTML = '';
                });

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
