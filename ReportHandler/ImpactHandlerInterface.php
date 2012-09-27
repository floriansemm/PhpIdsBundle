<?php
namespace FS\PhpIdsBundle\ReportHandler;

interface ReportHandlerInterface {
	
	public function reponsibleFor($impact, $url);
	public function handle(\IDS_Report $report);
}

?>