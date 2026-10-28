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

$GLOBALS['TL_LANG']['tl_module']['tag_jumpTo'][0] = 'Hoppa till sidan';
$GLOBALS['TL_LANG']['tl_module']['tag_jumpTo'][1] = 'Den här inställningen definierar till vilken sida en användare kommer att omdirigeras när han klickar på en tagglänk.';
$GLOBALS['TL_LANG']['tl_module']['tag_forTable'][0] = 'Tagga tabeller';
$GLOBALS['TL_LANG']['tl_module']['tag_forTable'][1] = 'Välj de tabeller som används för att visa taggmolnet. Detta val är endast giltigt om du använder den fördefinierade <em>tl_tag</em>-tabellen för att lagra taggarna.';
$GLOBALS['TL_LANG']['tl_module']['tag_tagtable'][0] = 'Taggkälltabell';
$GLOBALS['TL_LANG']['tl_module']['tag_tagtable'][1] = 'Ange namnet på källtabellen där taggarna kan hittas. Detta fält har som standard den fördefinierade tabellen <em>tl_tag</em>.';
$GLOBALS['TL_LANG']['tl_module']['tag_tagfield'][0] = 'Taggtabellfält';
$GLOBALS['TL_LANG']['tl_module']['tag_tagfield'][1] = 'Ange namnet på tabellfältet som innehåller taggarna. Detta fält har som standard det fördefinierade fältnamnet <em>tag</em>.';
$GLOBALS['TL_LANG']['tl_module']['tag_filter'][0] = 'Taggfilter';
$GLOBALS['TL_LANG']['tl_module']['tag_filter'][1] = 'Ange en kommaseparerad lista med taggar för att filtrera utdata från modulen.';
$GLOBALS['TL_LANG']['tl_module']['tag_maxtags'][0] = 'Maximalt antal taggar';
$GLOBALS['TL_LANG']['tl_module']['tag_maxtags'][1] = 'Vänligen ange det maximala antalet taggar i taggmolnet. Om taggmolnet innehåller fler taggar än det maximala antalet taggar kommer taggarna med det minsta antalet träffar att tas bort från molnet. Om du inte anger ett värde eller om värdet är 0, kommer alla taggar att visas.';
$GLOBALS['TL_LANG']['tl_module']['tag_buckets'][0] = 'Antal etikettstorlekar';
$GLOBALS['TL_LANG']['tl_module']['tag_buckets'][1] = 'Vänligen ange antalet taggstorlekar i frontend. Varje grupp av taggar får sin egen taggstorlek i frontend. Taggstorlekarna kommer att ges som CSS-väljare size1, size2, size3 ... size<em>n</em>.';
$GLOBALS['TL_LANG']['tl_module']['tag_named_class'][0] = 'Använd taggen klassnamn';
$GLOBALS['TL_LANG']['tl_module']['tag_named_class'][1] = 'Lägger till ytterligare en CSS-klassklass för varje tagg som innehåller taggnamnet. Använd detta extra klassnamn för ytterligare styling av taggar via CSS. Mellanslag i taggnamnen kommer att ersättas med understreck i CSS-klassnamnen.';
$GLOBALS['TL_LANG']['tl_module']['tag_on_page_class'][0] = 'Taggen finns på sidan';
$GLOBALS['TL_LANG']['tl_module']['tag_on_page_class'][1] = 'Lägger till ytterligare en CSS-klass (\'här\') för varje tagg som har tilldelats den faktiska sidan.';
$GLOBALS['TL_LANG']['tl_module']['tag_topten'][0] = 'Topptaggar';
$GLOBALS['TL_LANG']['tl_module']['tag_topten'][1] = 'Visa topptaggarna ovanför taggmolnet.';
$GLOBALS['TL_LANG']['tl_module']['tag_topten_expanded'][0] = 'Expandera Top Tags';
$GLOBALS['TL_LANG']['tl_module']['tag_topten_expanded'][1] = 'Expandera taggmolnet för Top Tags. Alla taggar i detta moln är synliga.';
$GLOBALS['TL_LANG']['tl_module']['tag_topten_number'][0] = 'Antal topptaggar';
$GLOBALS['TL_LANG']['tl_module']['tag_topten_number'][1] = 'Ange det maximala antalet som ska användas för topptaggarna.';
$GLOBALS['TL_LANG']['tl_module']['tag_all_expanded'][0] = 'Expandera alla taggar';
$GLOBALS['TL_LANG']['tl_module']['tag_all_expanded'][1] = 'Expandera taggmolnet "Alla taggar". Alla taggar i detta moln är synliga.';
$GLOBALS['TL_LANG']['tl_module']['tag_related'][0] = 'Visa relaterade taggar';
$GLOBALS['TL_LANG']['tl_module']['tag_related'][1] = 'Välj det här alternativet för att visa alla relaterade taggar för en tidigare vald tagg.';
$GLOBALS['TL_LANG']['tl_module']['news_showtags'][0] = 'Visa nyhetstaggar';
$GLOBALS['TL_LANG']['tl_module']['news_showtags'][1] = 'Välj det här alternativet för att visa alla tilldelade taggar under varje nyhetsinlägg. Detta fungerar bara om du använder en taggaktiverad nyhetsmall, t.ex. news_full_tags';
$GLOBALS['TL_LANG']['tl_module']['event_showtags'][0] = 'Visa händelsetaggar';
$GLOBALS['TL_LANG']['tl_module']['event_showtags'][1] = 'Välj det här alternativet för att visa alla tilldelade taggar under varje händelse. Detta fungerar bara om du använder en taggaktiverad händelsemall, t.ex. händelse___taggar';
$GLOBALS['TL_LANG']['tl_module']['tag_ignore'][0] = 'Ignorera taggar';
$GLOBALS['TL_LANG']['tl_module']['tag_ignore'][1] = 'Tvinga den här modulen att ignorera taggrelaterade åtgärder (t.ex. visa bara nyhetsinlägg för en given tagg)';
$GLOBALS['TL_LANG']['tl_module']['keep_url_params'][0] = 'Behåll URL-parametrar';
$GLOBALS['TL_LANG']['tl_module']['keep_url_params'][1] = 'Behåll Contao-specifika URL-parametrar (t.ex. datumparametrar för nyhetsarkiv) i tagglänkarna';
$GLOBALS['TL_LANG']['tl_module']['objecttype'][0] = 'Objekttyp';
$GLOBALS['TL_LANG']['tl_module']['objecttype'][1] = 'Välj den typ av objekt som ska visas i den här listan.';
$GLOBALS['TL_LANG']['tl_module']['tagsource'][0] = 'Taggkälla';
$GLOBALS['TL_LANG']['tl_module']['tagsource'][1] = 'Välj den tabell som används för att bygga tagglistan i denna modul.';
$GLOBALS['TL_LANG']['tl_module']['pagesource'][0] = 'Sidor';
$GLOBALS['TL_LANG']['tl_module']['pagesource'][1] = 'Välj sidorna som används för att bygga objektlistan. Om du väljer en sida som innehåller undersidor kommer alla undersidor att användas också.';
$GLOBALS['TL_LANG']['tl_module']['articlelist_template'][0] = 'Artikellista mall';
$GLOBALS['TL_LANG']['tl_module']['articlelist_template'][1] = 'Här kan du välja mall för artikellista.';
$GLOBALS['TL_LANG']['tl_module']['cloud_template'][0] = 'Tagg moln mall';
$GLOBALS['TL_LANG']['tl_module']['cloud_template'][1] = 'Här kan du välja taggmolnsmallen.';
$GLOBALS['TL_LANG']['tl_module']['scope_template'][0] = 'Taggomfattningsmall';
$GLOBALS['TL_LANG']['tl_module']['scope_template'][1] = 'Här kan du välja taggomfattningsmall.';
$GLOBALS['TL_LANG']['tl_module']['clear_text'][0] = 'Tagg omfattning titel';
$GLOBALS['TL_LANG']['tl_module']['clear_text'][1] = 'Vänligen ange en titel för taggens omfattning. Titeln är en hyperlänk som rensar taggomfånget och tar bort alla markerade taggar.';
$GLOBALS['TL_LANG']['tl_module']['show_empty_scope'][0] = 'Visa tomt omfång';
$GLOBALS['TL_LANG']['tl_module']['show_empty_scope'][1] = 'Visa taggomfattningen även om det inte finns några aktiva taggar.';
$GLOBALS['TL_LANG']['tl_module']['tag_show_reset'][0] = 'Visa tydligt alternativ';
$GLOBALS['TL_LANG']['tl_module']['tag_show_reset'][1] = 'Visa en hyperlänk för att rensa alla markerade taggar.';
$GLOBALS['TL_LANG']['tl_module']['hide_on_empty'][0] = 'Endast filtrerad utgång';
$GLOBALS['TL_LANG']['tl_module']['hide_on_empty'][1] = 'Den globala artikellistan förväntar sig alltid att en eller flera taggar producerar en filtrerad utdata. Utan taggfilter visas en tom lista.';
$GLOBALS['TL_LANG']['tl_module']['tag_alltags'] = 'Alla taggar';
$GLOBALS['TL_LANG']['tl_module']['tag_relatedtags'] = 'Relaterade taggar';
$GLOBALS['TL_LANG']['tl_module']['tl_content'] = 'Innehållselement';
$GLOBALS['TL_LANG']['tl_module']['tl_article'] = 'Artiklar';
$GLOBALS['TL_LANG']['tl_module']['tl_news'] = 'Nyhetsartiklar';
$GLOBALS['TL_LANG']['tl_module']['tag_clear_tags'] = 'Rensa markerade taggar';
$GLOBALS['TL_LANG']['tl_module']['tl_calendar_events'] = 'Händelser';
$GLOBALS['TL_LANG']['tl_module']['tl_page'] = 'Sidor';
$GLOBALS['TL_LANG']['tl_module']['tags'] = 'Taggar';
$GLOBALS['TL_LANG']['tl_module']['top_tags'] = 'De bästa %s-taggarna';
$GLOBALS['TL_LANG']['tl_module']['showtags_legend'] = 'Taggar-inställningar';
$GLOBALS['TL_LANG']['tl_module']['tagscope_legend'] = 'Taggomfångsinställningar';
$GLOBALS['TL_LANG']['tl_module']['size_legend'] = 'Antal och storleksinställningar';
$GLOBALS['TL_LANG']['tl_module']['tagextension_legend'] = 'Ytterligare tagglistor';
$GLOBALS['TL_LANG']['tl_module']['datasource_legend'] = 'Inställningar för datakälla';
$GLOBALS['TL_LANG']['tl_module']['object_selection_legend'] = 'Objekttyper';
$GLOBALS['TL_LANG']['tl_module']['tag_articles'][0] = 'Artiklar';
$GLOBALS['TL_LANG']['tl_module']['tag_articles'][1] = 'Välj vilka sidor deras artiklar används för att bygga taggmolnet. Om du markerar en sida som innehåller undersidor, kommer även artiklarna på alla undersidor att användas.';
$GLOBALS['TL_LANG']['tl_module']['show_in_column'][0] = 'Begränsa till specifik kolumn';
$GLOBALS['TL_LANG']['tl_module']['show_in_column'][1] = 'Begränsa utmatningen av artikellistan till en specifik kolumn i sidmallen.';
$GLOBALS['TL_LANG']['tl_module']['linktoarticles'][0] = 'Artikellista länkar till artiklar';
$GLOBALS['TL_LANG']['tl_module']['linktoarticles'][1] = 'Markera för att skapa en artikellista med länkar till artikeln eller avmarkera för att skapa en artikellista med länkar till den innehållande sidan.';
$GLOBALS['TL_LANG']['tl_module']['restrict_to_column'][0] = 'Begränsa till specifik kolumn';
$GLOBALS['TL_LANG']['tl_module']['restrict_to_column'][1] = 'Begränsa taggmolnet till taggar för artiklar från en specifik kolumn i sidmallen.';
$GLOBALS['TL_LANG']['tl_module']['articlelist_tpl'][0] = 'Mall för artikellista';
$GLOBALS['TL_LANG']['tl_module']['articlelist_tpl'][1] = 'Här kan du välja mall för artikellista.';
$GLOBALS['TL_LANG']['tl_module']['article_showtags'][0] = 'Visa artikeltaggar';
$GLOBALS['TL_LANG']['tl_module']['article_showtags'][1] = 'Välj det här alternativet för att visa alla tilldelade taggar under varje artikel. Detta fungerar bara om du använder en taggaktiverad artikelmall, t.ex. mod_global_articlelist';
$GLOBALS['TL_LANG']['tl_module']['articlelist_firstorder'][0] = 'Första sorteringskriterier';
$GLOBALS['TL_LANG']['tl_module']['articlelist_firstorder'][1] = 'Välj det första sorteringskriteriet för den resulterande artikellistan.';
$GLOBALS['TL_LANG']['tl_module']['articlelist_secondorder'][0] = 'Andra sorteringskriterier';
$GLOBALS['TL_LANG']['tl_module']['articlelist_secondorder'][1] = 'Välj det andra sorteringskriteriet för den resulterande artikellistan.';
$GLOBALS['TL_LANG']['tl_module']['tag_content_pages'][0] = 'Sidor';
$GLOBALS['TL_LANG']['tl_module']['tag_content_pages'][1] = 'Välj vilka sidor deras innehållselement används för att bygga taggmolnet. Om du väljer en sida som innehåller undersidor kommer även innehållselementen på alla undersidor att användas.';
$GLOBALS['TL_LANG']['tl_module']['tag_calendars'][0] = 'Kalendrar';
$GLOBALS['TL_LANG']['tl_module']['tag_calendars'][1] = 'Välj de kalendrar som används för att bygga taggmolnet.';
$GLOBALS['TL_LANG']['tl_module']['tag_membergroups'][0] = 'Medlemsgrupper';
$GLOBALS['TL_LANG']['tl_module']['tag_membergroups'][1] = 'Välj en eller flera medlemsgrupper för att bygga medlemstaggmolnet.';
$GLOBALS['TL_LANG']['tl_module']['tag_news_archives'][0] = 'Nyhetsarkiv';
$GLOBALS['TL_LANG']['tl_module']['tag_news_archives'][1] = 'Vänligen välj de nyhetsarkiv som används för att bygga taggmolnet.';
