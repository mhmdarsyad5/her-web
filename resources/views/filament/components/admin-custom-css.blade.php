<style>
    /* Table Drag Cursor & Scrollbar Styling */
    .fi-ta-content,
    .fi-ta-table-container {
        overflow-x: auto !important;
        -webkit-overflow-scrolling: touch !important;
        cursor: grab;
    }
    .fi-ta-content.is-dragging,
    .fi-ta-table-container.is-dragging {
        cursor: grabbing !important;
        user-select: none !important;
    }
    .fi-ta-content button,
    .fi-ta-content a,
    .fi-ta-content input,
    .fi-ta-content label,
    .fi-ta-table-container button,
    .fi-ta-table-container a,
    .fi-ta-table-container input,
    .fi-ta-table-container label {
        cursor: auto;
    }

    /* Custom Smooth Scrollbar for Mobile & Desktop Tables */
    .fi-ta-content::-webkit-scrollbar,
    .fi-ta-table-container::-webkit-scrollbar {
        height: 6px;
    }
    .fi-ta-content::-webkit-scrollbar-track,
    .fi-ta-table-container::-webkit-scrollbar-track {
        background: rgba(228, 228, 231, 0.5);
        border-radius: 9999px;
    }
    .fi-ta-content::-webkit-scrollbar-thumb,
    .fi-ta-table-container::-webkit-scrollbar-thumb {
        background: rgba(161, 161, 170, 0.8);
        border-radius: 9999px;
    }
    .dark .fi-ta-content::-webkit-scrollbar-track,
    .dark .fi-ta-table-container::-webkit-scrollbar-track {
        background: rgba(39, 39, 42, 0.5);
    }
    .dark .fi-ta-content::-webkit-scrollbar-thumb,
    .dark .fi-ta-table-container::-webkit-scrollbar-thumb {
        background: rgba(82, 82, 91, 0.8);
    }

    /* Mobile Adjustments for Small Monitors & Touch Devices */
    @media (max-width: 768px) {
        .fi-page {
            padding-left: 0.75rem !important;
            padding-right: 0.75rem !important;
        }
        .fi-header-heading {
            font-size: 1.25rem !important;
        }
        .fi-ta-header-toolbar {
            flex-wrap: wrap !important;
            gap: 0.5rem !important;
        }
        .fi-ta-search-field {
            width: 100% !important;
        }
    }
</style>

<script>
    (function () {
        let isDown = false;
        let startX;
        let scrollLeft;
        let activeContainer = null;

        function initTableDrag() {
            const containers = document.querySelectorAll('.fi-ta-content, .fi-ta-table-container');

            containers.forEach(container => {
                if (container.dataset.dragInitialized) return;
                container.dataset.dragInitialized = 'true';

                container.addEventListener('mousedown', (e) => {
                    // Ignore clicks on interactive elements like buttons, inputs, links
                    if (e.target.closest('button, input, a, select, [role="button"], label, .fi-dropdown')) return;

                    isDown = true;
                    activeContainer = container;
                    container.classList.add('is-dragging');
                    startX = e.pageX - container.offsetLeft;
                    scrollLeft = container.scrollLeft;
                });

                container.addEventListener('mouseleave', () => {
                    if (activeContainer === container) {
                        isDown = false;
                        container.classList.remove('is-dragging');
                        activeContainer = null;
                    }
                });

                container.addEventListener('mouseup', () => {
                    if (activeContainer === container) {
                        isDown = false;
                        container.classList.remove('is-dragging');
                        activeContainer = null;
                    }
                });

                container.addEventListener('mousemove', (e) => {
                    if (!isDown || activeContainer !== container) return;
                    e.preventDefault();
                    const x = e.pageX - container.offsetLeft;
                    const walk = (x - startX) * 1.5; // Drag speed multiplier
                    container.scrollLeft = scrollLeft - walk;
                });
            });
        }

        document.addEventListener('DOMContentLoaded', initTableDrag);
        document.addEventListener('livewire:navigated', initTableDrag);
        document.addEventListener('livewire:morph', initTableDrag);
        setInterval(initTableDrag, 1000);
    })();
</script>
