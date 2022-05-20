<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Contracts;

use Symfony\Component\Finder\SplFileInfo;

interface FileReader
{
    public function setRootDirectory(string $rootDirectory): self;

    public function setFileDirectory(string $fileDirectory): self;

    public function setPatterns(array $patterns): self;

    public function getFirstFile(): ?SplFileInfo;

    /**
     * Undocumented function
     *
     * @return array<\Symfony\Component\Finder\SplFileInfo>
     */
    public function getFiles(): array;
}
