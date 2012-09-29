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
	 * @param int $lowest
	 * @param string $url
	 * @return AbstractReportHandler
	 */
    private function setupHandler($lowest, $heighest, $url) {
    	$handler = new AbstractReportHandlerImplementation();
    	$handler->setImpactRange($lowest, $heighest);
    	$handler->setUrls(array($url));    	
    	
    	return $handler;
    }
    
    public function testIsResponsibleFor_Match_LastUrlMatch() {
    	$lowest = '10';
    	 
    	$handler = $this->setupHandler($lowest, $lowest, '');
		$handler->setUrls(array('/*', '/users/*', '/admin/*'));
    	
    	$this->assertTrue($handler->reponsibleFor($lowest, '/admin/'));
    }    

    public function testIsResponsibleFor_Match_SecondMatch() {
    	$lowest = '10';
    
    	$handler = $this->setupHandler($lowest, $lowest, '');
    	$handler->setUrls(array('/*', '/users/', '/admin/*'));
    	 
    	$this->assertTrue($handler->reponsibleFor($lowest, '/users/'));
    }    
    
    public function testIsResponsibleFor_Match_ImpactEqualsLowest() {
    	$lowest = '10';
    	$url = '/url/*';
    	 
    	$handler = $this->setupHandler($lowest, $lowest, $url);
    	 
    	$this->assertTrue($handler->reponsibleFor($lowest, $url));
    }    

    public function testIsResponsibleFor_Match_ImpactEqualsHighest() {
    	$lowest = '10';
    	$highest = '20';
    	$url = '/url/*';
    
    	$handler = $this->setupHandler($lowest, $highest, $url);
    
    	$this->assertTrue($handler->reponsibleFor($highest, $url));
    }    

    public function testIsResponsibleFor_Match_ImpactInRange() {
    	$lowest = '10';
    	$highest = '20';
    	$url = '/url/*';
    
    	$handler = $this->setupHandler($lowest, $highest, $url);
    
    	$this->assertTrue($handler->reponsibleFor(15, $url));
    }    
    
    public function testIsResponsibleFor_ZeroImpact() {
    	$url = '/url/*';
    	$handler = $this->setupHandler(10, 20, $url);
    	 
    	$this->assertFalse($handler->reponsibleFor(0, $url));
    }

    public function testIsResponsibleFor_NoMatch_ImpactToHigh() {
    	$url = '/url/*';
    	 
    	$handler = $this->setupHandler(10, 20, $url);
    	 
    	$this->assertFalse($handler->reponsibleFor(25, $url));
    }
    
    public function testIsResponsibleFor_NoMatch_NoUrlsSet() {
    	$lowest = 10;
    	$handler = $this->setupHandler($lowest, $lowest, '');
		$handler->setUrls(array());
    	
    	$this->assertFalse($handler->reponsibleFor($lowest, '/some/url/'));
    }    
    
    public function testIsResponsibleFor_NoMatch_WrongUrl() {
    	$url = '/url/*';
    	$lowest = 10;
    	$handler = $this->setupHandler($lowest, $lowest, $url);
    
    	$this->assertFalse($handler->reponsibleFor($lowest, '/some/url/'));
    }    
}

?>
