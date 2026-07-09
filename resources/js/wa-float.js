export default function waFloat() {
    return {
        show: (() => {
            const until = localStorage.getItem('hideWA_until');
            return !until || Date.now() > parseInt(until);
        })(),

        showText: false,

        close() {
            this.show = false;
            localStorage.setItem('hideWA_until', Date.now() + 300000);
        },

        init() {
            // Tunggu 3 detik baru tampilin popup teksnya
            setTimeout(() => {
                if (this.show) {
                    this.showText = true;
                }
            }, 3000);

            // Sembunyikan otomatis setelah 8 detik tayang (total 11 detik sejak page load)
            setTimeout(() => {
                this.showText = false;
            }, 11000);
        }
    }
}
