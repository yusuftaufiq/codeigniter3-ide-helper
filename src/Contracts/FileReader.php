<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Contracts;

interface FileReader
{
    public function getFirstFile(): string;

    public function getFiles(): string;
}
