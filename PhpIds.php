<?php

namespace FS\PhpIdsBundle;

use FS\PhpIdsBundle\Monitor\IdsMonitor;
use Symfony\Component\HttpFoundation\Request;

/**
 *
 * @author Florian Semm
 */
class PhpIds {
    /**
     *
     * @var array 
     */
    private $configs = array();
    
    /**
     *
     * @var IdsMonitor 
     */
    private $monitor = null;
    
    /**
     *
     * @var Request
     */
    private $request;
    
    const REQUEST_POST = 'POST';
    const REQUEST_GET = 'GET';
    const REQUEST_COOKIE = 'COOKIE';
    const REQUEST_ALL = 'REQUEST';
    
    /**
     *
     * @param Request $request 
     */
    public function __construct(Request $request) {
        $this->request = $request;
    }
    
    /**
     *
     * @param array $configs 
     */
    public function configureMonitor(array $configs) {
        $this->configs = $configs;

        $init = \IDS_Init::init();
        $init->setConfig($this->configs);
        
        $this->monitor = new IdsMonitor($this->addInputs($this->configs), $init);
    }
       
    /**
     *
     * add input by name: post, get, request, cookie
     * 
     * @param string $input 
     * @throws RuntimeException
     */
    public function addRequest($input) {
        if (!isset($this->configs['General'])) {
            throw new \RuntimeException('The Monitor is not configured!');
        }
        
        $this->configs['General']['inputs'][] = $input;
        
        $this->configureMonitor($this->configs);
    }
    
    private function addInputs(array $configs) {       
        $configuredInputs = $configs['General']['inputs'];
        foreach ($configuredInputs as $index => $input) {
            $configuredInputs[$index] = strtoupper($input);
        }
        
        $concreteInputs = array();
        if (in_array(self::REQUEST_POST, $configuredInputs)) {
            $concreteInputs[self::REQUEST_POST] = $this->request->request->all();
        }
        
        if (in_array(self::REQUEST_GET, $configuredInputs)) {
            $concreteInputs[self::REQUEST_GET] = $this->request->query->all();
        }
        
        if (in_array(self::REQUEST_COOKIE, $configuredInputs)) {
            $concreteInputs[self::REQUEST_COOKIE] = $this->request->cookies->all();
        }
        
        if (in_array(self::REQUEST_ALL, $configuredInputs)) {
            $concreteInputs[self::REQUEST_ALL] = $this->request->request->all();
        }
        
        return $concreteInputs;
    }
    
    /**
     * @return \IDS_Report
     */
    public function run() {
        if (count($this->configs) == 0 || $this->monitor === null) {
            throw new \RuntimeException('problems with the monitor-object occured, the monitor is not configured correct');
        }
        
        return $this->monitor->run();
    }
    
}

?>
