<?php

/**
 *
 * @author Florian Semm
 */
class PhpIdsTest extends \PHPUnit_Framework_TestCase {
    private $monitor;
    
    public function setUp() {
        $this->monitor = new FS\PhpIdsBundle\PhpIds();
    }
    
    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage problems with the monitor-object occured, please call configureMonitor
     */
    public function testRunWithoutConfig() {
        $this->monitor->run();
    }
}

?>
