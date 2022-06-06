<?php

declare(strict_types=1);

namespace Haemanthus\CodeIgniter3IdeHelper\Readers;

/**
 * Undocumented class
 */
class ClassFileReader extends FileReader
{
    /**
     * Undocumented function
     *
     * @return array<SplFileInfo>
     */
    public function getFiles(): array
    {
        array_walk($this->patterns, function (string $pattern): void {
            $this->finder->path($pattern);
        });

        $this->finder
            ->files()
            ->in($this->getFullDirectory())
            ->name('*.php');

        return iterator_to_array($this->finder, false);
    }
}
