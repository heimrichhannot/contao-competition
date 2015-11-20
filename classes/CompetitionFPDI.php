<?php

namespace HeimrichHannot\Competition;

class CompetitionFPDI extends \FPDI
{
	protected $intTemplateId;
	protected $strTemplate;

	public function Header()
	{
		$this->setSourceFile($this->strTemplate);
		$this->intTemplateId = $this->importPage(1);
		$this->useTemplate($this->intTemplateId, null, null, 0, 0, true);
	}

	public function setHeaderTemplate($strTemplate)
	{
		$this->strTemplate = $strTemplate;
	}

}