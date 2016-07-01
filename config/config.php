<?php

define('COMPETITION_FILENAME_SUFFIX', '_judges');

/**
 * Back end modules
 */
array_insert(
	$GLOBALS['BE_MOD'],
	1,
	array
	(
		'competition' => array
		(
			'competition_submission' => array
			(
				'tables' => array('tl_competition_submission_archive', 'tl_competition_submission'),
				'icon'   => 'system/modules/competition/assets/img/icon_submission.png',
				'export' => \HeimrichHannot\Exporter\ModuleExporter::getBackendModule(),
				'export_xls' => \HeimrichHannot\Exporter\ModuleExporter::getBackendModule(),
				'clean_members' => array('HeimrichHannot\Competition\Competition', 'cleanMembers')
			),
			'competition_review' => array
			(
				'tables' => array('tl_competition_review_archive', 'tl_competition_review'),
				'icon'   => 'system/modules/competition/assets/img/icon_review.png',
				'export' => \HeimrichHannot\Exporter\ModuleExporter::getBackendModule(),
				'export_xls' => \HeimrichHannot\Exporter\ModuleExporter::getBackendModule()
			)
		)
	)
);


/**
 * Hooks
 */
$GLOBALS['TL_HOOKS']['addCustomRegexp']['checkForDoubleReviewsBe'] = array('HeimrichHannot\Competition\Competition', 'checkForDoubleReviewsBe');
$GLOBALS['TL_HOOKS']['formHybridValidateFormField']['checkForDoubleReviewsFe'] = array('HeimrichHannot\Competition\Competition', 'checkForDoubleReviewsFe');


/**
 * Models
 */
$GLOBALS['TL_MODELS'][\HeimrichHannot\Competition\SubmissionModel::getTable()] = 'HeimrichHannot\Competition\SubmissionModel';
$GLOBALS['TL_MODELS'][\HeimrichHannot\Competition\SubmissionArchiveModel::getTable()] = 'HeimrichHannot\Competition\SubmissionArchiveModel';
$GLOBALS['TL_MODELS'][\HeimrichHannot\Competition\ReviewModel::getTable()] = 'HeimrichHannot\Competition\ReviewModel';
$GLOBALS['TL_MODELS'][\HeimrichHannot\Competition\ReviewArchiveModel::getTable()] = 'HeimrichHannot\Competition\ReviewArchiveModel';