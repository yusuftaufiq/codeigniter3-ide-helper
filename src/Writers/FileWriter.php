<?php

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
    protected ?string $outputPath = null;

    protected PrettyPrinter\Standard $printer;

    protected Filesystem $fs;

    public function __construct(
        PrettyPrinter\Standard $printer,
        Filesystem $fs
    ) {
        $this->printer = $printer;
        $this->fs = $fs;
    }

    public function setOutputPath(string $outputPath): self
    {
        $this->outputPath = $outputPath;

        return $this;
    }

    protected function createClassNodeWithDocumentComment(ClassStructuralElement $classStructuralElement): Node
    {
        $documentComment = $this->createPropertiesDocumentComment($classStructuralElement->getProperties());
        $class = $classStructuralElement->getNode();

        $class->setDocComment(new Comment\Doc($documentComment));

        return $class;
    }

    protected function createPropertiesDocumentComment(array $properties): string
    {
        $tags = array_map(fn (PropertyStructuralElement $property): string => (
            " * @property {$property->getType()} \${$property->getName()}"
        ), $properties);

        return "/**\n" . implode("\n", $tags) . "\n */";
    }

    protected function getFullPath(): string
    {
        return getcwd() . '/' . $this->outputPath;
    }

    /**
     * Undocumented function
     *
     * @param array<ClassStructuralElement> $classStructuralElements
     *
     * @return self
     */
    public function write(array $classStructuralElements): self
    {
        $classNodes = array_map(fn (ClassStructuralElement $classStructuralElement): Node => (
            $this->createClassNodeWithDocumentComment($classStructuralElement)
        ), $classStructuralElements);

        $code = $this->printer->prettyPrintFile($classNodes);

        $this->fs->dumpFile($this->getFullPath(), $code);

        return $this;
    }
}
