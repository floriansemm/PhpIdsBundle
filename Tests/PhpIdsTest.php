<?php

namespace FS\PhpIdsBundle\Tests;

use FS\PhpIdsBundle\PhpIds;

/**
 *
 * @author Florian Semm
 */
class PhpIdsTest extends \PHPUnit_Framework_TestCase {
    private $monitor;
    
    public function setUp() {
        $this->monitor = new PhpIds(new \Symfony\Component\HttpFoundation\Request());
    }
    
    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage problems with the monitor-object occured, the monitor is not configured correct
     */
    public function testRunWithoutConfig() {
        $this->monitor->run();
    }
    
    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage The Monitor is not configured!
     */
    public function testAddInputWithoutConfig() {
        $this->monitor->addRequest('someinput');
    }    
}

?>
