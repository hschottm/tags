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

$GLOBALS['TL_LANG']['tl_module']['tag_jumpTo'][0] = 'Sayfaya atla';
$GLOBALS['TL_LANG']['tl_module']['tag_jumpTo'][1] = 'Bu ayar, kullanıcının bir etiket bağlantısını tıkladığında hangi sayfaya yönlendirileceğini tanımlar.';
$GLOBALS['TL_LANG']['tl_module']['tag_forTable'][0] = 'Tabloları etiketleyin';
$GLOBALS['TL_LANG']['tl_module']['tag_forTable'][1] = 'Lütfen etiket bulutunu göstermek için kullanılan tabloları seçin. Bu seçim yalnızca etiketleri depolamak için önceden tanımlanmış <em>tl_tag</em> tablosunu kullanıyorsanız geçerlidir.';
$GLOBALS['TL_LANG']['tl_module']['tag_tagtable'][0] = 'Etiket kaynağı tablosu';
$GLOBALS['TL_LANG']['tl_module']['tag_tagtable'][1] = 'Lütfen etiketlerin bulunabileceği kaynak tablonun adını girin. Bu alan varsayılan olarak önceden tanımlanmış <em>tl_tag</em> tablosuna ayarlanır.';
$GLOBALS['TL_LANG']['tl_module']['tag_tagfield'][0] = 'Etiket tablosu alanı';
$GLOBALS['TL_LANG']['tl_module']['tag_tagfield'][1] = 'Lütfen etiketleri içeren tablo alanının adını girin. Bu alan varsayılan olarak <em>tag</em> önceden tanımlanmış alan adına sahiptir.';
$GLOBALS['TL_LANG']['tl_module']['tag_filter'][0] = 'Etiket filtresi';
$GLOBALS['TL_LANG']['tl_module']['tag_filter'][1] = 'Modül çıktısını filtrelemek için lütfen virgülle ayrılmış bir etiket listesi girin.';
$GLOBALS['TL_LANG']['tl_module']['tag_maxtags'][0] = 'Maksimum etiket sayısı';
$GLOBALS['TL_LANG']['tl_module']['tag_maxtags'][1] = 'Lütfen etiket bulutuna maksimum etiket sayısını girin. Etiket bulutu maksimum etiket sayısından daha fazla etiket içeriyorsa, en az sayıda isabete sahip olan etiketler buluttan kaldırılacaktır. Değer girmezseniz veya değer 0 ise tüm etiketler gösterilecektir.';
$GLOBALS['TL_LANG']['tl_module']['tag_buckets'][0] = 'Etiket boyutu sayısı';
$GLOBALS['TL_LANG']['tl_module']['tag_buckets'][1] = 'Lütfen ön uçtaki etiket boyutlarının sayısını girin. Her etiket grubunun ön uçta kendi etiket boyutu vardır. Etiket boyutları CSS seçicileri size1, size2, size3 ... size<em>n</em> olarak verilecektir.';
$GLOBALS['TL_LANG']['tl_module']['tag_named_class'][0] = 'Sınıf adı etiketini kullan';
$GLOBALS['TL_LANG']['tl_module']['tag_named_class'][1] = 'Etiket adını içeren her etiket için ek bir CSS sınıfı sınıfı ekler. CSS aracılığıyla etiketlerin ek stili için bu ekstra sınıf adını kullanın. Etiket adlarındaki boşluklar, CSS sınıf adlarındaki alt çizgilerle değiştirilecektir.';
$GLOBALS['TL_LANG']['tl_module']['tag_on_page_class'][0] = 'Etiket sayfada mevcut';
$GLOBALS['TL_LANG']['tl_module']['tag_on_page_class'][1] = 'Gerçek sayfaya atanmış her etiket için ek bir CSS sınıfı (\'buraya\') ekler.';
$GLOBALS['TL_LANG']['tl_module']['tag_topten'][0] = 'En İyi Etiketler';
$GLOBALS['TL_LANG']['tl_module']['tag_topten'][1] = 'En İyi Etiketleri etiket bulutunun üzerinde gösterin.';
$GLOBALS['TL_LANG']['tl_module']['tag_topten_expanded'][0] = 'En İyi Etiketleri Genişlet';
$GLOBALS['TL_LANG']['tl_module']['tag_topten_expanded'][1] = 'En İyi Etiketler etiket bulutunu genişletin. Bu buluttaki tüm etiketler görünür.';
$GLOBALS['TL_LANG']['tl_module']['tag_topten_number'][0] = 'En İyi Etiket Sayısı';
$GLOBALS['TL_LANG']['tl_module']['tag_topten_number'][1] = 'Üst Etiketler için kullanılması gereken maksimum sayıyı giriniz.';
$GLOBALS['TL_LANG']['tl_module']['tag_all_expanded'][0] = 'Tüm Etiketleri Genişlet';
$GLOBALS['TL_LANG']['tl_module']['tag_all_expanded'][1] = '\'Tüm Etiketler\' etiket bulutunu genişletin. Bu buluttaki tüm etiketler görünür.';
$GLOBALS['TL_LANG']['tl_module']['tag_related'][0] = 'İlgili etiketleri göster';
$GLOBALS['TL_LANG']['tl_module']['tag_related'][1] = 'Daha önce seçilen bir etiketin tüm ilgili etiketlerini göstermek için bu seçeneği seçin.';
$GLOBALS['TL_LANG']['tl_module']['news_showtags'][0] = 'Haber etiketlerini göster';
$GLOBALS['TL_LANG']['tl_module']['news_showtags'][1] = 'Her haber girişinin altında atanan tüm etiketleri göstermek için bu seçeneği seçin. Bu yalnızca etiketin etkin olduğu bir haber şablonu kullanıyorsanız işe yarar; news_full_tags';
$GLOBALS['TL_LANG']['tl_module']['event_showtags'][0] = 'Etkinlik etiketlerini göster';
$GLOBALS['TL_LANG']['tl_module']['event_showtags'][1] = 'Her etkinliğin altında atanan tüm etiketleri göstermek için bu seçeneği seçin. Bu yalnızca etiketin etkin olduğu bir etkinlik şablonu kullanıyorsanız işe yarar; etkinlik__..._etiketler';
$GLOBALS['TL_LANG']['tl_module']['tag_ignore'][0] = 'Etiketleri yoksay';
$GLOBALS['TL_LANG']['tl_module']['tag_ignore'][1] = 'Bu modülü, etiketle ilgili eylemleri göz ardı etmeye zorlayın (örneğin, yalnızca belirli bir etiketin haber girişlerini gösterin)';
$GLOBALS['TL_LANG']['tl_module']['keep_url_params'][0] = 'URL parametrelerini koru';
$GLOBALS['TL_LANG']['tl_module']['keep_url_params'][1] = 'Contao\'ya özgü URL parametrelerini (ör. haber arşivlerinin tarih parametreleri) etiket bağlantılarında tutun';
$GLOBALS['TL_LANG']['tl_module']['objecttype'][0] = 'Nesne türü';
$GLOBALS['TL_LANG']['tl_module']['objecttype'][1] = 'Lütfen bu listede gösterilmesi gereken nesne türünü seçin.';
$GLOBALS['TL_LANG']['tl_module']['tagsource'][0] = 'Etiket kaynağı';
$GLOBALS['TL_LANG']['tl_module']['tagsource'][1] = 'Lütfen bu modülde etiket listesini oluşturmak için kullanılan tabloyu seçin.';
$GLOBALS['TL_LANG']['tl_module']['pagesource'][0] = 'Sayfalar';
$GLOBALS['TL_LANG']['tl_module']['pagesource'][1] = 'Lütfen nesne listesini oluşturmak için kullanılan sayfaları seçin. Alt sayfalar içeren bir sayfa seçerseniz tüm alt sayfalar da kullanılacaktır.';
$GLOBALS['TL_LANG']['tl_module']['articlelist_template'][0] = 'Makale listesi şablonu';
$GLOBALS['TL_LANG']['tl_module']['articlelist_template'][1] = 'Burada makale listesi şablonunu seçebilirsiniz.';
$GLOBALS['TL_LANG']['tl_module']['cloud_template'][0] = 'Etiket bulutu şablonu';
$GLOBALS['TL_LANG']['tl_module']['cloud_template'][1] = 'Burada etiket bulutu şablonunu seçebilirsiniz.';
$GLOBALS['TL_LANG']['tl_module']['scope_template'][0] = 'Etiket kapsamı şablonu';
$GLOBALS['TL_LANG']['tl_module']['scope_template'][1] = 'Burada etiket kapsamı şablonunu seçebilirsiniz.';
$GLOBALS['TL_LANG']['tl_module']['clear_text'][0] = 'Etiket kapsamı başlığı';
$GLOBALS['TL_LANG']['tl_module']['clear_text'][1] = 'Lütfen etiket kapsamı için bir başlık girin. Başlık, etiket kapsamını temizleyen ve seçilen tüm etiketleri kaldıran bir köprüdür.';
$GLOBALS['TL_LANG']['tl_module']['show_empty_scope'][0] = 'Boş kapsamı göster';
$GLOBALS['TL_LANG']['tl_module']['show_empty_scope'][1] = 'Etkin etiket olmasa bile etiket kapsamını gösterin.';
$GLOBALS['TL_LANG']['tl_module']['tag_show_reset'][0] = 'Temizleme seçeneğini göster';
$GLOBALS['TL_LANG']['tl_module']['tag_show_reset'][1] = 'Seçilen tüm etiketleri temizlemek için bir köprü gösterin.';
$GLOBALS['TL_LANG']['tl_module']['hide_on_empty'][0] = 'Yalnızca filtrelenmiş çıktı';
$GLOBALS['TL_LANG']['tl_module']['hide_on_empty'][1] = 'Global makale listesi her zaman bir veya daha fazla etiketin filtrelenmiş bir çıktı üretmesini bekler. Etiket filtresi olmadan boş bir liste gösterilir.';
$GLOBALS['TL_LANG']['tl_module']['tag_alltags'] = 'Tüm Etiketler';
$GLOBALS['TL_LANG']['tl_module']['tag_relatedtags'] = 'İlgili Etiketler';
$GLOBALS['TL_LANG']['tl_module']['tl_content'] = 'İçerik öğeleri';
$GLOBALS['TL_LANG']['tl_module']['tl_article'] = 'Makaleler';
$GLOBALS['TL_LANG']['tl_module']['tl_news'] = 'Haber makaleleri';
$GLOBALS['TL_LANG']['tl_module']['tag_clear_tags'] = 'Seçilen etiketleri temizle';
$GLOBALS['TL_LANG']['tl_module']['tl_calendar_events'] = 'Etkinlikler';
$GLOBALS['TL_LANG']['tl_module']['tl_page'] = 'Sayfalar';
$GLOBALS['TL_LANG']['tl_module']['tags'] = 'Etiketler';
$GLOBALS['TL_LANG']['tl_module']['top_tags'] = 'En İyi %s Etiketler';
$GLOBALS['TL_LANG']['tl_module']['showtags_legend'] = 'Etiket ayarları';
$GLOBALS['TL_LANG']['tl_module']['tagscope_legend'] = 'Etiket kapsamı ayarları';
$GLOBALS['TL_LANG']['tl_module']['size_legend'] = 'Sayı ve boyut ayarları';
$GLOBALS['TL_LANG']['tl_module']['tagextension_legend'] = 'Ek etiket listeleri';
$GLOBALS['TL_LANG']['tl_module']['datasource_legend'] = 'Veri kaynağı ayarları';
$GLOBALS['TL_LANG']['tl_module']['object_selection_legend'] = 'Nesne türleri';
$GLOBALS['TL_LANG']['tl_module']['tag_articles'][0] = 'Makaleler';
$GLOBALS['TL_LANG']['tl_module']['tag_articles'][1] = 'Lütfen makalelerinin etiket bulutunu oluşturmak için kullanıldığı sayfaları seçin. Alt sayfalar içeren bir sayfayı işaretlerseniz tüm alt sayfaların makaleleri de kullanılacaktır.';
$GLOBALS['TL_LANG']['tl_module']['show_in_column'][0] = 'Belirli bir sütunla sınırla';
$GLOBALS['TL_LANG']['tl_module']['show_in_column'][1] = 'Makale listesinin çıktısını sayfa şablonunun belirli bir sütunuyla sınırlayın.';
$GLOBALS['TL_LANG']['tl_module']['linktoarticles'][0] = 'Makale listesi makalelere bağlantılar';
$GLOBALS['TL_LANG']['tl_module']['linktoarticles'][1] = 'Makaleye bağlantılar içeren bir makale listesi oluşturmak için işaretleyin veya makaleyi içeren sayfaya bağlantılar içeren bir makale listesi oluşturmak için işareti kaldırın.';
$GLOBALS['TL_LANG']['tl_module']['restrict_to_column'][0] = 'Belirli bir sütunla sınırla';
$GLOBALS['TL_LANG']['tl_module']['restrict_to_column'][1] = 'Etiket bulutunu, sayfa şablonunun belirli bir sütunundaki makalelerin etiketleriyle sınırlandırın.';
$GLOBALS['TL_LANG']['tl_module']['articlelist_tpl'][0] = 'Makale listesi şablonu';
$GLOBALS['TL_LANG']['tl_module']['articlelist_tpl'][1] = 'Burada makale listesi şablonunu seçebilirsiniz.';
$GLOBALS['TL_LANG']['tl_module']['article_showtags'][0] = 'Makale etiketlerini göster';
$GLOBALS['TL_LANG']['tl_module']['article_showtags'][1] = 'Her makalenin altında atanan tüm etiketleri göstermek için bu seçeneği seçin. Bu yalnızca etiketin etkin olduğu bir makale şablonu kullanıyorsanız işe yarar; mod_global_articlelist';
$GLOBALS['TL_LANG']['tl_module']['articlelist_firstorder'][0] = 'İlk sıralama kriterleri';
$GLOBALS['TL_LANG']['tl_module']['articlelist_firstorder'][1] = 'Ortaya çıkan makale listesi için ilk sıralama kriterini seçin.';
$GLOBALS['TL_LANG']['tl_module']['articlelist_secondorder'][0] = 'İkinci sıralama kriterleri';
$GLOBALS['TL_LANG']['tl_module']['articlelist_secondorder'][1] = 'Ortaya çıkan makale listesi için ikinci sıralama kriterini seçin.';
$GLOBALS['TL_LANG']['tl_module']['tag_content_pages'][0] = 'Sayfalar';
$GLOBALS['TL_LANG']['tl_module']['tag_content_pages'][1] = 'Lütfen etiket bulutunu oluşturmak için içerik öğelerinin kullanıldığı sayfaları seçin. Alt sayfalar içeren bir sayfa seçerseniz tüm alt sayfaların içerik öğeleri de kullanılacaktır.';
$GLOBALS['TL_LANG']['tl_module']['tag_calendars'][0] = 'Takvimler';
$GLOBALS['TL_LANG']['tl_module']['tag_calendars'][1] = 'Lütfen etiket bulutunu oluşturmak için kullanılan takvimleri seçin.';
$GLOBALS['TL_LANG']['tl_module']['tag_membergroups'][0] = 'Üye grupları';
$GLOBALS['TL_LANG']['tl_module']['tag_membergroups'][1] = 'Üye etiketi bulutunu oluşturmak için lütfen bir veya daha fazla üye grubu seçin.';
$GLOBALS['TL_LANG']['tl_module']['tag_news_archives'][0] = 'Haber arşivleri';
$GLOBALS['TL_LANG']['tl_module']['tag_news_archives'][1] = 'Lütfen etiket bulutunu oluşturmak için kullanılan haber arşivlerini seçin.';
