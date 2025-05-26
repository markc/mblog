<?php

use Tests\TestCase;

class PintCommandTest extends TestCase
{
    public function test_pint_command_exists_and_runs_successfully()
    {
        $this->artisan('pint')
            ->assertExitCode(0);
    }

    public function test_pint_command_has_correct_signature()
    {
        $command = $this->app->make(\App\Console\Commands\PintCommand::class);

        expect($command->getName())->toBe('pint');
        expect($command->getDescription())->toContain('Pint');
    }

    public function test_pint_command_can_be_called_via_artisan()
    {
        $output = $this->artisan('pint');

        $output->assertExitCode(0);
    }
}
