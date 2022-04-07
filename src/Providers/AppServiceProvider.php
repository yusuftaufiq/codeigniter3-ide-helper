<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Providers;

use DI\Scope;
use Symfony\Component\Finder\Finder;

class AppServiceProvider
{
    public static function definitions()
    {
        return [
            Finder::class => \DI\object(Finder::class)->scope(Scope::PROTOTYPE),
        ];
    }
}
