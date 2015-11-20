<?php

$arrDca = &$GLOBALS['TL_DCA']['tl_user_group'];

/**
 * Extend default palette
 */
$arrDca['palettes']['default'] = str_replace('formp', 'formp;{competition_legend},competition_submissions,competition_submissionp,competition_reviews,competition_reviewp;', $arrDca['palettes']['default']);


/**
 * Add fields to tl_user_group
 */
$arrDca['fields']['competition_submissions'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_user']['competition_submissions'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'foreignKey'              => 'tl_competition_submission_archive.title',
	'eval'                    => array('multiple'=>true, 'tl_class'=>'w50 w50h'),
	'sql'                     => "blob NULL"
);

$arrDca['fields']['competition_submissionp'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_user']['competition_submissionp'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'options'                 => array('create', 'delete'),
	'reference'               => &$GLOBALS['TL_LANG']['MSC'],
	'eval'                    => array('multiple'=>true, 'tl_class'=>'w50 w50h'),
	'sql'                     => "blob NULL"
);

$arrDca['fields']['competition_reviews'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_user']['competition_reviews'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'foreignKey'              => 'tl_competition_review_archive.title',
	'eval'                    => array('multiple'=>true, 'tl_class'=>'w50 w50h'),
	'sql'                     => "blob NULL"
);

$arrDca['fields']['competition_reviewp'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_user']['competition_reviewp'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'options'                 => array('create', 'delete'),
	'reference'               => &$GLOBALS['TL_LANG']['MSC'],
	'eval'                    => array('multiple'=>true, 'tl_class'=>'w50 w50h'),
	'sql'                     => "blob NULL"
);