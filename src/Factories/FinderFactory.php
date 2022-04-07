<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Factories;

use Symfony\Component\Finder\Finder;

/**
 * Undocumented class
 */
class FinderFactory
{
    /**
     * Undocumented function
     *
     * @return Finder
     */
    public function create(): Finder
    {
        return new Finder();
    }
}
