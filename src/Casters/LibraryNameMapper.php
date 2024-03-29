<?php

declare(strict_types=1);

namespace Haemanthus\CodeIgniter3IdeHelper\Casters;

class LibraryNameMapper extends ClassNameMapper
{
    /**
     * Undocumented variable
     *
     * @var array<string, string>
     */
    protected array $mapLibraries = [
        'benchmark' => 'CI_Benchmark',
        'cache' => 'CI_Cache',
        'calendar' => 'CI_Calendar',
        'config' => 'CI_Config',
        'database' => 'CI_DB',
        'db' => 'CI_DB',
        'driver' => 'CI_Driver',
        'email' => 'CI_Email',
        'encryption' => 'CI_Encryption',
        'form_validation' => 'CI_Form_validation',
        'ftp' => 'CI_Ftp',
        'image_lib' => 'CI_Image_lib',
        'input' => 'CI_Input',
        'lang' => 'CI_Lang',
        'load' => 'CI_Loader',
        'migration' => 'CI_Migration',
        'output' => 'CI_Output',
        'pagination' => 'CI_Pagination',
        'parser' => 'CI_Parser',
        'profiler' => 'CI_Profiler',
        'security' => 'CI_Security',
        'session' => 'CI_Session',
        'table' => 'CI_Table',
        'trackback' => 'CI_Trackback',
        'typography' => 'CI_Typography',
        'unit_test' => 'CI_Unit_test',
        'upload' => 'CI_Upload',
        'uri' => 'CI_URI',
        'user_agent' => 'CI_User_agent',
        'xmlrpc' => 'CI_Xmlrpc',
        'xmlrpcs' => 'CI_Xmlrpcs',
        'zip' => 'CI_Zip',
    ];

    public function concreteClassOf(string $name): string
    {
        if (array_key_exists($name, $this->mapLibraries) === true) {
            return $this->mapLibraries[$name];
        }

        return $this->fileNameOf($name);
    }

    public function concreteNameOf(string $name): string
    {
        return $this->fileNameOf($name);
    }
}
