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

$GLOBALS['TL_LANG']['tl_module']['tag_jumpTo'][0] = 'Saltar a la página';
$GLOBALS['TL_LANG']['tl_module']['tag_jumpTo'][1] = 'Esta configuración define a qué página se redirigirá a un usuario al hacer clic en el enlace de una etiqueta.';
$GLOBALS['TL_LANG']['tl_module']['tag_forTable'][0] = 'Tablas de etiquetas';
$GLOBALS['TL_LANG']['tl_module']['tag_forTable'][1] = 'Seleccione las tablas que se utilizan para mostrar la nube de etiquetas. Esta selección es válida solo si utiliza la tabla predefinida <em>tl_tag</em> para almacenar las etiquetas.';
$GLOBALS['TL_LANG']['tl_module']['tag_tagtable'][0] = 'Tabla de origen de etiquetas';
$GLOBALS['TL_LANG']['tl_module']['tag_tagtable'][1] = 'Introduzca el nombre de la tabla de origen en la que se pueden encontrar las etiquetas. Este campo tiene como valor predeterminado la tabla predefinida <em>tl_tag</em>.';
$GLOBALS['TL_LANG']['tl_module']['tag_tagfield'][0] = 'Campo de tabla de etiquetas';
$GLOBALS['TL_LANG']['tl_module']['tag_tagfield'][1] = 'Introduzca el nombre del campo de la tabla que contiene las etiquetas. Este campo tiene por defecto el nombre de campo predefinido <em>tag</em>.';
$GLOBALS['TL_LANG']['tl_module']['tag_filter'][0] = 'Filtro de etiquetas';
$GLOBALS['TL_LANG']['tl_module']['tag_filter'][1] = 'Ingrese una lista de etiquetas separadas por comas para filtrar la salida del módulo.';
$GLOBALS['TL_LANG']['tl_module']['tag_maxtags'][0] = 'Número máximo de etiquetas';
$GLOBALS['TL_LANG']['tl_module']['tag_maxtags'][1] = 'Introduzca el número máximo de etiquetas en la nube de etiquetas. Si la nube de etiquetas contiene más etiquetas que el número máximo de etiquetas, las etiquetas con el menor número de coincidencias se eliminarán de la nube. Si no ingresa un valor o el valor es 0, se mostrarán todas las etiquetas.';
$GLOBALS['TL_LANG']['tl_module']['tag_buckets'][0] = 'Número de tamaños de etiquetas';
$GLOBALS['TL_LANG']['tl_module']['tag_buckets'][1] = 'Ingrese el número de tamaños de etiquetas en la interfaz. Cada grupo de etiquetas tiene su propio tamaño de etiqueta en la interfaz. Los tamaños de las etiquetas se proporcionarán como selectores CSS tamaño1, tamaño2, tamaño3... tamaño<em>n</em>.';
$GLOBALS['TL_LANG']['tl_module']['tag_named_class'][0] = 'Usar etiqueta nombre de clase';
$GLOBALS['TL_LANG']['tl_module']['tag_named_class'][1] = 'Agrega una clase CSS adicional para cada etiqueta que contiene el nombre de la etiqueta. Utilice este nombre de clase adicional para aplicar estilos adicionales a las etiquetas mediante CSS. Los espacios en los nombres de las etiquetas se reemplazarán con guiones bajos en los nombres de las clases CSS.';
$GLOBALS['TL_LANG']['tl_module']['tag_on_page_class'][0] = 'La etiqueta existe en la página.';
$GLOBALS['TL_LANG']['tl_module']['tag_on_page_class'][1] = 'Agrega una clase CSS adicional ("aquí") para cada etiqueta que se haya asignado a la página real.';
$GLOBALS['TL_LANG']['tl_module']['tag_topten'][0] = 'Etiquetas principales';
$GLOBALS['TL_LANG']['tl_module']['tag_topten'][1] = 'Muestra las etiquetas principales encima de la nube de etiquetas.';
$GLOBALS['TL_LANG']['tl_module']['tag_topten_expanded'][0] = 'Expandir etiquetas principales';
$GLOBALS['TL_LANG']['tl_module']['tag_topten_expanded'][1] = 'Expanda la nube de etiquetas Etiquetas principales. Todas las etiquetas en esta nube son visibles.';
$GLOBALS['TL_LANG']['tl_module']['tag_topten_number'][0] = 'Número de etiquetas principales';
$GLOBALS['TL_LANG']['tl_module']['tag_topten_number'][1] = 'Ingrese el número máximo que debe usarse para las etiquetas principales.';
$GLOBALS['TL_LANG']['tl_module']['tag_all_expanded'][0] = 'Expandir todas las etiquetas';
$GLOBALS['TL_LANG']['tl_module']['tag_all_expanded'][1] = 'Expanda la nube de etiquetas "Todas las etiquetas". Todas las etiquetas en esta nube son visibles.';
$GLOBALS['TL_LANG']['tl_module']['tag_related'][0] = 'Mostrar etiquetas relacionadas';
$GLOBALS['TL_LANG']['tl_module']['tag_related'][1] = 'Seleccione esta opción para mostrar todas las etiquetas relacionadas de una etiqueta seleccionada previamente.';
$GLOBALS['TL_LANG']['tl_module']['news_showtags'][0] = 'Mostrar etiquetas de noticias';
$GLOBALS['TL_LANG']['tl_module']['news_showtags'][1] = 'Seleccione esta opción para mostrar todas las etiquetas asignadas debajo de cada entrada de noticias. Esto solo funciona si utiliza una plantilla de noticias habilitada para etiquetas, p. noticias_full_tags';
$GLOBALS['TL_LANG']['tl_module']['event_showtags'][0] = 'Mostrar etiquetas de eventos';
$GLOBALS['TL_LANG']['tl_module']['event_showtags'][1] = 'Seleccione esta opción para mostrar todas las etiquetas asignadas debajo de cada evento. Esto solo funciona si utiliza una plantilla de evento habilitada para etiquetas, p. evento_..._etiquetas';
$GLOBALS['TL_LANG']['tl_module']['tag_ignore'][0] = 'Ignorar etiquetas';
$GLOBALS['TL_LANG']['tl_module']['tag_ignore'][1] = 'Obligar a este módulo a ignorar las acciones relacionadas con etiquetas (por ejemplo, mostrar solo entradas de noticias de una etiqueta determinada)';
$GLOBALS['TL_LANG']['tl_module']['keep_url_params'][0] = 'Mantener los parámetros de URL';
$GLOBALS['TL_LANG']['tl_module']['keep_url_params'][1] = 'Mantenga los parámetros de URL específicos de Contao (por ejemplo, parámetros de fecha de archivos de noticias) en los enlaces de etiquetas';
$GLOBALS['TL_LANG']['tl_module']['objecttype'][0] = 'tipo de objeto';
$GLOBALS['TL_LANG']['tl_module']['objecttype'][1] = 'Seleccione el tipo de objeto que debe mostrarse en esta lista.';
$GLOBALS['TL_LANG']['tl_module']['tagsource'][0] = 'Fuente de la etiqueta';
$GLOBALS['TL_LANG']['tl_module']['tagsource'][1] = 'Seleccione la tabla que se utiliza para crear la lista de etiquetas en este módulo.';
$GLOBALS['TL_LANG']['tl_module']['pagesource'][0] = 'paginas';
$GLOBALS['TL_LANG']['tl_module']['pagesource'][1] = 'Seleccione las páginas que se utilizan para crear la lista de objetos. Si selecciona una página que contiene subpáginas, también se utilizarán todas las subpáginas.';
$GLOBALS['TL_LANG']['tl_module']['articlelist_template'][0] = 'Plantilla de lista de artículos';
$GLOBALS['TL_LANG']['tl_module']['articlelist_template'][1] = 'Aquí puede seleccionar la plantilla de lista de artículos.';
$GLOBALS['TL_LANG']['tl_module']['cloud_template'][0] = 'Plantilla de nube de etiquetas';
$GLOBALS['TL_LANG']['tl_module']['cloud_template'][1] = 'Aquí puede seleccionar la plantilla de nube de etiquetas.';
$GLOBALS['TL_LANG']['tl_module']['scope_template'][0] = 'Plantilla de alcance de etiqueta';
$GLOBALS['TL_LANG']['tl_module']['scope_template'][1] = 'Aquí puede seleccionar la plantilla de alcance de la etiqueta.';
$GLOBALS['TL_LANG']['tl_module']['clear_text'][0] = 'Título del alcance de la etiqueta';
$GLOBALS['TL_LANG']['tl_module']['clear_text'][1] = 'Introduzca un título para el alcance de la etiqueta. El título es un hipervínculo que borra el alcance de la etiqueta y elimina todas las etiquetas seleccionadas.';
$GLOBALS['TL_LANG']['tl_module']['show_empty_scope'][0] = 'Mostrar alcance vacío';
$GLOBALS['TL_LANG']['tl_module']['show_empty_scope'][1] = 'Muestra el alcance de la etiqueta incluso si no hay etiquetas activas.';
$GLOBALS['TL_LANG']['tl_module']['tag_show_reset'][0] = 'Mostrar opción clara';
$GLOBALS['TL_LANG']['tl_module']['tag_show_reset'][1] = 'Muestre un hipervínculo para borrar todas las etiquetas seleccionadas.';
$GLOBALS['TL_LANG']['tl_module']['hide_on_empty'][0] = 'Solo salida filtrada';
$GLOBALS['TL_LANG']['tl_module']['hide_on_empty'][1] = 'La lista de artículos global siempre espera que una o más etiquetas produzcan una salida filtrada. Sin un filtro de etiquetas, se muestra una lista vacía.';
$GLOBALS['TL_LANG']['tl_module']['tag_alltags'] = 'Todas las etiquetas';
$GLOBALS['TL_LANG']['tl_module']['tag_relatedtags'] = 'Etiquetas relacionadas';
$GLOBALS['TL_LANG']['tl_module']['tl_content'] = 'Elementos de contenido';
$GLOBALS['TL_LANG']['tl_module']['tl_article'] = 'Artículos';
$GLOBALS['TL_LANG']['tl_module']['tl_news'] = 'Artículos de noticias';
$GLOBALS['TL_LANG']['tl_module']['tag_clear_tags'] = 'Borrar etiquetas seleccionadas';
$GLOBALS['TL_LANG']['tl_module']['tl_calendar_events'] = 'Eventos';
$GLOBALS['TL_LANG']['tl_module']['tl_page'] = 'paginas';
$GLOBALS['TL_LANG']['tl_module']['tags'] = 'Etiquetas';
$GLOBALS['TL_LANG']['tl_module']['top_tags'] = 'Etiquetas principales %s';
$GLOBALS['TL_LANG']['tl_module']['showtags_legend'] = 'Configuración de etiquetas';
$GLOBALS['TL_LANG']['tl_module']['tagscope_legend'] = 'Configuración del alcance de la etiqueta';
$GLOBALS['TL_LANG']['tl_module']['size_legend'] = 'Configuración de número y tamaño';
$GLOBALS['TL_LANG']['tl_module']['tagextension_legend'] = 'Listas de etiquetas adicionales';
$GLOBALS['TL_LANG']['tl_module']['datasource_legend'] = 'Configuración de fuente de datos';
$GLOBALS['TL_LANG']['tl_module']['object_selection_legend'] = 'Tipos de objetos';
$GLOBALS['TL_LANG']['tl_module']['tag_articles'][0] = 'Artículos';
$GLOBALS['TL_LANG']['tl_module']['tag_articles'][1] = 'Seleccione las páginas que se utilizan sus artículos para crear la nube de etiquetas. Si marca una página que contiene subpáginas, también se utilizarán los artículos de todas las subpáginas.';
$GLOBALS['TL_LANG']['tl_module']['show_in_column'][0] = 'Restringir a una columna específica';
$GLOBALS['TL_LANG']['tl_module']['show_in_column'][1] = 'Restrinja la salida de la lista de artículos a una columna específica de la plantilla de página.';
$GLOBALS['TL_LANG']['tl_module']['linktoarticles'][0] = 'Enlaces de lista de artículos a artículos';
$GLOBALS['TL_LANG']['tl_module']['linktoarticles'][1] = 'Marque para crear una lista de artículos con enlaces al artículo o desmarque para crear una lista de artículos con enlaces a la página que lo contiene.';
$GLOBALS['TL_LANG']['tl_module']['restrict_to_column'][0] = 'Restringir a una columna específica';
$GLOBALS['TL_LANG']['tl_module']['restrict_to_column'][1] = 'Restrinja la nube de etiquetas a etiquetas de artículos de una columna específica de la plantilla de página.';
$GLOBALS['TL_LANG']['tl_module']['articlelist_tpl'][0] = 'Plantilla de lista de artículos';
$GLOBALS['TL_LANG']['tl_module']['articlelist_tpl'][1] = 'Aquí puede seleccionar la plantilla de lista de artículos.';
$GLOBALS['TL_LANG']['tl_module']['article_showtags'][0] = 'Mostrar etiquetas de artículo';
$GLOBALS['TL_LANG']['tl_module']['article_showtags'][1] = 'Seleccione esta opción para mostrar todas las etiquetas asignadas debajo de cada artículo. Esto solo funciona si utiliza una plantilla de artículo habilitada para etiquetas, p. mod_global_articlelist';
$GLOBALS['TL_LANG']['tl_module']['articlelist_firstorder'][0] = 'Primer criterio de clasificación';
$GLOBALS['TL_LANG']['tl_module']['articlelist_firstorder'][1] = 'Seleccione el primer criterio de clasificación para la lista de artículos resultante.';
$GLOBALS['TL_LANG']['tl_module']['articlelist_secondorder'][0] = 'Segundo criterio de clasificación';
$GLOBALS['TL_LANG']['tl_module']['articlelist_secondorder'][1] = 'Seleccione el segundo criterio de clasificación para la lista de artículos resultante.';
$GLOBALS['TL_LANG']['tl_module']['tag_content_pages'][0] = 'paginas';
$GLOBALS['TL_LANG']['tl_module']['tag_content_pages'][1] = 'Seleccione las páginas cuyos elementos de contenido se utilizan para crear la nube de etiquetas. Si selecciona una página que contiene subpáginas, también se utilizarán los elementos de contenido de todas las subpáginas.';
$GLOBALS['TL_LANG']['tl_module']['tag_calendars'][0] = 'Calendarios';
$GLOBALS['TL_LANG']['tl_module']['tag_calendars'][1] = 'Seleccione los calendarios que se utilizan para crear la nube de etiquetas.';
$GLOBALS['TL_LANG']['tl_module']['tag_membergroups'][0] = 'Grupos de miembros';
$GLOBALS['TL_LANG']['tl_module']['tag_membergroups'][1] = 'Seleccione uno o más grupos de miembros para crear la nube de etiquetas de miembros.';
$GLOBALS['TL_LANG']['tl_module']['tag_news_archives'][0] = 'Archivos de noticias';
$GLOBALS['TL_LANG']['tl_module']['tag_news_archives'][1] = 'Seleccione los archivos de noticias que se utilizan para crear la nube de etiquetas.';
