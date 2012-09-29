<?php
namespace FS\PhpIdsBundle\ReportHandler;

interface ReportHandlerInterface {
	
	/**
	 * @param int $impact
	 */
	public function setImpact($impact);
	
	/**
	 * @param array $urls
	 */
	public function setUrls(array $urls);

	/**
	 * @param int $impact
	 * @param string $url
	 * @return bool
	 */
	public function reponsibleFor($impact, $url);
	
	/**
	 * @param \IDS_Report $report
	 */
	public function handle(\IDS_Report $report);
}

?>