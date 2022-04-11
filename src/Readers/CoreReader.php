<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Readers;

/**
 * Undocumented class
 */
class CoreReader extends AbstractFileReader
{
    /**
     * Undocumented variable
     *
     * @var array
     */
    protected array $patterns = [];

    /**
     * Undocumented variable
     *
     * @var string $path
     */
    protected string $path = './application/core/';

    /**
     * Undocumented function
     *
     * @param array $patterns
     * @return self
     */
    public function setPatterns(array $patterns): self
    {
        $this->patterns = $patterns;

        return $this;
    }

    /**
     * Undocumented function
     *
     * @return array<\Symfony\Component\Finder\SplFileInfo>
     */
    public function getFiles(): array
    {
        array_walk($this->patterns, function ($pattern) {
            $this->finder->path($pattern);
        });

        $this->finder
            ->files()
            ->in($this->getFullPath())
            ->name('*.php');

        return iterator_to_array($this->finder, false);
    }
}
