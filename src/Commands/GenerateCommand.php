<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Commands;

use Haemanthus\CodeIgniter3IdeHelper\Services\ReaderService;
use Haemanthus\CodeIgniter3IdeHelper\Services\ParserService;
use Haemanthus\CodeIgniter3IdeHelper\Services\WriterService;
use League\Pipeline\Pipeline;

class GenerateCommand
{
    /**
     * Undocumented variable
     *
     * @var string $expression
     */
    public static $expression = 'generate [--dir=] [--controllers=] [--models=] [--filename=]';

    /**
     * Undocumented variable
     *
     * @var string $expression
     */
    public static $description = 'Generate IDE Helper files';

    /**
     * Undocumented variable
     *
     * @var array<string, string> $options
     */
    public static $options = [
        '--dir' => 'CodeIgniter 3 root directory',
        '--controllers' => 'Only generates IDE helper for the selected controllers',
        '--models' => 'Only generates IDE helper for the selected models',
        '--filename' => 'Output filename'
    ];

    /**
     * Undocumented variable
     *
     * @var \Haemanthus\CodeIgniter3IdeHelper\Services\ReaderService $readerService
     */
    protected $readerService;

    /**
     * Undocumented variable
     *
     * @var \Haemanthus\CodeIgniter3IdeHelper\Services\PraserService $parserService
     */
    protected $parserService;

    /**
     * Undocumented variable
     *
     * @var \Haemanthus\CodeIgniter3IdeHelper\Services\WriterService $writerService
     */
    protected $writerService;

    /**
     * Undocumented function
     *
     * @param \Haemanthus\CodeIgniter3IdeHelper\Services\ReaderService $readerService
     * @param \Haemanthus\CodeIgniter3IdeHelper\Services\ParserService $parserService
     * @param \Haemanthus\CodeIgniter3IdeHelper\Services\WriterService $writerService
     */
    public function __construct(
        ReaderService $readerService,
        ParserService $parserService,
        WriterService $writerService
    ) {
        $this->readerService = $readerService;
        $this->parserService = $parserService;
        $this->writerService = $writerService;
    }

    protected function getParsedControllerClasses(array $controllers)
    {
        return (new Pipeline())
            ->pipe([$this->readerService, 'getControllerClasses'])
            ->pipe([$this->parserService, 'parseClasses'])
            ->process($controllers);
    }

    protected function getParsedModelClasses(array $models)
    {
        return (new Pipeline())
            ->pipe([$this->readerService, 'getModelClasses'])
            ->pipe([$this->parserService, 'parseClasses'])
            ->process($models);
    }

    protected function getParsedCoreClasses()
    {
        return (new Pipeline())
            ->pipe([$this->parserService, 'parseClasses'])
            ->process($this->readerService->getCoreClasses());
    }

    /**
     * Undocumented function
     *
     * @param bool $write
     * @param bool $writeMixin
     * @param string $dir
     * @param string $controllers
     * @param string $models
     *
     * @return void
     */
    public function __invoke(
        $dir = './',
        $controllers = '*',
        $models = '*',
        $filename = './ide-helper.php'
    ) {
        $this->readerService->setDirectory($dir);

        $parsedCoreClasses = $this->getParsedCoreClasses();
        $parsedControllerClasses = $this->getParsedControllerClasses($controllers);
        $parsedModelClasses = $this->getParsedModelClasses($models);

        $this->writerService
            ->write($parsedCoreClasses, $parsedControllerClasses, $parsedModelClasses)
            ->saveTo($filename);
    }
}
