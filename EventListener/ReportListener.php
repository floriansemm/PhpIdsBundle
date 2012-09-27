<?php
namespace FS\PhpIdsBundle\EventListener;

use FS\PhpIdsBundle\ImpactHandler\DefaultImpactHandler;

use FS\PhpIdsBundle\ImpactHandler\ImpactHandlerInterface;

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
	
	public function addImpactListener(ImpactHandlerInterface $listener) {
		$this->impactListener[] = $listener;
	}
}

?>