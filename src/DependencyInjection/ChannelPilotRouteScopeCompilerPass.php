<?php

namespace Jnoack\JChannelPilotExporter\DependencyInjection;

use Jnoack\JChannelPilotExporter\Core\Framework\Routing\ChannelPilotRouteScope;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class ChannelPilotRouteScopeCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $scope = new Definition(ChannelPilotRouteScope::class);

        $scope->addTag('shopware.route_scope');
        $scope->setAutowired(true);
        $scope->setAutoconfigured(true);
        $scope->setPublic(true);

        $container->setDefinition(ChannelPilotRouteScope::class, $scope);
    }
}