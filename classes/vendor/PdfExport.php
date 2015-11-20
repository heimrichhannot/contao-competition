<?php

namespace HeimrichHannot;

class PdfExport
{
	protected $strTemplate;
	protected $objPdf;
	protected $strPdfMaster;
	protected $arrCss = array();
	protected $arrData = array();
	protected $blnGenerated = false;
	protected $strClass;
	
	public function __construct($strTemplate, $strClass, $strPdfMaster = null, $strOrientation = PDF_PAGE_ORIENTATION)
	{
		$this->strTemplate = $strTemplate;
		$this->strPdfMaster = $strPdfMaster;
		$this->strOrientation = $strOrientation;
		$this->strClass = $strClass;
		
		$this->initialize();
	}
	
	protected function initialize()
	{
		require_once(TL_ROOT . '/system/modules/xcommon/classes/pdf/tcpdf/tcpdf.php');
		require_once(TL_ROOT . '/system/config/tcpdf.php');

		// FPDI offers PDF master support
		if ($this->strClass)
			$this->objPdf = new $this->strClass($this->strOrientation, PDF_UNIT, PDF_PAGE_FORMAT, true);
		elseif ($this->strPdfMaster)
			$this->objPdf = new FpdiTemplate($this->strOrientation, PDF_UNIT, PDF_PAGE_FORMAT, true);
		else
			$this->objPdf = new \FPDI($this->strOrientation, PDF_UNIT, PDF_PAGE_FORMAT, true);
		
		if ($this->strPdfMaster)
			$this->numPages = $this->objPdf->setSourceFile($this->strPdfMaster);
		
		// Set document information
		$this->objPdf->SetCreator(PDF_CREATOR);
		$this->objPdf->SetAuthor(PDF_AUTHOR);
		$this->objPdf->SetTitle(PDF_AUTHOR);
		$this->objPdf->SetSubject(PDF_AUTHOR);
		$this->objPdf->setFontSubsetting(false);
		//$this->objPdf->setPrintHeader(false);
		//$this->objPdf->setPrintFooter(false);
		$this->objPdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		//$this->objPdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$this->objPdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);
		$this->objPdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		
		// set language information
		$arrLanguage['a_meta_dir'] = 'ltr';
		$arrLanguage['a_meta_charset'] = $GLOBALS['TL_CONFIG']['characterSet'];
		$arrLanguage['a_meta_language'] = $GLOBALS['TL_LANGUAGE'];
		$arrLanguage['w_page'] = 'page';
		$this->objPdf->setLanguageArray($arrLanguage);
	}
	
	public function generate()
	{
		// add the first page
		$this->objPdf->AddPage();
		
		$strHtml = '';
		
		// add css
		if (!empty($this->arrCss))
		{
			$strHtml .= '<style>';
			foreach ($this->arrCss as $strCss)
			{
				if (file_exists($strCss))
					$strHtml .= file_get_contents($strCss);
			}
			$strHtml .= '</style>';
		}
		
		$objTemplate = new \FrontendTemplate($this->strTemplate);
		$objTemplate->setData($this->arrData);
		
		$strHtml .= $objTemplate->parse();
	
		$this->objPdf->writeHTML($strHtml, true, 0, true, 1);
		
		$this->blnGenerated = true;
	}
	
	public function setMargins($intLeft, $intTop, $intRight, $intBottom)
	{
		$this->objPdf->SetMargins($intLeft, $intTop, $intRight);
		$this->objPdf->SetAutoPageBreak(true, $intBottom);
	}
	
	public function setData($arrData)
	{
		$this->arrData = $arrData;
	}
	
	public function addFont($strFilename)
	{
		if (file_exists($strFilename))
			$this->objPdf->addTTFfont($strFilename);
		else
			return false;
	}
	
	public function addCss($strFilename)
	{
		if (file_exists($strFilename))
			$this->arrCss[] = $strFilename;
		else
			return false;
	}
	
	public function saveFile($strFilename)
	{
		if (!$this->blnGenerated)
			$this->generate();
		
		if (!file_exists(dirname($strFilename)))
			mkdir(dirname($strFilename), 0755);
		
		// close output
		$this->objPdf->lastPage();
		
		// save to file
		$objFile = new \File($strFilename);
		return $objFile->write($this->objPdf->getPDFData());
	}
	
	public function sendFileToBrowser($strFilename)
	{
		if (!$this->blnGenerated)
			$this->generate();
		
		$this->objPdf->Output(strpos($strFilename, '.pdf') !== false ? $strFilename : $strFilename . '.pdf', 'D');
	}
	
	public function sendInlineToBrowser($strFilename)
	{
		if (!$this->blnGenerated)
			$this->generate();
		
		$this->objPdf->Output(strpos($strFilename, '.pdf') !== false ? $strFilename : $strFilename . '.pdf', 'I');
	}
	
}