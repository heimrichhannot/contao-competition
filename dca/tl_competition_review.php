<?php

$GLOBALS['TL_DCA']['tl_competition_review'] = array
(
	'config'   => array
	(
		'dataContainer'     => 'Table',
		'ptable'            => 'tl_competition_review_archive',
		'enableVersioning'  => true,
		'onsubmit_callback' => array
		(
			'setDateAdded' => array('HeimrichHannot\\HastePlus\\Utilities', 'setDateAdded'),
			'checkPublishedForPdfGeneration' => array('tl_competition_review', 'checkPublishedForPdfGeneration')
		),
		'sql' => array
		(
			'keys' => array
			(
				'id' => 'primary'
			)
		)
	),
	'list'     => array
	(
		'sorting'           => array
		(
			'mode'                  => 4,
			'fields'                => array('dateAdded DESC'),
			'headerFields'          => array('title'),
			'panelLayout'           => 'filter;search,limit',
			'child_record_callback' => array('tl_competition_review', 'listReviews'),
		),
		'global_operations' => array
		(
			'export' => \HeimrichHannot\Exporter\ModuleExporter::getGlobalOperation('export',
					$GLOBALS['TL_LANG']['tl_competition_review']['export'],
					'system/modules/competition/assets/img/icon_export.png'),
			'export_xls' => \HeimrichHannot\Exporter\ModuleExporter::getGlobalOperation('export_xls',
					$GLOBALS['TL_LANG']['tl_competition_review']['export_xls'],
					'system/modules/competition/assets/img/icon_export.png'),
			'all'    => array
			(
				'label'      => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'       => 'act=select',
				'class'      => 'header_edit_all',
				'attributes' => 'onclick="Backend.getScrollOffset();"'
			),
		),
		'operations'        => array
		(
			'edit'   => array
			(
				'label' => &$GLOBALS['TL_LANG']['tl_competition_review']['edit'],
				'href'  => 'act=edit',
				'icon'  => 'edit.gif'
			),
			'copy'   => array
			(
				'label' => &$GLOBALS['TL_LANG']['tl_competition_review']['copy'],
				'href'  => 'act=copy',
				'icon'  => 'copy.gif'
			),
			'delete' => array
			(
				'label'      => &$GLOBALS['TL_LANG']['tl_competition_review']['delete'],
				'href'       => 'act=delete',
				'icon'       => 'delete.gif',
				'attributes' => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
			),
			'toggle' => array
			(
				'label'           => &$GLOBALS['TL_LANG']['tl_competition_review']['toggle'],
				'icon'            => 'visible.gif',
				'attributes'      => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s)"',
				'button_callback' => array('tl_competition_review', 'toggleIcon')
			),
			'show'   => array
			(
				'label' => &$GLOBALS['TL_LANG']['tl_competition_review']['show'],
				'href'  => 'act=show',
				'icon'  => 'show.gif'
			)
		)
	),
	'palettes' => array(
		'default' => '{general_legend},jid,sid,pdfExportFile;{publish_legend},published;'
	),
	'fields'   => array
	(
		'id' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL auto_increment"
		),
		'pid' => array
		(
			'foreignKey'              => 'tl_competition_review_archive.title',
			'sql'                     => "int(10) unsigned NOT NULL default '0'",
			'relation'                => array('type'=>'belongsTo', 'load'=>'eager')
		),
		'tstamp' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'dateAdded' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['MSC']['dateAdded'],
			'sorting'                 => true,
			'flag'                    => 6,
			'eval'                    => array('rgxp'=>'datim', 'doNotCopy' => true),
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'jid' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_competition_review']['jid'],
			'exclude'                 => true,
			'filter'                  => true,
			'search'                  => true,
			'inputType'               => 'select',
			'default'                 => \FrontendUser::getInstance() && \FrontendUser::getInstance()->id ? \FrontendUser::getInstance()->id : 0,
			'foreignKey'              => 'tl_member.id',
			'options_callback'        => array('tl_competition_review', 'getAllowedMembersAsOptions'),
			'eval'                    => array('mandatory' => true, 'tl_class' => 'w50', 'includeBlankOption' => true, 'submitOnChange' => true),
			'sql'                     => "int(10) unsigned NOT NULL default '0'",
			'relation'                => array('type'=>'belongsTo', 'load'=>'lazy')
		),
		'sid' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_competition_review']['sid'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'select',
			'foreignKey'              => 'tl_competition_submission.id',
			'options_callback'        => array('tl_competition_review', 'getAllowedSubmissionsAsOptions'),
			'eval'                    => array('mandatory' => true, 'tl_class' => 'w50', 'includeBlankOption' => true, 'submitOnChange' => true, 'rgxp' => 'uniquesid'),
			'sql'                     => "varchar(10) NOT NULL default ''",
			'relation'                => array('type'=>'belongsTo', 'load'=>'lazy')
		),
		'pdfExportFile' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_competition_review']['pdfExportFile'],
			'inputType'               => 'fileTree',
			'exclude'                 => true,
			'eval'                    => array(
				'filesOnly' => true,
				'extensions' => 'pdf',
				'fieldType' => 'radio',
				'tl_class' => 'long clr'),
			'sql'                     => "binary(16) NULL"
		),
		'published' => array
		(
			'default'                 => true,
			'label'                   => &$GLOBALS['TL_LANG']['tl_competition_review']['published'],
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('tl_class'=>'w50', 'doNotCopy'=>true),
			'sql'                     => "char(1) NOT NULL default '0'"
		)
	)
);


class tl_competition_review extends \Backend
{
	public function listReviews($arrRow)
	{
		$strReview = '<div>';

		if (($objMember = \MemberModel::findByPk($arrRow['jid'])) !== null)
		{
			$strReview .= $objMember->firstname . ' ' . $objMember->lastname;
		}

		if (($objSubmission = \HeimrichHannot\Competition\SubmissionModel::findByPk($arrRow['sid'])) !== null)
		{
			if ($objSubmission->companyTeamName)
				$strReview .= ' <span style="color:#b3b3b3; padding-left:3px">[' . $objSubmission->companyTeamName . ']</span>';
		}

		$strReview .= '</div>';

		return $strReview;
	}

	public static function checkPublishedForPdfGeneration(\DataContainer $objDc)
	{
		if(!$objDc->activeRecord->published)
		{
			$objPdf = new HeimrichHannot\Competition\CompetitionExportPdf($objDc, 'tl_competition_review_archive', 'tl_competition_review');
			$varPdfUuid = $objPdf->uuidApplicantFile;
			\Database::getInstance()->prepare("UPDATE tl_competition_review SET pdfExportFile=? WHERE id=?")
				->execute($varPdfUuid, $objDc->activeRecord->id);
		}
	}

	/**
	 * Check permissions to edit table tl_competition_review
	 */
	public function checkPermission()
	{
		$objUser = \BackendUser::getInstance();
		$objSession = \Session::getInstance();
		$objDatabase = \Database::getInstance();

		// TODO!
		if (true || $objUser->isAdmin)
		{
			return;
		}

		// Set the root IDs
		if (!is_array($objUser->competition_reviews) || empty($objUser->competition_reviews))
		{
			$root = array(0);
		}
		else
		{
			$root = $objUser->competition_reviews;
		}

		$id = strlen(Input::get('id')) ? Input::get('id') : CURRENT_ID;

		// Check current action
		switch (Input::get('act'))
		{
			case 'paste':
				// Allow
				break;

			case 'create':
				if (!strlen(Input::get('pid')) || !in_array(Input::get('pid'), $root))
				{
					\Controller::log('Not enough permissions to create review items in competition review archive ID "'.Input::get('pid').'"', 'tl_competition_review checkPermission', TL_ERROR);
					\Controller::redirect('contao/main.php?act=error');
				}
				break;

			case 'cut':
			case 'copy':
				if (!in_array(Input::get('pid'), $root))
				{
					\Controller::log('Not enough permissions to '.Input::get('act').' review item ID "'.$id.'" to competition review archive ID "'.Input::get('pid').'"', 'tl_competition_review checkPermission', TL_ERROR);
					\Controller::redirect('contao/main.php?act=error');
				}
			// NO BREAK STATEMENT HERE

			case 'edit':
			case 'show':
			case 'delete':
			case 'toggle':
			case 'feature':
				$objArchive = $objDatabase->prepare("SELECT pid FROM tl_competition_review WHERE id=?")
					->limit(1)
					->execute($id);

				if ($objArchive->numRows < 1)
				{
					\Controller::log('Invalid review item ID "'.$id.'"', 'tl_competition_review checkPermission', TL_ERROR);
					\Controller::redirect('contao/main.php?act=error');
				}

				if (!in_array($objArchive->pid, $root))
				{
					\Controller::log('Not enough permissions to '.Input::get('act').' review item ID "'.$id.'" of competition review archive ID "'.$objArchive->pid.'"', 'tl_competition_review checkPermission', TL_ERROR);
					\Controller::redirect('contao/main.php?act=error');
				}
				break;

			case 'select':
			case 'editAll':
			case 'deleteAll':
			case 'overrideAll':
			case 'cutAll':
			case 'copyAll':
				if (!in_array($id, $root))
				{
					\Controller::log('Not enough permissions to access competition review archive ID "'.$id.'"', 'tl_competition_review checkPermission', TL_ERROR);
					\Controller::redirect('contao/main.php?act=error');
				}

				$objArchive = $objDatabase->prepare("SELECT id FROM tl_competition_review WHERE pid=?")
					->execute($id);

				if ($objArchive->numRows < 1)
				{
					\Controller::log('Invalid competition review archive ID "'.$id.'"', 'tl_competition_review checkPermission', TL_ERROR);
					\Controller::redirect('contao/main.php?act=error');
				}

				$session = $objSession->getData();
				$session['CURRENT']['IDS'] = array_intersect($session['CURRENT']['IDS'], $objArchive->fetchEach('id'));
				$objSession->setData($session);
				break;

			default:
				if (strlen(Input::get('act')))
				{
					\Controller::log('Invalid command "'.Input::get('act').'"', 'tl_competition_review checkPermission', TL_ERROR);
					\Controller::redirect('contao/main.php?act=error');
				}
				elseif (!in_array($id, $root))
				{
					\Controller::log('Not enough permissions to access competition review archive ID ' . $id, 'tl_competition_review checkPermission', TL_ERROR);
					\Controller::redirect('contao/main.php?act=error');
				}
				break;
		}
	}

	/**
	 * Return the "toggle visibility" button
	 * @param array
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @return string
	 */
	public function toggleIcon($row, $href, $label, $title, $icon, $attributes)
	{
		$objUser = \BackendUser::getInstance();

		if (strlen(Input::get('tid')))
		{
			$this->toggleVisibility(Input::get('tid'), (Input::get('state') == 1));
			\Controller::redirect($this->getReferer());
		}

		// Check permissions AFTER checking the tid, so hacking attempts are logged
		if (!$objUser->isAdmin && !$objUser->hasAccess('tl_competition_review::published', 'alexf'))
		{
			return '';
		}

		$href .= '&amp;tid='.$row['id'].'&amp;state='.($row['published'] ? 1 : '');

		if (!$row['published'])
		{
			$icon = 'invisible.gif';
		}

		return '<a href="'.$this->addToUrl($href).'" title="'.specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ';
	}


	/**
	 * published/enable a user group
	 * @param integer
	 * @param boolean
	 */
	public function toggleVisibility($intId, $blnVisible)
	{
		$objUser = \BackendUser::getInstance();
		$objDatabase = \Database::getInstance();

		// Check permissions to edit
		Input::setGet('id', $intId);
		Input::setGet('act', 'toggle');
		$this->checkPermission();

		// Check permissions to published
		if (!$objUser->isAdmin && !$objUser->hasAccess('tl_competition_review::published', 'alexf'))
		{
			\Controller::log('Not enough permissions to published/enable subscription item ID "'.$intId.'"', 'tl_competition_review toggleVisibility', TL_ERROR);
			\Controller::redirect('contao/main.php?act=error');
		}

		$objVersions = new Versions('tl_competition_review', $intId);
		$objVersions->initialize();

		// Trigger the save_callback
		if (is_array($GLOBALS['TL_DCA']['tl_competition_review']['fields']['published']['save_callback']))
		{
			foreach ($GLOBALS['TL_DCA']['tl_competition_review']['fields']['published']['save_callback'] as $callback)
			{
				$this->import($callback[0]);
				$blnVisible = $this->$callback[0]->$callback[1]($blnVisible, $this);
			}
		}

		// Update the database
		$objDatabase->prepare("UPDATE tl_competition_review SET tstamp=". time() .", published='" . ($blnVisible ? 1 : '') . "' WHERE id=?")
			->execute($intId);

		$objVersions->create();
		\Controller::log('A new version of record "tl_competition_review.id='.$intId.'" has been created'.$this->getParentEntries('tl_competition_review', $intId), 'tl_competition_review toggleVisibility()', TL_GENERAL);
	}

	public static function getAllowedMembersAsOptions(\DataContainer $objDc)
	{
		if ($objDc->activeRecord->pid)
			$intId = $objDc->activeRecord->pid;
		else
			$intId = \Input::get('id');

		return \HeimrichHannot\Competition\Competition::getAllowedMembersAsOptions($intId, \HeimrichHannot\Competition\Competition::MODE_REVIEW);
	}

	public static function getAllowedSubmissionsAsOptions(\DataContainer $objDc)
	{
		$intMemberId = TL_MODE == 'FE' ? \FrontendUser::getInstance()->id : $objDc->activeRecord->jid;

		return \HeimrichHannot\Competition\Competition::getAllowedSubmissionsAsOptions($objDc->activeRecord->pid, $intMemberId);
	}

}
