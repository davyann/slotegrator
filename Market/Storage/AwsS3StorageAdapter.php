<?php

namespace Market\Storage;

use AwsS3\Client\AwsStorageInterface;

class AwsS3StorageAdapter implements StorageInterface
{
    public function __construct(
        private AwsStorageInterface $client
    ) {
    }

    public function fileExists(string $fileName): bool
    {
        return $this->client->isAuthorized(); // Простейшая проверка
    }

    public function getUrl(string $fileName): ?string
    {
        try {
            return (string) $this->client->getUrl($fileName);
        } catch (\Throwable) {
            return null;
        }
    }
}
