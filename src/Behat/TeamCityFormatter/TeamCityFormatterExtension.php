<?php
namespace Behat\TeamCityFormatter3;

use Behat\Testwork\ServiceContainer\Extension as ExtensionInterface;
use Behat\Testwork\ServiceContainer\ExtensionManager;
use Behat\Testwork\Output\ServiceContainer\OutputExtension;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class TeamCityFormatterExtension implements ExtensionInterface
{
    public function getConfigKey()
    {
        return 'teamcity';
    }

    public function initialize(ExtensionManager $extensionManager)
    {
    }

    public function configure(ArrayNodeDefinition $builder)
    {
    }

    public function load(ContainerBuilder $container, array $config)
    {
				$outputDefinition = new Reference('cli.output');
        $outputPrinterDefinition = new Definition('Behat\TeamCityFormatter3\ConsoleOutput', array($outputDefinition));

        $definition = new Definition('Behat\TeamCityFormatter3\TeamCityFormatter', array($outputPrinterDefinition) );
				$definition->addTag( OutputExtension::FORMATTER_TAG, array('priority' => 90 ) );
        $container->setDefinition( OutputExtension::FORMATTER_TAG.'.teamcity', $definition );
    }

    public function process(ContainerBuilder $container)
    {
    }
}

