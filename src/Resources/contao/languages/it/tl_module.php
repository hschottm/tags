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

$GLOBALS['TL_LANG']['tl_module']['tag_jumpTo'][0] = 'Vai alla pagina';
$GLOBALS['TL_LANG']['tl_module']['tag_jumpTo'][1] = 'Questa impostazione definisce a quale pagina un utente verrà reindirizzato facendo clic sul collegamento di un tag.';
$GLOBALS['TL_LANG']['tl_module']['tag_forTable'][0] = 'Tabelle di tag';
$GLOBALS['TL_LANG']['tl_module']['tag_forTable'][1] = 'Seleziona le tabelle utilizzate per mostrare il tag cloud. Questa selezione è valida solo se si utilizza la tabella <em>tl_tag</em> predefinita per memorizzare i tag.';
$GLOBALS['TL_LANG']['tl_module']['tag_tagtable'][0] = 'Tabella delle origini tag';
$GLOBALS['TL_LANG']['tl_module']['tag_tagtable'][1] = 'Inserisci il nome della tabella di origine in cui è possibile trovare i tag. Per impostazione predefinita questo campo è la tabella predefinita <em>tl_tag</em>.';
$GLOBALS['TL_LANG']['tl_module']['tag_tagfield'][0] = 'Campo della tabella dei tag';
$GLOBALS['TL_LANG']['tl_module']['tag_tagfield'][1] = 'Inserisci il nome del campo della tabella che contiene i tag. Per impostazione predefinita questo campo utilizza il nome campo predefinito <em>tag</em>.';
$GLOBALS['TL_LANG']['tl_module']['tag_filter'][0] = 'Filtro tag';
$GLOBALS['TL_LANG']['tl_module']['tag_filter'][1] = 'Inserisci un elenco di tag separati da virgole per filtrare l\'output del modulo.';
$GLOBALS['TL_LANG']['tl_module']['tag_maxtags'][0] = 'Numero massimo di tag';
$GLOBALS['TL_LANG']['tl_module']['tag_maxtags'][1] = 'Inserisci il numero massimo di tag nel tag cloud. Se il tag cloud contiene più tag rispetto al numero massimo di tag, i tag con il numero di risultati più basso verranno rimossi dal cloud. Se non inserisci un valore o il valore è 0, verranno visualizzati tutti i tag.';
$GLOBALS['TL_LANG']['tl_module']['tag_buckets'][0] = 'Numero di dimensioni dei tag';
$GLOBALS['TL_LANG']['tl_module']['tag_buckets'][1] = 'Inserisci il numero di dimensioni dei tag nel frontend. Ogni gruppo di tag ottiene la propria dimensione nel frontend. Le dimensioni dei tag verranno fornite come selettori CSS size1, size2, size3 ... size<em>n</em>.';
$GLOBALS['TL_LANG']['tl_module']['tag_named_class'][0] = 'Utilizza il tag nomeclasse';
$GLOBALS['TL_LANG']['tl_module']['tag_named_class'][1] = 'Aggiunge una classe CSS aggiuntiva per ogni tag che contiene il nome del tag. Utilizza questo nome di classe aggiuntivo per uno stile aggiuntivo dei tag tramite CSS. Gli spazi nei nomi dei tag verranno sostituiti con caratteri di sottolineatura nei nomi delle classi CSS.';
$GLOBALS['TL_LANG']['tl_module']['tag_on_page_class'][0] = 'Il tag esiste nella pagina';
$GLOBALS['TL_LANG']['tl_module']['tag_on_page_class'][1] = 'Aggiunge una classe CSS aggiuntiva ("qui") per ogni tag assegnato alla pagina effettiva.';
$GLOBALS['TL_LANG']['tl_module']['tag_topten'][0] = 'Tag principali';
$GLOBALS['TL_LANG']['tl_module']['tag_topten'][1] = 'Mostra i tag principali sopra la nuvola di tag.';
$GLOBALS['TL_LANG']['tl_module']['tag_topten_expanded'][0] = 'Espandi i tag principali';
$GLOBALS['TL_LANG']['tl_module']['tag_topten_expanded'][1] = 'Espandi il tag cloud dei tag principali. Tutti i tag in questa nuvola sono visibili.';
$GLOBALS['TL_LANG']['tl_module']['tag_topten_number'][0] = 'Numero di tag principali';
$GLOBALS['TL_LANG']['tl_module']['tag_topten_number'][1] = 'Inserisci il numero massimo che deve essere utilizzato per i tag principali.';
$GLOBALS['TL_LANG']['tl_module']['tag_all_expanded'][0] = 'Espandi tutti i tag';
$GLOBALS['TL_LANG']['tl_module']['tag_all_expanded'][1] = 'Espandi il tag cloud "Tutti i tag". Tutti i tag in questa nuvola sono visibili.';
$GLOBALS['TL_LANG']['tl_module']['tag_related'][0] = 'Mostra tag correlati';
$GLOBALS['TL_LANG']['tl_module']['tag_related'][1] = 'Seleziona questa opzione per mostrare tutti i tag correlati di un tag precedentemente selezionato.';
$GLOBALS['TL_LANG']['tl_module']['news_showtags'][0] = 'Mostra i tag delle notizie';
$GLOBALS['TL_LANG']['tl_module']['news_showtags'][1] = 'Seleziona questa opzione per mostrare tutti i tag assegnati sotto ciascuna notizia. Funziona solo se utilizzi un modello di notizie abilitato per i tag, ad es. news_full_tags';
$GLOBALS['TL_LANG']['tl_module']['event_showtags'][0] = 'Mostra tag evento';
$GLOBALS['TL_LANG']['tl_module']['event_showtags'][1] = 'Seleziona questa opzione per mostrare tutti i tag assegnati sotto ogni evento. Funziona solo se utilizzi un modello di evento abilitato per i tag, ad es. evento_..._tag';
$GLOBALS['TL_LANG']['tl_module']['tag_ignore'][0] = 'Ignora i tag';
$GLOBALS['TL_LANG']['tl_module']['tag_ignore'][1] = 'Forza questo modulo a ignorare le azioni relative ai tag (ad esempio mostra solo le notizie di un determinato tag)';
$GLOBALS['TL_LANG']['tl_module']['keep_url_params'][0] = 'Mantieni i parametri URL';
$GLOBALS['TL_LANG']['tl_module']['keep_url_params'][1] = 'Mantieni i parametri URL specifici di Contao (ad esempio i parametri della data degli archivi di notizie) nei collegamenti dei tag';
$GLOBALS['TL_LANG']['tl_module']['objecttype'][0] = 'Tipo di oggetto';
$GLOBALS['TL_LANG']['tl_module']['objecttype'][1] = 'Seleziona il tipo di oggetto che deve essere mostrato in questo elenco.';
$GLOBALS['TL_LANG']['tl_module']['tagsource'][0] = 'Sorgente del tag';
$GLOBALS['TL_LANG']['tl_module']['tagsource'][1] = 'Seleziona la tabella utilizzata per creare l\'elenco dei tag in questo modulo.';
$GLOBALS['TL_LANG']['tl_module']['pagesource'][0] = 'Pagine';
$GLOBALS['TL_LANG']['tl_module']['pagesource'][1] = 'Seleziona le pagine utilizzate per creare l\'elenco degli oggetti. Se selezioni una pagina che contiene sottopagine, verranno utilizzate anche tutte le sottopagine.';
$GLOBALS['TL_LANG']['tl_module']['articlelist_template'][0] = 'Modello elenco articoli';
$GLOBALS['TL_LANG']['tl_module']['articlelist_template'][1] = 'Qui puoi selezionare il modello di elenco articoli.';
$GLOBALS['TL_LANG']['tl_module']['cloud_template'][0] = 'Modello nuvola di etichette';
$GLOBALS['TL_LANG']['tl_module']['cloud_template'][1] = 'Qui puoi selezionare il modello del tag cloud.';
$GLOBALS['TL_LANG']['tl_module']['scope_template'][0] = 'Modello di ambito del tag';
$GLOBALS['TL_LANG']['tl_module']['scope_template'][1] = 'Qui puoi selezionare il modello di ambito del tag.';
$GLOBALS['TL_LANG']['tl_module']['clear_text'][0] = 'Titolo dell\'ambito del tag';
$GLOBALS['TL_LANG']['tl_module']['clear_text'][1] = 'Inserisci un titolo per l\'ambito del tag. Il titolo è un collegamento ipertestuale che cancella l\'ambito del tag e rimuove tutti i tag selezionati.';
$GLOBALS['TL_LANG']['tl_module']['show_empty_scope'][0] = 'Mostra ambito vuoto';
$GLOBALS['TL_LANG']['tl_module']['show_empty_scope'][1] = 'Mostra l\'ambito del tag anche se non ci sono tag attivi.';
$GLOBALS['TL_LANG']['tl_module']['tag_show_reset'][0] = 'Mostra opzione chiara';
$GLOBALS['TL_LANG']['tl_module']['tag_show_reset'][1] = 'Mostra un collegamento ipertestuale per cancellare tutti i tag selezionati.';
$GLOBALS['TL_LANG']['tl_module']['hide_on_empty'][0] = 'Solo uscita filtrata';
$GLOBALS['TL_LANG']['tl_module']['hide_on_empty'][1] = 'L\'elenco articoli globale prevede sempre che uno o più tag producano un output filtrato. Senza un filtro tag, viene mostrato un elenco vuoto.';
$GLOBALS['TL_LANG']['tl_module']['tag_alltags'] = 'Tutti i tag';
$GLOBALS['TL_LANG']['tl_module']['tag_relatedtags'] = 'Tag correlati';
$GLOBALS['TL_LANG']['tl_module']['tl_content'] = 'Elementi di contenuto';
$GLOBALS['TL_LANG']['tl_module']['tl_article'] = 'Articoli';
$GLOBALS['TL_LANG']['tl_module']['tl_news'] = 'Articoli di notizie';
$GLOBALS['TL_LANG']['tl_module']['tag_clear_tags'] = 'Cancella i tag selezionati';
$GLOBALS['TL_LANG']['tl_module']['tl_calendar_events'] = 'Eventi';
$GLOBALS['TL_LANG']['tl_module']['tl_page'] = 'Pagine';
$GLOBALS['TL_LANG']['tl_module']['tags'] = 'Tag';
$GLOBALS['TL_LANG']['tl_module']['top_tags'] = 'I migliori tag %s';
$GLOBALS['TL_LANG']['tl_module']['showtags_legend'] = 'Impostazioni dei tag';
$GLOBALS['TL_LANG']['tl_module']['tagscope_legend'] = 'Impostazioni dell\'ambito dei tag';
$GLOBALS['TL_LANG']['tl_module']['size_legend'] = 'Impostazioni di numero e dimensione';
$GLOBALS['TL_LANG']['tl_module']['tagextension_legend'] = 'Elenchi di tag aggiuntivi';
$GLOBALS['TL_LANG']['tl_module']['datasource_legend'] = 'Impostazioni dell\'origine dati';
$GLOBALS['TL_LANG']['tl_module']['object_selection_legend'] = 'Tipi di oggetti';
$GLOBALS['TL_LANG']['tl_module']['tag_articles'][0] = 'Articoli';
$GLOBALS['TL_LANG']['tl_module']['tag_articles'][1] = 'Seleziona le pagine utilizzate dai loro articoli per creare il tag cloud. Se controlli una pagina che contiene sottopagine, verranno utilizzati anche gli articoli di tutte le sottopagine.';
$GLOBALS['TL_LANG']['tl_module']['show_in_column'][0] = 'Limita a una colonna specifica';
$GLOBALS['TL_LANG']['tl_module']['show_in_column'][1] = 'Limita l\'output dell\'elenco di articoli a una colonna specifica del modello di pagina.';
$GLOBALS['TL_LANG']['tl_module']['linktoarticles'][0] = 'L\'elenco degli articoli si collega agli articoli';
$GLOBALS['TL_LANG']['tl_module']['linktoarticles'][1] = 'Seleziona per creare un elenco di articoli con collegamenti all\'articolo o deseleziona per creare un elenco di articoli con collegamenti alla pagina che lo contiene.';
$GLOBALS['TL_LANG']['tl_module']['restrict_to_column'][0] = 'Limita a una colonna specifica';
$GLOBALS['TL_LANG']['tl_module']['restrict_to_column'][1] = 'Limita il tag cloud ai tag degli articoli di una colonna specifica del modello di pagina.';
$GLOBALS['TL_LANG']['tl_module']['articlelist_tpl'][0] = 'Modello di elenco articoli';
$GLOBALS['TL_LANG']['tl_module']['articlelist_tpl'][1] = 'Qui puoi selezionare il modello di elenco articoli.';
$GLOBALS['TL_LANG']['tl_module']['article_showtags'][0] = 'Mostra i tag degli articoli';
$GLOBALS['TL_LANG']['tl_module']['article_showtags'][1] = 'Seleziona questa opzione per mostrare tutti i tag assegnati sotto ogni articolo. Funziona solo se utilizzi un modello di articolo abilitato per i tag, ad es. mod_global_articlelist';
$GLOBALS['TL_LANG']['tl_module']['articlelist_firstorder'][0] = 'Primo criterio di ordinamento';
$GLOBALS['TL_LANG']['tl_module']['articlelist_firstorder'][1] = 'Seleziona il primo criterio di ordinamento per l\'elenco degli articoli risultante.';
$GLOBALS['TL_LANG']['tl_module']['articlelist_secondorder'][0] = 'Secondo criterio di ordinamento';
$GLOBALS['TL_LANG']['tl_module']['articlelist_secondorder'][1] = 'Seleziona il secondo criterio di ordinamento per l\'elenco di articoli risultante.';
$GLOBALS['TL_LANG']['tl_module']['tag_content_pages'][0] = 'Pagine';
$GLOBALS['TL_LANG']['tl_module']['tag_content_pages'][1] = 'Seleziona le pagine e i relativi elementi di contenuto utilizzati per creare il tag cloud. Se selezioni una pagina che contiene sottopagine, verranno utilizzati anche gli elementi di contenuto di tutte le sottopagine.';
$GLOBALS['TL_LANG']['tl_module']['tag_calendars'][0] = 'Calendari';
$GLOBALS['TL_LANG']['tl_module']['tag_calendars'][1] = 'Seleziona i calendari utilizzati per creare il tag cloud.';
$GLOBALS['TL_LANG']['tl_module']['tag_membergroups'][0] = 'Gruppi di membri';
$GLOBALS['TL_LANG']['tl_module']['tag_membergroups'][1] = 'Seleziona uno o più gruppi di membri per creare il tag cloud dei membri.';
$GLOBALS['TL_LANG']['tl_module']['tag_news_archives'][0] = 'Archivi di notizie';
$GLOBALS['TL_LANG']['tl_module']['tag_news_archives'][1] = 'Seleziona gli archivi di notizie utilizzati per creare il tag cloud.';
