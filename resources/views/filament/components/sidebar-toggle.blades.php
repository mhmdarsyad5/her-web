<button
    x-data
    x-on:click="
const body = document.body;
const collapsed = body.classList.toggle('fi-sidebar-collapsed');
localStorage.setItem('fiSidebarCollapsed', collapsed);
"
    class="p-2 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition"
    title="Toggle Sidebar">
    <x-heroicon-o-bars-3 class="w-5 h-5" />
</button>
