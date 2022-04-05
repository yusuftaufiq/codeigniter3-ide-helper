<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Readers;

class ModelReader extends AbstractReader
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
    protected $path = './application/models/';

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
