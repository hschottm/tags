<?php
/**
 * TL_ROOT/system/modules/tags/languages/de/tl_module.php
 *
 * Contao extension: tags
 * German translation file
 *
 * Copyright : &copy; Helmut Schottmüller
 * License   : GNU Lesser Public License (LGPL)
 * Author    : Helmut Schottmüller (hschottm), https://github.com/hschottm
 * Translator: Helmut Schottmüller (hschottm), https://github.com/hschottm
 *
 * This file was created automatically be the Contao extension repository translation module.
 * Do not edit this file manually. Contact the author or translator for this module to establish
 * permanent text corrections which are update-safe.
 */

$GLOBALS['TL_LANG']['tl_module']['tag_jumpTo']['0'] = "Weiterleitung zu Seite";
$GLOBALS['TL_LANG']['tl_module']['tag_jumpTo']['1'] = "Mit dieser Einstellung legen Sie fest, auf welche Seite ein Benutzer nach dem Anklicken einer Auszeichnung weitergeleitet wird.";
$GLOBALS['TL_LANG']['tl_module']['tag_forTable']['0'] = "Einschränkung auf Tabelle(n)";
$GLOBALS['TL_LANG']['tl_module']['tag_forTable']['1'] = "Wählen Sie bitte die Tabellen aus, auf die die Auswahl der Auszeichnungen beschränkt werden soll. Diese Einstellung wird nur verwendet, wenn Sie die vordefinierte Tabelle <em>tl_tag</em> zum Speichern von Auszeichnungen verwenden.";
$GLOBALS['TL_LANG']['tl_module']['tag_tagtable']['0'] = "Quell-Tabelle für Auszeichnungen";
$GLOBALS['TL_LANG']['tl_module']['tag_tagtable']['1'] = "Geben Sie bitte den Namen einer Tabelle an, von der die gespeicherten Auszeichnungen abgerufen werden können. Der Standard ist die vordefinierte Tabelle <em>tl_tag</em>.";
$GLOBALS['TL_LANG']['tl_module']['tag_tagfield']['0'] = "Tabellenfeld für Auszeichnungen";
$GLOBALS['TL_LANG']['tl_module']['tag_tagfield']['1'] = "Geben Sie bitte den Namen eines Tabellenfeldes an, aus dem die Auswahl der Auszeichnungen generiert werden soll. Der Standard ist das vordefinierte Tabellenfeld <em>tag</em>.";
$GLOBALS['TL_LANG']['tl_module']['tag_filter']['0'] = "Auszeichnungs-Filter";
$GLOBALS['TL_LANG']['tl_module']['tag_filter']['1'] = "Geben Sie eine kommagetrennte Liste von Auszeichnungen an, um die Ausgabe des Moduls auf Nachrichtenbeiträge mit den angegebenen Auszeichnungen einzuschränken.";
$GLOBALS['TL_LANG']['tl_module']['tag_maxtags']['0'] = "Maximale Anzahl von Auszeichnungen";
$GLOBALS['TL_LANG']['tl_module']['tag_maxtags']['1'] = "Geben Sie eine maximale Anzahl von Auszeichnungen an, die in der Tag Cloud angezeigt werden sollen. Sind mehr Auszeichnungen vorhanden als angezeigt werden dürfen, dann werden die Auszeichnungen die am wenigsten vorkommen aus der Liste entfernt. Wenn 0 oder kein Wert angegeben wird, werden alle Auszeichnungen angezeigt.";
$GLOBALS['TL_LANG']['tl_module']['tag_buckets']['0'] = "Anzahl der Auszeichnungsgrößen";
$GLOBALS['TL_LANG']['tl_module']['tag_buckets']['1'] = "Geben Sie die Anzahl der Auszeichnungsgrößen für das Frontend an. Jede Auszeichnungsgröße stellt eine Formatierungsmöglichkeit für eine Klasse von Auszeichnungen an. Die Auszeichnungsgrößen werden als CSS-Selektoren size1, size2, size3 ... size<em>n</em> angegeben.";
$GLOBALS['TL_LANG']['tl_module']['tag_named_class']['0'] = "Auszeichnungs-Klassennamen verwenden";
$GLOBALS['TL_LANG']['tl_module']['tag_named_class']['1'] = "Fügt einen zusätzlichen CSS Klassennamen für jede Auszeichnung hinzu, der aus dem Namen der jeweiligen Auszeichnung besteht. Damit können einzelne Auszeichnungen individuell per CSS angepasst werden. Leerzeichen in den Auszeichnungsnamen werden für die CSS-Klassennamen in Unterstriche umgewandelt.";
$GLOBALS['TL_LANG']['tl_module']['tag_on_page_class']['0'] = "Auszeichnung auf aktueller Seite";
$GLOBALS['TL_LANG']['tl_module']['tag_on_page_class']['1'] = "Fügt einen zusätzlichen CSS Klassennamen ('here') für jede Auszeichnung hinzu, die auf der aktuellen Seite vergeben wurde.";
$GLOBALS['TL_LANG']['tl_module']['tag_topten']['0'] = "Top Auszeichnungen";
$GLOBALS['TL_LANG']['tl_module']['tag_topten']['1'] = "Die Top Auszeichnungen über der Tag Cloud ausgeben.";
$GLOBALS['TL_LANG']['tl_module']['tag_topten_number']['0'] = "Anzahl der Top Auszeichnungen";
$GLOBALS['TL_LANG']['tl_module']['tag_topten_number']['1'] = "Geben Sie an, welche maximale Anzahl der am häufigsten verwendeten Auszeichnungen ausgegeben werden soll.";
$GLOBALS['TL_LANG']['tl_module']['tag_topten_expanded']['0'] = "Top Auszeichnungen sind aufgeklappt";
$GLOBALS['TL_LANG']['tl_module']['tag_topten_expanded']['1'] = "Die Tag Cloud mit den Top Auszeichnungen ist aufgeklappt, d.h. alle drin enthaltenen Auszeichnungen sind sichtbar.";
$GLOBALS['TL_LANG']['tl_module']['tag_all_expanded']['0'] = "Alle Auszeichnungen sind aufgeklappt";
$GLOBALS['TL_LANG']['tl_module']['tag_all_expanded']['1'] = "Die Tag Cloud mit den allen Auszeichnungen ist aufgeklappt, d.h. alle drin enthaltenen Auszeichnungen sind sichtbar.";
$GLOBALS['TL_LANG']['tl_module']['tag_related']['0'] = "Zugehörige Auszeichnungen";
$GLOBALS['TL_LANG']['tl_module']['tag_related']['1'] = "Wählen Sie diese Option aus, um bei einer ausgewählten Auszeichnung die zu dieser Auszeichnung zugehörigen Auszeichnungen in einer Liste anzuzeigen.";
$GLOBALS['TL_LANG']['tl_module']['news_showtags']['0'] = "Nachrichten-Auszeichnungen anzeigen";
$GLOBALS['TL_LANG']['tl_module']['news_showtags']['1'] = "Wählen Sie diese Option aus, um die zu einer Nachricht zugehörigen Auszeichnungen unterhalb der Nachricht anzuzeigen. Die Option ist nur dann wirksam, wenn Sie ein Template verwenden, das für die Anzeige von Auszeichnungen geeignet ist, z.B. news_full_tags.";
$GLOBALS['TL_LANG']['tl_module']['event_showtags']['0'] = "Ereignis-Auszeichnungen anzeigen";
$GLOBALS['TL_LANG']['tl_module']['event_showtags']['1'] = "Wählen Sie diese Option aus, um die zu einem Ereignis zugehörigen Auszeichnungen unterhalb des Ereignisses anzuzeigen. Die Option ist nur dann wirksam, wenn Sie ein Template verwenden, das für die Anzeige von Auszeichnungen geeignet ist, z.B. event_..._tags.";
$GLOBALS['TL_LANG']['tl_module']['tag_ignore']['0'] = "Auszeichnungen ignorieren";
$GLOBALS['TL_LANG']['tl_module']['tag_ignore']['1'] = "Das Modul ignoriert alle Auszeichnungen (z.B. die Filterung von Nachrichtenlisten nach Tags)";
$GLOBALS['TL_LANG']['tl_module']['keep_url_params']['0'] = "URL-Parameter erhalten";
$GLOBALS['TL_LANG']['tl_module']['keep_url_params']['1'] = "Contao-spezifische URL-Parameter (z.B. Datumsangaben für Nachrichtenarchive) in den Tag Cloud Links erhalten";
$GLOBALS['TL_LANG']['tl_module']['objecttype']['0'] = "Objekttyp";
$GLOBALS['TL_LANG']['tl_module']['objecttype']['1'] = "Bitte wählen Sie den Objekttyp aus, der angezeigt werden soll.";
$GLOBALS['TL_LANG']['tl_module']['tagsource']['0'] = "Einschränkung auf Datenquelle";
$GLOBALS['TL_LANG']['tl_module']['tagsource']['1'] = "Wählen Sie bitte die Tabelle aus, auf die die Auswahl der Auszeichnungen beschränkt werden soll.";
$GLOBALS['TL_LANG']['tl_module']['pagesource']['0'] = "Seiten";
$GLOBALS['TL_LANG']['tl_module']['pagesource']['1'] = "Bitte wählen Sie die Seite aus, die zur Erstellung der Objektliste verwendet werden soll. Wenn die Seite Unterseiten besitzt, so werden diese ebenfalls für die Generierung der Objektliste verwendet.";
$GLOBALS['TL_LANG']['tl_module']['hide_on_empty']['0'] = "Immer nach Auszeichnungen filtern";
$GLOBALS['TL_LANG']['tl_module']['hide_on_empty']['1'] = "Die globale Artikelliste erwartet immer mindestens eine Auszeichnung zur Filterung. Ohne eine angegebene Auszeichnung wird eine leere Liste ausgegeben.";
$GLOBALS['TL_LANG']['tl_module']['articlelist_template']['0'] = "Artikellisten-Template";
$GLOBALS['TL_LANG']['tl_module']['articlelist_template']['1'] = "Hier können Sie das Artikellisten-Template auswählen.";
$GLOBALS['TL_LANG']['tl_module']['cloud_template']['0'] = "Tag Cloud Template";
$GLOBALS['TL_LANG']['tl_module']['cloud_template']['1'] = "Hier können Sie das Tag Cloud Template auswählen.";
$GLOBALS['TL_LANG']['tl_module']['scope_template']['0'] = "Template für verwendete Auszeichnungen";
$GLOBALS['TL_LANG']['tl_module']['scope_template']['1'] = "Hier können Sie das Template für verwendete Auszeichnungen auswählen.";
$GLOBALS['TL_LANG']['tl_module']['clear_text']['0'] = "Titel der verwendeten Auszeichnungen";
$GLOBALS['TL_LANG']['tl_module']['clear_text']['1'] = "Bitte geben Sie einen Titel für die verwendeten Auszeichnungen ein. Der Titel dient zugleich als Hyperlink, um alle aktuell gesetzten Auszeichnungen zu entfernen.";
$GLOBALS['TL_LANG']['tl_module']['show_empty_scope']['0']  = 'Verwendete Auszeichnungen immer anzeigen';
$GLOBALS['TL_LANG']['tl_module']['show_empty_scope']['1']  = 'Zeigt die verwendeten Auszeichnungen auch dann an, wenn keine Auszeichnungen ausgewählt sind.';
$GLOBALS['TL_LANG']['tl_module']['tag_show_reset']['0']  = 'Auszeichnungen zurücksetzen';
$GLOBALS['TL_LANG']['tl_module']['tag_show_reset']['1']  = 'Bietet einen Hyperlink an, mit dem man die ausgewählten Auszeichnungen zurücksetzen kann.';
$GLOBALS['TL_LANG']['tl_module']['tag_alltags'] = "Alle Auszeichnungen";
$GLOBALS['TL_LANG']['tl_module']['tag_relatedtags'] = "Zugehörige Auszeichnungen";
$GLOBALS['TL_LANG']['tl_module']['tl_content'] = "Inhaltselemente";
$GLOBALS['TL_LANG']['tl_module']['tl_article'] = "Artikel";
$GLOBALS['TL_LANG']['tl_module']['tl_news'] = "Nachrichtenbeiträge";
$GLOBALS['TL_LANG']['tl_module']['tl_calendar_events'] = "Termine";
$GLOBALS['TL_LANG']['tl_module']['tl_page'] = "Seiten";
$GLOBALS['TL_LANG']['tl_module']['showtags_legend'] = "Tags-Einstellungen";
$GLOBALS['TL_LANG']['tl_module']['size_legend'] = "Anzahl und Größeneinstellungen";
$GLOBALS['TL_LANG']['tl_module']['tagextension_legend'] = "Zusätzliche Tag-Listen";
$GLOBALS['TL_LANG']['tl_module']['datasource_legend'] = "Datenquellen-Einstellungen";
$GLOBALS['TL_LANG']['tl_module']['tagscope_legend'] = "Einstellungen für verwendete Auszeichnungen";
$GLOBALS['TL_LANG']['tl_module']['tag_clear_tags'] = "Ausgewählte Auszeichnungen zurücksetzen";
$GLOBALS['TL_LANG']['tl_module']['object_selection_legend'] = "Objekttypen";
$GLOBALS['TL_LANG']['tl_module']['tags'] = "Auszeichnungen";
$GLOBALS['TL_LANG']['tl_module']['top_tags'] = 'Top %s Auszeichnungen';

// articles

$GLOBALS['TL_LANG']['tl_module']['tag_articles']['0'] = "Artikel";
$GLOBALS['TL_LANG']['tl_module']['tag_articles']['1'] = "Bitte wählen Sie die Seite aus, deren Artikel zur Erstellung der Tag Cloud verwendet werden sollen. Wenn die Seite Unterseiten besitzt, so werden diese Artikel ebenfalls für die Generierung der Tag Cloud verwendet.";
$GLOBALS['TL_LANG']['tl_module']['show_in_column']['0'] = "Auswahl auf eine bestimmt Spalte einschränken";
$GLOBALS['TL_LANG']['tl_module']['show_in_column']['1'] = "Schränken Sie die Auswahl der Artikelliste auf Artikel aus einer bestimmten Spalte eines Seitentemplates ein.";
$GLOBALS['TL_LANG']['tl_module']['linktoarticles']['0'] = "Weiterführende Links auf Artikel";
$GLOBALS['TL_LANG']['tl_module']['linktoarticles']['1'] = "Wählen Sie diese Option, wenn die weiterführenden Links der Artikelliste auf die Artikel verweisen sollen oder entfernen Sie diese Option, um auf die beinhaltenden Seiten der Artikel zu verweisen.";
$GLOBALS['TL_LANG']['tl_module']['restrict_to_column']['0'] = "Auswahl auf eine bestimmt Spalte einschränken";
$GLOBALS['TL_LANG']['tl_module']['restrict_to_column']['1'] = "Schränken Sie die Tag Cloud auf Tags von Artikeln aus einer bestimmten Spalte eines Seitentemplates ein.";
$GLOBALS['TL_LANG']['tl_module']['articlelist_tpl']['0'] = "Artikellisten-Template";
$GLOBALS['TL_LANG']['tl_module']['articlelist_tpl']['1'] = "Hier können Sie das Artikellisten-Template auswählen.";
$GLOBALS['TL_LANG']['tl_module']['article_showtags']['0'] = "Artikel-Auszeichnungen anzeigen";
$GLOBALS['TL_LANG']['tl_module']['article_showtags']['1'] = "Wählen Sie diese Option aus, um die zu einem Artikel zugehörigen Auszeichnungen unter dem Artikel anzuzeigen. Diese Einstellung funktioniert nur, wenn Sie ein Artikel-Template verwenden, das für die Ausgabe von Auszeichnungen vorgesehen wurde, wie z.B. mod_global_articlelist";
$GLOBALS['TL_LANG']['tl_module']['articlelist_firstorder'] = array('Erstes Sortierkriterium', 'Wählen Sie das erste Sortierkriterium für die Artikelliste aus.');
$GLOBALS['TL_LANG']['tl_module']['articlelist_secondorder'] = array('Zweites Sortierkriterium', 'Wählen Sie das zweite Sortierkriterium für die Artikelliste aus.');

// content

$GLOBALS['TL_LANG']['tl_module']['tag_content_pages']['0'] = "Seiten";
$GLOBALS['TL_LANG']['tl_module']['tag_content_pages']['1'] = "Bitte wählen Sie die Seite aus, deren Inhaltselemente zur Erstellung der Tag Cloud verwendet werden sollen. Wenn die Seite Unterseiten besitzt, so werden diese Inhaltselemente ebenfalls für die Generierung der Tag Cloud verwendet.";

// events

$GLOBALS['TL_LANG']['tl_module']['tag_calendars']['0'] = "Kalender";
$GLOBALS['TL_LANG']['tl_module']['tag_calendars']['1'] = "Bitte wählen Sie die Kalender aus, die für die Anzeige der Tag Cloud verwendet werden sollen.";

// members

$GLOBALS['TL_LANG']['tl_module']['tag_membergroups']['0'] = "Mitgliedergruppen";
$GLOBALS['TL_LANG']['tl_module']['tag_membergroups']['1'] = "Bitte wählen Sie eine oder mehrere Mitgliedergruppen aus, aus denen die Tag Cloud erzeugt werden soll.";

// news

$GLOBALS['TL_LANG']['tl_module']['tag_news_archives']['0'] = "Einschränkung auf Nachrichtenarchive";
$GLOBALS['TL_LANG']['tl_module']['tag_news_archives']['1'] = "Wählen Sie bitte die Nachrichtenarchive aus, deren Auszeichnungen für die Tag Cloud verwendet werden sollen.";

?>
