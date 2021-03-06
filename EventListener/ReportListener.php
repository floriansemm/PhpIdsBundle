<?php
namespace FS\PhpIdsBundle\EventListener;

use Symfony\Component\Routing\Matcher\UrlMatcher;

use Symfony\Component\Routing\Router;

use Symfony\Component\Routing\Route;

use FS\PhpIdsBundle\ReportHandler\ReportHandlerInterface;
use FS\PhpIdsBundle\PhpIds;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class ReportListener {
	/**
	 * 
	 * @var PhpIds
	 */
	private $ids = null;
	
	/**
	 * 
	 * @var array
	 */
	private $impactListener = array();
	
	public function __construct(PhpIds $ids) {
		$this->ids = $ids;
	}
	
	public function onKernelRequest(GetResponseEvent $event) {
		$report = $this->ids->run();
		$impact = $report->getImpact();
		$url = $event->getRequest()->getRequestUri();	
		
		foreach ($this->impactListener as $listener) {
			if ($listener->reponsibleFor($impact, $url)) {
				$listener->handle($report);
			}
		}		
	}
	
	public function addReportListener(ReportHandlerInterface $listener) {
		$this->impactListener[] = $listener;
	}
}

?>