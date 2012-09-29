<?php
namespace FS\PhpIdsBundle\ReportHandler;

use Symfony\Component\HttpKernel\Log\LoggerInterface;

class DefaultReportHandler extends AbstractReportHandler {
	/**
	 * @var LoggerInterface
	 */
	private $logger = null;
	
	public function __construct(LoggerInterface $logger) {
		$this->logger = $logger;
	}
	
	public function handle(\IDS_Report $report) {
		$this->logger->info(sprintf('current request %s has impact of %s', $this->requestUrl, $report->getImpact()));
	}

}

?>