<?php

namespace HeimrichHannot;

require_once TL_ROOT . '/system/modules/xcommon/classes/pdf/fpdi/fpdi.php'; // class name != file name => crash for autoload generator

class FpdiTemplate extends \FPDI
{
	protected $intIndex;
	
	public function Header()
	{
		if ($intIndex === null)
			$this->intIndex = $this->importPage(1);
		
		$this->useTemplate($this->intIndex);
	}
	
	public function Footer() {}
}