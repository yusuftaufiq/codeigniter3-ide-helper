<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Contracts;

use Symfony\Component\Finder\SplFileInfo;

interface FileReader
{
    public function setDirectory(string $dir): self;

    public function setPath(?string $path): self;

    public function setPatterns(array $patterns): self;

    public function getFirstFile(): ?SplFileInfo;

    /**
     * Undocumented function
     *
     * @return array<\Symfony\Component\Finder\SplFileInfo>
     */
    public function getFiles(): array;
}
