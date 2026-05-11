export default function waFloat() {
    let lastScroll = window.scrollY;

    return {
        show: (() => {
            const until = localStorage.getItem('hideWA_until');
            return !until || Date.now() > parseInt(until);
        })(),

        close() {
            this.show = false;
            localStorage.setItem('hideWA_until', Date.now() + 300000);
        },

        init() {
            window.addEventListener('scroll', () => {
                const current = window.scrollY;

                if (current > lastScroll && current > 120) {
                    this.show = false;
                }

                if (current < lastScroll) {
                    const until = localStorage.getItem('hideWA_until');
                    if (!until || Date.now() > parseInt(until)) {
                        this.show = true;
                    }
                }

                lastScroll = current;
            });
        }
    }
}
