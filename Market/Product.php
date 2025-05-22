<?php

namespace Market;

use Market\Storage\StorageInterface;

class Product
{
    private StorageInterface $fileStorage;
    private StorageInterface $awsStorage;

    private array $legacyImageFileNames = [];
    private array $s3ImageFileNames = [];

    public function __construct(StorageInterface $fileStorage, StorageInterface $awsStorage)
    {
        $this->fileStorage = $fileStorage;
        $this->awsStorage = $awsStorage;
    }

    public function getImageUrl(): ?string
    {
        foreach ($this->legacyImageFileNames as $fileName) {
            if ($this->fileStorage->fileExists($fileName)) {
                return $this->fileStorage->getUrl($fileName);
            }
        }
        return null;
    }

    public function getImageUrls(): array
    {
        $urls = [];

        foreach ($this->legacyImageFileNames as $fileName) {
            if ($this->fileStorage->fileExists($fileName)) {
                $url = $this->fileStorage->getUrl($fileName);
                if ($url !== null) {
                    $urls[] = $url;
                }
            }
        }

        foreach ($this->s3ImageFileNames as $fileName) {
            if ($this->awsStorage->fileExists($fileName)) {
                $url = $this->awsStorage->getUrl($fileName);
                if ($url !== null) {
                    $urls[] = $url;
                }
            }
        }

        return $urls;
    }

    // Для теста или заполнения извне
    public function setLegacyImageFileNames(array $fileNames): void
    {
        $this->legacyImageFileNames = $fileNames;
    }

    public function setS3ImageFileNames(array $fileNames): void
    {
        $this->s3ImageFileNames = $fileNames;
    }
}
