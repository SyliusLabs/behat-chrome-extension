<?php

namespace DMore\ChromeExtension\Behat\ServiceContainer;

use Behat\MinkExtension\ServiceContainer\MinkExtension;
use Behat\Testwork\ServiceContainer\Extension as ExtensionInterface;
use Behat\Testwork\ServiceContainer\ExtensionManager;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ChromeExtension implements ExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigKey(): string
    {
        return 'chrome';
    }

    /**
     * {@inheritdoc}
     */
    public function initialize(ExtensionManager $extensionManager): void
    {
        if (null !== $minkExtension = $extensionManager->getExtension('mink')) {
            /* @var $minkExtension MinkExtension */
            $minkExtension->registerDriverFactory(new Driver\ChromeFactory());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configure(ArrayNodeDefinition $builder): void
    {
    }

    /**
     * {@inheritdoc}
     */
    public function load(ContainerBuilder $container, array $config): void
    {
    }

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container): void
    {
    }
}
