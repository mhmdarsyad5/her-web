export default function copyBadge(text) {
    if (!text) return;

    navigator.clipboard.writeText(text).then(() => {
        showCopyToast();
    });
}

function showCopyToast() {
    let toast = document.getElementById('copyBadgeToast');

    // Kalau belum ada, buat otomatis
    if (!toast) {
        toast = document.createElement('div');
        toast.id = 'copyBadgeToast';
        toast.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-5 h-5 text-green-600"
                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M5 13l4 4L19 7" />
            </svg>
            <span>Berhasil disalin</span>
        `;

        toast.className = `
            fixed bottom-6 right-6 z-50
            flex items-center gap-2
            rounded-xl border
            border-neutral-200
            bg-white
            px-4 py-3
            text-sm font-medium
            text-neutral-900
            shadow-lg
            opacity-0 translate-y-4
            pointer-events-none
            transition-all duration-300
        `;

        document.body.appendChild(toast);
    }

    // Show
    toast.classList.remove('opacity-0', 'translate-y-4');
    toast.classList.add('opacity-100', 'translate-y-0');

    // Auto hide
    setTimeout(() => {
        toast.classList.add('opacity-0', 'translate-y-4');
        toast.classList.remove('opacity-100', 'translate-y-0');
    }, 2000);
}
