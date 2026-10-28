<?php

/**
 * TYPOlight webCMS
 * Copyright (C) 2005 Leo Feyer
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at http://www.gnu.org/licenses/.
 *
 * PHP version 5
 * @copyright  Helmut Schottmüller 2008-2010
 * @author     Helmut Schottmüller <https://github.com/hschottm>
 * @package    tags
 * @license    LGPL
 * @filesource
 */

$GLOBALS['TL_LANG']['tl_module']['tag_jumpTo'][0] = 'Ga naar pagina';
$GLOBALS['TL_LANG']['tl_module']['tag_jumpTo'][1] = 'Deze instelling bepaalt naar welke pagina een gebruiker wordt doorgestuurd wanneer hij op een taglink klikt.';
$GLOBALS['TL_LANG']['tl_module']['tag_forTable'][0] = 'Label tafels';
$GLOBALS['TL_LANG']['tl_module']['tag_forTable'][1] = 'Selecteer de tabellen die worden gebruikt om de tagwolk weer te geven. Deze selectie is alleen geldig als u de vooraf gedefinieerde tabel <em>tl_tag</em> gebruikt om de tags op te slaan.';
$GLOBALS['TL_LANG']['tl_module']['tag_tagtable'][0] = 'Tagbrontabel';
$GLOBALS['TL_LANG']['tl_module']['tag_tagtable'][1] = 'Voer de naam in van de brontabel waarin de tags te vinden zijn. Dit veld is standaard ingesteld op de vooraf gedefinieerde tabel <em>tl_tag</em>.';
$GLOBALS['TL_LANG']['tl_module']['tag_tagfield'][0] = 'Tabelveld met tags';
$GLOBALS['TL_LANG']['tl_module']['tag_tagfield'][1] = 'Voer de naam in van het tabelveld dat de tags bevat. Dit veld heeft standaard de vooraf gedefinieerde veldnaam <em>tag</em>.';
$GLOBALS['TL_LANG']['tl_module']['tag_filter'][0] = 'Tagfilter';
$GLOBALS['TL_LANG']['tl_module']['tag_filter'][1] = 'Voer een door komma\'s gescheiden lijst met tags in om de uitvoer van de module te filteren.';
$GLOBALS['TL_LANG']['tl_module']['tag_maxtags'][0] = 'Maximaal aantal tags';
$GLOBALS['TL_LANG']['tl_module']['tag_maxtags'][1] = 'Voer het maximale aantal tags in de tagwolk in. Als de tagwolk meer tags bevat dan het maximale aantal tags, worden de tags met het kleinste aantal treffers uit de cloud verwijderd. Als u geen waarde invoert of de waarde is 0, worden alle tags weergegeven.';
$GLOBALS['TL_LANG']['tl_module']['tag_buckets'][0] = 'Aantal tagformaten';
$GLOBALS['TL_LANG']['tl_module']['tag_buckets'][1] = 'Voer het aantal tagformaten in de frontend in. Elke groep tags krijgt zijn eigen taggrootte in de frontend. De taggroottes worden weergegeven als CSS-kiezers size1, size2, size3 ... size<em>n</em>.';
$GLOBALS['TL_LANG']['tl_module']['tag_named_class'][0] = 'Gebruik tag klassenaam';
$GLOBALS['TL_LANG']['tl_module']['tag_named_class'][1] = 'Voegt een extra CSS-klasseklasse toe voor elke tag die de tagnaam bevat. Gebruik deze extra klassenaam voor extra styling van tags via CSS. Spaties in de tagnamen worden vervangen door onderstrepingstekens in de CSS-klassenamen.';
$GLOBALS['TL_LANG']['tl_module']['tag_on_page_class'][0] = 'Tag bestaat op pagina';
$GLOBALS['TL_LANG']['tl_module']['tag_on_page_class'][1] = 'Voegt een extra CSS-klasse toe (\'hier\') voor elke tag die aan de daadwerkelijke pagina is toegewezen.';
$GLOBALS['TL_LANG']['tl_module']['tag_topten'][0] = 'Toptags';
$GLOBALS['TL_LANG']['tl_module']['tag_topten'][1] = 'Toon de Top Tags boven de tagwolk.';
$GLOBALS['TL_LANG']['tl_module']['tag_topten_expanded'][0] = 'Vouw Toptags uit';
$GLOBALS['TL_LANG']['tl_module']['tag_topten_expanded'][1] = 'Vouw de tagwolk Top Tags uit. Alle tags in deze cloud zijn zichtbaar.';
$GLOBALS['TL_LANG']['tl_module']['tag_topten_number'][0] = 'Aantal toptags';
$GLOBALS['TL_LANG']['tl_module']['tag_topten_number'][1] = 'Voer het maximale aantal in dat voor de Top Tags mag worden gebruikt.';
$GLOBALS['TL_LANG']['tl_module']['tag_all_expanded'][0] = 'Vouw alle tags uit';
$GLOBALS['TL_LANG']['tl_module']['tag_all_expanded'][1] = 'Vouw de tagwolk \'Alle tags\' uit. Alle tags in deze cloud zijn zichtbaar.';
$GLOBALS['TL_LANG']['tl_module']['tag_related'][0] = 'Toon gerelateerde tags';
$GLOBALS['TL_LANG']['tl_module']['tag_related'][1] = 'Selecteer deze optie om alle gerelateerde tags van een eerder geselecteerde tag weer te geven.';
$GLOBALS['TL_LANG']['tl_module']['news_showtags'][0] = 'Toon nieuwstags';
$GLOBALS['TL_LANG']['tl_module']['news_showtags'][1] = 'Selecteer deze optie om alle toegewezen tags onder elk nieuwsbericht weer te geven. Dit werkt alleen als u een nieuwssjabloon met tagfunctie gebruikt, b.v. nieuws_volledige_tags';
$GLOBALS['TL_LANG']['tl_module']['event_showtags'][0] = 'Toon gebeurtenistags';
$GLOBALS['TL_LANG']['tl_module']['event_showtags'][1] = 'Selecteer deze optie om alle toegewezen tags onder elke gebeurtenis weer te geven. Dit werkt alleen als u een gebeurtenissjabloon met tagfunctie gebruikt, b.v. gebeurtenis_..._tags';
$GLOBALS['TL_LANG']['tl_module']['tag_ignore'][0] = 'Negeer tags';
$GLOBALS['TL_LANG']['tl_module']['tag_ignore'][1] = 'Forceer deze module om tag-gerelateerde acties te negeren (bijvoorbeeld alleen nieuwsitems van een bepaalde tag tonen)';
$GLOBALS['TL_LANG']['tl_module']['keep_url_params'][0] = 'Bewaar URL-parameters';
$GLOBALS['TL_LANG']['tl_module']['keep_url_params'][1] = 'Bewaar Contao-specifieke URL-parameters (bijvoorbeeld datumparameters van nieuwsarchieven) in de taglinks';
$GLOBALS['TL_LANG']['tl_module']['objecttype'][0] = 'Objecttype';
$GLOBALS['TL_LANG']['tl_module']['objecttype'][1] = 'Selecteer het type object dat in deze lijst moet worden weergegeven.';
$GLOBALS['TL_LANG']['tl_module']['tagsource'][0] = 'Tagbron';
$GLOBALS['TL_LANG']['tl_module']['tagsource'][1] = 'Selecteer de tabel die wordt gebruikt om de taglijst in deze module samen te stellen.';
$GLOBALS['TL_LANG']['tl_module']['pagesource'][0] = 'Pagina\'s';
$GLOBALS['TL_LANG']['tl_module']['pagesource'][1] = 'Selecteer de pagina\'s die worden gebruikt om de objectenlijst samen te stellen. Als u een pagina selecteert die subpagina\'s bevat, worden alle subpagina\'s ook gebruikt.';
$GLOBALS['TL_LANG']['tl_module']['articlelist_template'][0] = 'Artikellijstsjabloon';
$GLOBALS['TL_LANG']['tl_module']['articlelist_template'][1] = 'Hier kunt u het artikellijstsjabloon selecteren.';
$GLOBALS['TL_LANG']['tl_module']['cloud_template'][0] = 'Tagwolk-sjabloon';
$GLOBALS['TL_LANG']['tl_module']['cloud_template'][1] = 'Hier kunt u de tagwolk-sjabloon selecteren.';
$GLOBALS['TL_LANG']['tl_module']['scope_template'][0] = 'Sjabloon voor tagbereik';
$GLOBALS['TL_LANG']['tl_module']['scope_template'][1] = 'Hier kunt u de tagbereiksjabloon selecteren.';
$GLOBALS['TL_LANG']['tl_module']['clear_text'][0] = 'Titel van tagbereik';
$GLOBALS['TL_LANG']['tl_module']['clear_text'][1] = 'Voer een titel in voor het tagbereik. De titel is een hyperlink die het tagbereik wist en alle geselecteerde tags verwijdert.';
$GLOBALS['TL_LANG']['tl_module']['show_empty_scope'][0] = 'Toon leeg bereik';
$GLOBALS['TL_LANG']['tl_module']['show_empty_scope'][1] = 'Toon het tagbereik, zelfs als er geen actieve tags zijn.';
$GLOBALS['TL_LANG']['tl_module']['tag_show_reset'][0] = 'Toon duidelijke optie';
$GLOBALS['TL_LANG']['tl_module']['tag_show_reset'][1] = 'Toon een hyperlink om alle geselecteerde tags te wissen.';
$GLOBALS['TL_LANG']['tl_module']['hide_on_empty'][0] = 'Alleen gefilterde uitvoer';
$GLOBALS['TL_LANG']['tl_module']['hide_on_empty'][1] = 'De globale artikellijst verwacht altijd dat een of meer tags een gefilterde uitvoer produceren. Zonder tagfilter wordt een lege lijst weergegeven.';
$GLOBALS['TL_LANG']['tl_module']['tag_alltags'] = 'Alle labels';
$GLOBALS['TL_LANG']['tl_module']['tag_relatedtags'] = 'Gerelateerde tags';
$GLOBALS['TL_LANG']['tl_module']['tl_content'] = 'Inhoudselementen';
$GLOBALS['TL_LANG']['tl_module']['tl_article'] = 'Artikelen';
$GLOBALS['TL_LANG']['tl_module']['tl_news'] = 'Nieuwsartikelen';
$GLOBALS['TL_LANG']['tl_module']['tag_clear_tags'] = 'Wis geselecteerde tags';
$GLOBALS['TL_LANG']['tl_module']['tl_calendar_events'] = 'Evenementen';
$GLOBALS['TL_LANG']['tl_module']['tl_page'] = 'Pagina\'s';
$GLOBALS['TL_LANG']['tl_module']['tags'] = 'Labels';
$GLOBALS['TL_LANG']['tl_module']['top_tags'] = 'Top %s-tags';
$GLOBALS['TL_LANG']['tl_module']['showtags_legend'] = 'Tags-instellingen';
$GLOBALS['TL_LANG']['tl_module']['tagscope_legend'] = 'Instellingen voor tagbereik';
$GLOBALS['TL_LANG']['tl_module']['size_legend'] = 'Aantal- en maatinstellingen';
$GLOBALS['TL_LANG']['tl_module']['tagextension_legend'] = 'Extra taglijsten';
$GLOBALS['TL_LANG']['tl_module']['datasource_legend'] = 'Gegevensbroninstellingen';
$GLOBALS['TL_LANG']['tl_module']['object_selection_legend'] = 'Objecttypen';
$GLOBALS['TL_LANG']['tl_module']['tag_articles'][0] = 'Artikelen';
$GLOBALS['TL_LANG']['tl_module']['tag_articles'][1] = 'Selecteer de pagina\'s waarvan hun artikelen worden gebruikt om de tagwolk op te bouwen. Als u een pagina aanvinkt die subpagina\'s bevat, worden de artikelen van alle subpagina\'s ook gebruikt.';
$GLOBALS['TL_LANG']['tl_module']['show_in_column'][0] = 'Beperken tot specifieke kolom';
$GLOBALS['TL_LANG']['tl_module']['show_in_column'][1] = 'Beperk de uitvoer van de artikellijst tot een specifieke kolom van het paginasjabloon.';
$GLOBALS['TL_LANG']['tl_module']['linktoarticles'][0] = 'Artikellijstlinks naar artikelen';
$GLOBALS['TL_LANG']['tl_module']['linktoarticles'][1] = 'Vink dit aan om een ​​artikellijst te maken met links naar het artikel of verwijder het vinkje om een ​​artikellijst te maken met links naar de betreffende pagina.';
$GLOBALS['TL_LANG']['tl_module']['restrict_to_column'][0] = 'Beperken tot specifieke kolom';
$GLOBALS['TL_LANG']['tl_module']['restrict_to_column'][1] = 'Beperk de tagwolk tot tags van artikelen uit een specifieke kolom van de paginasjabloon.';
$GLOBALS['TL_LANG']['tl_module']['articlelist_tpl'][0] = 'Sjabloon voor artikellijst';
$GLOBALS['TL_LANG']['tl_module']['articlelist_tpl'][1] = 'Hier kunt u het artikellijstsjabloon selecteren.';
$GLOBALS['TL_LANG']['tl_module']['article_showtags'][0] = 'Toon artikeltags';
$GLOBALS['TL_LANG']['tl_module']['article_showtags'][1] = 'Selecteer deze optie om alle toegewezen tags onder elk artikel weer te geven. Dit werkt alleen als u een artikelsjabloon met tagfunctie gebruikt, b.v. mod_global_articlelist';
$GLOBALS['TL_LANG']['tl_module']['articlelist_firstorder'][0] = 'Eerste sorteercriteria';
$GLOBALS['TL_LANG']['tl_module']['articlelist_firstorder'][1] = 'Selecteer de eerste sorteercriteria voor de resulterende artikellijst.';
$GLOBALS['TL_LANG']['tl_module']['articlelist_secondorder'][0] = 'Tweede sorteercriteria';
$GLOBALS['TL_LANG']['tl_module']['articlelist_secondorder'][1] = 'Selecteer het tweede sorteercriterium voor de resulterende artikellijst.';
$GLOBALS['TL_LANG']['tl_module']['tag_content_pages'][0] = 'Pagina\'s';
$GLOBALS['TL_LANG']['tl_module']['tag_content_pages'][1] = 'Selecteer de pagina\'s waarvan de inhoudselementen worden gebruikt om de tagwolk samen te stellen. Als u een pagina selecteert die subpagina\'s bevat, worden de inhoudselementen van alle subpagina\'s ook gebruikt.';
$GLOBALS['TL_LANG']['tl_module']['tag_calendars'][0] = 'Kalenders';
$GLOBALS['TL_LANG']['tl_module']['tag_calendars'][1] = 'Selecteer de kalenders die worden gebruikt om de tagwolk samen te stellen.';
$GLOBALS['TL_LANG']['tl_module']['tag_membergroups'][0] = 'Ledengroepen';
$GLOBALS['TL_LANG']['tl_module']['tag_membergroups'][1] = 'Selecteer een of meer ledengroepen om de ledentagwolk samen te stellen.';
$GLOBALS['TL_LANG']['tl_module']['tag_news_archives'][0] = 'Nieuwsarchief';
$GLOBALS['TL_LANG']['tl_module']['tag_news_archives'][1] = 'Selecteer de nieuwsarchieven die worden gebruikt om de tagwolk op te bouwen.';
