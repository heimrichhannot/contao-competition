<?php

$arrLang = &$GLOBALS['TL_LANG']['tl_competition_review_archive'];

/**
 * Fields
 */
$arrLang['title'] 		= array('Titel', 'Der Titel des Bewertungs-Archivs');
$arrLang['memberGroups'] = array('Mitgliedergruppen', 'Wählen Sie hier die Mitgliedergruppen aus, die einem Mitglied ermöglichen, in diesem Archiv Bewertungen zu erstellen. Um keine Einschränkung zu machen, lassen Sie dieses Feld bitte leer.');
$arrLang['submissionArchives'] = array('Bewerbungsarchive', 'Wählen Sie hier die Bewerbungsarchive aus, deren Bewerbungen in diesem Archiv Bewertungen zu erhalten können. Um keine Einschränkung zu machen, lassen Sie dieses Feld bitte leer.');
$arrLang['filesDir']					= array('Uploadverzeichnis', 'Wählen Sie hier das Verzeichnis aus, dem die hochgeladenen Dateien hinzugefügt werden sollen.');
$arrLang['filesUseHomeDir']				= array('Benutzerverzeichnisse verwenden', 'Wählen Sie diese Option, wenn die hochgeladenen Dateien vorrangig dem Benutzerverzeichnis hinzugefügt werden sollen. Hat das aktuell eingeloggte Mitglied kein Benutzerverzeichnis, wird das Uploadverzeichnis genutzt.');
$arrLang['filesUseProtectedHomeDir']	= array('Geschützte Benutzerverzeichnisse verwenden', 'Wählen Sie diese Option, wenn die hochgeladenen Dateien vorrangig dem geschützten Benutzerverzeichnis, dann dem normalen und dann dem Uploadverzeichnis hinzugefügt werden sollen.');
$arrLang['filesDirName']				= array('Archiv-Verzeichnisname', 'Geben Sie hier bei Bedarf einen Verzeichnisnamen ein, der im Exportverzeichnis erzeugt wird (bspw. "meinwettbewerb").');

/**
 * Buttons
 */
$arrLang['new']			= array('Neues Bewertungs-Archiv', 'Ein neues Bewertungs-Archiv erstellen');
$arrLang['show']		= array('Bewertungs-Archiv Details', 'Die Details von Bewertungs-Archiv ID %s anzeigen');
$arrLang['edit']		= array('Bewertungs-Archiv bearbeiten', 'Bewertungs-Archiv ID %s bearbeiten');
$arrLang['editheader']	= array('Bewertungs-Archiv Einstellungen bearbeiten', 'Einstellungen von Bewertungs-Archiv ID %s bearbeiten');
$arrLang['copy']		= array('Bewertungs-Archiv duplizieren', 'Bewertungs-Archiv ID %s duplizieren');
$arrLang['delete']		= array('Bewertungs-Archiv löschen', 'Bewertungs-Archiv ID %s löschen');
