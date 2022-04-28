<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Readers;

/**
 * Undocumented class
 */
class AutoloadFileReader extends AbstractFileReader
{
    /**
     * Undocumented variable
     *
     * @var string $path
     */
    protected string $path = './application/config/';

    /**
     * Undocumented function
     *
     * @return string
     */
    protected function getPath(): ?string
    {
        return $this->path;
    }

    /**
     * Undocumented function
     *
     * @return array<\Symfony\Component\Finder\SplFileInfo>
     */
    public function getFiles(): array
    {
        $this->finder
            ->files()
            ->in($this->getFullPath())
            ->name('autoload.php');

        return iterator_to_array($this->finder, false);
    }
}
