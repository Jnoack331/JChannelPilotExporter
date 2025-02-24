<?php declare(strict_types=1);

namespace Jnoack\JChannelPilotExporter;

use Jnoack\JChannelPilotExporter\DependencyInjection\ChannelPilotRouteScopeCompilerPass;
use Shopware\Core\Framework\Plugin;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Loader\DelegatingLoader;
use Symfony\Component\Config\Loader\LoaderResolver;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\DirectoryLoader;
use Symfony\Component\DependencyInjection\Loader\GlobFileLoader;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class JChannelPilotExporter extends Plugin
{
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $locator = new FileLocator('Resources/config');
        $resolver = new LoaderResolver([
            new XmlFileLoader($container, $locator),
            new GlobFileLoader($container, $locator),
            new DirectoryLoader($container, $locator),
        ]);

        $configLoader = new DelegatingLoader($resolver);
        $confDir = \rtrim($this->getPath(), '/') . '/Resources/config';

        if ($container->getParameter('kernel.environment') === 'dev') {
            $configLoader->load($confDir . '/dev/*.xml', 'glob');
        }

        $container->addCompilerPass(new ChannelPilotRouteScopeCompilerPass(), PassConfig::TYPE_BEFORE_OPTIMIZATION, 100);
    }
}
