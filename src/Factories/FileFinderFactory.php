<?php

declare(strict_types=1);

namespace Haemanthus\CodeIgniter3IdeHelper\Factories;

use Symfony\Component\Finder\Finder;

/**
 * Undocumented class
 */
class FileFinderFactory
{
    /**
     * Undocumented function
     */
    public function create(): Finder
    {
        return new Finder();
    }
}
