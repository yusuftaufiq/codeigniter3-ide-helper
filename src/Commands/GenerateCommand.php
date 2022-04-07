<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Commands;

use Haemanthus\CodeIgniter3IdeHelper\Services\ReaderService;
use Haemanthus\CodeIgniter3IdeHelper\Services\ParserService;
use Haemanthus\CodeIgniter3IdeHelper\Services\WriterService;

/**
 * Undocumented class
 */
class GenerateCommand
{
    /**
     * Undocumented variable
     *
     * @var string $expression
     */
    public static string $expression = 'generate [-d|--dir=] [-c|--controller=]* [-m|--model=]* [-o|--output=]';

    /**
     * Undocumented variable
     *
     * @var string $expression
     */
    public static string $description = 'Generate IDE Helper files';

    /**
     * Undocumented variable
     *
     * @var array<string, string> $options
     */
    public static array $options = [
        '--dir' => 'CodeIgniter 3 root directory',
        '--controller' => 'Pattern in string or regex to match controller files',
        '--model' => 'Pattern in string or regex to match model files',
        '--output' => 'Output filename'
    ];

    /**
     * Undocumented variable
     *
     * @var \Haemanthus\CodeIgniter3IdeHelper\Services\ReaderService $readerService
     */
    protected ReaderService $readerService;

    /**
     * Undocumented variable
     *
     * @var \Haemanthus\CodeIgniter3IdeHelper\Services\ParserService $parserService
     */
    protected ParserService $parserService;

    /**
     * Undocumented variable
     *
     * @var \Haemanthus\CodeIgniter3IdeHelper\Services\WriterService $writerService
     */
    protected WriterService $writerService;

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
        $dir = '/./',
        $controller = [],
        $model = [],
        $output = '/./ide-helper.php'
    ): void {
        $this->readerService->setDirectory($dir);

        $autoloadFile = $this->readerService->getAutoloadFile();
        $controllerFiles = $this->readerService->getControllerFiles($controller);
        $modelFiles = $this->readerService->getModelFiles($model);

        var_dump($autoloadFile->getFilename());
        var_dump($controllerFiles[0]->getContents());
        var_dump($modelFiles[0]->getContents());
    }
}
