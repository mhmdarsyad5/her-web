@extends('frontend.layouts.app')

@section('title', $pageTitle ?? strip_tags(setting('site_name')))
@section('description', 'Pelajari profil, sejarah singkat, serta visi dan misi Herro Equipment Rentals sebagai penyedia jasa sewa alat berat terpercaya.')

@section('content')

    {{-- Breadcrumb --}}
    @include('frontend.components.breadcrumb')

    {{-- ================= SECTION 1: INTRODUCTION & VISION MISSION ================= --}}
    <section class="pt-8 pb-16 sm:pt-10 sm:pb-20 bg-white">
        <div class="max-w-7xl mx-auto px-6 sm:px-12 lg:px-20 mb-16 fade-slide opacity-0 translate-y-4">
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-zinc-955">INTRODUCTION</h2>
            <p class="text-xs sm:text-sm font-bold tracking-wider text-primary-900 uppercase mt-1">Tentang Kami</p>

            <div class="mt-8 space-y-6 text-zinc-650 text-sm sm:text-base leading-relaxed text-justify">
                <p>
                    PT Herro Equipment Rentals adalah penyedia layanan material handling yang berfokus secara eksklusif pada
                    solusi sewa forklift tahunan untuk kebutuhan skala industri dan pergudangan di Indonesia. Kami
                    mendedikasikan diri untuk mendukung kelancaran mobilitas logistik perusahaan Anda melalui penyediaan
                    armada berkualitas tinggi dari merek global HANGCHA, yang telah teruji ketangguhan serta efisiensi
                    teknologinya di lapangan.
                </p>
                <p>
                    Melalui skema penyewaan jangka panjang, kami hadir untuk membantu Anda mengoptimalkan efisiensi biaya
                    operasional tanpa harus membebani pengeluaran aset modal perusahaan. Layanan sewa tahunan kami dirancang
                    secara komprehensif, tidak hanya menyediakan unit dalam kondisi prima, tetapi juga mencakup jadwal
                    perawatan rutin, ketersediaan suku cadang, dan dukungan penanganan teknis untuk memastikan seluruh
                    kegiatan operasional berjalan aman tanpa hambatan.
                </p>
            </div>
        </div>

        {{-- Vision & Mission (Premium Dark Zinc Card) --}}
        <div class="max-w-7xl mx-auto px-6 sm:px-12 lg:px-20">
            <div
                class="relative overflow-hidden rounded-[2rem] bg-zinc-900 text-white p-8 sm:p-12 shadow-2xl border border-zinc-800/80 fade-slide opacity-0 translate-y-4">
                {{-- Skewed Orange Gradient Overlay --}}
                <div
                    class="absolute right-0 top-0 bottom-0 w-1/3 bg-gradient-to-br from-primary-900/10 via-primary-500/10 to-transparent pointer-events-none transform -skew-x-12 translate-x-12 hidden lg:block">
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 relative z-10">
                    <div class="lg:col-span-8 space-y-10">
                        {{-- VISI --}}
                        <div class="space-y-3">
                            <h3 class="text-lg sm:text-xl font-bold tracking-wider text-primary-500 uppercase">VISI</h3>
                            <div class="space-y-2">
                                <p class="text-sm sm:text-base leading-relaxed text-zinc-100 font-medium">
                                    Menjadi penyedia sewa forklift HANGCHA resmi terunggul dan terpercaya se-Indonesia,
                                    mendukung pertumbuhan industri logistik nasional Indonesia.
                                </p>
                                <p
                                    class="text-xs sm:text-sm text-zinc-400/90 italic font-light tracking-wide leading-relaxed font-sans">
                                    印尼语愿景成为全印尼顶尖且值得信赖的官方杭州叉车租赁服务商，助力印尼本土物流工业稳步发展。
                                </p>
                            </div>
                        </div>

                        <div class="h-px bg-zinc-800/80"></div>

                        {{-- MISI --}}
                        <div class="space-y-3">
                            <h3 class="text-lg sm:text-xl font-bold tracking-wider text-primary-500 uppercase">MISI</h3>
                            <div class="space-y-2">
                                <p class="text-sm sm:text-base leading-relaxed text-zinc-100 font-medium">
                                    Berfokus penuh layanan sewa forklift merek HANGCHA asli, menawarkan solusi sewa
                                    fleksibel, perawatan cepat dan layanan purna pakai profesional, membantu pelaku usaha
                                    lokal menghemat biaya operasional serta meningkatkan efisiensi kerja lapangan.
                                </p>
                                <p
                                    class="text-xs sm:text-sm text-zinc-400/90 italic font-light tracking-wide leading-relaxed font-sans">
                                    印尼语使命专注正品杭州叉车租赁服务，提供灵活租赁方案、极速维保与专业售后，助力本土企业节省运营开支、提升现场作业效率。
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ================= SECTION 2: WHY US ================= --}}
    <section class="py-16 sm:py-20 bg-zinc-50 border-t border-zinc-200/80">
        <div class="max-w-7xl mx-auto px-6 sm:px-12 lg:px-20">

            {{-- Title --}}
            <div class="mb-10 fade-slide opacity-0 translate-y-4">
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-zinc-955">WHY US?</h2>
            </div>

            {{-- Image Banner with Skewed Geometric Corners --}}
            <div
                class="relative overflow-hidden rounded-[2rem] border border-zinc-200/80 bg-white p-3 sm:p-4 shadow-xl fade-slide opacity-0 translate-y-4 mb-10">
                <img src="{{ asset('assets-default/pages/pabrik_hangcha.png') }}" alt="Hangcha Factory"
                    class="w-full h-56 sm:h-80 lg:h-96 object-cover rounded-2xl relative z-0">
            </div>

            {{-- Text Columns --}}
            <div class="space-y-6 text-zinc-650 text-sm sm:text-base leading-relaxed text-justify fade-slide opacity-0 translate-y-4">
                <p>
                    Memilih PT Herro Equipment Rental (PT HER) sebagai mitra berarti Anda mengamankan efisiensi operasional
                    jangka panjang tanpa terbebani pengeluaran modal besar untuk pembelian dan penyusutan aset. Kami secara
                    khusus menghadirkan armada HANGCHA yang telah terbukti ketangguhannya, dipadukan dengan layanan
                    konsultasi awal untuk memastikan setiap unit yang disewa benar-benar sesuai dengan kondisi medan kerja
                    dan kebutuhan logistik di fasilitas Anda.
                </p>
                <p>
                    Layanan sewa tahunan kami juga dirancang agar Anda terbebas dari segala kerepotan manajemen perawatan
                    armada. Seluruh jadwal pemeliharaan rutin, perbaikan teknis, hingga jaminan ketersediaan suku cadang
                    sepenuhnya menjadi tanggung jawab kami. Ditambah dengan dukungan tim mekanik yang responsif dan siap
                    memberikan penanganan cepat di lokasi kerja, PT HER menjamin setiap kendala dapat segera teratasi
                    sehingga operasional bisnis utama Anda tetap berjalan lancar dan optimal.
                </p>
            </div>
        </div>
    </section>

    {{-- ================= SECTION 3: WHO WE ARE ================= --}}
    <section class="py-16 sm:py-20 bg-white border-t border-zinc-200/80">
        <div class="max-w-7xl mx-auto px-6 sm:px-12 lg:px-20">

            {{-- Header --}}
            <div class="mb-8 fade-slide opacity-0 translate-y-4">
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-zinc-955">WHO WE ARE</h2>
                <p class="text-sm sm:text-base font-bold text-zinc-800 mt-2">Spesialisasi Unit HANGCHA</p>
                <p class="mt-4 max-w-3xl text-sm sm:text-base leading-relaxed text-zinc-600 text-justify">
                    Kami fokus pada penyediaan armada HANGCHA yang telah terbukti tangguh, andal, dan memiliki efisiensi
                    tinggi untuk mendukung berbagai skala operasional industri dan pergudangan.
                </p>
            </div>

            {{-- Indonesia Grid Map Container --}}
            <div
                class="relative overflow-hidden rounded-[2rem] border border-zinc-200/80 bg-amber-500 shadow-xl fade-slide opacity-0 translate-y-4 mb-12 aspect-[2.1/1] sm:aspect-[2.3/1]">
                <img src="{{ asset('assets-default/pages/peta_indonesia_grid.png') }}"
                    alt="Peta Jangkauan HANGCHA Indonesia" class="w-full h-full object-cover select-none">
            </div>

            {{-- List Features --}}
            <div class="space-y-6 fade-slide opacity-0 translate-y-4">

                {{-- Item 1 --}}
                <div class="flex gap-4">
                    <div class="flex-shrink-0 mt-1 flex h-5 w-5 items-center justify-center rounded-full bg-primary-900">
                        <span class="h-2 w-2 rounded-full bg-white"></span>
                    </div>
                    <div>
                        <h4 class="text-base sm:text-lg font-bold text-zinc-955">Sewa Forklift Tahunan</h4>
                        <p class="mt-1 text-sm text-zinc-600 leading-relaxed">
                            Kami menyediakan kontrak penyewaan forklift HANGCHA jangka panjang untuk memastikan stabilitas
                            dan efisiensi biaya operasional perusahaan Anda.
                        </p>
                    </div>
                </div>

                {{-- Item 2 --}}
                <div class="flex gap-4 border-t border-zinc-100 pt-6">
                    <div class="flex-shrink-0 mt-1 flex h-5 w-5 items-center justify-center rounded-full bg-primary-900">
                        <span class="h-2 w-2 rounded-full bg-white"></span>
                    </div>
                    <div>
                        <h4 class="text-base sm:text-lg font-bold text-zinc-955">Penyediaan Unit Terkini</h4>
                        <p class="mt-1 text-sm text-zinc-600 leading-relaxed">
                            Kami menghadirkan unit forklift HANGCHA dalam kondisi prima yang dilengkapi teknologi terbaru
                            untuk mendukung produktivitas material handling.
                        </p>
                    </div>
                </div>

                {{-- Item 3 --}}
                <div class="flex gap-4 border-t border-zinc-100 pt-6">
                    <div class="flex-shrink-0 mt-1 flex h-5 w-5 items-center justify-center rounded-full bg-primary-900">
                        <span class="h-2 w-2 rounded-full bg-white"></span>
                    </div>
                    <div>
                        <h4 class="text-base sm:text-lg font-bold text-zinc-955">Pemeliharaan dan Servis Rutin</h4>
                        <p class="mt-1 text-sm text-zinc-600 leading-relaxed">
                            Seluruh biaya dan jadwal perawatan berkala sudah termasuk dalam paket sewa, memastikan unit
                            selalu beroperasi pada performa maksimal.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ================= ANIMATION ================= --}}
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const elements = document.querySelectorAll(".fade-slide");
            const observer = new IntersectionObserver(entries => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.remove("opacity-0", "translate-y-4");
                        entry.target.classList.add("opacity-100", "translate-y-0");
                        entry.target.style.transition = "all 0.6s cubic-bezier(0.4, 0, 0.2, 1)";
                    }
                });
            }, { threshold: 0.1, rootMargin: "0px 0px -20px 0px" });
            elements.forEach(el => observer.observe(el));
        });
    </script>

@endsection