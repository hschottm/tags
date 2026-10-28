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

$GLOBALS['TL_LANG']['tl_module']['tag_jumpTo'][0] = 'پرش به صفحه';
$GLOBALS['TL_LANG']['tl_module']['tag_jumpTo'][1] = 'این تنظیم مشخص می‌کند که کاربر با کلیک کردن روی پیوند برچسب به کدام صفحه هدایت می‌شود.';
$GLOBALS['TL_LANG']['tl_module']['tag_forTable'][0] = 'جداول را تگ کنید';
$GLOBALS['TL_LANG']['tl_module']['tag_forTable'][1] = 'لطفاً جداولی را انتخاب کنید که برای نمایش ابر برچسب استفاده می شود. این انتخاب فقط در صورتی معتبر است که از جدول از پیش تعریف شده <em>tl_tag</em> برای ذخیره تگ ها استفاده کنید.';
$GLOBALS['TL_LANG']['tl_module']['tag_tagtable'][0] = 'جدول منبع را تگ کنید';
$GLOBALS['TL_LANG']['tl_module']['tag_tagtable'][1] = 'لطفاً نام جدول منبع را که برچسب ها در آن یافت می شوند وارد کنید. این فیلد به صورت پیش فرض جدول از پیش تعریف شده <em>tl_tag</em> است.';
$GLOBALS['TL_LANG']['tl_module']['tag_tagfield'][0] = 'فیلد جدول را تگ کنید';
$GLOBALS['TL_LANG']['tl_module']['tag_tagfield'][1] = 'لطفاً نام فیلد جدولی که برچسب ها را در خود دارد وارد کنید. این فیلد به طور پیش فرض به نام فیلد از پیش تعریف شده <em>tag</em> می باشد.';
$GLOBALS['TL_LANG']['tl_module']['tag_filter'][0] = 'فیلتر برچسب';
$GLOBALS['TL_LANG']['tl_module']['tag_filter'][1] = 'لطفاً برای فیلتر کردن خروجی ماژول، فهرستی از برچسب‌ها را وارد کنید که با کاما جدا شده‌اند.';
$GLOBALS['TL_LANG']['tl_module']['tag_maxtags'][0] = 'حداکثر تعداد برچسب';
$GLOBALS['TL_LANG']['tl_module']['tag_maxtags'][1] = 'لطفاً حداکثر تعداد برچسب ها را در ابر برچسب وارد کنید. اگر ابر برچسب حاوی تگ های بیشتری از حداکثر تعداد برچسب ها باشد، برچسب هایی که کمترین تعداد بازدید را داشته باشند از ابر حذف می شوند. اگر مقداری وارد نکنید یا مقدار آن 0 باشد، همه برچسب ها نشان داده می شوند.';
$GLOBALS['TL_LANG']['tl_module']['tag_buckets'][0] = 'تعداد اندازه های برچسب';
$GLOBALS['TL_LANG']['tl_module']['tag_buckets'][1] = 'لطفاً تعداد اندازه‌های برچسب را در قسمت جلویی وارد کنید. هر گروه از تگ ها اندازه تگ مخصوص به خود را در قسمت جلویی دارند. اندازه تگ ها به عنوان انتخابگرهای CSS size1، size2، size3 ... size<em>n</em> داده می شود.';
$GLOBALS['TL_LANG']['tl_module']['tag_named_class'][0] = 'از نام کلاس تگ استفاده کنید';
$GLOBALS['TL_LANG']['tl_module']['tag_named_class'][1] = 'برای هر تگ که حاوی نام تگ است، یک کلاس کلاس CSS اضافی اضافه می کند. از این نام کلاس اضافی برای استایل بیشتر تگ ها از طریق CSS استفاده کنید. فاصله در نام تگ ها با زیرخط در نام کلاس CSS جایگزین می شود.';
$GLOBALS['TL_LANG']['tl_module']['tag_on_page_class'][0] = 'برچسب در صفحه وجود دارد';
$GLOBALS['TL_LANG']['tl_module']['tag_on_page_class'][1] = 'یک کلاس CSS اضافی ("اینجا") برای هر برچسبی که به صفحه واقعی اختصاص داده شده است اضافه می کند.';
$GLOBALS['TL_LANG']['tl_module']['tag_topten'][0] = 'برچسب های برتر';
$GLOBALS['TL_LANG']['tl_module']['tag_topten'][1] = 'برچسب‌های برتر را در بالای ابر برچسب نشان دهید.';
$GLOBALS['TL_LANG']['tl_module']['tag_topten_expanded'][0] = 'برچسب های برتر را گسترش دهید';
$GLOBALS['TL_LANG']['tl_module']['tag_topten_expanded'][1] = 'ابر تگ Top Tags را گسترش دهید. همه برچسب ها در این ابر قابل مشاهده هستند.';
$GLOBALS['TL_LANG']['tl_module']['tag_topten_number'][0] = 'تعداد تگ های برتر';
$GLOBALS['TL_LANG']['tl_module']['tag_topten_number'][1] = 'حداکثر عددی که باید برای تگ های برتر استفاده شود را وارد کنید.';
$GLOBALS['TL_LANG']['tl_module']['tag_all_expanded'][0] = 'همه برچسب ها را گسترش دهید';
$GLOBALS['TL_LANG']['tl_module']['tag_all_expanded'][1] = 'ابر برچسب "همه برچسب ها" را گسترش دهید. همه برچسب ها در این ابر قابل مشاهده هستند.';
$GLOBALS['TL_LANG']['tl_module']['tag_related'][0] = 'نمایش برچسب های مرتبط';
$GLOBALS['TL_LANG']['tl_module']['tag_related'][1] = 'این گزینه را انتخاب کنید تا تمام تگ های مربوط به یک تگ انتخاب شده قبلی نمایش داده شود.';
$GLOBALS['TL_LANG']['tl_module']['news_showtags'][0] = 'نمایش برچسب های خبری';
$GLOBALS['TL_LANG']['tl_module']['news_showtags'][1] = 'این گزینه را انتخاب کنید تا همه برچسب های اختصاص داده شده در زیر هر ورودی خبری نمایش داده شود. این فقط در صورتی کار می کند که از یک الگوی خبری فعال با برچسب استفاده کنید، به عنوان مثال. news_full_tags';
$GLOBALS['TL_LANG']['tl_module']['event_showtags'][0] = 'نمایش برچسب های رویداد';
$GLOBALS['TL_LANG']['tl_module']['event_showtags'][1] = 'این گزینه را انتخاب کنید تا همه تگ های اختصاص داده شده در زیر هر رویداد نمایش داده شوند. این فقط در صورتی کار می کند که از یک الگوی رویداد با برچسب فعال استفاده کنید، به عنوان مثال. رویداد_..._برچسب ها';
$GLOBALS['TL_LANG']['tl_module']['tag_ignore'][0] = 'برچسب ها را نادیده بگیرید';
$GLOBALS['TL_LANG']['tl_module']['tag_ignore'][1] = 'این ماژول را مجبور کنید که اقدامات مربوط به برچسب را نادیده بگیرد (مثلاً فقط ورودی های خبری یک برچسب مشخص را نشان دهد)';
$GLOBALS['TL_LANG']['tl_module']['keep_url_params'][0] = 'پارامترهای URL را حفظ کنید';
$GLOBALS['TL_LANG']['tl_module']['keep_url_params'][1] = 'پارامترهای URL خاص Contao (به عنوان مثال پارامترهای تاریخ آرشیو اخبار) را در پیوندهای برچسب نگه دارید';
$GLOBALS['TL_LANG']['tl_module']['objecttype'][0] = 'نوع شی';
$GLOBALS['TL_LANG']['tl_module']['objecttype'][1] = 'لطفاً نوع شی را که باید در این لیست نشان داده شود انتخاب کنید.';
$GLOBALS['TL_LANG']['tl_module']['tagsource'][0] = 'منبع تگ';
$GLOBALS['TL_LANG']['tl_module']['tagsource'][1] = 'لطفا جدولی را انتخاب کنید که برای ساخت لیست برچسب در این ماژول استفاده می شود.';
$GLOBALS['TL_LANG']['tl_module']['pagesource'][0] = 'صفحات';
$GLOBALS['TL_LANG']['tl_module']['pagesource'][1] = 'لطفاً صفحاتی را انتخاب کنید که برای ساخت لیست شیء استفاده می شوند. اگر صفحه‌ای را انتخاب کنید که حاوی صفحات فرعی است، از تمام صفحات فرعی نیز استفاده می‌شود.';
$GLOBALS['TL_LANG']['tl_module']['articlelist_template'][0] = 'قالب لیست مقاله';
$GLOBALS['TL_LANG']['tl_module']['articlelist_template'][1] = 'در اینجا می توانید قالب مقاله لیست را انتخاب کنید.';
$GLOBALS['TL_LANG']['tl_module']['cloud_template'][0] = 'الگوی ابر را تگ کنید';
$GLOBALS['TL_LANG']['tl_module']['cloud_template'][1] = 'در اینجا می توانید الگوی ابر برچسب را انتخاب کنید.';
$GLOBALS['TL_LANG']['tl_module']['scope_template'][0] = 'الگوی محدوده تگ';
$GLOBALS['TL_LANG']['tl_module']['scope_template'][1] = 'در اینجا می توانید الگوی محدوده تگ را انتخاب کنید.';
$GLOBALS['TL_LANG']['tl_module']['clear_text'][0] = 'عنوان دامنه برچسب';
$GLOBALS['TL_LANG']['tl_module']['clear_text'][1] = 'لطفاً یک عنوان برای دامنه تگ وارد کنید. عنوان یک لینک است که محدوده تگ را پاک می کند و همه تگ های انتخاب شده را حذف می کند.';
$GLOBALS['TL_LANG']['tl_module']['show_empty_scope'][0] = 'نمایش محدوده خالی';
$GLOBALS['TL_LANG']['tl_module']['show_empty_scope'][1] = 'حتی اگر هیچ برچسب فعالی وجود نداشته باشد، دامنه تگ را نشان دهید.';
$GLOBALS['TL_LANG']['tl_module']['tag_show_reset'][0] = 'نمایش گزینه روشن';
$GLOBALS['TL_LANG']['tl_module']['tag_show_reset'][1] = 'برای پاک کردن تمام تگ های انتخاب شده، یک پیوند نشان دهید.';
$GLOBALS['TL_LANG']['tl_module']['hide_on_empty'][0] = 'فقط خروجی فیلتر شده';
$GLOBALS['TL_LANG']['tl_module']['hide_on_empty'][1] = 'فهرست مقالات جهانی همیشه انتظار دارد که یک یا چند برچسب خروجی فیلتر شده تولید کنند. بدون فیلتر برچسب، یک لیست خالی نشان داده می شود.';
$GLOBALS['TL_LANG']['tl_module']['tag_alltags'] = 'همه برچسب ها';
$GLOBALS['TL_LANG']['tl_module']['tag_relatedtags'] = 'برچسب های مرتبط';
$GLOBALS['TL_LANG']['tl_module']['tl_content'] = 'عناصر محتوا';
$GLOBALS['TL_LANG']['tl_module']['tl_article'] = 'مقالات';
$GLOBALS['TL_LANG']['tl_module']['tl_news'] = 'مقالات خبری';
$GLOBALS['TL_LANG']['tl_module']['tag_clear_tags'] = 'برچسب های انتخاب شده را پاک کنید';
$GLOBALS['TL_LANG']['tl_module']['tl_calendar_events'] = 'رویدادها';
$GLOBALS['TL_LANG']['tl_module']['tl_page'] = 'صفحات';
$GLOBALS['TL_LANG']['tl_module']['tags'] = 'برچسب ها';
$GLOBALS['TL_LANG']['tl_module']['top_tags'] = 'برچسب های برتر %s';
$GLOBALS['TL_LANG']['tl_module']['showtags_legend'] = 'تنظیمات برچسب ها';
$GLOBALS['TL_LANG']['tl_module']['tagscope_legend'] = 'تنظیمات دامنه برچسب';
$GLOBALS['TL_LANG']['tl_module']['size_legend'] = 'تنظیمات شماره و اندازه';
$GLOBALS['TL_LANG']['tl_module']['tagextension_legend'] = 'لیست برچسب های اضافی';
$GLOBALS['TL_LANG']['tl_module']['datasource_legend'] = 'تنظیمات منبع داده';
$GLOBALS['TL_LANG']['tl_module']['object_selection_legend'] = 'انواع شی';
$GLOBALS['TL_LANG']['tl_module']['tag_articles'][0] = 'مقالات';
$GLOBALS['TL_LANG']['tl_module']['tag_articles'][1] = 'لطفاً صفحاتی را که مقالات آنها برای ساختن ابر برچسب استفاده می شود، انتخاب کنید. اگر صفحه ای را بررسی کنید که حاوی صفحات فرعی است، از مقالات همه زیرصفحات نیز استفاده می شود.';
$GLOBALS['TL_LANG']['tl_module']['show_in_column'][0] = 'محدود به ستون خاص';
$GLOBALS['TL_LANG']['tl_module']['show_in_column'][1] = 'خروجی لیست مقاله را به ستون خاصی از الگوی صفحه محدود کنید.';
$GLOBALS['TL_LANG']['tl_module']['linktoarticles'][0] = 'پیوندهای فهرست مقالات به مقالات';
$GLOBALS['TL_LANG']['tl_module']['linktoarticles'][1] = 'برای ایجاد فهرست مقاله با پیوند به مقاله علامت بزنید یا برای ایجاد فهرست مقاله با پیوندهایی به صفحه حاوی علامت علامت بزنید.';
$GLOBALS['TL_LANG']['tl_module']['restrict_to_column'][0] = 'محدود به ستون خاص';
$GLOBALS['TL_LANG']['tl_module']['restrict_to_column'][1] = 'ابر برچسب را به برچسب های مقالات از یک ستون خاص از الگوی صفحه محدود کنید.';
$GLOBALS['TL_LANG']['tl_module']['articlelist_tpl'][0] = 'قالب لیست مقاله';
$GLOBALS['TL_LANG']['tl_module']['articlelist_tpl'][1] = 'در اینجا می توانید الگوی فهرست مقاله را انتخاب کنید.';
$GLOBALS['TL_LANG']['tl_module']['article_showtags'][0] = 'نمایش برچسب های مقاله';
$GLOBALS['TL_LANG']['tl_module']['article_showtags'][1] = 'این گزینه را انتخاب کنید تا همه تگ های اختصاص داده شده در زیر هر مقاله نشان داده شود. این فقط در صورتی کار می کند که از یک الگوی مقاله با برچسب فعال استفاده کنید، به عنوان مثال. mod_global_articlelist';
$GLOBALS['TL_LANG']['tl_module']['articlelist_firstorder'][0] = 'معیارهای مرتب سازی اول';
$GLOBALS['TL_LANG']['tl_module']['articlelist_firstorder'][1] = 'اولین معیار مرتب سازی را برای فهرست مقالات به دست آمده انتخاب کنید.';
$GLOBALS['TL_LANG']['tl_module']['articlelist_secondorder'][0] = 'معیارهای مرتب سازی دوم';
$GLOBALS['TL_LANG']['tl_module']['articlelist_secondorder'][1] = 'معیار مرتب سازی دوم را برای فهرست مقالات به دست آمده انتخاب کنید.';
$GLOBALS['TL_LANG']['tl_module']['tag_content_pages'][0] = 'صفحات';
$GLOBALS['TL_LANG']['tl_module']['tag_content_pages'][1] = 'لطفاً صفحاتی را انتخاب کنید که عناصر محتوای آنها برای ساخت ابر برچسب استفاده می شود. اگر صفحه ای را انتخاب کنید که حاوی صفحات فرعی است، از عناصر محتوایی همه صفحات فرعی نیز استفاده می شود.';
$GLOBALS['TL_LANG']['tl_module']['tag_calendars'][0] = 'تقویم ها';
$GLOBALS['TL_LANG']['tl_module']['tag_calendars'][1] = 'لطفاً تقویم‌هایی را انتخاب کنید که برای ساخت ابر برچسب استفاده می‌شوند.';
$GLOBALS['TL_LANG']['tl_module']['tag_membergroups'][0] = 'گروه های عضو';
$GLOBALS['TL_LANG']['tl_module']['tag_membergroups'][1] = 'لطفاً یک یا چند گروه عضو را برای ایجاد ابر برچسب اعضا انتخاب کنید.';
$GLOBALS['TL_LANG']['tl_module']['tag_news_archives'][0] = 'آرشیو اخبار';
$GLOBALS['TL_LANG']['tl_module']['tag_news_archives'][1] = 'لطفاً آرشیوهای خبری را که برای ساخت ابر برچسب استفاده می شود، انتخاب کنید.';
