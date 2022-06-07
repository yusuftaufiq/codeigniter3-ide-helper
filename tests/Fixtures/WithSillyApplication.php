<?php

declare(strict_types=1);

namespace Tests\Fixtures;

trait WithSillyApplication
{
    private \Silly\Application $silly;

    private function setUpSillyApplication(): void
    {
        $this->silly = new \Silly\Application();
        $this->silly->setAutoExit(false);
        $this->silly->setCatchExceptions(false);
    }
}
