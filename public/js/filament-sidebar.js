<!-- public/js/filament-sidebar.js -->
document.addEventListener('DOMContentLoaded', () => {
const collapsed = localStorage.getItem('fiSidebarCollapsed') === 'true';
if (collapsed) {
document.body.classList.add('fi-sidebar-collapsed');
}
});


<!-- In your service provider -->
Filament::serving(function () {
FilamentAsset::register([Asset::script('filament-sidebar', __DIR__.'/../../public/js/filament-sidebar.js')]);
});
