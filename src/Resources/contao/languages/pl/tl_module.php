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

$GLOBALS['TL_LANG']['tl_module']['tag_jumpTo'][0] = 'Przejdź do strony';
$GLOBALS['TL_LANG']['tl_module']['tag_jumpTo'][1] = 'To ustawienie określa, na jaką stronę użytkownik zostanie przekierowany po kliknięciu łącza tagu.';
$GLOBALS['TL_LANG']['tl_module']['tag_forTable'][0] = 'Tabele tagów';
$GLOBALS['TL_LANG']['tl_module']['tag_forTable'][1] = 'Proszę wybrać tabele, które służą do pokazania chmury tagów. Ten wybór jest ważny tylko wtedy, gdy do przechowywania tagów używasz predefiniowanej tabeli <em>tl_tag</em>.';
$GLOBALS['TL_LANG']['tl_module']['tag_tagtable'][0] = 'Tabela źródłowa tagów';
$GLOBALS['TL_LANG']['tl_module']['tag_tagtable'][1] = 'Proszę o podanie nazwy tabeli źródłowej w której znajdują się tagi. Domyślnie w tym polu znajduje się predefiniowana tabela <em>tl_tag</em>.';
$GLOBALS['TL_LANG']['tl_module']['tag_tagfield'][0] = 'Pole tabeli znaczników';
$GLOBALS['TL_LANG']['tl_module']['tag_tagfield'][1] = 'Proszę wpisać nazwę pola tabeli, w którym znajdują się tagi. Domyślnie to pole ma wstępnie zdefiniowaną nazwę <em>tag</em>.';
$GLOBALS['TL_LANG']['tl_module']['tag_filter'][0] = 'Filtr tagów';
$GLOBALS['TL_LANG']['tl_module']['tag_filter'][1] = 'Wprowadź listę tagów rozdzielonych przecinkami, aby przefiltrować dane wyjściowe modułu.';
$GLOBALS['TL_LANG']['tl_module']['tag_maxtags'][0] = 'Maksymalna liczba tagów';
$GLOBALS['TL_LANG']['tl_module']['tag_maxtags'][1] = 'Proszę podać maksymalną liczbę tagów w chmurze tagów. Jeżeli chmura tagów zawiera więcej tagów niż maksymalna liczba tagów, tagi z najmniejszą liczbą trafień zostaną usunięte z chmury. Jeśli nie wprowadzisz wartości lub będzie ona równa 0, zostaną pokazane wszystkie tagi.';
$GLOBALS['TL_LANG']['tl_module']['tag_buckets'][0] = 'Liczba rozmiarów tagów';
$GLOBALS['TL_LANG']['tl_module']['tag_buckets'][1] = 'Wprowadź liczbę rozmiarów tagów w interfejsie. Każda grupa tagów ma swój własny rozmiar tagu w interfejsie. Rozmiary tagów zostaną podane jako selektory CSS size1, size2, size3 ... size<em>n</em>.';
$GLOBALS['TL_LANG']['tl_module']['tag_named_class'][0] = 'Użyj tagu nazwa klasy';
$GLOBALS['TL_LANG']['tl_module']['tag_named_class'][1] = 'Dodaje dodatkową klasę CSS dla każdego tagu, który zawiera nazwę tagu. Użyj tej dodatkowej nazwy klasy, aby uzyskać dodatkową stylizację tagów za pomocą CSS. Spacje w nazwach tagów zostaną zastąpione podkreśleniami w nazwach klas CSS.';
$GLOBALS['TL_LANG']['tl_module']['tag_on_page_class'][0] = 'Tag istnieje na stronie';
$GLOBALS['TL_LANG']['tl_module']['tag_on_page_class'][1] = 'Dodaje dodatkową klasę CSS („tutaj”) dla każdego tagu przypisanego do aktualnej strony.';
$GLOBALS['TL_LANG']['tl_module']['tag_topten'][0] = 'Najlepsze tagi';
$GLOBALS['TL_LANG']['tl_module']['tag_topten'][1] = 'Pokaż najważniejsze tagi nad chmurą tagów.';
$GLOBALS['TL_LANG']['tl_module']['tag_topten_expanded'][0] = 'Rozwiń Najważniejsze tagi';
$GLOBALS['TL_LANG']['tl_module']['tag_topten_expanded'][1] = 'Rozwiń chmurę tagów Top Tags. Wszystkie tagi w tej chmurze są widoczne.';
$GLOBALS['TL_LANG']['tl_module']['tag_topten_number'][0] = 'Liczba najważniejszych tagów';
$GLOBALS['TL_LANG']['tl_module']['tag_topten_number'][1] = 'Wprowadź maksymalną liczbę, która powinna być używana dla najważniejszych tagów.';
$GLOBALS['TL_LANG']['tl_module']['tag_all_expanded'][0] = 'Rozwiń wszystkie tagi';
$GLOBALS['TL_LANG']['tl_module']['tag_all_expanded'][1] = 'Rozwiń chmurę tagów „Wszystkie tagi”. Wszystkie tagi w tej chmurze są widoczne.';
$GLOBALS['TL_LANG']['tl_module']['tag_related'][0] = 'Pokaż powiązane tagi';
$GLOBALS['TL_LANG']['tl_module']['tag_related'][1] = 'Wybierz tę opcję, aby wyświetlić wszystkie powiązane tagi z wcześniej wybranym tagiem.';
$GLOBALS['TL_LANG']['tl_module']['news_showtags'][0] = 'Pokaż tagi wiadomości';
$GLOBALS['TL_LANG']['tl_module']['news_showtags'][1] = 'Wybierz tę opcję, aby wyświetlić wszystkie przypisane tagi pod każdym wpisem wiadomości. Działa to tylko wtedy, gdy używasz szablonu wiadomości z obsługą tagów, np. news_full_tags';
$GLOBALS['TL_LANG']['tl_module']['event_showtags'][0] = 'Pokaż tagi zdarzeń';
$GLOBALS['TL_LANG']['tl_module']['event_showtags'][1] = 'Wybierz tę opcję, aby wyświetlić wszystkie przypisane tagi pod każdym zdarzeniem. Działa to tylko wtedy, gdy używasz szablonu zdarzenia obsługującego tag, np. wydarzenie__..._tagi';
$GLOBALS['TL_LANG']['tl_module']['tag_ignore'][0] = 'Ignoruj tagi';
$GLOBALS['TL_LANG']['tl_module']['tag_ignore'][1] = 'Wymuś na tym module ignorowanie działań związanych z tagiem (np. pokazywanie tylko wpisów aktualności z danego tagu)';
$GLOBALS['TL_LANG']['tl_module']['keep_url_params'][0] = 'Zachowaj parametry adresu URL';
$GLOBALS['TL_LANG']['tl_module']['keep_url_params'][1] = 'Zachowaj specyficzne dla Contao parametry adresu URL (np. parametry daty archiwów wiadomości) w linkach tagów';
$GLOBALS['TL_LANG']['tl_module']['objecttype'][0] = 'Typ obiektu';
$GLOBALS['TL_LANG']['tl_module']['objecttype'][1] = 'Proszę wybrać typ obiektu, który ma być pokazany na tej liście.';
$GLOBALS['TL_LANG']['tl_module']['tagsource'][0] = 'Źródło tagu';
$GLOBALS['TL_LANG']['tl_module']['tagsource'][1] = 'Proszę wybrać tabelę, która zostanie wykorzystana do zbudowania listy tagów w tym module.';
$GLOBALS['TL_LANG']['tl_module']['pagesource'][0] = 'Strony';
$GLOBALS['TL_LANG']['tl_module']['pagesource'][1] = 'Proszę wybrać strony, które zostaną użyte do zbudowania listy obiektów. Jeżeli wybierzesz stronę zawierającą podstrony, wykorzystane zostaną także wszystkie podstrony.';
$GLOBALS['TL_LANG']['tl_module']['articlelist_template'][0] = 'Szablon listy artykułów';
$GLOBALS['TL_LANG']['tl_module']['articlelist_template'][1] = 'Tutaj możesz wybrać szablon listy artykułów.';
$GLOBALS['TL_LANG']['tl_module']['cloud_template'][0] = 'Szablon chmury tagów';
$GLOBALS['TL_LANG']['tl_module']['cloud_template'][1] = 'Tutaj możesz wybrać szablon chmury tagów.';
$GLOBALS['TL_LANG']['tl_module']['scope_template'][0] = 'Szablon zakresu tagu';
$GLOBALS['TL_LANG']['tl_module']['scope_template'][1] = 'Tutaj możesz wybrać szablon zakresu tagu.';
$GLOBALS['TL_LANG']['tl_module']['clear_text'][0] = 'Tytuł zakresu tagu';
$GLOBALS['TL_LANG']['tl_module']['clear_text'][1] = 'Wprowadź tytuł zakresu tagu. Tytuł jest hiperłączem, które czyści zakres tagu i usuwa wszystkie wybrane tagi.';
$GLOBALS['TL_LANG']['tl_module']['show_empty_scope'][0] = 'Pokaż pusty zakres';
$GLOBALS['TL_LANG']['tl_module']['show_empty_scope'][1] = 'Pokaż zakres tagu, nawet jeśli nie ma aktywnych tagów.';
$GLOBALS['TL_LANG']['tl_module']['tag_show_reset'][0] = 'Pokaż wyraźną opcję';
$GLOBALS['TL_LANG']['tl_module']['tag_show_reset'][1] = 'Pokaż hiperłącze, aby wyczyścić wszystkie zaznaczone tagi.';
$GLOBALS['TL_LANG']['tl_module']['hide_on_empty'][0] = 'Tylko filtrowane wyjście';
$GLOBALS['TL_LANG']['tl_module']['hide_on_empty'][1] = 'Globalna lista artykułów zawsze oczekuje, że jeden lub więcej tagów wygeneruje filtrowane dane wyjściowe. Bez filtra tagów wyświetlana jest pusta lista.';
$GLOBALS['TL_LANG']['tl_module']['tag_alltags'] = 'Wszystkie tagi';
$GLOBALS['TL_LANG']['tl_module']['tag_relatedtags'] = 'Powiązane tagi';
$GLOBALS['TL_LANG']['tl_module']['tl_content'] = 'Elementy treści';
$GLOBALS['TL_LANG']['tl_module']['tl_article'] = 'Artykuły';
$GLOBALS['TL_LANG']['tl_module']['tl_news'] = 'Artykuły z wiadomościami';
$GLOBALS['TL_LANG']['tl_module']['tag_clear_tags'] = 'Wyczyść wybrane tagi';
$GLOBALS['TL_LANG']['tl_module']['tl_calendar_events'] = 'Wydarzenia';
$GLOBALS['TL_LANG']['tl_module']['tl_page'] = 'Strony';
$GLOBALS['TL_LANG']['tl_module']['tags'] = 'Tagi';
$GLOBALS['TL_LANG']['tl_module']['top_tags'] = 'Najpopularniejsze tagi %s';
$GLOBALS['TL_LANG']['tl_module']['showtags_legend'] = 'Ustawienia tagów';
$GLOBALS['TL_LANG']['tl_module']['tagscope_legend'] = 'Ustawienia zakresu tagu';
$GLOBALS['TL_LANG']['tl_module']['size_legend'] = 'Ustawienia liczby i rozmiaru';
$GLOBALS['TL_LANG']['tl_module']['tagextension_legend'] = 'Dodatkowe listy tagów';
$GLOBALS['TL_LANG']['tl_module']['datasource_legend'] = 'Ustawienia źródła danych';
$GLOBALS['TL_LANG']['tl_module']['object_selection_legend'] = 'Typy obiektów';
$GLOBALS['TL_LANG']['tl_module']['tag_articles'][0] = 'Artykuły';
$GLOBALS['TL_LANG']['tl_module']['tag_articles'][1] = 'Wybierz strony, na których artykuły są używane do tworzenia chmury tagów. Jeśli zaznaczysz stronę zawierającą podstrony, użyte zostaną także artykuły ze wszystkich podstron.';
$GLOBALS['TL_LANG']['tl_module']['show_in_column'][0] = 'Ogranicz do określonej kolumny';
$GLOBALS['TL_LANG']['tl_module']['show_in_column'][1] = 'Ogranicz wyjście listy artykułów do określonej kolumny szablonu strony.';
$GLOBALS['TL_LANG']['tl_module']['linktoarticles'][0] = 'Lista artykułów zawiera linki do artykułów';
$GLOBALS['TL_LANG']['tl_module']['linktoarticles'][1] = 'Zaznacz, aby utworzyć listę artykułów z linkami do artykułu lub odznacz, aby utworzyć listę artykułów z linkami do strony zawierającej.';
$GLOBALS['TL_LANG']['tl_module']['restrict_to_column'][0] = 'Ogranicz do określonej kolumny';
$GLOBALS['TL_LANG']['tl_module']['restrict_to_column'][1] = 'Ogranicz chmurę tagów do tagów artykułów z określonej kolumny szablonu strony.';
$GLOBALS['TL_LANG']['tl_module']['articlelist_tpl'][0] = 'Szablon listy artykułów';
$GLOBALS['TL_LANG']['tl_module']['articlelist_tpl'][1] = 'Tutaj możesz wybrać szablon listy artykułów.';
$GLOBALS['TL_LANG']['tl_module']['article_showtags'][0] = 'Pokaż tagi artykułów';
$GLOBALS['TL_LANG']['tl_module']['article_showtags'][1] = 'Wybierz tę opcję, aby wyświetlić wszystkie przypisane tagi pod każdym artykułem. Działa to tylko wtedy, gdy używasz szablonu artykułu obsługującego tagi, np. mod_global_articlelist';
$GLOBALS['TL_LANG']['tl_module']['articlelist_firstorder'][0] = 'Kryteria pierwszego sortowania';
$GLOBALS['TL_LANG']['tl_module']['articlelist_firstorder'][1] = 'Wybierz pierwsze kryteria sortowania dla wynikowej listy artykułów.';
$GLOBALS['TL_LANG']['tl_module']['articlelist_secondorder'][0] = 'Kryteria drugiego sortowania';
$GLOBALS['TL_LANG']['tl_module']['articlelist_secondorder'][1] = 'Wybierz drugie kryterium sortowania dla wynikowej listy artykułów.';
$GLOBALS['TL_LANG']['tl_module']['tag_content_pages'][0] = 'Strony';
$GLOBALS['TL_LANG']['tl_module']['tag_content_pages'][1] = 'Wybierz strony, których elementy treści zostaną użyte do zbudowania chmury tagów. Jeśli wybierzesz stronę zawierającą podstrony, wykorzystane zostaną również elementy treści wszystkich podstron.';
$GLOBALS['TL_LANG']['tl_module']['tag_calendars'][0] = 'Kalendarze';
$GLOBALS['TL_LANG']['tl_module']['tag_calendars'][1] = 'Proszę wybrać kalendarze, które zostaną użyte do zbudowania chmury tagów.';
$GLOBALS['TL_LANG']['tl_module']['tag_membergroups'][0] = 'Grupy członkowskie';
$GLOBALS['TL_LANG']['tl_module']['tag_membergroups'][1] = 'Wybierz jedną lub więcej grup członkowskich, aby utworzyć chmurę tagów członkowskich.';
$GLOBALS['TL_LANG']['tl_module']['tag_news_archives'][0] = 'Archiwa wiadomości';
$GLOBALS['TL_LANG']['tl_module']['tag_news_archives'][1] = 'Wybierz archiwa wiadomości, które zostaną użyte do zbudowania chmury tagów.';
