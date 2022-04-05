<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Readers;

class AutoloadReader extends AbstractReader
{
    /**
     * Undocumented variable
     *
     * @var string
     */
    protected $dir = './';

    /**
     * Undocumented variable
     *
     * @var string $path
     */
    protected $path = './application/config/autoload.php';

    /**
     * Undocumented variable
     *
     * @var array<string, array<int, string>>
     */
    protected $autoload = [
        'cores' => [
            'benchmark',
            'config',
            'input',
            'lang',
            'loader',
            'output',
            'security',
            'uri',
        ],
    ];

    /**
     * Undocumented function
     *
     * @param string $dir
     */
    public function __construct($dir)
    {
        $this->dir = $dir;
    }
}
