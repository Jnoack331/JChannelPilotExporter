<?php declare(strict_types=1);

namespace Jnoack\JChannelPilotExporter\Command;

use Jnoack\JChannelPilotExporter\Services\ExportService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\Service\Attribute\Required;

#[AsCommand(
    name: 'j:channel_pilot:export',
    description: 'starts the channel pilot export',
)]
class ExportCommand extends Command
{
    protected ExportService $exportService;

    #[Required]
    public function setExportService(
        ExportService $exportService,
    ) {
        $this->exportService = $exportService;
    }

    protected function configure(): void
    {
        $this->setDescription('Does something very special.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->exportService->export();
        // Exit code 0 for success
        return 0;
    }
}
