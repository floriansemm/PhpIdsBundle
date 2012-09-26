<?php
namespace FS\PhpIdsBundle\ImpactHandler;

interface ImpactHandlerInterface {
	
	public function reponsibleFor($impact, $url);
	public function handle(\IDS_Report $report);
}

?>