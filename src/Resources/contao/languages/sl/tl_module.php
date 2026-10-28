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

$GLOBALS['TL_LANG']['tl_module']['tag_jumpTo'][0] = 'Skoči na stran';
$GLOBALS['TL_LANG']['tl_module']['tag_jumpTo'][1] = 'Ta nastavitev določa, na katero stran bo uporabnik preusmerjen, ko klikne povezavo oznake.';
$GLOBALS['TL_LANG']['tl_module']['tag_forTable'][0] = 'Tabele z oznakami';
$GLOBALS['TL_LANG']['tl_module']['tag_forTable'][1] = 'Izberite tabele, ki se uporabljajo za prikaz oblaka oznak. Ta izbira je veljavna le, če za shranjevanje oznak uporabljate vnaprej določeno tabelo <em>tl_tag</em>.';
$GLOBALS['TL_LANG']['tl_module']['tag_tagtable'][0] = 'Izvorna tabela oznak';
$GLOBALS['TL_LANG']['tl_module']['tag_tagtable'][1] = 'Vnesite ime izvorne tabele, v kateri so oznake. To polje je privzeto nastavljeno na vnaprej določeno tabelo <em>tl_tag</em>.';
$GLOBALS['TL_LANG']['tl_module']['tag_tagfield'][0] = 'Polje tabele oznak';
$GLOBALS['TL_LANG']['tl_module']['tag_tagfield'][1] = 'Vnesite ime polja tabele, ki vsebuje oznake. To polje ima privzeto vnaprej določeno ime polja <em>tag</em>.';
$GLOBALS['TL_LANG']['tl_module']['tag_filter'][0] = 'Filter oznak';
$GLOBALS['TL_LANG']['tl_module']['tag_filter'][1] = 'Vnesite seznam oznak, ločenih z vejicami, da filtrirate izhod modula.';
$GLOBALS['TL_LANG']['tl_module']['tag_maxtags'][0] = 'Največje število oznak';
$GLOBALS['TL_LANG']['tl_module']['tag_maxtags'][1] = 'Vnesite največje število oznak v oblak oznak. Če oblak oznak vsebuje več oznak, kot je največje število oznak, bodo oznake z najmanjšim številom zadetkov odstranjene iz oblaka. Če ne vnesete vrednosti ali je vrednost 0, bodo prikazane vse oznake.';
$GLOBALS['TL_LANG']['tl_module']['tag_buckets'][0] = 'Število velikosti oznak';
$GLOBALS['TL_LANG']['tl_module']['tag_buckets'][1] = 'Prosimo, vnesite število velikosti oznak v sprednji del. Vsaka skupina oznak dobi lastno velikost oznake v sprednjem delu. Velikosti oznak bodo podane kot izbirniki CSS size1, size2, size3 ... size<em>n</em>.';
$GLOBALS['TL_LANG']['tl_module']['tag_named_class'][0] = 'Uporabite ime razreda oznake';
$GLOBALS['TL_LANG']['tl_module']['tag_named_class'][1] = 'Doda dodaten razred razreda CSS za vsako oznako, ki vsebuje ime oznake. Uporabite to dodatno ime razreda za dodatno oblikovanje oznak prek CSS. Presledki v imenih oznak bodo zamenjani s podčrtaji v imenih razredov CSS.';
$GLOBALS['TL_LANG']['tl_module']['tag_on_page_class'][0] = 'Oznaka obstaja na strani';
$GLOBALS['TL_LANG']['tl_module']['tag_on_page_class'][1] = 'Doda dodaten razred CSS (\'tukaj\') za vsako oznako, ki je bila dodeljena dejanski strani.';
$GLOBALS['TL_LANG']['tl_module']['tag_topten'][0] = 'Top oznake';
$GLOBALS['TL_LANG']['tl_module']['tag_topten'][1] = 'Pokaži najboljše oznake nad oblakom oznak.';
$GLOBALS['TL_LANG']['tl_module']['tag_topten_expanded'][0] = 'Razširi Top Tags';
$GLOBALS['TL_LANG']['tl_module']['tag_topten_expanded'][1] = 'Razširite oblak oznak Top Tags. Vse oznake v tem oblaku so vidne.';
$GLOBALS['TL_LANG']['tl_module']['tag_topten_number'][0] = 'Število najboljših oznak';
$GLOBALS['TL_LANG']['tl_module']['tag_topten_number'][1] = 'Vnesite največje število, ki naj se uporabi za Top Tags.';
$GLOBALS['TL_LANG']['tl_module']['tag_all_expanded'][0] = 'Razširi vse oznake';
$GLOBALS['TL_LANG']['tl_module']['tag_all_expanded'][1] = 'Razširite oblak oznak »Vse oznake«. Vse oznake v tem oblaku so vidne.';
$GLOBALS['TL_LANG']['tl_module']['tag_related'][0] = 'Prikaži povezane oznake';
$GLOBALS['TL_LANG']['tl_module']['tag_related'][1] = 'Izberite to možnost, če želite prikazati vse povezane oznake predhodno izbrane oznake.';
$GLOBALS['TL_LANG']['tl_module']['news_showtags'][0] = 'Prikaži oznake novic';
$GLOBALS['TL_LANG']['tl_module']['news_showtags'][1] = 'Izberite to možnost, če želite pod vsako novico prikazati vse dodeljene oznake. To deluje le, če uporabljate predlogo novic, ki podpira oznake, npr. novice_polne_oznake';
$GLOBALS['TL_LANG']['tl_module']['event_showtags'][0] = 'Pokaži oznake dogodkov';
$GLOBALS['TL_LANG']['tl_module']['event_showtags'][1] = 'Izberite to možnost, če želite pod vsakim dogodkom prikazati vse dodeljene oznake. To deluje le, če uporabljate predlogo dogodka z omogočeno oznako, npr. dogodek_..._oznake';
$GLOBALS['TL_LANG']['tl_module']['tag_ignore'][0] = 'Ignoriraj oznake';
$GLOBALS['TL_LANG']['tl_module']['tag_ignore'][1] = 'Prisili ta modul, da ignorira dejanja, povezana z oznako (npr. prikaži samo vnose novic dane oznake)';
$GLOBALS['TL_LANG']['tl_module']['keep_url_params'][0] = 'Ohranite parametre URL-ja';
$GLOBALS['TL_LANG']['tl_module']['keep_url_params'][1] = 'Ohranite parametre URL-ja, specifične za Contao (npr. parametre datuma arhivov novic) v povezavah oznak';
$GLOBALS['TL_LANG']['tl_module']['objecttype'][0] = 'Vrsta predmeta';
$GLOBALS['TL_LANG']['tl_module']['objecttype'][1] = 'Izberite vrsto predmeta, ki naj bo prikazan na tem seznamu.';
$GLOBALS['TL_LANG']['tl_module']['tagsource'][0] = 'Vir oznake';
$GLOBALS['TL_LANG']['tl_module']['tagsource'][1] = 'Izberite tabelo, ki se uporablja za izdelavo seznama oznak v tem modulu.';
$GLOBALS['TL_LANG']['tl_module']['pagesource'][0] = 'Strani';
$GLOBALS['TL_LANG']['tl_module']['pagesource'][1] = 'Izberite strani, ki se uporabljajo za izdelavo seznama predmetov. Če izberete stran, ki vsebuje podstrani, bodo uporabljene tudi vse podstrani.';
$GLOBALS['TL_LANG']['tl_module']['articlelist_template'][0] = 'Predloga seznama člankov';
$GLOBALS['TL_LANG']['tl_module']['articlelist_template'][1] = 'Tukaj lahko izberete predlogo seznama člankov.';
$GLOBALS['TL_LANG']['tl_module']['cloud_template'][0] = 'Predloga oblaka oznak';
$GLOBALS['TL_LANG']['tl_module']['cloud_template'][1] = 'Tukaj lahko izberete predlogo oblaka oznak.';
$GLOBALS['TL_LANG']['tl_module']['scope_template'][0] = 'Predloga obsega oznake';
$GLOBALS['TL_LANG']['tl_module']['scope_template'][1] = 'Tukaj lahko izberete predlogo obsega oznake.';
$GLOBALS['TL_LANG']['tl_module']['clear_text'][0] = 'Naslov obsega oznake';
$GLOBALS['TL_LANG']['tl_module']['clear_text'][1] = 'Vnesite naslov za obseg oznake. Naslov je hiperpovezava, ki počisti obseg oznake in odstrani vse izbrane oznake.';
$GLOBALS['TL_LANG']['tl_module']['show_empty_scope'][0] = 'Pokaži prazen obseg';
$GLOBALS['TL_LANG']['tl_module']['show_empty_scope'][1] = 'Pokažite obseg oznake, tudi če ni aktivnih oznak.';
$GLOBALS['TL_LANG']['tl_module']['tag_show_reset'][0] = 'Prikaži jasno možnost';
$GLOBALS['TL_LANG']['tl_module']['tag_show_reset'][1] = 'Prikaži hiperpovezavo za brisanje vseh izbranih oznak.';
$GLOBALS['TL_LANG']['tl_module']['hide_on_empty'][0] = 'Samo filtriran izhod';
$GLOBALS['TL_LANG']['tl_module']['hide_on_empty'][1] = 'Globalni seznam člankov vedno pričakuje, da bo ena ali več oznak ustvarilo filtriran rezultat. Brez filtra oznak je prikazan prazen seznam.';
$GLOBALS['TL_LANG']['tl_module']['tag_alltags'] = 'Vse oznake';
$GLOBALS['TL_LANG']['tl_module']['tag_relatedtags'] = 'Sorodne oznake';
$GLOBALS['TL_LANG']['tl_module']['tl_content'] = 'Vsebinski elementi';
$GLOBALS['TL_LANG']['tl_module']['tl_article'] = 'Članki';
$GLOBALS['TL_LANG']['tl_module']['tl_news'] = 'Novičarski članki';
$GLOBALS['TL_LANG']['tl_module']['tag_clear_tags'] = 'Počisti izbrane oznake';
$GLOBALS['TL_LANG']['tl_module']['tl_calendar_events'] = 'Dogodki';
$GLOBALS['TL_LANG']['tl_module']['tl_page'] = 'Strani';
$GLOBALS['TL_LANG']['tl_module']['tags'] = 'Oznake';
$GLOBALS['TL_LANG']['tl_module']['top_tags'] = 'Top oznake %s';
$GLOBALS['TL_LANG']['tl_module']['showtags_legend'] = 'Nastavitve oznak';
$GLOBALS['TL_LANG']['tl_module']['tagscope_legend'] = 'Nastavitve obsega oznake';
$GLOBALS['TL_LANG']['tl_module']['size_legend'] = 'Nastavitve števila in velikosti';
$GLOBALS['TL_LANG']['tl_module']['tagextension_legend'] = 'Dodatni seznami oznak';
$GLOBALS['TL_LANG']['tl_module']['datasource_legend'] = 'Nastavitve vira podatkov';
$GLOBALS['TL_LANG']['tl_module']['object_selection_legend'] = 'Vrste predmetov';
$GLOBALS['TL_LANG']['tl_module']['tag_articles'][0] = 'Članki';
$GLOBALS['TL_LANG']['tl_module']['tag_articles'][1] = 'Izberite strani, na katerih se njihovi članki uporabljajo za gradnjo oblaka oznak. Če označite stran, ki vsebuje podstrani, bodo uporabljeni tudi članki vseh podstrani.';
$GLOBALS['TL_LANG']['tl_module']['show_in_column'][0] = 'Omeji na določen stolpec';
$GLOBALS['TL_LANG']['tl_module']['show_in_column'][1] = 'Omejite izpis seznama člankov na določen stolpec predloge strani.';
$GLOBALS['TL_LANG']['tl_module']['linktoarticles'][0] = 'Seznam člankov povezave do člankov';
$GLOBALS['TL_LANG']['tl_module']['linktoarticles'][1] = 'Označite, če želite ustvariti seznam člankov s povezavami do članka, ali počistite, če želite ustvariti seznam člankov s povezavami do strani, ki vsebuje.';
$GLOBALS['TL_LANG']['tl_module']['restrict_to_column'][0] = 'Omeji na določen stolpec';
$GLOBALS['TL_LANG']['tl_module']['restrict_to_column'][1] = 'Omejite oblak oznak na oznake člankov iz določenega stolpca predloge strani.';
$GLOBALS['TL_LANG']['tl_module']['articlelist_tpl'][0] = 'Predloga seznama člankov';
$GLOBALS['TL_LANG']['tl_module']['articlelist_tpl'][1] = 'Tukaj lahko izberete predlogo seznama člankov.';
$GLOBALS['TL_LANG']['tl_module']['article_showtags'][0] = 'Prikaži oznake člankov';
$GLOBALS['TL_LANG']['tl_module']['article_showtags'][1] = 'Izberite to možnost, če želite pod vsakim člankom prikazati vse dodeljene oznake. To deluje le, če uporabljate predlogo članka z omogočeno oznako, npr. mod_global_articlelist';
$GLOBALS['TL_LANG']['tl_module']['articlelist_firstorder'][0] = 'Prvo merilo razvrščanja';
$GLOBALS['TL_LANG']['tl_module']['articlelist_firstorder'][1] = 'Izberite prvi kriterij razvrščanja za končni seznam artiklov.';
$GLOBALS['TL_LANG']['tl_module']['articlelist_secondorder'][0] = 'Kriteriji druge sorte';
$GLOBALS['TL_LANG']['tl_module']['articlelist_secondorder'][1] = 'Izberite drugo merilo razvrščanja za nastali seznam člankov.';
$GLOBALS['TL_LANG']['tl_module']['tag_content_pages'][0] = 'Strani';
$GLOBALS['TL_LANG']['tl_module']['tag_content_pages'][1] = 'Izberite strani, na katerih se elementi vsebine uporabljajo za izgradnjo oblaka oznak. Če izberete stran, ki vsebuje podstrani, bodo uporabljeni tudi elementi vsebine vseh podstrani.';
$GLOBALS['TL_LANG']['tl_module']['tag_calendars'][0] = 'Koledarji';
$GLOBALS['TL_LANG']['tl_module']['tag_calendars'][1] = 'Izberite koledarje, ki se uporabljajo za izdelavo oblaka oznak.';
$GLOBALS['TL_LANG']['tl_module']['tag_membergroups'][0] = 'Članske skupine';
$GLOBALS['TL_LANG']['tl_module']['tag_membergroups'][1] = 'Izberite eno ali več skupin članov, da zgradite oblak oznak članov.';
$GLOBALS['TL_LANG']['tl_module']['tag_news_archives'][0] = 'Arhiv novic';
$GLOBALS['TL_LANG']['tl_module']['tag_news_archives'][1] = 'Prosimo izberite arhive novic, ki se uporabljajo za izgradnjo oblaka oznak.';
