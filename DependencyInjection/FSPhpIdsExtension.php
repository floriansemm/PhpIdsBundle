<?php

namespace FS\PhpIdsBundle\DependencyInjection;

use FS\PhpIdsBundle\DependencyInjection\Configuration\Configuration;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Config\FileLocator;

/**
 *
 * @author Florian Semm
 */
class FSPhpIdsExtension extends Extension {
    public function load(array $configs, ContainerBuilder $container) {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
        
        $processor     = new Processor();
        $configuration = new Configuration();

        $config = $processor->process($configuration->getConfigTreeBuilder(), $configs);       

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
