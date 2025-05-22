<?php

namespace Market\Storage;

interface StorageInterface
{
    public function fileExists(string $fileName): bool;
    public function getUrl(string $fileName): ?string;
}
