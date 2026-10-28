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

$GLOBALS['TL_LANG']['tl_module']['tag_jumpTo'][0] = 'Přejít na stránku';
$GLOBALS['TL_LANG']['tl_module']['tag_jumpTo'][1] = 'Toto nastavení určuje, na kterou stránku bude uživatel přesměrován po kliknutí na odkaz značky.';
$GLOBALS['TL_LANG']['tl_module']['tag_forTable'][0] = 'Tabulky značek';
$GLOBALS['TL_LANG']['tl_module']['tag_forTable'][1] = 'Vyberte prosím tabulky, které se používají k zobrazení cloudu značek. Tento výběr je platný pouze v případě, že k uložení tagů použijete předdefinovanou tabulku <em>tl_tag</em>.';
$GLOBALS['TL_LANG']['tl_module']['tag_tagtable'][0] = 'Zdrojová tabulka značek';
$GLOBALS['TL_LANG']['tl_module']['tag_tagtable'][1] = 'Zadejte prosím název zdrojové tabulky, ve které lze značky nalézt. This field defaults to the predefined table <em>tl_tag</em>.';
$GLOBALS['TL_LANG']['tl_module']['tag_tagfield'][0] = 'Pole tabulky značek';
$GLOBALS['TL_LANG']['tl_module']['tag_tagfield'][1] = 'Please enter the name of the table field which holds the tags. Toto pole má výchozí předdefinovaný název pole <em>tag</em>.';
$GLOBALS['TL_LANG']['tl_module']['tag_filter'][0] = 'Filtr značek';
$GLOBALS['TL_LANG']['tl_module']['tag_filter'][1] = 'Chcete-li filtrovat výstup modulu, zadejte seznam značek oddělených čárkami.';
$GLOBALS['TL_LANG']['tl_module']['tag_maxtags'][0] = 'Maximální počet značek';
$GLOBALS['TL_LANG']['tl_module']['tag_maxtags'][1] = 'Zadejte prosím maximální počet značek v cloudu značek. Pokud cloud tagů obsahuje více tagů, než je maximální počet tagů, tagy s nejmenším počtem zásahů budou z cloudu odstraněny. Pokud nezadáte hodnotu nebo je hodnota 0, zobrazí se všechny značky.';
$GLOBALS['TL_LANG']['tl_module']['tag_buckets'][0] = 'Počet velikostí štítků';
$GLOBALS['TL_LANG']['tl_module']['tag_buckets'][1] = 'Please enter the number of tag sizes in the frontend. Každá skupina značek má ve frontendu svou vlastní velikost značky. The tag sizes will be give as CSS selectors size1, size2, size3 ... size<em>n</em>.';
$GLOBALS['TL_LANG']['tl_module']['tag_named_class'][0] = 'Použijte značku classname';
$GLOBALS['TL_LANG']['tl_module']['tag_named_class'][1] = 'Přidá další třídu CSS pro každou značku, která obsahuje název značky. Použijte tento extra název třídy pro další stylování značek pomocí CSS. Mezery v názvech značek budou nahrazeny podtržítky v názvech tříd CSS.';
$GLOBALS['TL_LANG']['tl_module']['tag_on_page_class'][0] = 'Značka na stránce existuje';
$GLOBALS['TL_LANG']['tl_module']['tag_on_page_class'][1] = 'Přidá další třídu CSS („zde“) pro každou značku, která byla přiřazena ke skutečné stránce.';
$GLOBALS['TL_LANG']['tl_module']['tag_topten'][0] = 'Top Tagy';
$GLOBALS['TL_LANG']['tl_module']['tag_topten'][1] = 'Zobrazit Top Tagy nad tag cloudem.';
$GLOBALS['TL_LANG']['tl_module']['tag_topten_expanded'][0] = 'Rozbalte Nejlepší značky';
$GLOBALS['TL_LANG']['tl_module']['tag_topten_expanded'][1] = 'Rozbalte oblak značek Top Tags. Všechny štítky v tomto cloudu jsou viditelné.';
$GLOBALS['TL_LANG']['tl_module']['tag_topten_number'][0] = 'Počet nejlepších značek';
$GLOBALS['TL_LANG']['tl_module']['tag_topten_number'][1] = 'Zadejte maximální počet, který by měl být použit pro Top Tagy.';
$GLOBALS['TL_LANG']['tl_module']['tag_all_expanded'][0] = 'Rozbalte všechny značky';
$GLOBALS['TL_LANG']['tl_module']['tag_all_expanded'][1] = 'Rozbalte oblak značek „Všechny značky“. Všechny štítky v tomto cloudu jsou viditelné.';
$GLOBALS['TL_LANG']['tl_module']['tag_related'][0] = 'Zobrazit související značky';
$GLOBALS['TL_LANG']['tl_module']['tag_related'][1] = 'Tuto možnost vyberte, chcete-li zobrazit všechny související značky dříve vybrané značky.';
$GLOBALS['TL_LANG']['tl_module']['news_showtags'][0] = 'Zobrazit značky zpráv';
$GLOBALS['TL_LANG']['tl_module']['news_showtags'][1] = 'Tuto možnost vyberte, chcete-li pod každou zprávou zobrazit všechny přiřazené štítky. Funguje to pouze v případě, že používáte šablonu zpráv s povolenou značkou, např. news_full_tags';
$GLOBALS['TL_LANG']['tl_module']['event_showtags'][0] = 'Zobrazit značky událostí';
$GLOBALS['TL_LANG']['tl_module']['event_showtags'][1] = 'Tuto možnost vyberte, chcete-li pod každou událostí zobrazit všechny přiřazené značky. Funguje to pouze v případě, že používáte šablonu události s povolenou značkou, např. event_..._tags';
$GLOBALS['TL_LANG']['tl_module']['tag_ignore'][0] = 'Ignorujte značky';
$GLOBALS['TL_LANG']['tl_module']['tag_ignore'][1] = 'Vynutit, aby tento modul ignoroval akce související se značkami (např. zobrazovat pouze zprávy o dané značce)';
$GLOBALS['TL_LANG']['tl_module']['keep_url_params'][0] = 'Zachovejte parametry adresy URL';
$GLOBALS['TL_LANG']['tl_module']['keep_url_params'][1] = 'V odkazech na značky ponechte specifické parametry URL adresy Contao (např. parametry data archivů zpráv).';
$GLOBALS['TL_LANG']['tl_module']['objecttype'][0] = 'Typ objektu';
$GLOBALS['TL_LANG']['tl_module']['objecttype'][1] = 'Vyberte prosím typ objektu, který má být zobrazen v tomto seznamu.';
$GLOBALS['TL_LANG']['tl_module']['tagsource'][0] = 'Zdroj značky';
$GLOBALS['TL_LANG']['tl_module']['tagsource'][1] = 'Vyberte prosím tabulku, která se používá k vytvoření seznamu značek v tomto modulu.';
$GLOBALS['TL_LANG']['tl_module']['pagesource'][0] = 'Stránky';
$GLOBALS['TL_LANG']['tl_module']['pagesource'][1] = 'Please select the pages that are used to build the object list. If you select a page which contains subpages, all subpages will be used too.';
$GLOBALS['TL_LANG']['tl_module']['articlelist_template'][0] = 'Šablona seznamu článků';
$GLOBALS['TL_LANG']['tl_module']['articlelist_template'][1] = 'Zde můžete vybrat šablonu seznamu článků.';
$GLOBALS['TL_LANG']['tl_module']['cloud_template'][0] = 'Šablona tag cloud';
$GLOBALS['TL_LANG']['tl_module']['cloud_template'][1] = 'Zde můžete vybrat šablonu cloudu značek.';
$GLOBALS['TL_LANG']['tl_module']['scope_template'][0] = 'Šablona rozsahu značky';
$GLOBALS['TL_LANG']['tl_module']['scope_template'][1] = 'Zde můžete vybrat šablonu rozsahu značky.';
$GLOBALS['TL_LANG']['tl_module']['clear_text'][0] = 'Název rozsahu značky';
$GLOBALS['TL_LANG']['tl_module']['clear_text'][1] = 'Zadejte název rozsahu značky. Titulek je hypertextový odkaz, který vymaže rozsah značky a odstraní všechny vybrané značky.';
$GLOBALS['TL_LANG']['tl_module']['show_empty_scope'][0] = 'Zobrazit prázdný rozsah';
$GLOBALS['TL_LANG']['tl_module']['show_empty_scope'][1] = 'Zobrazit rozsah značky, i když neexistují žádné aktivní značky.';
$GLOBALS['TL_LANG']['tl_module']['tag_show_reset'][0] = 'Zobrazit jasnou možnost';
$GLOBALS['TL_LANG']['tl_module']['tag_show_reset'][1] = 'Zobrazit hypertextový odkaz pro vymazání všech vybraných značek.';
$GLOBALS['TL_LANG']['tl_module']['hide_on_empty'][0] = 'Pouze filtrovaný výstup';
$GLOBALS['TL_LANG']['tl_module']['hide_on_empty'][1] = 'Globální seznam článků vždy očekává, že jedna nebo více značek vytvoří filtrovaný výstup. Bez filtru značek se zobrazí prázdný seznam.';
$GLOBALS['TL_LANG']['tl_module']['tag_alltags'] = 'Všechny značky';
$GLOBALS['TL_LANG']['tl_module']['tag_relatedtags'] = 'Související značky';
$GLOBALS['TL_LANG']['tl_module']['tl_content'] = 'Obsahové prvky';
$GLOBALS['TL_LANG']['tl_module']['tl_article'] = 'články';
$GLOBALS['TL_LANG']['tl_module']['tl_news'] = 'Zpravodajské články';
$GLOBALS['TL_LANG']['tl_module']['tag_clear_tags'] = 'Vymazat vybrané značky';
$GLOBALS['TL_LANG']['tl_module']['tl_calendar_events'] = 'Události';
$GLOBALS['TL_LANG']['tl_module']['tl_page'] = 'Stránky';
$GLOBALS['TL_LANG']['tl_module']['tags'] = 'Tagy';
$GLOBALS['TL_LANG']['tl_module']['top_tags'] = 'Nejlepší %s Tagy';
$GLOBALS['TL_LANG']['tl_module']['showtags_legend'] = 'Nastavení značek';
$GLOBALS['TL_LANG']['tl_module']['tagscope_legend'] = 'Nastavení rozsahu značek';
$GLOBALS['TL_LANG']['tl_module']['size_legend'] = 'Nastavení počtu a velikosti';
$GLOBALS['TL_LANG']['tl_module']['tagextension_legend'] = 'Další seznamy značek';
$GLOBALS['TL_LANG']['tl_module']['datasource_legend'] = 'Nastavení zdroje dat';
$GLOBALS['TL_LANG']['tl_module']['object_selection_legend'] = 'Typy objektů';
$GLOBALS['TL_LANG']['tl_module']['tag_articles'][0] = 'články';
$GLOBALS['TL_LANG']['tl_module']['tag_articles'][1] = 'Please select the pages theirs articles are used to build the tag cloud. If you check a page which contains subpages, the articles of all subpages will be used too.';
$GLOBALS['TL_LANG']['tl_module']['show_in_column'][0] = 'Omezit na konkrétní sloupec';
$GLOBALS['TL_LANG']['tl_module']['show_in_column'][1] = 'Omezte výstup seznamu článků na konkrétní sloupec šablony stránky.';
$GLOBALS['TL_LANG']['tl_module']['linktoarticles'][0] = 'Odkazy na seznam článků na články';
$GLOBALS['TL_LANG']['tl_module']['linktoarticles'][1] = 'Zaškrtnutím vytvoříte seznam článků s odkazy na článek nebo zrušením zaškrtnutí vytvoříte seznam článků s odkazy na stránku obsahující.';
$GLOBALS['TL_LANG']['tl_module']['restrict_to_column'][0] = 'Omezit na konkrétní sloupec';
$GLOBALS['TL_LANG']['tl_module']['restrict_to_column'][1] = 'Omezte shluk značek na značky článků z určitého sloupce šablony stránky.';
$GLOBALS['TL_LANG']['tl_module']['articlelist_tpl'][0] = 'Šablona seznamu článků';
$GLOBALS['TL_LANG']['tl_module']['articlelist_tpl'][1] = 'Zde můžete vybrat šablonu seznamu článků.';
$GLOBALS['TL_LANG']['tl_module']['article_showtags'][0] = 'Zobrazit značky článků';
$GLOBALS['TL_LANG']['tl_module']['article_showtags'][1] = 'Tuto možnost vyberte, chcete-li pod každým článkem zobrazit všechny přiřazené štítky. Funguje to pouze v případě, že používáte šablonu článku s povolenou značkou, např. mod_global_articlelist';
$GLOBALS['TL_LANG']['tl_module']['articlelist_firstorder'][0] = 'Kritéria prvního řazení';
$GLOBALS['TL_LANG']['tl_module']['articlelist_firstorder'][1] = 'Vyberte první kritéria řazení pro výsledný seznam článků.';
$GLOBALS['TL_LANG']['tl_module']['articlelist_secondorder'][0] = 'Kritéria druhého řazení';
$GLOBALS['TL_LANG']['tl_module']['articlelist_secondorder'][1] = 'Vyberte druhé kritérium řazení pro výsledný seznam článků.';
$GLOBALS['TL_LANG']['tl_module']['tag_content_pages'][0] = 'Stránky';
$GLOBALS['TL_LANG']['tl_module']['tag_content_pages'][1] = 'Vyberte stránky, jejichž obsahové prvky se používají k vytvoření cloudu značek. Pokud vyberete stránku, která obsahuje podstránky, použijí se také obsahové prvky všech podstránek.';
$GLOBALS['TL_LANG']['tl_module']['tag_calendars'][0] = 'Kalendáře';
$GLOBALS['TL_LANG']['tl_module']['tag_calendars'][1] = 'Please select the calendars which are used to build the tag cloud.';
$GLOBALS['TL_LANG']['tl_module']['tag_membergroups'][0] = 'Skupiny členů';
$GLOBALS['TL_LANG']['tl_module']['tag_membergroups'][1] = 'Please select one or more member groups to build the member tag cloud.';
$GLOBALS['TL_LANG']['tl_module']['tag_news_archives'][0] = 'Archivy zpráv';
$GLOBALS['TL_LANG']['tl_module']['tag_news_archives'][1] = 'Please select the news archives which are used to build the tag cloud.';
