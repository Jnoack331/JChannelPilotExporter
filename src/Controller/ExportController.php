<?php

namespace Jnoack\JChannelPilotExporter\Controller;

use Jnoack\JChannelPilotExporter\Core\Framework\Routing\ChannelPilotRouteScope;
use Shopware\Core\System\SystemConfig\SystemConfigService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\Routing\Attribute\Route;
use function Symfony\Component\String\s;

#[Route(defaults: ['_routeScope' => [ChannelPilotRouteScope::ID]])]
class ExportController extends AbstractController
{
    public function __construct(
      private readonly SystemConfigService $systemConfigService,
    ) {
    }

    #[Route(
        path: '/channel_pilot/export',
        name: 'channel_pilot.export',
        defaults: ['_httpCache' => false],
        methods: ['GET']
    )]
    public function load(): BinaryFileResponse
    {
        $reponse = $this->file(__DIR__ . '/test.txt');
        $reponse->setCache([
            'no_cache'         => true,
            'no_store'         => true,
        ]);

        return $reponse;
    }
}