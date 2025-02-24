<?php

namespace Jnoack\JChannelPilotExporter\Core\Framework\Routing;

use Shopware\Core\Framework\Routing\AbstractRouteScope;
use Symfony\Component\HttpFoundation\Request;

class ChannelPilotRouteScope extends AbstractRouteScope
{
    final public const ID = 'channel_pilot';

    protected $allowedPaths = [self::ID];

    public function isAllowed(Request $request): bool
    {
        return true;
    }

    public function getId(): string
    {
        return static::ID;
    }
}