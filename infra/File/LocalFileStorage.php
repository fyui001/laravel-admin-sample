<?php

namespace Infra\File;

use Domain\File\FileStorageInterface;
use Domain\File\StorageType;
use Illuminate\Filesystem\FilesystemManager;

class LocalFileStorage implements FileStorageInterface
{
    use FileStorageTrait;

    public function __construct(FilesystemManager $filesystemManager)
    {
        $this->fileSystem = $filesystemManager->disk('local');
    }

    public function storageType(): StorageType
    {
        return new StorageType(StorageType::LOCAL_FILE_STORAGE);
    }
}
