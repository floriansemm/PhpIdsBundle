<?php
namespace FS\PhpIdsBundle\ReportHandler;

abstract class AbstractReportHandler implements ReportHandlerInterface {

	protected $impact = 0;
	protected $urls = array(); 
	
	/**
	 * (non-PHPdoc)
	 * @see \FS\PhpIdsBundle\ReportHandler\ReportHandlerInterface::setImpact()
	 */
	public function setImpact($impact) {
		$this->impact = $impact;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \FS\PhpIdsBundle\ReportHandler\ReportHandlerInterface::setUrls()
	 */
	public function setUrls(array $urls) {
		$this->urls = $urls;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \FS\PhpIdsBundle\ReportHandler\ReportHandlerInterface::reponsibleFor()
	 */
	public function reponsibleFor($impact, $url) {
		if (!($impact <= $this->impact) || $impact <= 0) {
			return false;
		}
		
		$match = false;
		foreach ($this->urls as $urlResponsibleFor) {
			if (preg_match('#^'.$urlResponsibleFor.'#', $url)) {
				$match = true;
			}
		}
		
		return $match;
	}
}

?>