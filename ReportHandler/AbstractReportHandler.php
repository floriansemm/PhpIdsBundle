<?php
namespace FS\PhpIdsBundle\ReportHandler;

abstract class AbstractReportHandler implements ReportHandlerInterface {

	protected $lowest = 0;
	protected $highest = 0;
	protected $urls = array(); 
	protected $requestUrl = '';
	
	/**
	 * (non-PHPdoc)
	 * @see \FS\PhpIdsBundle\ReportHandler\ReportHandlerInterface::setImpactRange()
	 */
	public function setImpactRange($lowest, $highest) {
		$this->lowest = $lowest;
		$this->highest = $highest;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \FS\PhpIdsBundle\ReportHandler\ReportHandlerInterface::setUrls()
	 */
	public function setUrls(array $urls) {
		$this->urls = $urls;
	}
	
	private function isImpactInRange($impact) {
		 return ($impact >= $this->lowest && $impact <= $this->highest);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \FS\PhpIdsBundle\ReportHandler\ReportHandlerInterface::reponsibleFor()
	 */
	public function reponsibleFor($impact, $url) {
		$this->requestUrl = $url;
		
		if (!$this->isImpactInRange($impact) || $impact <= 0) {
			return false;
		}
		
		$match = false;
		foreach ($this->urls as $urlResponsibleFor) {
			if (preg_match('#^'.$urlResponsibleFor.'#', $this->requestUrl)) {
				$match = true;
			}
		}
		
		return $match;
	}
}

?>