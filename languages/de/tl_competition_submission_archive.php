<?php

$arrLang = &$GLOBALS['TL_LANG']['tl_competition_submission_archive'];


/**
 * Fields
 */
$arrLang['title'] 						= array('Titel', 'Der Titel des Bewerbungs-Archivs');
$arrLang['memberGroups']				= array('Mitgliedergruppen', 'Wählen Sie hier die Mitgliedergruppen aus, die einem Mitglied ermöglichen, in diesem Archiv Bewerbungen zu erstellen. Um keine Einschränkung zu machen, lassen Sie dieses Feld bitte leer.');
$arrLang['filesDir']					= array('Exportverzeichnis', 'Wählen Sie hier das Verzeichnis aus, dem die exportierten Dateien hinzugefügt werden sollen.');
$arrLang['filesUseHomeDir']				= array('Benutzerverzeichnisse verwenden', 'Wählen Sie diese Option, wenn die exportierten Dateien vorrangig dem Benutzerverzeichnis hinzugefügt werden sollen. Hat das aktuell eingeloggte Mitglied kein Benutzerverzeichnis, wird das Exportverzeichnis genutzt.');
$arrLang['filesUseProtectedHomeDir']	= array('Geschützte Benutzerverzeichnisse verwenden', 'Wählen Sie diese Option, wenn die exportierten Dateien vorrangig dem geschützten Benutzerverzeichnis, dann dem normalen und dann dem Exportverzeichnis hinzugefügt werden sollen.');
$arrLang['filesDirName']				= array('Archiv-Verzeichnisname', 'Geben Sie hier bei Bedarf einen Verzeichnisnamen ein, der im Exportverzeichnis erzeugt wird (bspw. "meinwettbewerb").');

/**
 * Buttons
 */
$arrLang['new']			= array('Neues Bewerbungs-Archiv', 'Ein neues Bewerbungs-Archiv erstellen');
$arrLang['show']		= array('Bewerbungs-Archiv Details', 'Die Details von Bewerbungs-Archiv ID %s anzeigen');
$arrLang['edit']		= array('Bewerbungs-Archiv bearbeiten', 'Bewerbungs-Archiv ID %s bearbeiten');
$arrLang['editheader']	= array('Bewerbungs-Archiv Einstellungen bearbeiten', 'Einstellungen von Bewerbungs-Archiv ID %s bearbeiten');
$arrLang['copy']		= array('Bewerbungs-Archiv duplizieren', 'Bewerbungs-Archiv ID %s duplizieren');
$arrLang['delete']		= array('Bewerbungs-Archiv löschen', 'Bewerbungs-Archiv ID %s löschen');