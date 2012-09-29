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
	 * @var AbstractReportHandler
	 */
	private $impl = null;
	
    public function setUp() {
    	$this->impl = new AbstractReportHandlerImplementation();
    }
    
    public function testIsResponsibleFor() {
    	$impact = 10;
    	$url = '/url/*';
    	
    	$this->impl->setImpact($impact);
    	$this->impl->setUrls(array($url));
    	
    	$this->assertTrue($this->impl->reponsibleFor($impact, $url));
    }
}

?>
