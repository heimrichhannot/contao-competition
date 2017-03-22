<?php

$arrLang = &$GLOBALS['TL_LANG']['tl_competition_review_archive'];

/**
 * Fields
 */
$arrLang['title']                    = ['Titel', 'Der Titel des Bewertungs-Archivs'];
$arrLang['memberGroups']             = [
    'Mitgliedergruppen',
    'Wählen Sie hier die Mitgliedergruppen aus, die einem Mitglied ermöglichen, in diesem Archiv Bewertungen zu erstellen. Um keine Einschränkung zu machen, lassen Sie dieses Feld bitte leer.'
];
$arrLang['submissionArchive']        = [
    'Bewerbungsarchiv',
    'Wählen Sie hier das Bewerbungsarchiv aus, dessen Bewerbungen in diesem Archiv Bewertungen erhalten können. Um keine Einschränkung zu machen, lassen Sie dieses Feld bitte leer.'
];
$arrLang['filesDir']                 =
    ['Uploadverzeichnis', 'Wählen Sie hier das Verzeichnis aus, dem die hochgeladenen Dateien hinzugefügt werden sollen.'];
$arrLang['filesUseHomeDir']          = [
    'Benutzerverzeichnisse verwenden',
    'Wählen Sie diese Option, wenn die hochgeladenen Dateien vorrangig dem Benutzerverzeichnis hinzugefügt werden sollen. Hat das aktuell eingeloggte Mitglied kein Benutzerverzeichnis, wird das Uploadverzeichnis genutzt.'
];
$arrLang['filesUseProtectedHomeDir'] = [
    'Geschützte Benutzerverzeichnisse verwenden',
    'Wählen Sie diese Option, wenn die hochgeladenen Dateien vorrangig dem geschützten Benutzerverzeichnis, dann dem normalen und dann dem Uploadverzeichnis hinzugefügt werden sollen.'
];
$arrLang['filesDirName']             = [
    'Archiv-Verzeichnisname',
    'Geben Sie hier bei Bedarf einen Verzeichnisnamen ein, der im Exportverzeichnis erzeugt wird (bspw. "meinwettbewerb").'
];

/**
 * Buttons
 */
$arrLang['new']        = ['Neues Bewertungs-Archiv', 'Ein neues Bewertungs-Archiv erstellen'];
$arrLang['show']       = ['Bewertungs-Archiv Details', 'Die Details von Bewertungs-Archiv ID %s anzeigen'];
$arrLang['edit']       = ['Bewertungs-Archiv bearbeiten', 'Bewertungs-Archiv ID %s bearbeiten'];
$arrLang['editheader'] = ['Bewertungs-Archiv Einstellungen bearbeiten', 'Einstellungen von Bewertungs-Archiv ID %s bearbeiten'];
$arrLang['copy']       = ['Bewertungs-Archiv duplizieren', 'Bewertungs-Archiv ID %s duplizieren'];
$arrLang['delete']     = ['Bewertungs-Archiv löschen', 'Bewertungs-Archiv ID %s löschen'];
