<?php

namespace Tests\Fixtures;

use Haemanthus\CodeIgniter3IdeHelper\Factories\FileFinderFactory;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

trait WithFileReader
{
    private MockObject $finderFactory;

    private MockObject $finder;

    private MockObject $fs;

    private function setUpFileReader(): void
    {
        $this->finderFactory = $this->createStub(FileFinderFactory::class);
        $this->finder = $this->createMock(Finder::class);
        $this->fs = $this->createMock(Filesystem::class);

        $this->finderFactory->method('create')->willReturn($this->finder);
    }
}
