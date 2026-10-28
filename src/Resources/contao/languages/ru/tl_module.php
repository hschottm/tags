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

$GLOBALS['TL_LANG']['tl_module']['tag_jumpTo'][0] = 'Перейти на страницу';
$GLOBALS['TL_LANG']['tl_module']['tag_jumpTo'][1] = 'Этот параметр определяет, на какую страницу будет перенаправлен пользователь при нажатии на ссылку тега.';
$GLOBALS['TL_LANG']['tl_module']['tag_forTable'][0] = 'Таблицы тегов';
$GLOBALS['TL_LANG']['tl_module']['tag_forTable'][1] = 'Пожалуйста, выберите таблицы, которые используются для отображения облака тегов. Этот выбор действителен, только если вы используете предопределенную таблицу <em>tl_tag</em> для хранения тегов.';
$GLOBALS['TL_LANG']['tl_module']['tag_tagtable'][0] = 'Таблица источников тегов';
$GLOBALS['TL_LANG']['tl_module']['tag_tagtable'][1] = 'Введите имя исходной таблицы, в которой можно найти теги. По умолчанию в этом поле используется предопределенная таблица <em>tl_tag</em>.';
$GLOBALS['TL_LANG']['tl_module']['tag_tagfield'][0] = 'Поле таблицы тегов';
$GLOBALS['TL_LANG']['tl_module']['tag_tagfield'][1] = 'Введите имя поля таблицы, в котором хранятся теги. По умолчанию это поле имеет предопределенное имя <em>tag</em>.';
$GLOBALS['TL_LANG']['tl_module']['tag_filter'][0] = 'Фильтр тегов';
$GLOBALS['TL_LANG']['tl_module']['tag_filter'][1] = 'Введите разделенный запятыми список тегов, чтобы отфильтровать выходные данные модуля.';
$GLOBALS['TL_LANG']['tl_module']['tag_maxtags'][0] = 'Максимальное количество тегов';
$GLOBALS['TL_LANG']['tl_module']['tag_maxtags'][1] = 'Введите максимальное количество тегов в облаке тегов. Если облако тегов содержит больше тегов, чем максимальное количество тегов, теги с наименьшим количеством совпадений будут удалены из облака. Если вы не введете значение или значение равно 0, будут показаны все теги.';
$GLOBALS['TL_LANG']['tl_module']['tag_buckets'][0] = 'Количество размеров тегов';
$GLOBALS['TL_LANG']['tl_module']['tag_buckets'][1] = 'Введите количество размеров тегов во внешнем интерфейсе. Каждая группа тегов получает свой собственный размер тега во внешнем интерфейсе. Размеры тегов будут заданы в виде селекторов CSS size1, size2, size3 ... size<em>n</em>.';
$GLOBALS['TL_LANG']['tl_module']['tag_named_class'][0] = 'Использовать имя класса тега';
$GLOBALS['TL_LANG']['tl_module']['tag_named_class'][1] = 'Добавляет дополнительный класс класса CSS для каждого тега, содержащего имя тега. Используйте это дополнительное имя класса для дополнительного оформления тегов с помощью CSS. Пробелы в именах тегов будут заменены символами подчеркивания в именах классов CSS.';
$GLOBALS['TL_LANG']['tl_module']['tag_on_page_class'][0] = 'Тег существует на странице';
$GLOBALS['TL_LANG']['tl_module']['tag_on_page_class'][1] = 'Добавляет дополнительный класс CSS («здесь») для каждого тега, назначенного фактической странице.';
$GLOBALS['TL_LANG']['tl_module']['tag_topten'][0] = 'Популярные теги';
$GLOBALS['TL_LANG']['tl_module']['tag_topten'][1] = 'Покажите самые популярные теги над облаком тегов.';
$GLOBALS['TL_LANG']['tl_module']['tag_topten_expanded'][0] = 'Развернуть популярные теги';
$GLOBALS['TL_LANG']['tl_module']['tag_topten_expanded'][1] = 'Разверните облако тегов Top Tags. Все теги в этом облаке видны.';
$GLOBALS['TL_LANG']['tl_module']['tag_topten_number'][0] = 'Количество топ-тегов';
$GLOBALS['TL_LANG']['tl_module']['tag_topten_number'][1] = 'Введите максимальное число, которое следует использовать для топ-тегов.';
$GLOBALS['TL_LANG']['tl_module']['tag_all_expanded'][0] = 'Развернуть все теги';
$GLOBALS['TL_LANG']['tl_module']['tag_all_expanded'][1] = 'Разверните облако тегов «Все теги». Все теги в этом облаке видны.';
$GLOBALS['TL_LANG']['tl_module']['tag_related'][0] = 'Показать связанные теги';
$GLOBALS['TL_LANG']['tl_module']['tag_related'][1] = 'Выберите этот параметр, чтобы отобразить все связанные теги ранее выбранного тега.';
$GLOBALS['TL_LANG']['tl_module']['news_showtags'][0] = 'Показать теги новостей';
$GLOBALS['TL_LANG']['tl_module']['news_showtags'][1] = 'Выберите этот параметр, чтобы отображать все назначенные теги под каждой записью новостей. Это работает только в том случае, если вы используете шаблон новостей с поддержкой тегов, например. news_full_tags';
$GLOBALS['TL_LANG']['tl_module']['event_showtags'][0] = 'Показать теги событий';
$GLOBALS['TL_LANG']['tl_module']['event_showtags'][1] = 'Выберите этот параметр, чтобы отображать все назначенные теги под каждым событием. Это работает только в том случае, если вы используете шаблон событий с поддержкой тегов, например. event_..._tags';
$GLOBALS['TL_LANG']['tl_module']['tag_ignore'][0] = 'Игнорировать теги';
$GLOBALS['TL_LANG']['tl_module']['tag_ignore'][1] = 'Заставить этот модуль игнорировать действия, связанные с тегом (например, показывать только записи новостей данного тега)';
$GLOBALS['TL_LANG']['tl_module']['keep_url_params'][0] = 'Сохранять параметры URL';
$GLOBALS['TL_LANG']['tl_module']['keep_url_params'][1] = 'Сохраняйте конкретные параметры URL-адреса Contao (например, параметры даты архивов новостей) в ссылках тегов.';
$GLOBALS['TL_LANG']['tl_module']['objecttype'][0] = 'Тип объекта';
$GLOBALS['TL_LANG']['tl_module']['objecttype'][1] = 'Пожалуйста, выберите тип объекта, который должен отображаться в этом списке.';
$GLOBALS['TL_LANG']['tl_module']['tagsource'][0] = 'Источник тега';
$GLOBALS['TL_LANG']['tl_module']['tagsource'][1] = 'Пожалуйста, выберите таблицу, которая используется для построения списка тегов в этом модуле.';
$GLOBALS['TL_LANG']['tl_module']['pagesource'][0] = 'Страницы';
$GLOBALS['TL_LANG']['tl_module']['pagesource'][1] = 'Пожалуйста, выберите страницы, которые используются для создания списка объектов. Если вы выберете страницу, содержащую подстраницы, все подстраницы также будут использоваться.';
$GLOBALS['TL_LANG']['tl_module']['articlelist_template'][0] = 'Шаблон списка статей';
$GLOBALS['TL_LANG']['tl_module']['articlelist_template'][1] = 'Здесь вы можете выбрать шаблон списка статей.';
$GLOBALS['TL_LANG']['tl_module']['cloud_template'][0] = 'Шаблон облака тегов';
$GLOBALS['TL_LANG']['tl_module']['cloud_template'][1] = 'Здесь вы можете выбрать шаблон облака тегов.';
$GLOBALS['TL_LANG']['tl_module']['scope_template'][0] = 'Шаблон области действия тега';
$GLOBALS['TL_LANG']['tl_module']['scope_template'][1] = 'Здесь вы можете выбрать шаблон области действия тега.';
$GLOBALS['TL_LANG']['tl_module']['clear_text'][0] = 'Название области тега';
$GLOBALS['TL_LANG']['tl_module']['clear_text'][1] = 'Введите название области действия тега. Заголовок — это гиперссылка, которая очищает область тега и удаляет все выбранные теги.';
$GLOBALS['TL_LANG']['tl_module']['show_empty_scope'][0] = 'Показать пустую область';
$GLOBALS['TL_LANG']['tl_module']['show_empty_scope'][1] = 'Показывать область действия тега, даже если активных тегов нет.';
$GLOBALS['TL_LANG']['tl_module']['tag_show_reset'][0] = 'Показать четкую опцию';
$GLOBALS['TL_LANG']['tl_module']['tag_show_reset'][1] = 'Показать гиперссылку, чтобы очистить все выбранные теги.';
$GLOBALS['TL_LANG']['tl_module']['hide_on_empty'][0] = 'Только отфильтрованный вывод';
$GLOBALS['TL_LANG']['tl_module']['hide_on_empty'][1] = 'Глобальный список статей всегда ожидает, что один или несколько тегов дадут отфильтрованный результат. Без фильтра тегов отображается пустой список.';
$GLOBALS['TL_LANG']['tl_module']['tag_alltags'] = 'Все теги';
$GLOBALS['TL_LANG']['tl_module']['tag_relatedtags'] = 'Связанные теги';
$GLOBALS['TL_LANG']['tl_module']['tl_content'] = 'Элементы контента';
$GLOBALS['TL_LANG']['tl_module']['tl_article'] = 'Статьи';
$GLOBALS['TL_LANG']['tl_module']['tl_news'] = 'Новостные статьи';
$GLOBALS['TL_LANG']['tl_module']['tag_clear_tags'] = 'Очистить выбранные теги';
$GLOBALS['TL_LANG']['tl_module']['tl_calendar_events'] = 'События';
$GLOBALS['TL_LANG']['tl_module']['tl_page'] = 'Страницы';
$GLOBALS['TL_LANG']['tl_module']['tags'] = 'Теги';
$GLOBALS['TL_LANG']['tl_module']['top_tags'] = 'Топ %s Теги';
$GLOBALS['TL_LANG']['tl_module']['showtags_legend'] = 'Настройки тегов';
$GLOBALS['TL_LANG']['tl_module']['tagscope_legend'] = 'Настройки области действия тега';
$GLOBALS['TL_LANG']['tl_module']['size_legend'] = 'Настройки количества и размера';
$GLOBALS['TL_LANG']['tl_module']['tagextension_legend'] = 'Дополнительные списки тегов';
$GLOBALS['TL_LANG']['tl_module']['datasource_legend'] = 'Настройки источника данных';
$GLOBALS['TL_LANG']['tl_module']['object_selection_legend'] = 'Типы объектов';
$GLOBALS['TL_LANG']['tl_module']['tag_articles'][0] = 'Статьи';
$GLOBALS['TL_LANG']['tl_module']['tag_articles'][1] = 'Пожалуйста, выберите страницы, на которых их статьи используются для создания облака тегов. Если вы проверите страницу, содержащую подстраницы, статьи всех подстраниц также будут использованы.';
$GLOBALS['TL_LANG']['tl_module']['show_in_column'][0] = 'Ограничить определенным столбцом';
$GLOBALS['TL_LANG']['tl_module']['show_in_column'][1] = 'Ограничьте вывод списка статей определенным столбцом шаблона страницы.';
$GLOBALS['TL_LANG']['tl_module']['linktoarticles'][0] = 'Список статей, ссылки на статьи';
$GLOBALS['TL_LANG']['tl_module']['linktoarticles'][1] = 'Установите этот флажок, чтобы создать список статей со ссылками на статью, или снимите флажок, чтобы создать список статей со ссылками на содержащую страницу.';
$GLOBALS['TL_LANG']['tl_module']['restrict_to_column'][0] = 'Ограничить определенным столбцом';
$GLOBALS['TL_LANG']['tl_module']['restrict_to_column'][1] = 'Ограничьте облако тегов тегами статей из определенного столбца шаблона страницы.';
$GLOBALS['TL_LANG']['tl_module']['articlelist_tpl'][0] = 'Шаблон списка статей';
$GLOBALS['TL_LANG']['tl_module']['articlelist_tpl'][1] = 'Здесь вы можете выбрать шаблон списка статей.';
$GLOBALS['TL_LANG']['tl_module']['article_showtags'][0] = 'Показать теги статей';
$GLOBALS['TL_LANG']['tl_module']['article_showtags'][1] = 'Выберите этот параметр, чтобы отображать все назначенные теги под каждой статьей. Это работает только в том случае, если вы используете шаблон статьи с поддержкой тегов, например. mod_global_articlelist';
$GLOBALS['TL_LANG']['tl_module']['articlelist_firstorder'][0] = 'Критерии первой сортировки';
$GLOBALS['TL_LANG']['tl_module']['articlelist_firstorder'][1] = 'Выберите первый критерий сортировки для результирующего списка статей.';
$GLOBALS['TL_LANG']['tl_module']['articlelist_secondorder'][0] = 'Критерии второй сортировки';
$GLOBALS['TL_LANG']['tl_module']['articlelist_secondorder'][1] = 'Выберите второй критерий сортировки результирующего списка статей.';
$GLOBALS['TL_LANG']['tl_module']['tag_content_pages'][0] = 'Страницы';
$GLOBALS['TL_LANG']['tl_module']['tag_content_pages'][1] = 'Пожалуйста, выберите страницы, элементы контента которых используются для создания облака тегов. Если вы выберете страницу, содержащую подстраницы, элементы содержимого всех подстраниц также будут использоваться.';
$GLOBALS['TL_LANG']['tl_module']['tag_calendars'][0] = 'Календари';
$GLOBALS['TL_LANG']['tl_module']['tag_calendars'][1] = 'Пожалуйста, выберите календари, которые используются для создания облака тегов.';
$GLOBALS['TL_LANG']['tl_module']['tag_membergroups'][0] = 'Группы участников';
$GLOBALS['TL_LANG']['tl_module']['tag_membergroups'][1] = 'Выберите одну или несколько групп участников, чтобы создать облако тегов участников.';
$GLOBALS['TL_LANG']['tl_module']['tag_news_archives'][0] = 'Архив новостей';
$GLOBALS['TL_LANG']['tl_module']['tag_news_archives'][1] = 'Пожалуйста, выберите архивы новостей, которые используются для создания облака тегов.';
