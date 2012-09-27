<?php
namespace FS\PhpIdsBundle\ReportHandler;

interface ReportHandlerInterface {
	
	public function setImpact($impact);
	public function setRoutes(array $routes);
	
	public function reponsibleFor($impact, $url);
	public function handle(\IDS_Report $report);
}

?>