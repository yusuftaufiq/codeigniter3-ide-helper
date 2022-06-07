<?php

declare(strict_types=1);

namespace Haemanthus\CodeIgniter3IdeHelper\Writers;

use Haemanthus\CodeIgniter3IdeHelper\Contracts\FileWriter as FileWriterContract;
use Haemanthus\CodeIgniter3IdeHelper\Elements\ClassStructuralElement;
use Haemanthus\CodeIgniter3IdeHelper\Elements\PropertyStructuralElement;
use PhpParser\Comment;
use PhpParser\Node;
use PhpParser\PrettyPrinter;
use Symfony\Component\Filesystem\Filesystem;

class FileWriter implements FileWriterContract
{
    protected string $outputPath = '_ide_helper.php';

    protected PrettyPrinter\Standard $printer;

    protected Filesystem $fs;

    public function __construct(
        PrettyPrinter\Standard $printer,
        Filesystem $fs
    ) {
        $this->printer = $printer;
        $this->fs = $fs;
    }

    public function getOutputPath(): string
    {
        return $this->outputPath;
    }

    public function setOutputPath(string $outputPath): self
    {
        $this->outputPath = $outputPath;

        return $this;
    }

    /**
     * Undocumented function
     *
     * @param array<ClassStructuralElement> $classStructuralElements
     */
    public function write(array $classStructuralElements): self
    {
        usort($classStructuralElements, function (ClassStructuralElement $a, ClassStructuralElement $b) {
            return $a->getNode()->name->name <=> $b->getNode()->name->name;
        });

        $classNodes = array_map(fn (ClassStructuralElement $classStructuralElement): Node => (
            $this->createClassNodeWithDocumentComment($classStructuralElement)
        ), $classStructuralElements);

        $code = $this->printer->prettyPrintFile($classNodes);

        $this->fs->dumpFile($this->getFullPath(), $code);

        return $this;
    }

    protected function createClassNodeWithDocumentComment(ClassStructuralElement $classStructuralElement): Node
    {
        $documentComment = $this->createPropertiesDocumentComment($classStructuralElement->getProperties());
        $class = $classStructuralElement->getNode();

        $class->setDocComment(new Comment\Doc($documentComment));

        return $class;
    }

    /**
     * Undocumented function
     *
     * @param array<PropertyStructuralElement> $properties
     */
    protected function createPropertiesDocumentComment(array $properties): string
    {
        $tags = array_map(static fn (PropertyStructuralElement $property): string => (
            " * @property {$property->getType()} \${$property->getName()}"
        ), $properties);

        return "/**\n" . implode("\n", $tags) . "\n */";
    }

    protected function getFullPath(): string
    {
        return getcwd() . '/' . $this->outputPath;
    }
}
