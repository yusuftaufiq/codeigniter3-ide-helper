<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Casts;

use Haemanthus\CodeIgniter3IdeHelper\Objects\PropertyTagDTO;
use PhpParser\Node;

abstract class AbstractNodeCast
{
    /**
    * Undocumented variable
    *
    * @var array<string, array<string, string>>
    */
    protected $map = [
        'cores' => [
            'benchmark' => 'CI_Benchmark',
            'config' => 'CI_Config',
            'input' => 'CI_Input',
            'lang' => 'CI_Lang',
            'load' => 'CI_Loader',
            'output' => 'CI_Output',
            'security' => 'CI_Security',
            'uri' => 'CI_URI',
        ],
        'libraries' => [
            'cache' => 'CI_Cache',
            'calendar' => 'CI_Calendar',
            // 'driver' => 'CI_Driver',
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
        ],
    ];

    abstract public function cast(Node $node): array;
}