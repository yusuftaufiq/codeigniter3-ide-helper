<?php

declare(strict_types=1);

namespace Tests\Unit\Readers;

use Haemanthus\CodeIgniter3IdeHelper\Readers\FileReader;
use PHPUnit\Framework\TestCase;
use Tests\Fixtures\WithFileReader;

class AbstractFileReaderTest extends TestCase
{
    use WithFileReader;

    private FileReader $reader;

    public function setUp(): void
    {
        $this->setUpFileReader();

        $this->reader = $this->getMockForAbstractClass(FileReader::class, [
            $this->finderFactory,
            $this->fs,
        ]);
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_should_add_the_suffix_directory_if_it_doesnt_exist(): void
    {
        $this->reader->setRootDirectory('./tests/stubs/test_files');
        $this->reader->setFileDirectory('./application/core');

        $this->fs
            ->expects($this->once())
            ->method('exists')
            ->with($this->stringEndsWith('./tests/stubs/test_files/./application/core/'))
            ->willReturn(true);

        $this->assertTrue($this->reader->isDirectoryExists());
    }
}
