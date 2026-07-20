<x-filament-panels::page>
    <style>
        .media-container {
            display: flex;
            gap: 20px;
            align-items: flex-start;
            font-family: inherit;
        }
        .media-left {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 16px;
            min-width: 0;
        }
        .media-right {
            width: 280px;
            flex-shrink: 0;
        }
        
        /* Toolbar styling */
        .media-toolbar {
            background: #f4f4f5;
            border: 1px solid #e4e4e7;
            border-radius: 8px;
            padding: 10px 12px;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }
        .media-actions {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 8px;
        }
        
        /* Buttons */
        .media-btn {
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            font-size: 12px;
            font-weight: 600;
            padding: 0 14px;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s;
            border: 1px solid transparent;
            box-sizing: border-box;
            line-height: 1;
            text-decoration: none;
        }
        .media-btn-primary {
            background-color: #2563eb;
            color: white !important;
            border-color: #2563eb;
        }
        .media-btn-primary:hover {
            background-color: #1d4ed8;
        }
        .media-btn-secondary {
            background-color: white;
            color: #3f3f46 !important;
            border-color: #d4d4d8;
        }
        .media-btn-secondary:hover {
            background-color: #f4f4f5;
        }
        .media-btn-danger {
            background-color: #fef2f2;
            color: #dc2626 !important;
            border-color: #fca5a5;
        }
        .media-btn-danger:hover {
            background-color: #fee2e2;
        }
        
        /* Input & Dropdown Groups */
        .media-input-group {
            display: inline-flex;
            align-items: center;
            background: white;
            border: 1px solid #d4d4d8;
            border-radius: 6px;
            height: 32px;
            box-sizing: border-box;
            overflow: hidden;
        }
        .media-input {
            border: none !important;
            outline: none !important;
            box-shadow: none !important;
            font-size: 12px;
            padding: 0 8px;
            background: transparent;
            color: #3f3f46;
            height: 100%;
        }

        /* Breadcrumbs */
        .media-breadcrumbs {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            font-weight: 500;
            color: #71717a;
            padding-left: 4px;
        }
        .media-breadcrumb-item {
            cursor: pointer;
            transition: color 0.2s;
        }
        .media-breadcrumb-item:hover {
            color: #2563eb;
            text-decoration: underline;
        }
        .media-breadcrumb-separator {
            color: #d4d4d8;
        }

        /* Explorer area */
        .media-explorer {
            background: #fbfbfb;
            border: 1px solid #e4e4e7;
            border-radius: 8px;
            padding: 20px;
            min-height: 450px;
        }
        .media-section-title {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #a1a1aa;
            margin-bottom: 16px;
            margin-top: 0;
        }
        .media-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(210px, 1fr));
            gap: 12px;
        }
        
        /* Grid Items */
        .media-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            border-radius: 8px;
            border: 1px solid #e4e4e7;
            background: white;
            cursor: pointer;
            transition: all 0.2s;
            min-width: 0; /* for text truncate */
            user-select: none;
        }
        .media-item:hover {
            background: #f4f4f5;
            border-color: #cbd5e1;
        }
        .media-item-selected {
            background-color: #eff6ff !important;
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 1px #3b82f6;
        }
        .media-item-icon {
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .media-item-name {
            font-size: 12px;
            font-weight: 600;
            color: #27272a;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            flex: 1;
            text-align: left;
        }
        .media-item-selected .media-item-name {
            color: #1e3a8a;
        }
        
        /* File thumb inside item */
        .media-item-thumb {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            overflow: hidden;
            border: 1px solid #e4e4e7;
            background: #f4f4f5;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .media-item-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Checkbox styling */
        .media-checkbox {
            width: 13px;
            height: 13px;
            border-radius: 3px;
            border: 1px solid #d4d4d8;
            cursor: pointer;
            accent-color: #2563eb;
            flex-shrink: 0;
        }

        /* Right Panel (Details Card) */
        .media-detail-card {
            background: white;
            border: 1px solid #e4e4e7;
            border-radius: 8px;
            padding: 20px;
            min-height: 450px;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }
        .media-detail-title {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #a1a1aa;
            border-bottom: 1px solid #f4f4f5;
            padding-bottom: 8px;
            margin: 0;
            text-align: left;
        }
        .media-preview-box {
            width: 100%;
            height: 160px;
            border-radius: 6px;
            border: 1px solid #e4e4e7;
            background: #fafafa;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 8px;
            overflow: hidden;
        }
        .media-preview-box img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            border-radius: 4px;
        }
        .media-meta-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
            font-size: 11px;
            text-align: left;
        }
        .media-meta-item-label {
            font-weight: 600;
            color: #a1a1aa;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 2px;
            display: block;
        }
        .media-meta-item-value {
            font-weight: 700;
            color: #27272a;
            word-break: break-all;
            display: block;
        }
        .media-textarea-copy {
            width: 100%;
            font-family: monospace;
            font-size: 10px;
            background: #f4f4f5;
            border: 1px solid #e4e4e7;
            border-radius: 4px;
            padding: 8px;
            color: #3f3f46;
            resize: none;
            cursor: pointer;
        }
        .media-textarea-copy:focus {
            border-color: #3b82f6;
            outline: none;
        }

        /* Empty state */
        .media-empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 80px 0;
            color: #a1a1aa;
            text-align: center;
        }
        .media-empty-text {
            font-size: 12px;
            font-weight: 600;
            color: #71717a;
            margin-top: 8px;
        }

        /* Loading animation */
        @keyframes mediaPulse {
            0%, 100% { opacity: 1; }
            50% { opacity: .4; }
        }
        .media-loading-indicator {
            font-size: 11px;
            color: #2563eb;
            font-weight: bold;
            animation: mediaPulse 1.5s infinite;
        }

        /* Dark Mode overrides */
        .dark .media-toolbar {
            background: #18181b;
            border-color: #27272a;
        }
        .dark .media-btn-secondary {
            background-color: #27272a;
            color: #e4e4e7 !important;
            border-color: #3f3f46;
        }
        .dark .media-btn-secondary:hover {
            background-color: #3f3f46;
        }
        .dark .media-input-group {
            background: #18181b;
            border-color: #3f3f46;
        }
        .dark .media-input {
            color: #e4e4e7;
        }
        .dark .media-input-btn {
            background: #1e3a8a;
            color: #60a5fa;
        }
        .dark .media-input-btn:hover {
            background: #1e40af;
        }
        .dark .media-explorer {
            background: #09090b;
            border-color: #27272a;
        }
        .dark .media-item {
            background: #18181b;
            border-color: #27272a;
        }
        .dark .media-item:hover {
            background: #27272a;
            border-color: #3f3f46;
        }
        .dark .media-item-selected {
            background-color: #172554 !important;
            border-color: #3b82f6 !important;
        }
        .dark .media-item-name {
            color: #e4e4e7;
        }
        .dark .media-item-selected .media-item-name {
            color: #dbeafe;
        }
        .dark .media-detail-card {
            background: #18181b;
            border-color: #27272a;
        }
        .dark .media-preview-box {
            background: #09090b;
            border-color: #27272a;
        }
        .dark .media-meta-item-value {
            color: #e4e4e7;
        }
        .dark .media-textarea-copy {
            background: #09090b;
            border-color: #27272a;
            color: #d4d4d8;
        }
        .dark .media-checkbox {
            border-color: #3f3f46;
        }
        .dark .media-loading-indicator {
            color: #60a5fa;
        }
    </style>

    <div class="media-container">
        
        {{-- LEFT COLUMN: EXPLORER & TOOLBAR --}}
        <div class="media-left">
            
            {{-- TOOLBAR --}}
            <div class="media-toolbar">
                
                {{-- Left Group: File & Folder Actions --}}
                <div class="media-actions">
                    {{-- Upload Files --}}
                    <label class="media-btn media-btn-primary">
                        <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                        Upload
                        <input type="file" multiple wire:model="uploadedFiles" style="display: none;">
                    </label>

                    {{-- Loading Indicator --}}
                    <span wire:loading wire:target="uploadedFiles" class="media-loading-indicator" style="margin-left: 4px;">
                        Mengunggah...
                    </span>

                    {{-- Separator Line --}}
                    <div style="width: 1px; height: 20px; background: #e4e4e7; margin: 0 4px;" class="dark:bg-zinc-800"></div>

                    {{-- Add Folder Input and Button --}}
                    <div class="media-input-group">
                        <input type="text" wire:model.defer="newFolderName" placeholder="Folder baru..." class="media-input" style="width: 120px;">
                        <button wire:click="createFolder" title="Buat Folder" class="media-input-btn" style="height: 26px; width: 26px; border: none; border-radius: 4px; display: flex; align-items: center; justify-content: center; margin-right: 2px; background: #eff6ff; color: #2563eb; cursor: pointer;">
                            <svg style="width: 12px; height: 12px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        </button>
                    </div>

                    {{-- Navigate Up Button --}}
                    @if($currentPath)
                        <button wire:click="navigateUp" class="media-btn media-btn-secondary">
                            <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Kembali
                        </button>
                    @endif
                </div>

                {{-- Right Group: Search, Filter, and Bulk Actions --}}
                <div class="media-actions">
                    {{-- Search Input Group --}}
                    <div class="media-input-group" style="padding-left: 8px;">
                        <svg style="width: 14px; height: 14px; color: #a1a1aa; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari file..." class="media-input" style="width: 120px;">
                    </div>

                    {{-- File Type Filter Dropdown --}}
                    <div class="media-input-group">
                        <select wire:model.live="filterType" class="media-input" style="width: 110px; font-size: 11px; border: none; cursor: pointer; padding: 0 8px; background: transparent;">
                            <option value="all">Semua Jenis</option>
                            <option value="image">Hanya Gambar</option>
                            <option value="document">Hanya Dokumen</option>
                        </select>
                    </div>

                    {{-- Select All / Deselect All --}}
                    @if(!empty($this->directories) || !empty($this->files))
                        @if(count($selectedItems) === count($this->directories) + count($this->files) && count($selectedItems) > 0)
                            <button wire:click="deselectAll" class="media-btn media-btn-secondary">
                                <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                Batal Pilih
                            </button>
                        @else
                            <button wire:click="selectAll" class="media-btn media-btn-secondary">
                                <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Pilih Semua
                            </button>
                        @endif
                    @endif

                </div>
            </div>

            {{-- BREADCRUMBS & ACTIONS --}}
            <div style="display: flex; justify-content: space-between; align-items: center; height: 38px !important; padding: 0 !important; margin-bottom: 8px !important; box-sizing: border-box !important;">
                <div class="media-breadcrumbs" style="margin: 0; display: flex; align-items: center;">
                    <span class="media-breadcrumb-item" wire:click="navigateTo('')">Media Library</span>
                    @if($currentPath)
                        @php $parts = explode('/', $currentPath); $tempPath = ''; @endphp
                        @foreach($parts as $part)
                            @php $tempPath = $tempPath ? $tempPath . '/' . $part : $part; @endphp
                            <span class="media-breadcrumb-separator">></span>
                            <span class="media-breadcrumb-item" wire:click="navigateTo('{{ $tempPath }}')">{{ $part }}</span>
                        @endforeach
                    @endif
                </div>

                @if(!empty($selectedItems))
                    <div style="display: flex; gap: 8px; align-items: center;">
                        {{-- Move Selected Button --}}
                        <button wire:click="startMove" class="media-btn media-btn-secondary">
                            <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                            Pindahkan ({{ count($selectedItems) }})
                        </button>

                        {{-- Delete Selected Button --}}
                        <button wire:click="deleteSelected" onclick="confirm('Apakah Anda yakin ingin menghapus ' + {{ count($selectedItems) }} + ' item terpilih?') || event.stopImmediatePropagation()" class="media-btn media-btn-danger">
                            <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            Hapus ({{ count($selectedItems) }})
                        </button>
                    </div>
                @endif
            </div>

            {{-- FILE & DIRECTORY LISTING CONTAINER --}}
            <div class="media-explorer">
                
                <h4 class="media-section-title">
                    Media Library
                </h4>

                @if(empty($this->directories) && empty($this->files))
                    <div class="media-empty-state">
                        <svg style="width: 48px; height: 48px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9"></path></svg>
                        <p class="media-empty-text">Folder ini kosong atau tidak ditemukan file</p>
                    </div>
                @else
                    
                    {{-- Folders & Files Grid (Desktop-like rectangular style) --}}
                    <div class="media-grid">
                        
                        {{-- Render Directories --}}
                        @foreach($this->paginatedDirectories as $dir)
                            @php 
                                $isSelected = in_array($dir['path'], $selectedItems);
                            @endphp
                            <div 
                                wire:key="dir-item-{{ $dir['path'] }}-{{ $isSelected ? 'selected' : 'unselected' }}"
                                wire:click="selectItem('{{ $dir['name'] }}', 'folder')"
                                wire:dblclick="navigateTo('{{ $dir['path'] }}')"
                                class="media-item {{ $isSelected ? 'media-item-selected' : '' }}"
                            >
                                <input type="checkbox" wire:click.stop="toggleSelect('{{ $dir['path'] }}', 'folder', '{{ $dir['name'] }}')" {{ $isSelected ? 'checked' : '' }} class="media-checkbox">
                                <div class="media-item-icon">
                                    <svg style="width: 32px; height: 32px; color: #f59e0b;" fill="currentColor" viewBox="0 0 20 20"><path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"></path></svg>
                                </div>
                                <span class="media-item-name" title="{{ $dir['name'] }}">
                                    {{ $dir['name'] }}
                                </span>
                            </div>
                        @endforeach

                        {{-- Render Files --}}
                        @foreach($this->paginatedFiles as $file)
                            @php 
                                $isSelected = in_array($file['path'], $selectedItems);
                                $isImage = in_array($file['extension'], ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg']);
                            @endphp
                            <div 
                                wire:key="file-item-{{ $file['path'] }}-{{ $isSelected ? 'selected' : 'unselected' }}"
                                wire:click="selectItem('{{ $file['name'] }}', 'file')"
                                class="media-item {{ $isSelected ? 'media-item-selected' : '' }}"
                            >
                                <input type="checkbox" wire:click.stop="toggleSelect('{{ $file['path'] }}', 'file', '{{ $file['name'] }}')" {{ $isSelected ? 'checked' : '' }} class="media-checkbox">
                                <div class="media-item-icon">
                                    @if($isImage)
                                        <div class="media-item-thumb">
                                            <img src="{{ $file['url'] }}" alt="{{ $file['name'] }}">
                                        </div>
                                    @else
                                        <svg style="width: 32px; height: 32px; color: #a1a1aa;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                    @endif
                                </div>
                                <span class="media-item-name" title="{{ $file['name'] }}">
                                    {{ $file['name'] }}
                                </span>
                            </div>
                        @endforeach

                    </div>

                    {{-- Pagination Controls --}}
                    @if($this->totalPages > 1)
                        <div class="flex items-center justify-between pt-4 mt-4 border-t border-zinc-200 dark:border-zinc-800 text-xs">
                            <span class="text-zinc-500 font-medium">Halaman {{ $this->page }} dari {{ $this->totalPages }}</span>
                            <div class="flex items-center gap-1">
                                <button type="button" wire:click="previousPage" {{ $this->page <= 1 ? 'disabled' : '' }} class="px-3 py-1.5 rounded-md bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 font-semibold disabled:opacity-40 hover:bg-zinc-200 transition-colors">
                                    &larr; Prev
                                </button>
                                <button type="button" wire:click="nextPage" {{ $this->page >= $this->totalPages ? 'disabled' : '' }} class="px-3 py-1.5 rounded-md bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 font-semibold disabled:opacity-40 hover:bg-zinc-200 transition-colors">
                                    Next &rarr;
                                </button>
                            </div>
                        </div>
                    @endif
                @endif

            </div>

        </div>

        {{-- RIGHT COLUMN: DETAIL PANEL --}}
        <div class="media-right">
            <div class="media-detail-card">
                
                <h3 class="media-detail-title">
                    Detail Item
                </h3>

                @if($selectedItem)
                    <div class="flex-1 flex flex-col space-y-4" style="display: flex; flex-direction: column; gap: 16px;">
                        
                        {{-- Preview Box --}}
                        <div class="media-preview-box">
                            @if($selectedItem['type'] === 'folder')
                                <svg style="width: 64px; height: 64px; color: #f59e0b;" fill="currentColor" viewBox="0 0 20 20"><path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"></path></svg>
                            @else
                                @php 
                                    $isImage = in_array($selectedItem['extension'], ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg']);
                                @endphp
                                @if($isImage)
                                    <img src="{{ $selectedItem['url'] }}" alt="{{ $selectedItem['name'] }}">
                                @else
                                    <svg style="width: 64px; height: 64px; color: #a1a1aa;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                @endif
                            @endif
                        </div>

                        {{-- Metadata --}}
                        <div class="media-meta-list">
                            <div>
                                <span class="media-meta-item-label">Nama</span>
                                <span class="media-meta-item-value select-all">{{ $selectedItem['name'] }}</span>
                            </div>
                            
                            <div>
                                <span class="media-meta-item-label">Tipe</span>
                                <span class="media-meta-item-value capitalize">{{ $selectedItem['type'] }}</span>
                            </div>
                            
                            <div>
                                <span class="media-meta-item-label">Kapasitas / Ukuran</span>
                                <span class="media-meta-item-value">{{ $selectedItem['size'] }}</span>
                            </div>

                            @if($selectedItem['type'] === 'file')
                                <div class="pt-1" x-data="{ copied: false }">
                                    <span class="media-meta-item-label">Path URL (Salin)</span>
                                    <div style="display: flex; gap: 4px; margin-top: 4px; align-items: stretch;">
                                        <textarea readonly onclick="this.select();" class="media-textarea-copy" style="margin: 0; flex: 1;" rows="2">/storage/{{ $selectedItem['path'] }}</textarea>
                                        <button 
                                            @click="navigator.clipboard.writeText('/storage/{{ $selectedItem['path'] }}'); copied = true; setTimeout(() => copied = false, 2000)"
                                            class="media-btn media-btn-primary" 
                                            style="padding: 4px 10px; font-size: 10px; flex-shrink: 0; display: inline-flex; align-items: center; justify-content: center;"
                                        >
                                            <span x-show="!copied">Salin</span>
                                            <span x-show="copied" style="color: #93c5fd; font-weight: bold;">Disalin!</span>
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- Action buttons --}}
                        @if($selectedItem['type'] === 'file')
                            <div>
                                <a href="{{ $selectedItem['url'] }}" target="_blank" class="media-btn media-btn-primary" style="display: flex; justify-content: center; width: 100%; box-sizing: border-box;">
                                    Buka di Tab Baru
                                </a>
                            </div>
                        @endif

                    </div>
                @else
                    <div style="flex: 1; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; color: #a1a1aa; padding: 40px 0;">
                        <svg style="width: 40px; height: 40px; margin-bottom: 12px; opacity: 0.3;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <p style="font-size: 11px; font-weight: 600; color: #71717a; margin: 0;">Pilih folder atau file untuk melihat informasi detail di sini.</p>
                    </div>
                @endif

            </div>
        </div>

    </div>

    {{-- MOVE MODAL OVERLAY --}}
    @if($isMoving)
        <div style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; z-index: 9999; padding: 16px;">
            <div class="media-detail-card" style="width: 420px; min-height: auto; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.2); gap: 20px;">
                <h3 class="media-detail-title" style="border: none; padding: 0; margin: 0; font-size: 14px; font-weight: 700; color: #27272a;">
                    Pindahkan Item
                </h3>
                
                <p style="font-size: 12px; color: #71717a; margin: 0; text-align: left;">
                    Pilih folder tujuan untuk memindahkan <strong>{{ count($selectedItems) }}</strong> item terpilih:
                </p>

                <div class="media-input-group" style="width: 100%; display: flex; box-sizing: border-box;">
                    <select wire:model="targetFolder" class="media-input" style="width: 100%; font-size: 12px; height: 100%; border: none; cursor: pointer; padding: 0 8px; background: transparent;">
                        @foreach($this->moveTargetDirectories as $dirPath)
                            <option value="{{ $dirPath }}">
                                {{ $dirPath === '' ? 'Root (Disk Utama)' : '/' . $dirPath }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div style="display: flex; gap: 8px; justify-content: flex-end; width: 100%;">
                    <button wire:click="cancelMove" class="media-btn media-btn-secondary" style="flex: 1;">
                        Batal
                    </button>
                    <button wire:click="moveSelectedItems" class="media-btn media-btn-primary" style="flex: 1;">
                        Pindahkan Sekarang
                    </button>
                </div>
            </div>
        </div>
    @endif
</x-filament-panels::page>
