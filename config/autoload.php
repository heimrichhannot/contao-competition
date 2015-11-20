<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2015 Leo Feyer
 *
 * @package Competition
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'HeimrichHannot',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Models
	'HeimrichHannot\Competition\ReviewModel'            => 'system/modules/competition/models/ReviewModel.php',
	'HeimrichHannot\Competition\ReviewArchiveModel'     => 'system/modules/competition/models/ReviewArchiveModel.php',
	'HeimrichHannot\Competition\SubmissionModel'        => 'system/modules/competition/models/SubmissionModel.php',
	'HeimrichHannot\Competition\SubmissionArchiveModel' => 'system/modules/competition/models/SubmissionArchiveModel.php',

	// Classes
	'HeimrichHannot\Competition\CompetitionExportPdf'   => 'system/modules/competition/classes/CompetitionExportPdf.php',
	'HeimrichHannot\Competition\Competition'            => 'system/modules/competition/classes/Competition.php',
	'HeimrichHannot\Competition\CompetitionFPDI'        => 'system/modules/competition/classes/CompetitionFPDI.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'mod_iso_cancellation'   => 'system/modules/competition/templates',
	'pdf_competition_export' => 'system/modules/competition/templates',
	'pdf_competition_export_cover' => 'system/modules/competition/templates',
	'mod_iso_activation'     => 'system/modules/competition/templates',
));
