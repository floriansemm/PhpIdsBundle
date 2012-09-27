<?php
namespace FS\PhpIdsBundle\ReportHandler;

class DefaultReportHandler implements ReportHandlerInterface {

	public function reponsibleFor($impact, $url) {
		var_dump($impact);
		var_dump($url);
		
		return true;
	}
	public function handle(\IDS_Report $report) {
		var_dump($report);
	}

}

?>