<?php

namespace Tests\Unit\Readers;

use Haemanthus\CodeIgniter3IdeHelper\Readers\AutoloadFileReader;
use PHPUnit\Framework\TestCase;
use Tests\Fixture\WithFileReader;

class AutoloadFileReaderTest extends TestCase
{
    use WithFileReader;

    private AutoloadFileReader $reader;

    public function setUp(): void
    {
        $this->setUpFileReader();

        $this->reader = new AutoloadFileReader($this->finderFactory, $this->fs);
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_should_find_files_with_correct_directory(): void
    {
        $this->finder->expects($this->once())->method('files')->willReturnSelf();
        $this->finder->expects($this->once())->method('in')->with($this->stringEndsWith('./application/config/'))->willReturnSelf();
        $this->finder->expects($this->once())->method('name')->with('autoload.php');
        $this->finder->expects($this->once())->method('getIterator')->willReturn(new \ArrayObject());

        $this->reader->getFiles();
    }
}
