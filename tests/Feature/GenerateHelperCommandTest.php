<?php

namespace Tests;

use Haemanthus\CodeIgniter3IdeHelper\Commands\GenerateHelperCommand;
use Haemanthus\CodeIgniter3IdeHelper\Facades\GenerateHelperFacade;
use PHPUnit\Framework\TestCase;
use Spatie\Snapshots\MatchesSnapshots;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Tester\TesterTrait;
use Tests\Fixture\SpyOutput;
use Tests\Fixture\WithContainer;
use Tests\Fixture\WithSillyApplication;

class GenerateHelperCommandTest extends TestCase
{
    use MatchesSnapshots;
    use TesterTrait;
    use WithContainer;
    use WithSillyApplication;

    private GenerateHelperCommand $command;

    private SpyOutput $spyOutput;

    public function setUp(): void
    {
        $this->setUpContainer();
        $this->setUpSillyApplication();

        $this->spyOutput = $this->container->get(SpyOutput::class);
        $this->container->set(OutputInterface::class, $this->spyOutput);

        $this->command = new GenerateHelperCommand($this->silly, $this->container->get(GenerateHelperFacade::class));
        $this->command->execute();
    }

    /**
     * @test
     *
     * @return string
     */
    public function it_should_have_a_successful_output_message(): string
    {
        $outputFilePath = './tmp/_ide_helper_it_should_have_a_successful_output_message.php';

        $result = $this->silly->run(
            new StringInput("generate --dir ./tests/stubs/test_files/ --output-path ${outputFilePath}"),
            $this->spyOutput,
        );

        $this->assertSame(\Silly\Command\Command::SUCCESS, $result);
        $this->assertStringContainsString("Successfully generated IDE helper file to ${outputFilePath}", $this->spyOutput->getOutput());

        return $outputFilePath;
    }

    /**
     * @test
     *
     * @return string
     */
    public function it_should_ask_for_codeigniter_3_directory_if_not_found(): string
    {
        $outputFilePath = './tmp/_ide_helper_it_should_ask_for_codeigniter_3_directory_if_not_found.php';

        $input = new StringInput("generate --output-path ${outputFilePath}");
        $input->setStream($this->createStream([
            './tests/stubs/test_files/',
        ]));

        $result = $this->silly->run($input, $this->spyOutput);

        $this->assertSame(\Silly\Command\Command::SUCCESS, $result);
        $this->assertStringContainsString("CodeIgniter 3 directory can't be found.", $this->spyOutput->getOutput());
        $this->assertStringContainsString("Please type the correct CodeIgniter 3 directory", $this->spyOutput->getOutput());

        return $outputFilePath;
    }

    /**
     * @test
     * @depends it_should_have_a_successful_output_message
     * @depends it_should_ask_for_codeigniter_3_directory_if_not_found
     *
     * @return void
     */
    public function it_should_have_the_same_output_file_as_the_snapshot_file(string ...$outputFilePaths): void
    {
        array_walk($outputFilePaths, function (string $outputFilePath): void {
            $this->assertMatchesFileSnapshot($outputFilePath);
        });
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_should_give_an_error_message_if_finally_the_codeigniter_3_directory_is_not_found(): void
    {
        $result = $this->silly->run(new StringInput('generate --no-interaction'), $this->spyOutput);

        $this->assertSame(\Silly\Command\Command::FAILURE, $result);
        $this->assertStringContainsString("Unfortunately, we still can't find your CodeIgniter 3 directory.", $this->spyOutput->getOutput());
    }
}
