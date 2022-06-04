<?php

namespace Tests\Fixture;

use Symfony\Component\Console\Output\Output;

class SpyOutput extends Output
{
    protected string $output = '';

    protected function doWrite(string $message, bool $newline)
    {
        $this->output .= $message . ($newline === true ? "\n" : '');
    }

    public function getOutput(): string
    {
        return $this->output;
    }
}