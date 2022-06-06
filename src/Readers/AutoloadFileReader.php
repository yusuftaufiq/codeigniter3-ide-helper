<?php

declare(strict_types=1);

namespace Haemanthus\CodeIgniter3IdeHelper\Readers;

use Symfony\Component\Finder\SplFileInfo;

class AutoloadFileReader extends FileReader
{
    protected ?string $fileDirectory = './application/config/';

    /**
     * Undocumented function
     *
     * @return array<SplFileInfo>
     */
    public function getFiles(): array
    {
        $this->finder
            ->files()
            ->in($this->getFullDirectory())
            ->name('autoload.php');

        return iterator_to_array($this->finder, false);
    }
}
