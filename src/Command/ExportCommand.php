<?php declare(strict_types=1);

namespace Jnoack\JChannelPilotExporter\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AsCommand(
    name: 'j:channel_pilot:export',
    description: 'starts the channel pilot export',
), AutoconfigureTag('console.command')]
class ExportCommand extends Command
{
    public function __construct(?string $name = null)
    {
    }

    protected function configure(): void
    {
        $this->setDescription('Does something very special.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('It works!');

        // Exit code 0 for success
        return 0;
    }
}
