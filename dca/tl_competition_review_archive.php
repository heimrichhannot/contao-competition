<?php

$GLOBALS['TL_DCA']['tl_competition_review_archive'] = array
(
	// Config
	'config'   => array
	(
		'dataContainer'    => 'Table',
		'ctable'           => array('tl_competition_review'),
		'enableVersioning'  => true,
		'switchToEdit'     => true,
		'onload_callback' => array
		(
			array('tl_competition_review_archive', 'checkPermission'),
			array('tl_competition_review_archive', 'modifyPalette'),
		),
		'sql' => array
		(
			'keys' => array
			(
				'id' => 'primary'
			)
		)
	),

	// List
	'list'     => array
	(
		'sorting'           => array
		(
			'mode'        => 1,
			'fields'      => array('title'),
			'flag'        => 1,
			'panelLayout' => 'search,limit'
		),
		'label'             => array
		(
			'fields' => array('title'),
			'format' => '%s'
		),
		'global_operations' => array
		(
			'all' => array
			(
				'label'      => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'       => 'act=select',
				'class'      => 'header_edit_all',
				'attributes' => 'onclick="Backend.getScrollOffset();"'
			)
		),
		'operations'        => array
		(
			'edit'       => array
			(
				'label' => &$GLOBALS['TL_LANG']['tl_competition_review_archive']['edit'],
				'href'  => 'table=tl_competition_review',
				'icon'  => 'edit.gif'
			),
			'editheader' => array
			(
				'label'           => &$GLOBALS['TL_LANG']['tl_competition_review_archive']['editheader'],
				'href'            => 'act=edit',
				'icon'            => 'header.gif',
				'button_callback' => array('tl_competition_review_archive', 'editHeader'),
				'attributes'      => 'class="edit-header"'
			),
			'copy'       => array
			(
				'label' => &$GLOBALS['TL_LANG']['tl_competition_review_archive']['copy'],
				'href'  => 'act=copy',
				'icon'  => 'copy.gif'
			),
			'delete'     => array
			(
				'label'      => &$GLOBALS['TL_LANG']['tl_competition_review_archive']['delete'],
				'href'       => 'act=delete',
				'icon'       => 'delete.gif',
				'attributes' => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm']
					. '\'))return false;Backend.getScrollOffset()"'
			),
			'show'       => array
			(
				'label' => &$GLOBALS['TL_LANG']['tl_competition_review_archive']['show'],
				'href'  => 'act=show',
				'icon'  => 'show.gif'
			),
			'export'     => array
			(
				'label' => &$GLOBALS['TL_LANG']['tl_competition_review_archive']['export'],
				'href'  => 'table=tl_competition_review&key=export',
				'icon'  => 'export.gif'
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'__selector__' => array('addPdfExport', 'addPdfCover'),
		'default' => 'title,memberGroups,submissionArchives,addPdfExport;'
	),

	// Subpalettes
	'subpalettes' => array(
		'addPdfCover' => 'pdfCoverBackground,pdfCoverTemplate;'
	),

	// Fields
	'fields'   => array
	(
		'id' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL auto_increment"
		),
		'tstamp' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'title' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_competition_review_archive']['title'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class' => 'w50'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'memberGroups' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_competition_review_archive']['memberGroups'],
			'exclude'                 => true,
			'inputType'               => 'select',
			'foreignKey'              => 'tl_member_group.name',
			'eval'                    => array(
				'tl_class' => 'w50',
				'chosen' => true,
				'multiple' => true,
				'includeBlankOption' => true
			),
			'sql'                     => "blob NULL",
			'relation'                => array('type'=>'belongsToMany', 'load'=>'lazy')
		),
		'submissionArchives' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_competition_review_archive']['submissionArchives'],
			'exclude'                 => true,
			'inputType'               => 'select',
			'foreignKey'              => 'tl_competition_review_archive.title',
			'eval'                    => array(
				'tl_class' => 'w50',
				'chosen' => true,
				'multiple' => true,
				'includeBlankOption' => true
			),
			'sql'                     => "blob NULL",
			'relation'                => array('type'=>'belongsToMany', 'load'=>'lazy')
		),

		// export
		'addPdfExport' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_competition_review_archive']['addPdfExport'],
			'exclude'                 => true,
			'inputType'               => 'checkbox',
			'eval'					  => array(
				'submitOnChange' => true,
				'doNotCopy' => true,
				'tl_class' => 'long clr'),
			'sql'                     => "char(1) NOT NULL default ''"
		),
		'addPdfCover' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_competition_review_archive']['addPdfCover'],
			'exclude'                 => true,
			'inputType'               => 'checkbox',
			'eval'					  => array(
				'submitOnChange' => true,
				'doNotCopy' => true,
				'tl_class' => 'long clr'),
			'sql'                     => "char(1) NOT NULL default ''"
		),
		'pdfCoverBackground' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_competition_review_archive']['pdfCoverBackground'],
			'inputType'               => 'fileTree',
			'exclude'                 => true,
			'eval'                    => array(
				'filesOnly' => true,
				'extensions' => 'pdf',
				'fieldType' => 'radio',
				'tl_class' => 'w50'),
			'sql'                     => "binary(16) NULL"
		),

		'pdfCoverTemplate' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_competition_review_archive']['pdfCoverTemplate'],
			'exclude'          => true,
			'inputType'        => 'select',
			'options_callback' => array('tl_competition_review_archive', 'getCompetitionPdfTemplates'),
			'eval'             => array(
				'tl_class' => 'w50',
				'includeBlankOption' => true
			),
			'sql'              => "varchar(64) NOT NULL default ''"
		),
		'pdfBackground' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_competition_review_archive']['pdfBackground'],
			'inputType'               => 'fileTree',
			'exclude'                 => true,
			'eval'                    => array(
				'filesOnly' => true,
				'extensions' => 'pdf',
				'fieldType' => 'radio',
				'tl_class' => 'w50'),
			'sql'                     => "binary(16) NULL"
		),
		'pdfTemplate' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_competition_review_archive']['pdfTemplate'],
			'exclude'          => true,
			'inputType'        => 'select',
			'options_callback' => array('tl_competition_review_archive', 'getCompetitionPdfTemplates'),
			'eval'             => array(
				'tl_class' => 'w50',
				'includeBlankOption' => true
			),
			'sql'              => "varchar(64) NOT NULL default ''"
		),
		'pdfFonts' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_competition_review_archive']['pdfFonts'],
			'inputType'               => 'fileTree',
			'exclude'                 => true,
			'eval'                    => array(
				'filesOnly' => true,
				'extensions' => 'ttf',
				'fieldType' => 'checkbox',
				'multiple' => true,
				'tl_class' => 'w50 clr'),
			'sql'                     => "blob NULL"
		),
		'pdfMargins' => array
		(
			'label' => &$GLOBALS['TL_LANG']['tl_competition_review_archive']['pdfMargins'],
			'exclude' => true,
			'inputType' => 'trbl',
			'options' => array('pt', 'in', 'cm', 'mm'),
			'eval' => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
			'sql' => "varchar(128) NOT NULL default ''"
		),
		'pdfExportFileNamePrefix' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_competition_review_archive']['pdfExportFileNamePrefix'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>50, 'tl_class' => 'w50'),
			'sql'                     => "varchar(50) NOT NULL default ''"
		),
		'pdfExportDir' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_competition_review_archive']['pdfExportDir'],
			'exclude'                 => true,
			'inputType'               => 'fileTree',
			'eval'                    => array('fieldType'=>'radio', 'mandatory' => true, 'tl_class'=>'w50'),
			'sql'                     => "binary(16) NULL"
		),
		'pdfExportUseHomeDir' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_competition_review_archive']['pdfExportUseHomeDir'],
			'exclude'                 => true,
			'inputType'               => 'checkbox',
			'eval'					  => array('tl_class' => 'w50'),
			'sql'                     => "char(1) NOT NULL default ''"
		),
		'pdfExportFileTitle' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_competition_review_archive']['pdfExportFileTitle'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>50, 'tl_class' => 'w50'),
			'sql'                     => "varchar(50) NOT NULL default ''"
		),
		'pdfExportFileSubject' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_competition_review_archive']['pdfExportFileSubject'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>255, 'tl_class' => 'w50'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'pdfExportFileCreator' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_competition_review_archive']['pdfExportFileCreator'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>100, 'tl_class' => 'w50'),
			'sql'                     => "varchar(100) NOT NULL default ''"
		),

		'pdfSkipLabels' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_competition_review_archive']['pdfSkipLabels'],
			'exclude'			=> true,
			'inputType'			=> 'select',
			'options_callback'  => array('tl_competition_review_archive', 'getExportableSubmissionFields'),
			'eval'              => array(
				'chosen' => true,
				'multiple' => true,
				'tl_class' => 'long clr'),
			'sql'               => "blob NULL"
		),
		'pdfExportFields' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_competition_review_archive']['pdfExportFields'],
			'exclude'			=> true,
			'inputType'			=> 'checkboxWizard',
			'options_callback'  => array('tl_competition_review_archive', 'getExportableSubmissionFields'),
			'eval'              => array(
				'multiple' => true,
				'tl_class' => 'long clr'),
			'sql'               => "blob NULL"
		)
	)
);

$arrDca = &$GLOBALS['TL_DCA']['tl_competition_review_archive'];

$arrDca['grouppalettes']['pdfExport'] = '{cover_legend:hide},addPdfCover;
		{config_legend:hide},pdfBackground,pdfTemplate,pdfFonts,pdfMargins;
		{exportFile_legend},pdfExportFileNamePrefix,pdfExportDir,pdfExportUseHomeDir,pdfExportFileTitle,pdfExportFileSubject,pdfExportFileCreator;
		{exportForApplicant_legend:hide},pdfSkipLabels,pdfExportFields';

if (in_array('protected_homedirs', \ModuleLoader::getActive()))
{
	$arrDca['grouppalettes']['pdfExport'] = str_replace('pdfExportUseHomeDir',
		'pdfExportUseHomeDir,pdfExportUseProtectedHomeDir', $arrDca['grouppalettes']['pdfExport']);

	$arrDca['fields']['pdfExportUseProtectedHomeDir'] = array
	(
		'label'                   => &$GLOBALS['TL_LANG']['tl_competition_review_archive']['pdfExportUseProtectedHomeDir'],
		'exclude'                 => true,
		'inputType'               => 'checkbox',
		'eval'					  => array('tl_class' => 'w50'),
		'sql'                     => "char(1) NOT NULL default ''"
	);
}

$arrDca['palettes']['default'] .= $arrDca['grouppalettes']['pdfExport'];

class tl_competition_review_archive extends \Backend
{
	public static function modifyPalette()
	{
		if (($objArchive = \HeimrichHannot\Competition\ReviewArchiveModel::findByPk(\Input::get('id'))) !== null)
		{
			if (!$objArchive->addPdfExport)
			{
				$arrDca = &$GLOBALS['TL_DCA']['tl_competition_review_archive'];

				$arrDca['palettes']['default'] = str_replace(
					$arrDca['grouppalettes']['pdfExport'], '',
					$GLOBALS['TL_DCA']['tl_competition_review_archive']['palettes']['default']
				);
			}
		}
	}

	public function getCompetitionPdfTemplates()
	{
		return $this->getTemplateGroup('pdf_competition_');
	}

	public function getExportableSubmissionFields()
	{
		$return = array();
		$arrExcludedFields = array('id', 'pid', 'tstamp', 'jid', 'dateAdded', 'published');

		$this->loadDataContainer('tl_competition_review');

		foreach($GLOBALS['TL_DCA']['tl_competition_review']['fields'] as $k=>$v)
		{
			if(!in_array($k, $arrExcludedFields))
			{
				$return[$k] = $k;
			}
		}

		return $return;
	}


	public function checkPermission()
	{
		$objUser = \BackendUser::getInstance();
		$objSession = \Session::getInstance();
		$objDatabase = \Database::getInstance();

		// TODO
		if (true || $objUser->isAdmin)
		{
			return;
		}

		// Set root IDs
		if (!is_array($objUser->competition_reviews) || empty($objUser->competition_reviews))
		{
			$root = array(0);
		}
		else
		{
			$root = $objUser->competition_reviews;
		}

		$GLOBALS['TL_DCA']['tl_competition_review_archive']['list']['sorting']['root'] = $root;

		// Check permissions to add archives
		if (!$objUser->hasAccess('create', 'competition_reviewp'))
		{
			$GLOBALS['TL_DCA']['tl_competition_review_archive']['config']['closed'] = true;
		}

		// Check current action
		switch (Input::get('act'))
		{
			case 'create':
			case 'select':
				// Allow
				break;

			case 'edit':
				// Dynamically add the record to the user profile
				if (!in_array(Input::get('id'), $root))
				{
					$arrNew = $objSession->get('new_records');

					if (is_array($arrNew['tl_competition_review_archive']) && in_array(Input::get('id'), $arrNew['tl_competition_review_archive']))
					{
						// Add permissions on user level
						if ($objUser->inherit == 'custom' || !$objUser->groups[0])
						{
							$objUser = $objDatabase->prepare("SELECT competition_reviews, competition_reviewp FROM tl_user WHERE id=?")
								->limit(1)
								->execute($objUser->id);

							$arrcompetition_reviews = deserialize($objUser->competition_reviews);

							if (is_array($arrcompetition_reviews) && in_array('create', $arrcompetition_reviews))
							{
								$arrcompetition_reviews = deserialize($objUser->competition_reviews);
								$arrcompetition_reviews[] = Input::get('id');

								$objDatabase->prepare("UPDATE tl_user SET competition_reviews=? WHERE id=?")
									->execute(serialize($arrcompetition_reviews), $objUser->id);
							}
						}

						// Add permissions on group level
						elseif ($objUser->groups[0] > 0)
						{
							$objGroup = $objDatabase->prepare("SELECT competition_reviews, competition_reviewp FROM tl_user_group WHERE id=?")
								->limit(1)
								->execute($objUser->groups[0]);

							$arrcompetition_reviews = deserialize($objGroup->competition_reviews);

							if (is_array($arrcompetition_reviews) && in_array('create', $arrcompetition_reviews))
							{
								$arrcompetition_reviews = deserialize($objGroup->competition_reviews);
								$arrcompetition_reviews[] = Input::get('id');

								$objDatabase->prepare("UPDATE tl_user_group SET competition_reviews=? WHERE id=?")
									->execute(serialize($arrcompetition_reviews), $objUser->groups[0]);
							}
						}

						// Add new element to the user object
						$root[] = Input::get('id');
						$objUser->competition_reviews = $root;
					}
				}
			// No break;

			case 'copy':
			case 'delete':
			case 'show':
				if (!in_array(Input::get('id'), $root) || (Input::get('act') == 'delete' && !$objUser->hasAccess('delete', 'competition_reviews')))
				{
					\Controller::log('Not enough permissions to '.Input::get('act').' competition reviews archive ID "'.Input::get('id').'"', 'tl_competition_review_archive checkPermission', TL_ERROR);
					\Controller::redirect('contao/main.php?act=error');
				}
				break;

			case 'editAll':
			case 'deleteAll':
			case 'overrideAll':
				$session = $objSession->getData();
				if (Input::get('act') == 'deleteAll' && !$objUser->hasAccess('delete', 'competition_reviews'))
				{
					$session['CURRENT']['IDS'] = array();
				}
				else
				{
					$session['CURRENT']['IDS'] = array_intersect($session['CURRENT']['IDS'], $root);
				}
				$objSession->setData($session);
				break;

			default:
				if (strlen(Input::get('act')))
				{
					\Controller::log('Not enough permissions to '.Input::get('act').' competition reviews archives', 'tl_competition_review_archive checkPermission', TL_ERROR);
					\Controller::redirect('contao/main.php?act=error');
				}
				break;
		}
	}

	public function editHeader($row, $href, $label, $title, $icon, $attributes)
	{
		$objUser = \BackendUser::getInstance();

		return ($objUser->isAdmin || count(preg_grep('/^tl_competition_review_archive::/', $objUser->alexf)) > 0) ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ' : Image::getHtml(preg_replace('/\.gif$/i', '_.gif', $icon)).' ';
	}

	public function copyArchive($row, $href, $label, $title, $icon, $attributes)
	{
		$objUser = \BackendUser::getInstance();

		return ($objUser->isAdmin || $objUser->hasAccess('create', 'competition_reviews')) ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ' : Image::getHtml(preg_replace('/\.gif$/i', '_.gif', $icon)).' ';
	}

	public function deleteArchive($row, $href, $label, $title, $icon, $attributes)
	{
		$objUser = \BackendUser::getInstance();
		
		return ($objUser->isAdmin || $objUser->hasAccess('delete', 'competition_reviews')) ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ' : Image::getHtml(preg_replace('/\.gif$/i', '_.gif', $icon)).' ';
	}
}

