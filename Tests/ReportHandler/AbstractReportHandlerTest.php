<?php

namespace FS\PhpIdsBundle\Tests\ReportHandler;

use FS\PhpIdsBundle\ReportHandler\AbstractReportHandler;
use FS\PhpIdsBundle\Tests\Resources\implementations\AbstractReportHandlerImplementation;

/**
 *
 * @author Florian Semm
 */
class AbstractReportHandlerTest extends \PHPUnit_Framework_TestCase {

	/**
	 * 
	 * @param int $impact
	 * @param string $url
	 * @return AbstractReportHandler
	 */
    private function setupHandler($impact, $url) {
    	$handler = new AbstractReportHandlerImplementation();
    	$handler->setImpact($impact);
    	$handler->setUrls(array($url));    	
    	
    	return $handler;
    }
    
    public function testIsResponsibleFor_Match() {
    	$impact = '10'; 
    	$url = '/url/*';
    	
		$handler = $this->setupHandler($impact, $url);
    	
    	$this->assertTrue($handler->reponsibleFor($impact, $url));
    }
    
    public function testIsResponsibleFor_Match_LastUrlMatch() {
    	$impact = '10';
    	 
    	$handler = $this->setupHandler($impact, '');
		$handler->setUrls(array('/*', '/users/*', '/admin/*'));
    	
    	$this->assertTrue($handler->reponsibleFor($impact, '/admin/'));
    }    

    public function testIsResponsibleFor_Match_SecondMatch() {
    	$impact = '10';
    
    	$handler = $this->setupHandler($impact, '');
    	$handler->setUrls(array('/*', '/users/', '/admin/*'));
    	 
    	$this->assertTrue($handler->reponsibleFor($impact, '/users/'));
    }    
    
    public function testIsResponsibleFor_ZeroImpact() {
    	$url = '/url/*';
    	$handler = $this->setupHandler(10, $url);
    	 
    	$this->assertFalse($handler->reponsibleFor(0, $url));
    }

    public function testIsResponsibleFor_NoMatch_WrongToHigh() {
    	$url = '/url/*';
    	 
    	$handler = $this->setupHandler(10, $url);
    	 
    	$this->assertFalse($handler->reponsibleFor(25, $url));
    }
    
    public function testIsResponsibleFor_NoMatch_NoUrlsSet() {
    	$impact = 10;
    	$handler = $this->setupHandler($impact, '');
		$handler->setUrls(array());
    	
    	$this->assertFalse($handler->reponsibleFor($impact, '/some/url/'));
    }    
    
    public function testIsResponsibleFor_NoMatch_WrongUrl() {
    	$url = '/url/*';
    	$impact = 10;
    	$handler = $this->setupHandler($impact, $url);
    
    	$this->assertFalse($handler->reponsibleFor($impact, '/some/url/'));
    }    
}

?>
