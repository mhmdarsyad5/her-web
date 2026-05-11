import 'swiper/css';
import 'swiper/css/pagination';
import 'swiper/css/effect-fade';

import './hero-swiper';
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

    // =====================================================
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
                    p.classList.remove('bg-primary-500', 'text-white', 'border-primary-500', 'shadow-md');
                    p.classList.add('bg-white', 'text-zinc-600', 'border-zinc-200');
                });
                // Set active state for clicked pill
                this.classList.remove('bg-white', 'text-zinc-600', 'border-zinc-200');
                this.classList.add('bg-primary-500', 'text-white', 'border-primary-500', 'shadow-md');

                activeCategorySlug = this.getAttribute('data-slug');
                
                // Trigger search manually
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
            fetch('/search/skeleton')
                .then(res => res.text())
                .then(html => {
                    pagesGrid.innerHTML = html;
                    if (paginationWrapper) paginationWrapper.innerHTML = '';
                });

            fetch(`/search/pages?keyword=${encodeURIComponent(keyword)}&category=${encodeURIComponent(activeCategorySlug)}`)
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

            fetch('/search/products/skeleton')
                .then(res => res.text())
                .then(html => {
                    productGrid.innerHTML = html;
                    if (paginationWrapper) paginationWrapper.innerHTML = '';
                });

            fetch(`/search/products?keyword=${encodeURIComponent(keyword)}`)
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
