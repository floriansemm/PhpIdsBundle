<?php

namespace FS\PhpIdsBundle\DependencyInjection\Configuration;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Configuration for Log4Php
 *
 * @author Florian Semm
 */
class Configuration implements ConfigurationInterface {
    
    /**
     *
     * @return NodeInterface 
     */
    public function getConfigTreeBuilder() {
        $treeBuilder = new TreeBuilder();
        
        $rootNode = $treeBuilder->root('fs_php_ids', 'array');
        $rootNode
            ->children()
                ->arrayNode('general')                        
                    ->beforeNormalization()
                        ->ifTrue(function($v){
                            return array_key_exists('use_default_filter', $v) == true && (bool)$v['use_default_filter'] == true;
                        })
                        ->then(function($v){
                            unset($v['filter_path']);

                            return $v;
                        })
                    ->end()    
                    ->children()
                        ->arrayNode('inputs')
                            ->requiresAtLeastOneElement()
                            ->prototype('scalar')->end()
                        ->end()
                        ->scalarNode('filter_type')->end()
                        ->booleanNode('use_base_path')->end()
                        ->booleanNode('use_default_filter')->end()
                        ->scalarNode('filter_path')->defaultValue('default_filter.xml')->end()
                        ->scalarNode('base_path')->defaultValue('%kernel.root_dir%/../vendor/phpids/lib/IDS/')->end()
                        ->scalarNode('tmp_path')->end()
                        ->booleanNode('scan_keys')->end()
                        ->arrayNode('html')->prototype('scalar')->end()->end()
                        ->arrayNode('json')->prototype('scalar')->end()->end()
                        ->arrayNode('exceptions')->defaultNull()->prototype('scalar')->end()->end()
                        ->scalarNode('min_php_version')->end()    
                    ->end()
                ->end()
                ->arrayNode('logging')
                    ->addDefaultsIfNotSet()    
                    ->children()
                        ->scalarNode('path')->defaultValue('%kernel.root_dir%/logs/phpids.log')->end()
                        ->arrayNode('recipients')
                            ->requiresAtLeastOneElement()
                            ->prototype('scalar')->end()
                        ->end()
                        ->scalarNode('subject')->defaultValue('PHPIDS detected an intrusion attempt!')->end()
                        ->scalarNode('header')->defaultValue('From: <PHPIDS> info@phpids.org')->end()
                        ->scalarNode('envelope')->defaultNull()->end()
                        ->booleanNode('safemode')->defaultValue(true)->end()
                        ->booleanNode('urlencode')->defaultValue(true)->end()
                        ->scalarNode('allowed_rate')->defaultValue(15)->end()
                        ->scalarNode('wrapper')->defaultValue('mysql:host=localhost;port=3306;dbname=phpids')->end()    
                        ->scalarNode('user')->defaultValue('root')->end()
                        ->scalarNode('password')->defaultValue('')->end()
                        ->scalarNode('table')->defaultValue('intrusions')->end()
                    ->end()
                ->end()
                ->arrayNode('caching')                      
                    ->children()
                        ->scalarNode('method')->isRequired()->end()
                        ->scalarNode('expiration_time')->defaultValue('600')->end()
                        ->scalarNode('path')->cannotBeEmpty()->end()
                        ->scalarNode('wrapper')->cannotBeEmpty()->end()
                        ->scalarNode('user')->cannotBeEmpty()->end()
                        ->scalarNode('password')->cannotBeEmpty()->end()
                        ->scalarNode('table')->cannotBeEmpty()->end()
                        ->scalarNode('host')->cannotBeEmpty()->end()
                        ->scalarNode('port')->cannotBeEmpty()->end()
                        ->scalarNode('key_prefix')->cannotBeEmpty()->end()
                    ->end()
                ->end()
            ->end();
        
        
        return $treeBuilder->buildTree();
    }
}

?>
