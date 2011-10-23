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
    
    public function __construct(Request $request) {
        $this->request = $request;
    }
    
    public function configureMonitor(array $configs) {
        $this->configs = $configs;

        $init = \IDS_Init::init();
        $init->setConfig($this->configs);
        
        $this->monitor = new IdsMonitor($this->addInputs($this->configs), $init);
    }
    
    private function addInputs(array $configs) {
//        if (array_key_exists('General', $configs) || array_key_exists('inputs', $configs['General'])) {
//            throw new \RuntimeException('you need to setup the inputs');
//        }
        
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
     * @see \IDS_Monitor::run()
     */
    public function run() {
        if (count($this->configs) == 0 || $this->monitor === null) {
            throw new \RuntimeException('problems with the monitor-object occured, please call configureMonitor');
        }
        
        return $this->monitor->run();
    }
    
}

?>
