<?php

namespace App\Filament\Pages;

use App\Support\ActivityLogger;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class Media extends Page
{
    use WithFileUploads;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-folder-open';

    protected string $view = 'filament.pages.media';

    protected static ?string $navigationLabel = 'Media Explorer';

    protected static ?string $title = 'Media Explorer';

    protected static \UnitEnum|string|null $navigationGroup = 'Website Content';

    protected static ?int $navigationSort = 4;

    public $currentPath = ''; // Relative to 'public' disk root

    public $newFolderName = '';

    public $uploadedFiles = []; // Temporary holding array for Livewire file uploads

    // Selection state
    public $selectedItems = []; // Array of selected paths: ['path1', 'path2']

    public $selectedItem = null; // Contains active preview item details

    // Search state
    public $search = '';

    // Filter state
    public $filterType = 'all'; // 'all', 'image', 'document'

    // Move state
    public $isMoving = false;

    public $targetFolder = '';

    // Pagination state
    public $perPage = 24;

    public $page = 1;

    public function updatedSearch()
    {
        $this->page = 1;
    }

    public function updatedFilterType()
    {
        $this->page = 1;
    }

    public function mount()
    {
        $this->currentPath = '';
    }

    public function getDirectoriesProperty()
    {
        if ($this->filterType !== 'all') {
            return [];
        }

        $dirs = Storage::disk('public')->directories($this->currentPath);
        $collection = collect($dirs)->map(function ($dirPath) {
            return [
                'name' => basename($dirPath),
                'path' => $dirPath,
                'type' => 'folder',
            ];
        });

        if (! empty(trim($this->search))) {
            $searchLower = strtolower($this->search);
            $collection = $collection->filter(function ($dir) use ($searchLower) {
                return str_contains(strtolower($dir['name']), $searchLower);
            });
        }

        return $collection->toArray();
    }

    public function getFilesProperty()
    {
        $files = Storage::disk('public')->files($this->currentPath);
        $collection = collect($files)->map(function ($filePath) {
            $extension = pathinfo($filePath, PATHINFO_EXTENSION);
            $size = Storage::disk('public')->size($filePath);

            // Format size
            if ($size >= 1048576) {
                $formattedSize = round($size / 1048576, 2).' MB';
            } elseif ($size >= 1024) {
                $formattedSize = round($size / 1024, 2).' KB';
            } else {
                $formattedSize = $size.' B';
            }

            return [
                'name' => basename($filePath),
                'path' => $filePath,
                'type' => 'file',
                'extension' => strtolower($extension),
                'size' => $formattedSize,
                'url' => Storage::disk('public')->url($filePath),
            ];
        });

        if (! empty(trim($this->search))) {
            $searchLower = strtolower($this->search);
            $collection = $collection->filter(function ($file) use ($searchLower) {
                return str_contains(strtolower($file['name']), $searchLower);
            });
        }

        if ($this->filterType === 'image') {
            $collection = $collection->filter(function ($file) {
                return in_array($file['extension'], ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg']);
            });
        } elseif ($this->filterType === 'document') {
            $collection = $collection->filter(function ($file) {
                return ! in_array($file['extension'], ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg']);
            });
        }

        return $collection->toArray();
    }

    public function toggleSelect($path, $type, $name)
    {
        if (in_array($path, $this->selectedItems)) {
            $this->selectedItems = array_values(array_diff($this->selectedItems, [$path]));

            if ($this->selectedItem && $this->selectedItem['path'] === $path) {
                $this->selectedItem = null;
                if (! empty($this->selectedItems)) {
                    $this->selectItemByPath(end($this->selectedItems));
                }
            }
        } else {
            $this->selectedItems[] = $path;
            $this->selectItemByPath($path);
        }
    }

    public function selectItem($name, $type): void
    {
        $fullPath = $this->currentPath ? $this->currentPath.'/'.$name : $name;

        // Jika sudah ada di selectedItems, hanya update preview panel tanpa mengubah seleksi
        if (in_array($fullPath, $this->selectedItems)) {
            $this->selectItemByPath($fullPath);

            return;
        }

        // Jika belum, tambahkan ke selectedItems (multi-select)
        $this->selectedItems[] = $fullPath;
        $this->selectItemByPath($fullPath);
    }

    public function selectAll(): void
    {
        $this->selectedItems = [];

        foreach ($this->directories as $dir) {
            $this->selectedItems[] = $dir['path'];
        }

        foreach ($this->files as $file) {
            $this->selectedItems[] = $file['path'];
        }

        // Update preview to last item if any
        if (! empty($this->selectedItems)) {
            $this->selectItemByPath(end($this->selectedItems));
        }
    }

    public function deselectAll(): void
    {
        $this->selectedItems = [];
        $this->selectedItem = null;
    }

    protected function selectItemByPath($path)
    {
        $name = basename($path);

        // Check directory status safely by examining structure
        // Since Laravel's directoryExists is not standard on older flysystem, we check if it is within current directory's directories.
        // Or check if directoryExists is available (Laravel 9+). In Laravel 11/12 directoryExists() is native and works:
        $isDir = Storage::disk('public')->directoryExists($path);

        if ($isDir) {
            $this->selectedItem = [
                'name' => $name,
                'path' => $path,
                'type' => 'folder',
                'url' => null,
                'size' => count(Storage::disk('public')->files($path)).' file, '.count(Storage::disk('public')->directories($path)).' folder',
            ];
        } else {
            if (Storage::disk('public')->exists($path)) {
                $size = Storage::disk('public')->size($path);
                if ($size >= 1048576) {
                    $formattedSize = round($size / 1048576, 2).' MB';
                } elseif ($size >= 1024) {
                    $formattedSize = round($size / 1024, 2).' KB';
                } else {
                    $formattedSize = $size.' B';
                }

                $this->selectedItem = [
                    'name' => $name,
                    'path' => $path,
                    'type' => 'file',
                    'url' => Storage::disk('public')->url($path),
                    'size' => $formattedSize,
                    'extension' => strtolower(pathinfo($path, PATHINFO_EXTENSION)),
                ];
            } else {
                $this->selectedItem = null;
            }
        }
    }

    public function navigateTo($path)
    {
        $this->currentPath = $path;
        $this->selectedItem = null;
        $this->selectedItems = [];
        $this->reset('newFolderName', 'uploadedFiles', 'search', 'filterType');
    }

    public function navigateUp()
    {
        if (empty($this->currentPath)) {
            return;
        }

        $parts = explode('/', $this->currentPath);
        array_pop($parts);
        $this->currentPath = implode('/', $parts);
        $this->selectedItem = null;
        $this->selectedItems = [];
        $this->reset('newFolderName', 'uploadedFiles', 'search', 'filterType');
    }

    public function createFolder()
    {
        $this->validate([
            'newFolderName' => 'required|string|min:1|max:50',
        ]);

        $slugName = Str::slug($this->newFolderName);
        $targetPath = $this->currentPath ? $this->currentPath.'/'.$slugName : $slugName;

        if (Storage::disk('public')->exists($targetPath)) {
            Notification::make()
                ->title('Folder sudah ada')
                ->danger()
                ->send();

            return;
        }

        Storage::disk('public')->makeDirectory($targetPath);

        ActivityLogger::log('create', 'Membuat folder baru: '.$targetPath, 'Media', $targetPath);

        Notification::make()
            ->title('Folder berhasil dibuat')
            ->success()
            ->send();

        $this->reset('newFolderName');
    }

    public function updatedUploadedFiles()
    {
        $supportedExtensions = ['webp', 'jpg', 'jpeg', 'png', 'gif'];
        $uploadedCount = 0;

        foreach ($this->uploadedFiles as $file) {
            $ext = strtolower($file->getClientOriginalExtension() ?: pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION));

            // Rejeksi format heic dan format lain yang tidak terdaftar
            if (empty($ext) || ! in_array($ext, $supportedExtensions)) {
                Notification::make()
                    ->title('Gagal mengunggah file')
                    ->body('Format file tidak didukung: .'.($ext ?: 'unknown').' ('.$file->getClientOriginalName().')')
                    ->danger()
                    ->send();

                continue;
            }

            // Batasi ukuran maksimal 10MB (10240 KB)
            if ($file->getSize() > 10485760) {
                Notification::make()
                    ->title('Gagal mengunggah file')
                    ->body('Ukuran file melebihi batas 10MB: '.$file->getClientOriginalName())
                    ->danger()
                    ->send();

                continue;
            }

            $originalName = $file->getClientOriginalName();
            $name = pathinfo($originalName, PATHINFO_FILENAME);
            $cleanName = Str::slug($name).'.'.$ext;

            $file->storeAs($this->currentPath, $cleanName, 'public');
            $uploadedCount++;

            ActivityLogger::log('upload', 'Mengunggah file: '.$cleanName.' ke folder '.($this->currentPath ?: 'root'), 'Media', $cleanName);
        }

        if ($uploadedCount > 0) {
            Notification::make()
                ->title($uploadedCount.' file berhasil diunggah')
                ->success()
                ->send();
        }

        $this->reset('uploadedFiles');
    }

    public function deleteSelected()
    {
        if (empty($this->selectedItems)) {
            return;
        }

        $deletedCount = 0;

        foreach ($this->selectedItems as $path) {
            $isDir = Storage::disk('public')->directoryExists($path);

            if ($isDir) {
                Storage::disk('public')->deleteDirectory($path);
                $deletedCount++;
            } else {
                if (Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                    $deletedCount++;
                }
            }
        }

        ActivityLogger::log('delete', 'Menghapus '.$deletedCount.' item media dari storage', 'Media', null, ['items' => $this->selectedItems]);

        Notification::make()
            ->title($deletedCount.' item berhasil dihapus')
            ->success()
            ->send();

        $this->selectedItems = [];
        $this->selectedItem = null;
    }

    // Move feature methods
    public function getMoveTargetDirectoriesProperty()
    {
        $dirs = Storage::disk('public')->allDirectories();
        // Add root path as first option
        array_unshift($dirs, '');

        return $dirs;
    }

    public function startMove()
    {
        if (empty($this->selectedItems)) {
            return;
        }
        $this->targetFolder = '';
        $this->isMoving = true;
    }

    public function cancelMove()
    {
        $this->isMoving = false;
    }

    public function moveSelectedItems()
    {
        if (empty($this->selectedItems)) {
            $this->isMoving = false;

            return;
        }

        $movedCount = 0;

        foreach ($this->selectedItems as $sourcePath) {
            $name = basename($sourcePath);
            $targetPath = $this->targetFolder ? $this->targetFolder.'/'.$name : $name;

            if ($sourcePath === $targetPath) {
                continue;
            }

            $isDir = Storage::disk('public')->directoryExists($sourcePath);

            if ($isDir) {
                if (! Storage::disk('public')->exists($targetPath)) {
                    Storage::disk('public')->move($sourcePath, $targetPath);
                    $movedCount++;
                }
            } else {
                if (Storage::disk('public')->exists($sourcePath)) {
                    // Overwrite check: only move if target doesn't exist
                    if (! Storage::disk('public')->exists($targetPath)) {
                        Storage::disk('public')->move($sourcePath, $targetPath);
                        $movedCount++;
                    }
                }
            }
        }

        ActivityLogger::log('move', 'Memindahkan '.$movedCount.' item media ke folder '.($this->targetFolder ?: 'root'), 'Media', null, ['items' => $this->selectedItems, 'target' => $this->targetFolder]);

        Notification::make()
            ->title($movedCount.' item berhasil dipindahkan')
            ->success()
            ->send();

        $this->selectedItems = [];
        $this->selectedItem = null;
        $this->isMoving = false;
    }

    // Pagination Computed Properties & Methods
    public function getTotalPagesProperty()
    {
        $total = count($this->directories) + count($this->files);

        return max(1, (int) ceil($total / $this->perPage));
    }

    public function getPaginatedDirectoriesProperty()
    {
        $dirs = $this->directories;
        $start = ($this->page - 1) * $this->perPage;

        return array_slice($dirs, max(0, $start), $this->perPage);
    }

    public function getPaginatedFilesProperty()
    {
        $dirCount = count($this->directories);
        $files = $this->files;
        $start = ($this->page - 1) * $this->perPage - $dirCount;

        if ($start < 0) {
            $length = $this->perPage - count($this->paginatedDirectories);

            return array_slice($files, 0, max(0, $length));
        }

        return array_slice($files, $start, $this->perPage);
    }

    public function nextPage()
    {
        if ($this->page < $this->totalPages) {
            $this->page++;
        }
    }

    public function previousPage()
    {
        if ($this->page > 1) {
            $this->page--;
        }
    }

    public function gotoPage($page)
    {
        $this->page = max(1, min((int) $page, $this->totalPages));
    }
}
