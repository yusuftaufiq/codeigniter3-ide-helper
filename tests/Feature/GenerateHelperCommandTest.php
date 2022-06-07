<?php

declare(strict_types=1);

namespace Tests\Feature;

use Haemanthus\CodeIgniter3IdeHelper\Commands\GenerateHelperCommand;
use PHPUnit\Framework\TestCase;
use Spatie\Snapshots\MatchesSnapshots;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Tester\TesterTrait;
use Symfony\Component\Filesystem\Filesystem;
use Tests\Fixtures\SpyOutput;
use Tests\Fixtures\WithContainer;
use Tests\Fixtures\WithSillyApplication;

class GenerateHelperCommandTest extends TestCase
{
    use MatchesSnapshots;
    use TesterTrait;
    use WithContainer;
    use WithSillyApplication;

    private SpyOutput $spyOutput;

    public function setUp(): void
    {
        $this->setUpContainer();
        $this->setUpSillyApplication();

        $this->spyOutput = $this->container->get(SpyOutput::class);
        $this->container->set(\Silly\Application::class, $this->silly);

        /** @var GenerateHelperCommand */
        $command = $this->container->get(GenerateHelperCommand::class);
        $command->execute();
    }

    public function tearDown(): void
    {
        (new Filesystem())->remove('./tmp/');
    }

    private function assertSuccessfulCommand(int $statusCode, string $outputFilePath): void
    {
        $this->assertSame(\Silly\Command\Command::SUCCESS, $statusCode);
        $this->assertStringContainsString(
            "Successfully generated IDE helper file to {$outputFilePath}",
            $this->spyOutput->getOutput(),
        );
        $this->assertMatchesFileSnapshot($outputFilePath);
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_should_generate_all_files(): void
    {
        $outputFilePath = './tmp/_ide_helper_it_should_generate_all_files.php';

        $statusCode = $this->silly->run(
            new StringInput("generate --dir ./tests/stubs/test_files/ --output-path ${outputFilePath}"),
            $this->spyOutput,
        );

        $this->assertSuccessfulCommand($statusCode, $outputFilePath);
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_should_only_generate_filtered_files(): void
    {
        $outputFilePath = './tmp/_ide_helper_it_should_only_generate_filtered_files.php';

        $statusCode = $this->silly->run(
            new StringInput(<<<EOT
            generate
                --dir ./tests/stubs/test_files/
                --output-path ${outputFilePath}
                --pattern AuthController
                --pattern User
            EOT),
            $this->spyOutput,
        );

        $this->assertSuccessfulCommand($statusCode, $outputFilePath);
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_should_ask_for_codeigniter_3_directory_if_not_found(): void
    {
        $outputFilePath = './tmp/_ide_helper_it_should_ask_for_codeigniter_3_directory_if_not_found.php';

        $input = new StringInput("generate --output-path ${outputFilePath}");
        $input->setStream($this->createStream([
            './tests/stubs/test_files/',
        ]));

        $statusCode = $this->silly->run($input, $this->spyOutput);

        $this->assertStringContainsString("CodeIgniter 3 directory can't be found.", $this->spyOutput->getOutput());
        $this->assertStringContainsString(
            "Please type the correct CodeIgniter 3 directory",
            $this->spyOutput->getOutput(),
        );
        $this->assertSuccessfulCommand($statusCode, $outputFilePath);
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_should_give_an_error_message_if_finally_the_codeigniter_3_directory_is_not_found(): void
    {
        $statusCode = $this->silly->run(new StringInput('generate --no-interaction'), $this->spyOutput);

        $this->assertSame(\Silly\Command\Command::FAILURE, $statusCode);
        $this->assertStringContainsString(
            "Unfortunately, we still can't find your CodeIgniter 3 directory.",
            $this->spyOutput->getOutput(),
        );
    }
}
