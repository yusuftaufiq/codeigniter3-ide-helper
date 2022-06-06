<?php

declare(strict_types=1);

namespace Haemanthus\CodeIgniter3IdeHelper\Facades;

use Haemanthus\CodeIgniter3IdeHelper\Elements\ClassStructuralElement;
use Haemanthus\CodeIgniter3IdeHelper\Enums\FileType;
use Haemanthus\CodeIgniter3IdeHelper\Factories\FileParserFactory;
use Symfony\Component\Finder\SplFileInfo;

class ParserFacade
{
    protected FileParserFactory $fileParser;

    public function __construct(FileParserFactory $fileParser)
    {
        $this->fileParser = $fileParser;
    }

    /**
     * Undocumented function
     *
     * @return array<ClassStructuralElement>
     */
    public function parseAutoloadFile(SplFileInfo $file): array
    {
        return $this->fileParser
            ->create(FileType::autoload())
            ->parse($file->getContents());
    }

    /**
     * Undocumented function
     *
     * @param array<SplFileInfo> $files
     *
     * @return array<ClassStructuralElement>
     */
    public function parseClassFiles(array $files): array
    {
        return array_reduce($files, function (array $carry, SplFileInfo $file): array {
            $classStructuralElements = $this->fileParser
                ->create(FileType::core())
                ->parse($file->getContents());

            $filteredClassStructuralElements = array_filter(
                $classStructuralElements,
                static fn (ClassStructuralElement $class): bool => count($class->getProperties()) > 0
            );

            return array_merge($carry, $filteredClassStructuralElements);
        }, []);
    }
}
