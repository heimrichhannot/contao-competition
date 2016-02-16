<?php

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
				'export' => \HeimrichHannot\Exporter\Exporter::getBackendModule(),
				'export_xls' => \HeimrichHannot\Exporter\Exporter::getBackendModule(),
				'clean_members' => array('HeimrichHannot\Competition\Competition', 'cleanMembers')
			),
			'competition_review' => array
			(
				'tables' => array('tl_competition_review_archive', 'tl_competition_review'),
				'icon'   => 'system/modules/competition/assets/img/icon_review.png',
				'export' => \HeimrichHannot\Exporter\Exporter::getBackendModule(),
				'export_xls' => \HeimrichHannot\Exporter\Exporter::getBackendModule()
			)
		)
	)
);


/**
 * Hooks
 */
if (in_array('frontendedit', \ModuleLoader::getActive()))
{
	$GLOBALS['TL_HOOKS']['frontendEditAddCreateBehavior']['checkForExistingReviews'] =
			array('HeimrichHannot\Competition\Competition', 'checkForExistingReviews');
}

/**
 * Models
 */
$GLOBALS['TL_MODELS'][\HeimrichHannot\Competition\SubmissionModel::getTable()] = 'HeimrichHannot\Competition\SubmissionModel';
$GLOBALS['TL_MODELS'][\HeimrichHannot\Competition\SubmissionArchiveModel::getTable()] = 'HeimrichHannot\Competition\SubmissionArchiveModel';
$GLOBALS['TL_MODELS'][\HeimrichHannot\Competition\ReviewModel::getTable()] = 'HeimrichHannot\Competition\ReviewModel';
$GLOBALS['TL_MODELS'][\HeimrichHannot\Competition\ReviewArchiveModel::getTable()] = 'HeimrichHannot\Competition\ReviewArchiveModel';