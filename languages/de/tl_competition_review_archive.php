<?php

$arrLang = &$GLOBALS['TL_LANG']['tl_competition_review_archive'];

/**
 * Fields
 */
$arrLang['title'] 		= array('Titel', 'Der Titel des Bewertungs-Archivs');
$arrLang['memberGroups'] = array('Mitgliedergruppen', 'Wählen Sie hier die Mitgliedergruppen aus, die einem Mitglied ermöglichen, in diesem Archiv Bewertungen zu erstellen. Um keine Einschränkung zu machen, lassen Sie dieses Feld bitte leer.');
$arrLang['submissionArchives'] = array('Bewerbungsarchive', 'Wählen Sie hier die Bewerbungsarchive aus, deren Bewerbungen in diesem Archiv Bewertungen zu erhalten können. Um keine Einschränkung zu machen, lassen Sie dieses Feld bitte leer.');
$arrLang['addPdfExport']				= array('PDF-Export hinzufügen', 'Aktiviert den PDF-Export');
$arrLang['addPdfCover']					= array('PDF-Deckblatt hinzufügen', 'Fügt dem PDF ein Deckblatt hinzu.');
$arrLang['pdfCoverBackground']			= array('PDF-Hintergrund Beckblatt', 'Wählen Sie hier ein PDF-Template als grafisches Grundgerüst für das Deckblatt.');
$arrLang['pdfCoverTemplate']			= array('PDF-Vorlage Deckblatt', 'Wählen Sie hier ein Template für das Deckblatt');
$arrLang['pdfBackground']				= array('PDF-Hintergrund', 'Wählen Sie hier ein PDF-Template als grafisches Grundgerüst.');
$arrLang['pdfTemplate']					= array('PDF-Vorlage', 'Wählen Sie hier ein Template für die PDF.');
$arrLang['pdfFonts']					= array('PDF-Fonts', 'Wählen Sie hier die Fonts, welche im PDF verwendet werden sollen.');
$arrLang['pdfMargins']					= array('PDF-Margins', 'Wählen Sie hier die Seitenabstände, welche im PDF verwendet werden sollen.');
$arrLang['pdfExportFileNamePrefix']		= array('Prefix für Dateiname', 'Geben Sie hier den Prefix ein, der dem Dateinamen hinzugefügt werden soll.');
$arrLang['pdfExportDir']				= array('Exportverzeichnis', 'Wählen Sie hier das Verzeichnis aus, dem die exportierten Dateien hinzugefügt werden sollen.');
$arrLang['pdfExportUseHomeDir']			= array('Benutzerverzeichnisse verwenden', 'Wählen Sie diese Option, wenn die exportierten Dateien vorrangig dem Benutzerverzeichnis hinzugefügt werden sollen. Hat das aktuell eingeloggte Mitglied kein Benutzerverzeichnis, wird das Exportverzeichnis genutzt.');
$arrLang['pdfExportUseProtectedHomeDir']= array('Geschützte Benutzerverzeichnisse verwenden', 'Wählen Sie diese Option, wenn die exportierten Dateien vorrangig dem geschützten Benutzerverzeichnis, dann dem normalen und dann dem Exportverzeichnis hinzugefügt werden sollen.');
$arrLang['pdfExportFileTitle']			= array('Meta Titel', 'Hier können Sie den Titel für das Dokument angeben.');
$arrLang['pdfExportFileSubject']		= array('Meta Thema', 'Hier können Sie das Thema für das Dokument angeben.');
$arrLang['pdfExportFileCreator']		= array('Meta Ersteller/Autor', 'Hier können Sie den Ersteller/Autor für das Dokument angeben.');
$arrLang['pdfSkipLabels']				= array('Labels überspringen', 'Geben Sie hier die Labels an, die im PDF nicht ausgegeben werden sollen.');
$arrLang['pdfExportFields']				= array('Zu exportierende Felder', 'Wählen Sie hier die Felder aus, welche im PDF erscheinen sollen.');

/**
 * Legends
 */
$arrLang['cover_legend'] = 'PDF - Layout - Deckblatt';
$arrLang['config_legend'] = 'PDF - Layout - Konfiguration';
$arrLang['exportFile_legend'] = 'PDF - Export - Dateikonfiguration';
$arrLang['exportForApplicant_legend'] = 'PDF - Export - Bewerber';


/**
 * Buttons
 */
$arrLang['new']			= array('Neues Bewertungs-Archiv', 'Ein neues Bewertungs-Archiv erstellen');
$arrLang['show']		= array('Bewertungs-Archiv Details', 'Die Details von Bewertungs-Archiv ID %s anzeigen');
$arrLang['edit']		= array('Bewertungs-Archiv bearbeiten', 'Bewertungs-Archiv ID %s bearbeiten');
$arrLang['editheader']	= array('Bewertungs-Archiv Einstellungen bearbeiten', 'Einstellungen von Bewertungs-Archiv ID %s bearbeiten');
$arrLang['copy']		= array('Bewertungs-Archiv duplizieren', 'Bewertungs-Archiv ID %s duplizieren');
$arrLang['delete']		= array('Bewertungs-Archiv löschen', 'Bewertungs-Archiv ID %s löschen');
