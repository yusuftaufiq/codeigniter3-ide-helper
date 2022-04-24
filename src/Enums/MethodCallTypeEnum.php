<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Enums;

use Spatie\Enum\Enum;

/**
 * @method static self library()
 * @method static self model()
 */
final class MethodCallTypeEnum extends Enum
{
    private $libraries = [
        'cache' => 'CI_Cache',
        'calendar' => 'CI_Calendar',
        'driver' => 'CI_Driver',
        'email' => 'CI_Email',
        'encryption' => 'CI_Encryption',
        'form_validation' => 'CI_Form_validation',
        'ftp' => 'CI_Ftp',
        'image_lib' => 'CI_Image_lib',
        'migration' => 'CI_Migration',
        'pagination' => 'CI_Pagination',
        'parser' => 'CI_Parser',
        'profiler' => 'CI_Profiler',
        'session' => 'CI_Session',
        'table' => 'CI_Table',
        'trackback' => 'CI_Trackback',
        'typography' => 'CI_Typography',
        'unit_test' => 'CI_Unit_test',
        'upload' => 'CI_Upload',
        'user_agent' => 'CI_User_agent',
        'xmlrpc' => 'CI_Xmlrpc',
        'xmlrpcs' => 'CI_Xmlrpcs',
        'zip' => 'CI_Zip',
    ];

    private function concreteLibraryNameOf(string $alias): string
    {
        if (array_key_exists($alias, $this->libraries) === true) {
            return $this->libraries[$alias];
        }

        return $alias;
    }

    private function concreteModelNameOf(string $alias): string
    {
        $path = explode('/', $alias);
        $name = $path[array_key_last($path)];

        return $name;
    }

    public function concreteNameOf(string $alias): ?string
    {
        switch (true) {
            case $this->equals(self::library()):
                $name = $this->concreteLibraryNameOf($alias);
                break;

            case $this->equals(self::model()):
                $name = $this->concreteModelNameOf($alias);
                break;
    
            default:
                $name = null;
                break;
        }

        return $name;
    }
}
