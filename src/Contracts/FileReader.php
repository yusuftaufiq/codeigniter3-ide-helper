<?php

declare(strict_types=1);

namespace Haemanthus\CodeIgniter3IdeHelper\Contracts;

use Symfony\Component\Finder\SplFileInfo;

interface FileReader
{
    public function setRootDirectory(string $rootDirectory): self;

    public function setFileDirectory(string $fileDirectory): self;

    /**
     * Undocumented function
     *
     * @param array<string> $patterns
     */
    public function setPatterns(array $patterns): self;

    public function getFirstFile(): ?SplFileInfo;

    public function isDirectoryExists(): bool;

    /**
     * Undocumented function
     *
     * @return array<SplFileInfo>
     */
    public function getFiles(): array;
}
