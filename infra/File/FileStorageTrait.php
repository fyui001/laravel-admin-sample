<?php

namespace Infra\File;

use Domain\File\FileMetaData;
use Domain\File\FilePath;
use Domain\File\ResourceFile;
use Illuminate\Http\UploadedFile;

trait FileStorageTrait
{
    /**
     * @var \Illuminate\Filesystem\FilesystemAdapter
     */
    private $fileSystem;

    abstract function storageType(): string;

    public function url(string $path)
    {
        return $this->fileSystem->url($path);
    }

    public function get(string $filePath)
    {
        return $this->fileSystem->get($filePath);
    }

    public function clone(FilePath $filePath): string
    {
        $newFilepath = $filePath->getNewNameForCopy()->rawValue();
        $this->fileSystem->copy($filePath, $newFilepath);

        return $newFilepath;
    }

    public function upload(UploadedFile $file, string $destination, bool $isPublic = false): string
    {
        $isPublicString = $isPublic ? 'public' : 'private';
        return $this->fileSystem->putFile($isPublicString . '/' . $destination, $file, $isPublicString);
    }

    public function uploadByResource(ResourceFile $file, string $destination, bool $isPublic = false): string
    {
        $isPublicString = $isPublic ? 'public' : 'private';
        return $this->fileSystem->put($isPublicString . '/' . $file->getFilePath($destination), $file->getResource(),
            $isPublicString);
    }

    public function download(FileMetaData $file)
    {
        return $this->fileSystem->get($file->getFilePath()->rawValue());
    }

    public function delete(string $filePath): bool
    {
        return $this->fileSystem->delete($filePath);
    }
}
