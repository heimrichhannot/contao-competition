<?php

namespace HeimrichHannot\Competition;

use Contao\MemberModel;
use HeimrichHannot\Haste\Util\Format;
use HeimrichHannot\HastePlus\Files;

class CompetitionExportPdf extends \Frontend
{
	protected $strDefaultTemplate = 'pdf_competition_export';
	protected $strDefaultCoverTemplate = 'pdf_competition_export_cover';
	protected $arrExportFields = array();
	protected $arrSkipLabels = array();
	protected $arrOutput = array();
	protected $strArchiveTable;
	protected $strTable;
	protected $objDc;
	protected $pdf;

	public $uuidApplicantFile;
	public $uuidJudgesFile;

	public function __construct($objDc, $strArchiveTable, $strTable)
	{
		$this->strArchiveTable = $strArchiveTable;
		$this->strTable = $strTable;
		\System::loadLanguageFile($this->strArchiveTable);

		$this->objDc = $objDc;

		$strClassName = \Model::getClassFromTable($this->strArchiveTable);
		$objArchive = $strClassName::findByPk($objDc->activeRecord->pid);
		$objMember = MemberModel::findByPk($this->objDc->activeRecord->mid ?: $this->objDc->activeRecord->jid);

		$arrSettings = $this->getArchiveSettings($objArchive);

		// generate applicant pdf
		if ($objArchive->pdfExportFields && $strFileName = $this->buildFilename($objDc->activeRecord->id, $objMember, $objArchive))
		{
			$strExportFields = $objArchive->pdfExportFields;
			$strSkipLabels = $objArchive->pdfSkipLabels;
			$this->uuidApplicantFile = $this->generatePdf($strFileName, $arrSettings, $strExportFields, $strSkipLabels);
		}

		// generate judges pdf
		if($objArchive->pdfExportFieldsForJudges && $strFileName = $this->buildFilename($objDc->activeRecord->id, $objMember, $objArchive, COMPETITION_FILENAME_SUFFIX))
		{
			$strExportFieldsForJudge = $objArchive->pdfExportFieldsForJudges;
			$strSkipLabelsForJudge = $objArchive->pdfSkipLabelsForJudges;
			$this->uuidJudgesFile = $this->generatePdf($strFileName, $arrSettings, $strExportFieldsForJudge, $strSkipLabelsForJudge, true);
		}
	}


	protected function buildFilename($intId, $objMember, $objArchive, $strSuffix='')
	{
		if ($objArchive->filesDir && $objFolder = \FilesModel::findByUuid($objArchive->filesDir))
		{
			$strDir = $objFolder->path;

			if ($objArchive->filesUseHomeDir && $objMember->homeDir)
				$strDir = Files::getPathFromUuid($objMember->homeDir);

			if ($objArchive->filesUseProtectedHomeDir && $objMember->protectedHomeDir)
				$strDir = Files::getPathFromUuid($objMember->protectedHomeDir);

			if ($objArchive->filesDirName)
				$strDir .= '/' . $objArchive->filesDirName;

			if ($strDir)
				return $strDir . '/' . Files::sanitizeFileName($objArchive->pdfExportFileNamePrefix . $objMember->id . '_' . $intId . $strSuffix) . '.pdf';
		}

		return false;
	}


	protected function getArchiveSettings($objArchive)
	{
		$arrSettings = array();

		// Cover
		$arrSettings['addPdfCover'] = $objArchive->addPdfCover;
		$arrSettings['pdfCoverBackground'] = (isset($objArchive->pdfCoverBackground)) ? $objArchive->pdfCoverBackground : null;
		$arrSettings['pdfCoverTemplate'] = (isset($objArchive->pdfCoverTemplate)) ? $objArchive->pdfCoverTemplate : $this->strDefaultCoverTemplate;
		// Body
		$arrSettings['pdfBackground'] = (isset($objArchive->pdfBackground)) ? $objArchive->pdfBackground : null;
		$arrSettings['pdfTemplate'] = (isset($objArchive->pdfTemplate)) ? $objArchive->pdfTemplate : $this->strDefaultTemplate;
		$arrSettings['pdfFonts'] = deserialize($arrSettings['pdfFonts'], true);
		// General
		$arrSettings['margins'] = deserialize($objArchive->pdfMargins, true);
		$arrSettings['fileTitle'] = $objArchive->pdfExportFileTitle;
		$arrSettings['fileSubject'] = $objArchive->pdfExportFileSubject;
		$arrSettings['fileCreator'] = $objArchive->pdfExportFileCreator;

		return $arrSettings;
	}


	protected function generatePdf($strFileName, $arrSettings, $strExportFields, $strSkipLabels, $blnForJudges = false)
	{
		$objFile = new \File($strFileName);

		$this->arrExportFields = deserialize($strExportFields, true);
		$this->arrSkipLabels = deserialize($strSkipLabels, true);
		$this->arrOutput = $this->setOutputValues();

		// TCPDF configuration
		$l['a_meta_dir'] = 'ltr';
		$l['a_meta_charset'] = $GLOBALS['TL_CONFIG']['characterSet'];
		$l['a_meta_language'] = $GLOBALS['TL_LANGUAGE'];
		$l['w_page'] = 'page';

		require_once(TL_ROOT . '/system/modules/competition/classes/vendor/tcpdf/tcpdf.php');
		require_once(TL_ROOT . '/system/config/tcpdf.php');
		require_once(TL_ROOT . '/system/modules/competition/classes/vendor/fpdi/fpdi.php');
		
		$this->pdf = new CompetitionFPDI(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true);

		// Set document information
		$this->pdf->SetCreator($arrSettings['fileCreator']);
		$this->pdf->SetAuthor($arrSettings['fileCreator']);
		$this->pdf->SetTitle($arrSettings['fileTitle']);
		$this->pdf->SetSubject($arrSettings['fileSubject']);
		$this->pdf->setFontSubsetting(false);
		$this->pdf->setPrintFooter(false);
		if(!empty($arrSettings['margins']))
		{
			$this->pdf->SetMargins($arrSettings['margins']['left'], $arrSettings['margins']['top'], $arrSettings['margins']['right']);
			$this->pdf->SetAutoPageBreak(true, $arrSettings['margins']['bottom']);
			$this->pdf->setPageUnit($arrSettings['margins']['unit']);
		}
		if(!empty($arrSettings['pdfFonts']))
		{
			foreach($arrSettings['pdfFonts'] as $strFont)
			{
				$this->pdf->addTTFfont(TL_ROOT . \HeimrichHannot\HastePlus\Files::getPathFromUuid($strFont));
			}
		}

		// pdf - cover sheet
		if ($arrSettings['addPdfCover'])
		{
			if($arrSettings['pdfCoverBackground'])
			{
				$this->pdf->setPrintHeader(true);
				$strTemplate =TL_ROOT . '/' . \HeimrichHannot\HastePlus\Files::getPathFromUuid($arrSettings['pdfCoverBackground']);
			}
			else
			{
				$this->pdf->setPrintHeader(false);
				$strTemplate = '';
			}
			$this->pdf->setHeaderTemplate($strTemplate);
			$this->pdf->AddPage();
			$this->pdf->writeHTML($this->compile($arrSettings['pdfCoverTemplate'], $blnForJudges), true, 0, true, 1);
		}

		// pdf - content
		if($arrSettings['pdfBackground'])
		{
			$this->pdf->setPrintHeader(true);
			$strTemplate = TL_ROOT . '/' . \HeimrichHannot\HastePlus\Files::getPathFromUuid($arrSettings['pdfBackground']);
		}
		else
		{
			$this->pdf->setPrintHeader(false);
			$strTemplate = '';
		}
		$this->pdf->setHeaderTemplate($strTemplate);
		$this->pdf->AddPage();
		$this->pdf->writeHTML($this->compile($arrSettings['pdfTemplate'], $blnForJudges), true, 0, true, 1);

		$this->pdf->lastPage();
		$objFile->write($this->pdf->getPDFData());
		$objFile->close();

		return $objFile->getModel()->uuid;
	}

	protected function compile($strTemplate, $blnForJudges = false)
	{
		$cssBase = file_get_contents(TL_ROOT . '/system/modules/competition/assets/css/style.css');
		$objTpl = new \FrontendTemplate($strTemplate);
		$objTpl->forJudges = $blnForJudges;
		$objTpl->arrOutput = $this->arrOutput;

		return '<style>' . $cssBase . '</style>' . $objTpl->parse();
	}

	protected function setOutputValues()
	{
		\Controller::loadDataContainer('tl_competition_submission');
		$arrDcaFields = $GLOBALS['TL_DCA']['tl_competition_submission']['fields'];
		\Controller::loadLanguageFile('tl_competition_submission');

		$arrOutput = array();

		foreach($this->arrExportFields as $strField)
		{
			if (array_key_exists($strField, $this->arrSubmitted))
			{
				$strLabel = in_array($strField, $this->arrSkipLabels) ? '' : ($arrDcaFields[$strField]['label'] ?: $strField);
				$strValue = Format::getFormatedValueByDca($this->arrSubmitted[$strField], $arrDcaFields[$strField], $this->objDc);

				$arrOutput[$strField] = array($strLabel, $strValue);
			}
			else
			{
				if ($arrDcaFields[$strField]['inputType'] == 'explanation')
					$arrOutput[$strField] = array('', $arrDcaFields[$strField]['eval']['text']);
			}
		}

		return $arrOutput;
	}
	
	public function __get($strKey)
	{
		return $this->{$strKey};
	}
}