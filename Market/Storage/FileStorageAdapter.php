<?php

namespace Market\Storage;

use Market\FileStorageRepository;

class FileStorageAdapter implements StorageInterface
{
    public function __construct(
        private FileStorageRepository $repository
    ) {
    }

    public function fileExists(string $fileName): bool
    {
        return $this->repository->fileExists($fileName);
    }

    public function getUrl(string $fileName): ?string
    {
        return $this->repository->getUrl($fileName);
    }
}
