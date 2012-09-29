<?php

namespace FS\PhpIdsBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Reference;

use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use FS\PhpIdsBundle\DependencyInjection\Configuration\Configuration;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Config\FileLocator;

/**
 *
 * @author Florian Semm
 */
class FSPhpIdsExtension extends Extension {
    public function load(array $configs, ContainerBuilder $container) {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');
        
        $processor     = new Processor();
        $configuration = new Configuration();

        $config = $processor->process($configuration->getConfigTreeBuilder(), $configs);       

        if (array_key_exists('handler', $config)) {
        	foreach ($config['handler'] as $handler) {
        		$reportHandlerserviceId = $handler['id'];
        		if ($container->hasDefinition($reportHandlerserviceId)) {
        			$reportHandlerservice = $container->getDefinition($reportHandlerserviceId);
        			
        			$lowest = $handler['impact_range']['lowest'];
        			$highest = $handler['impact_range']['highest'];
        			
        			$reportHandlerservice->addMethodCall('setImpactRange', array($lowest, $highest));
        			$reportHandlerservice->addMethodCall('setUrls', array($handler['urls']));
        			
        			$reportListener = $container->getDefinition('phpids.report_listener');
        			$reportListener->addMethodCall('addReportListener', array(new Reference($reportHandlerserviceId)));
        		}
        	}
        }
        
        $renamedConfig = $this->renameConfigKeys($config);
        $container->getDefinition('phpids')->addMethodCall('configureMonitor', array($renamedConfig));
    }

    private function renameConfigKeys(array $config) {
        $renamedConfig = array();
        $renamedConfig['General'] = $config['general'];
        
        if (true === array_key_exists('logging', $config)) {
            $renamedConfig['Logging'] = $config['logging'];
        }
        
        if (true === array_key_exists('caching', $config)) {
            $renamedConfig['Caching'] = $config['caching'];            
        }
        
        return $renamedConfig;
    }
    
    public function getAlias() {
        return 'fs_php_ids';
    } 
}

?>
