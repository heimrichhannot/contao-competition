<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2016 Leo Feyer
 *
 * @license LGPL-3.0+
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
	// Classes
	'HeimrichHannot\Competition\Competition'            => 'system/modules/competition/classes/Competition.php',

	// Models
	'HeimrichHannot\Competition\SubmissionModel'        => 'system/modules/competition/models/SubmissionModel.php',
	'HeimrichHannot\Competition\ReviewModel'            => 'system/modules/competition/models/ReviewModel.php',
	'HeimrichHannot\Competition\ReviewArchiveModel'     => 'system/modules/competition/models/ReviewArchiveModel.php',
	'HeimrichHannot\Competition\SubmissionArchiveModel' => 'system/modules/competition/models/SubmissionArchiveModel.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'pdf_competition_export'       => 'system/modules/competition/templates',
	'mod_iso_activation'           => 'system/modules/competition/templates',
	'pdf_competition_export_cover' => 'system/modules/competition/templates',
	'mod_iso_cancellation'         => 'system/modules/competition/templates',
));
