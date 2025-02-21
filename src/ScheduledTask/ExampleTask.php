<?php declare(strict_types=1);

namespace Jnoack\JChannelPilotExporter\ScheduledTask;

use Shopware\Core\Framework\MessageQueue\ScheduledTask\ScheduledTask;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag('shopware.scheduled.task')]
class ExampleTask extends ScheduledTask
{
    public static function getTaskName(): string
    {
        return 'j.channel_pilot.export';
    }

    public static function getDefaultInterval(): int
    {
        return 300; // 5 minutes
    }
}
