<?php

namespace Tests\Readers\Unit;

use Haemanthus\CodeIgniter3IdeHelper\Readers\ClassFileReader;
use PHPUnit\Framework\TestCase;
use Tests\Fixture\WithFileReader;

class ClassFileReaderTest extends TestCase
{
    use WithFileReader;

    private ClassFileReader $reader;

    public function setUp(): void
    {
        $this->setUpFileReader();

        $this->reader = new ClassFileReader($this->finderFactory, $this->fs);
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_should_find_files_with_correct_pattern_and_directory(): void
    {
        $patterns = ['Controller', 'MY_'];

        $this->finder
            ->expects($this->exactly(2))
            ->method('path')
            ->withConsecutive(...array_map(fn (string $pattern): array => (
                [$this->equalTo($pattern)]
            ), $patterns));

        $this->finder->expects($this->once())->method('files')->willReturnSelf();
        $this->finder->expects($this->once())->method('in')->withAnyParameters()->willReturnSelf();
        $this->finder->expects($this->once())->method('name')->with('*.php');
        $this->finder->expects($this->once())->method('getIterator')->willReturn(new \ArrayObject());

        $this->reader->setPatterns($patterns);
        $this->reader->getFiles();
    }
}
