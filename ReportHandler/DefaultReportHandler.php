<?php
namespace FS\PhpIdsBundle\ReportHandler;

class DefaultReportHandler extends AbstractReportHandler {
	public function handle(\IDS_Report $report) {
		print_r($this->impact);
		print_r($report);
	}

}

?>