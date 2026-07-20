@php
    $files = [];
    $folders = [];

    try {
        $allFiles = \Illuminate\Support\Facades\Storage::disk('public')->allFiles();
        foreach ($allFiles as $file) {
            $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            if (in_array($ext, ['webp', 'jpg', 'jpeg', 'png', 'gif'])) {
                $parts = explode('/', str_replace('\\', '/', $file));
                $folder = count($parts) > 1 ? $parts[0] : 'root';

                if (!in_array($folder, $folders)) {
                    $folders[] = $folder;
                }

                // Ambil ukuran file untuk ditampilkan di preview native
                $sizeBytes = 0;
                try {
                    $sizeBytes = \Illuminate\Support\Facades\Storage::disk('public')->size($file);
                } catch (\Throwable $e) {
                }

                $sizeFormatted = '';
                if ($sizeBytes > 0) {
                    if ($sizeBytes >= 1048576) {
                        $sizeFormatted = number_format($sizeBytes / 1048576, 1) . ' MB';
                    } else {
                        $sizeFormatted = number_format($sizeBytes / 1024, 0) . ' KB';
                    }
                }

                $files[] = [
                    'path' => $file,
                    'url' => \Illuminate\Support\Facades\Storage::disk('public')->url($file),
                    'name' => basename($file),
                    'folder' => $folder,
                    'size' => $sizeFormatted,
                ];
            }
        }
        sort($folders);
    } catch (\Throwable $e) {
        \Illuminate\Support\Facades\Log::error('Gagal scan media server: ' . $e->getMessage());
    }
@endphp

<div x-data="{
    isOpen: false,
    currentFolder: '',
    search: '',
    files: [],
    folders: [],
    selectedFiles: [],
    multiple: false,

    get filteredFiles() {
        return this.files.filter(f => {
            const matchesFolder = f.folder === this.currentFolder;
            const matchesSearch = f.name.toLowerCase().includes(this.search.toLowerCase());
            return matchesFolder && matchesSearch;
        });
    },

    toggleFile(path) {
        if (this.multiple) {
            if (this.selectedFiles.includes(path)) {
                this.selectedFiles = this.selectedFiles.filter(p => p !== path);
            } else {
                this.selectedFiles.push(path);
            }
        } else {
            // Mode Tunggal: Toggle seleksi
            if (this.selectedFiles.includes(path)) {
                this.selectedFiles = [];
            } else {
                this.selectedFiles = [path];
            }
        }
    },

    removeSelected(path) {
        this.selectedFiles = this.selectedFiles.filter(p => p !== path);
        this.updateWireState();
    },

    confirmSelection() {
        this.updateWireState();
        this.isOpen = false;
    },

    updateWireState() {
        let value = this.selectedFiles;
        if (!this.multiple) {
            value = this.selectedFiles[0] || null;
        }
        this.$wire.set('{{ $statePath }}', value);
        this.$wire.set('{{ $uploadStatePath }}', value);
    }
}" x-init='
    files = {{ json_encode($files) }};
    folders = {{ json_encode($folders) }};
    currentFolder = "{{ $directory }}";
    multiple = {{ $multiple ? "true" : "false" }};
    
    const val = {{ json_encode($stateValue) }};
    if (val) {
        selectedFiles = Array.isArray(val) ? val : [val];
    }
' class="mt-2">
    <style wire:ignore>
        /* CSS Reset / Overwrite untuk Modal Galeri */
        .gm-modal-backdrop {
            position: fixed !important;
            inset: 0 !important;
            z-index: 99999 !important;
            display: flex;
            align-items: center !important;
            justify-content: center !important;
            padding: 1.5rem !important;
            background-color: rgba(9, 9, 11, 0.7) !important;
            backdrop-filter: blur(8px) !important;
        }

        .gm-modal-box {
            background-color: #ffffff !important;
            border: 1px solid #e4e4e7 !important;
            border-radius: 1.25rem !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25) !important;
            width: 100% !important;
            max-width: 68rem !important;
            height: 85vh !important;
            display: flex !important;
            flex-direction: column !important;
            overflow: hidden !important;
            font-family: inherit !important;
        }

        .dark .gm-modal-box {
            background-color: #18181b !important;
            border-color: #27272a !important;
        }

        /* Header */
        .gm-header {
            padding: 1.25rem 1.75rem !important;
            border-bottom: 1px solid #e4e4e7 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            gap: 1.5rem !important;
        }

        .dark .gm-header {
            border-color: #27272a !important;
        }

        .gm-header-title {
            font-size: 0.95rem !important;
            font-weight: 800 !important;
            color: #09090b !important;
            margin: 0 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.05em !important;
        }

        .dark .gm-header-title {
            color: #ffffff !important;
        }

        .gm-header-subtitle {
            font-size: 0.75rem !important;
            color: #71717a !important;
            margin: 0.15rem 0 0 0 !important;
        }

        .dark .gm-header-subtitle {
            color: #a1a1aa !important;
        }

        /* Search */
        .gm-search-wrapper {
            position: relative !important;
            width: 18rem !important;
        }

        .gm-search-input {
            width: 100% !important;
            padding: 0.5rem 0.75rem 0.5rem 2.25rem !important;
            font-size: 0.75rem !important;
            border: 1px solid #d4d4d8 !important;
            border-radius: 0.5rem !important;
            outline: none !important;
            transition: all 0.2s !important;
            background-color: #ffffff !important;
        }

        .dark .gm-search-input {
            background-color: #27272a !important;
            border-color: #3f3f46 !important;
            color: #ffffff !important;
        }

        .gm-search-input:focus {
            border-color: #F5A21C !important;
            box-shadow: 0 0 0 2px rgba(245, 162, 28, 0.15) !important;
        }

        .gm-search-icon {
            position: absolute !important;
            left: 0.75rem !important;
            top: 50% !important;
            transform: translateY(-50%) !important;
            color: #a1a1aa !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }

        /* Close */
        .gm-close-btn {
            border: none !important;
            background: transparent !important;
            color: #a1a1aa !important;
            cursor: pointer !important;
            padding: 0.35rem !important;
            border-radius: 0.5rem !important;
            transition: all 0.2s !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }

        .gm-close-btn:hover {
            color: #18181b !important;
            background-color: #f4f4f5 !important;
        }

        .dark .gm-close-btn:hover {
            color: #ffffff !important;
            background-color: #27272a !important;
        }

        /* Layout Body */
        .gm-body {
            flex: 1 !important;
            display: flex !important;
            overflow: hidden !important;
        }

        /* Sidebar */
        .gm-sidebar {
            width: 15rem !important;
            border-right: 1px solid #e4e4e7 !important;
            background-color: #fafafa !important;
            padding: 1.25rem 1rem !important;
            overflow-y: auto !important;
            display: flex !important;
            flex-direction: column !important;
            gap: 0.25rem !important;
        }

        .dark .gm-sidebar {
            background-color: #09090b !important;
            border-color: #27272a !important;
        }

        .gm-sidebar-title {
            font-size: 0.7rem !important;
            font-weight: 700 !important;
            color: #a1a1aa !important;
            text-transform: uppercase !important;
            letter-spacing: 0.07em !important;
            margin-bottom: 0.75rem !important;
            padding-left: 0.5rem !important;
        }

        .gm-folder-item {
            width: 100% !important;
            display: flex !important;
            align-items: center !important;
            gap: 0.75rem !important;
            padding: 0.55rem 0.75rem !important;
            font-size: 0.75rem !important;
            font-weight: 500 !important;
            color: #52525b !important;
            border: none !important;
            background: transparent !important;
            border-radius: 0.5rem !important;
            cursor: pointer !important;
            text-align: left !important;
            transition: all 0.2s !important;
        }

        .dark .gm-folder-item {
            color: #a1a1aa !important;
        }

        .gm-folder-item:hover {
            background-color: #f4f4f5 !important;
            color: #18181b !important;
        }

        .dark .gm-folder-item:hover {
            background-color: #18181b !important;
            color: #ffffff !important;
        }

        .gm-folder-item.active {
            background-color: #F5A21C !important;
            color: #ffffff !important;
            font-weight: 600 !important;
        }

        .gm-folder-item.active svg {
            color: #ffffff !important;
        }

        /* Grid Container */
        .gm-grid-container {
            flex: 1 !important;
            padding: 1.25rem !important;
            overflow-y: auto !important;
            background-color: #f4f4f5 !important;
        }

        .dark .gm-grid-container {
            background-color: #09090b !important;
        }

        .gm-grid {
            display: grid !important;
            grid-template-columns: repeat(auto-fill, minmax(95px, 1fr)) !important;
            gap: 0.75rem !important;
            width: 100% !important;
        }

        /* Grid Item */
        .gm-item {
            background-color: #ffffff !important;
            border: 2px solid #e4e4e7 !important;
            border-radius: 0.5rem !important;
            overflow: hidden !important;
            cursor: pointer !important;
            position: relative !important;
            transition: all 0.15s ease-in-out !important;
            display: flex !important;
            flex-direction: column !important;
        }

        .dark .gm-item {
            background-color: #18181b !important;
            border-color: #27272a !important;
        }

        .gm-item:hover {
            transform: translateY(-1px) !important;
            border-color: #a1a1aa !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05) !important;
        }

        .gm-item.active {
            border-color: #F5A21C !important;
            box-shadow: 0 0 0 2px rgba(245, 162, 28, 0.25) !important;
        }

        .gm-item-image-wrapper {
            position: relative !important;
            width: 100% !important;
            padding-top: 100% !important;
            background-color: #fafafa !important;
            overflow: hidden !important;
        }

        .dark .gm-item-image-wrapper {
            background-color: #27272a !important;
        }

        .gm-item-image {
            position: absolute !important;
            inset: 0 !important;
            width: 100% !important;
            height: 100% !important;
            object-fit: cover !important;
        }

        .gm-item-info {
            padding: 0.4rem !important;
            border-top: 1px solid #e4e4e7 !important;
        }

        .dark .gm-item-info {
            border-color: #27272a !important;
        }

        .gm-item-name {
            font-size: 0.6rem !important;
            font-weight: 500 !important;
            color: #52525b !important;
            margin: 0 !important;
            white-space: nowrap !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
            text-align: center !important;
        }

        .dark .gm-item-name {
            color: #d4d4d8 !important;
        }

        /* Checkmark */
        .gm-checkmark {
            position: absolute !important;
            top: 0.35rem !important;
            right: 0.35rem !important;
            background-color: #F5A21C !important;
            color: #ffffff !important;
            border-radius: 9999px !important;
            padding: 0.15rem !important;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1) !important;
            z-index: 10 !important;
            display: flex;
            align-items: center !important;
            justify-content: center !important;
        }

        /* Footer */
        .gm-footer {
            padding: 1.25rem 1.75rem !important;
            border-top: 1px solid #e4e4e7 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: flex-end !important;
            gap: 0.75rem !important;
            background-color: #ffffff !important;
        }

        .dark .gm-footer {
            background-color: #18181b !important;
            border-color: #27272a !important;
        }

        /* Buttons */
        .gm-btn {
            padding: 0.5rem 1.25rem !important;
            font-size: 0.75rem !important;
            font-weight: 600 !important;
            border-radius: 0.5rem !important;
            cursor: pointer !important;
            transition: all 0.2s !important;
            border: none !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 0.5rem !important;
        }

        .gm-btn-secondary {
            background-color: #ffffff !important;
            color: #52525b !important;
            border: 1px solid #d4d4d8 !important;
        }

        .gm-btn-secondary:hover {
            background-color: #f4f4f5 !important;
        }

        .dark .gm-btn-secondary {
            background-color: #27272a !important;
            color: #e4e4e7 !important;
            border-color: #3f3f46 !important;
        }

        .dark .gm-btn-secondary:hover {
            background-color: #3f3f46 !important;
        }

        .gm-btn-primary {
            background-color: #F5A21C !important;
            color: #ffffff !important;
        }

        .gm-btn-primary:hover {
            background-color: #e09110 !important;
        }

        /* PREVIEW STYLING: Dibuat persis seperti Gambar 2 (FilePond/Filament Native FileUpload) */
        .gm-native-preview-container {
            display: grid !important;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)) !important;
            gap: 1rem !important;
            width: 100% !important;
            margin-bottom: 0.75rem !important;
        }

        .gm-native-preview-card {
            position: relative !important;
            width: 100% !important;
            height: 11rem !important;
            /* Tinggi disesuaikan dengan aspek rasio FilePond (sekitar 176px) */
            border-radius: 0.75rem !important;
            /* rounded-xl */
            border: 1px solid #e4e4e7 !important;
            background-color: #1f2937 !important;
            overflow: hidden !important;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;
            transition: all 0.2s !important;
        }

        .dark .gm-native-preview-card {
            border-color: #27272a !important;
            background-color: #111827 !important;
        }

        .gm-native-preview-card img {
            width: 100% !important;
            height: 100% !important;
            object-fit: cover !important;
        }

        /* Gradient overlay atas agar nama file yang berwarna putih dapat terbaca dengan jelas */
        .gm-native-preview-overlay {
            position: absolute !important;
            inset: 0 !important;
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0) 50%) !important;
            pointer-events: none !important;
            z-index: 10 !important;
        }

        /* Tombol Hapus Bulat di Kiri Atas seperti Native Filament (Gambar 2) */
        .gm-native-remove-btn {
            position: absolute !important;
            top: 0.75rem !important;
            left: 0.75rem !important;
            /* LEFT side seperti di Gambar 2 */
            background-color: rgba(0, 0, 0, 0.5) !important;
            color: #ffffff !important;
            border-radius: 9999px !important;
            width: 1.75rem !important;
            height: 1.75rem !important;
            border: none !important;
            cursor: pointer !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2) !important;
            transition: background-color 0.15s, transform 0.15s !important;
            z-index: 20 !important;
        }

        .gm-native-remove-btn:hover {
            background-color: rgba(0, 0, 0, 0.8) !important;
            transform: scale(1.05) !important;
        }

        /* Text info nama file & ukuran di sebelah kanan tombol hapus */
        .gm-native-info-wrapper {
            position: absolute !important;
            top: 0.75rem !important;
            left: 3rem !important;
            /* Jarak pas setelah tombol hapus bulat */
            color: #ffffff !important;
            display: flex !important;
            flex-direction: column !important;
            z-index: 20 !important;
            pointer-events: none !important;
        }

        .gm-native-filename {
            font-size: 0.7rem !important;
            font-weight: 600 !important;
            line-height: 1rem !important;
            max-width: 18rem !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
            white-space: nowrap !important;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.6) !important;
        }

        .gm-native-filesize {
            font-size: 0.6rem !important;
            color: rgba(255, 255, 255, 0.7) !important;
            line-height: 0.85rem !important;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.6) !important;
        }
    </style>

    <!-- PREVIEW AREA: Tampilan persis seperti Gambar 2 (FilePond/Filament Native FileUpload) -->
    <div x-show="selectedFiles.length > 0" class="gm-native-preview-container">
        <template x-for="path in selectedFiles" :key="path">
            <div class="gm-native-preview-card">
                <!-- Overlay gelap atas -->
                <div class="gm-native-preview-overlay"></div>

                <!-- Gambar -->
                <img :src="files.find(f => f.path === path)?.url || '/storage/' + path" />

                <!-- Tombol Hapus Bulat Kiri Atas -->
                <button type="button" @click="removeSelected(path)" class="gm-native-remove-btn">
                    <svg style="width: 12px; height: 12px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <!-- Nama File & Ukuran -->
                <div class="gm-native-info-wrapper">
                    <span class="gm-native-filename" x-text="path.split('/').pop()"></span>
                    <span class="gm-native-filesize"
                        x-text="files.find(f => f.path === path)?.size || 'Unknown Size'"></span>
                </div>
            </div>
        </template>
    </div>

    <!-- Tombol Trigger -->
    <div class="flex items-center gap-2">
        <button type="button" @click="
                isOpen = true;
                const val = $wire.get('{{ $statePath }}');
                selectedFiles = val ? (Array.isArray(val) ? val : [val]) : [];
            "
            class="inline-flex items-center gap-2 px-3 py-1.5 text-xs font-semibold text-zinc-700 bg-white border border-zinc-300 rounded-lg hover:bg-zinc-50 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition"
            style="border: 1px solid #d4d4d8; padding: 0.5rem 0.75rem; border-radius: 0.5rem; background: #fff; cursor: pointer;">
            <svg style="width: 16px; height: 16px; color: #71717a;" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
            </svg>
            <span style="font-family: inherit;">Pilih dari Galeri</span>
        </button>
    </div>

    <!-- Modal Popup -->
    <div x-show="isOpen" x-cloak class="gm-modal-backdrop" x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">

        <!-- Modal Box -->
        <div @click.away="isOpen = false" class="gm-modal-box" x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95">

            <!-- Header -->
            <div class="gm-header">
                <div>
                    <h3 class="gm-header-title">Galeri Media</h3>
                    <p class="gm-header-subtitle">Pilih gambar yang sudah terunggah.</p>
                </div>

                <!-- Search Input -->
                <div class="gm-search-wrapper">
                    <input type="text" x-model="search" placeholder="Cari nama file..." class="gm-search-input">
                    <span class="gm-search-icon">
                        <svg style="width: 14px; height: 14px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </span>
                </div>

                <!-- Tombol Close -->
                <button type="button" @click="isOpen = false" class="gm-close-btn">
                    <svg style="width: 18px; height: 18px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Body Content -->
            <div class="gm-body">
                <!-- Sidebar Folder (Left) -->
                <div class="gm-sidebar">
                    <span class="gm-sidebar-title">Daftar Folder</span>
                    <template x-for="folder in folders" :key="folder">
                        <button type="button" @click="currentFolder = folder" class="gm-folder-item"
                            :class="currentFolder === folder ? 'active' : ''">
                            <svg style="width: 16px; height: 16px; shrink: 0; color: #a1a1aa;" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                            </svg>
                            <span
                                style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap; text-transform: capitalize;"
                                x-text="folder.replace('_', ' ').replace('-', ' ')"></span>
                        </button>
                    </template>
                </div>

                <!-- Image Grid (Right) -->
                <div class="gm-grid-container">
                    <div x-show="filteredFiles.length === 0"
                        style="height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; color: #a1a1aa;">
                        <svg style="width: 40px; height: 40px; margin-bottom: 0.5rem;" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <p style="font-size: 0.75rem;">Tidak ada gambar ditemukan di folder ini.</p>
                    </div>

                    <div x-show="filteredFiles.length > 0" class="gm-grid">
                        <template x-for="file in filteredFiles" :key="file.path">
                            <div @click="toggleFile(file.path)"
                                @dblclick="selectedFiles = [file.path]; confirmSelection()" class="gm-item"
                                :class="selectedFiles.includes(file.path) ? 'active' : ''">

                                <!-- Image Wrapper -->
                                <div class="gm-item-image-wrapper">
                                    <img :src="file.url" :alt="file.name" class="gm-item-image" loading="lazy">
                                </div>

                                <!-- Label Info -->
                                <div class="gm-item-info">
                                    <p class="gm-item-name" x-text="file.name"></p>
                                </div>

                                <!-- Checkmark -->
                                <div x-show="selectedFiles.includes(file.path)" class="gm-checkmark">
                                    <svg style="width: 10px; height: 10px;" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" stroke-width="3.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Footer Action -->
            <div class="gm-footer">
                <button type="button" @click="isOpen = false" class="gm-btn gm-btn-secondary">
                    Batal
                </button>
                <button type="button" @click="confirmSelection" class="gm-btn gm-btn-primary">
                    Konfirmasi Pilihan (<span x-text="selectedFiles.length"></span>)
                </button>
            </div>
        </div>
    </div>
</div>