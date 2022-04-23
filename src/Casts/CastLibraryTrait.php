<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Casts;

trait CastLibraryTrait
{
    /**
    * Undocumented variable
    *
    * @var array<string, string>
    */
    protected $mapLibraries = [
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

    protected function classTypeOf(string $name): string
    {
        if (array_key_exists($name, $this->mapLibraries) === true) {
            return $this->mapLibraries[$name];
        }

        return $name;
    }
}
