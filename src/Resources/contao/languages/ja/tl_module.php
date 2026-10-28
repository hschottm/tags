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

$GLOBALS['TL_LANG']['tl_module']['tag_jumpTo'][0] = 'ページへジャンプ';
$GLOBALS['TL_LANG']['tl_module']['tag_jumpTo'][1] = 'この設定では、タグ リンクをクリックしたときにユーザーがリダイレクトされるページを定義します。';
$GLOBALS['TL_LANG']['tl_module']['tag_forTable'][0] = 'タグテーブル';
$GLOBALS['TL_LANG']['tl_module']['tag_forTable'][1] = 'タグクラウドを表示するために使用するテーブルを選択してください。この選択は、事前定義された <em>tl_tag</em> テーブルを使用してタグを保存する場合にのみ有効です。';
$GLOBALS['TL_LANG']['tl_module']['tag_tagtable'][0] = 'タグソーステーブル';
$GLOBALS['TL_LANG']['tl_module']['tag_tagtable'][1] = 'タグが存在するソース テーブルの名前を入力してください。このフィールドのデフォルトは、事前定義テーブル <em>tl_tag</em> です。';
$GLOBALS['TL_LANG']['tl_module']['tag_tagfield'][0] = 'タグテーブルフィールド';
$GLOBALS['TL_LANG']['tl_module']['tag_tagfield'][1] = 'タグを保持するテーブル フィールドの名前を入力してください。このフィールドのデフォルトは、事前定義されたフィールド名 <em>tag</em> です。';
$GLOBALS['TL_LANG']['tl_module']['tag_filter'][0] = 'タグフィルター';
$GLOBALS['TL_LANG']['tl_module']['tag_filter'][1] = 'モジュールの出力をフィルタリングするには、タグのカンマ区切りリストを入力してください。';
$GLOBALS['TL_LANG']['tl_module']['tag_maxtags'][0] = 'タグの最大数';
$GLOBALS['TL_LANG']['tl_module']['tag_maxtags'][1] = 'タグクラウド内のタグの最大数を入力してください。タグ クラウドにタグの最大数を超えるタグが含まれている場合、ヒット数が最も少ないタグがクラウドから削除されます。値を入力しない場合、または値が 0 の場合は、すべてのタグが表示されます。';
$GLOBALS['TL_LANG']['tl_module']['tag_buckets'][0] = 'タグサイズの数';
$GLOBALS['TL_LANG']['tl_module']['tag_buckets'][1] = 'フロントエンドでタグのサイズの数を入力してください。タグの各グループは、フロントエンドで独自のタグ サイズを取得します。タグのサイズは、CSS セレクター size1、size2、size3 ... size<em>n</em> として指定されます。';
$GLOBALS['TL_LANG']['tl_module']['tag_named_class'][0] = 'タグのクラス名を使用する';
$GLOBALS['TL_LANG']['tl_module']['tag_named_class'][1] = 'タグ名を含むすべてのタグに追加の CSS クラス class を追加します。 CSS 経由でタグのスタイルを追加するには、この追加のクラス名を使用します。タグ名のスペースは、CSS クラス名のアンダースコアに置き換えられます。';
$GLOBALS['TL_LANG']['tl_module']['tag_on_page_class'][0] = 'ページ上にタグが存在します';
$GLOBALS['TL_LANG']['tl_module']['tag_on_page_class'][1] = '実際のページに割り当てられているすべてのタグに追加の CSS クラス (「here」) を追加します。';
$GLOBALS['TL_LANG']['tl_module']['tag_topten'][0] = '人気のタグ';
$GLOBALS['TL_LANG']['tl_module']['tag_topten'][1] = 'タグクラウドの上にトップタグを表示します。';
$GLOBALS['TL_LANG']['tl_module']['tag_topten_expanded'][0] = '上位のタグを展開する';
$GLOBALS['TL_LANG']['tl_module']['tag_topten_expanded'][1] = '「トップタグ」タグクラウドを展開します。このクラウド内のすべてのタグが表示されます。';
$GLOBALS['TL_LANG']['tl_module']['tag_topten_number'][0] = '上位タグの数';
$GLOBALS['TL_LANG']['tl_module']['tag_topten_number'][1] = '上位タグに使用する最大数を入力します。';
$GLOBALS['TL_LANG']['tl_module']['tag_all_expanded'][0] = 'すべてのタグを展開';
$GLOBALS['TL_LANG']['tl_module']['tag_all_expanded'][1] = '「すべてのタグ」タグクラウドを展開します。このクラウド内のすべてのタグが表示されます。';
$GLOBALS['TL_LANG']['tl_module']['tag_related'][0] = '関連タグを表示';
$GLOBALS['TL_LANG']['tl_module']['tag_related'][1] = '以前に選択したタグに関連するすべてのタグを表示するには、このオプションを選択します。';
$GLOBALS['TL_LANG']['tl_module']['news_showtags'][0] = 'ニュースタグを表示';
$GLOBALS['TL_LANG']['tl_module']['news_showtags'][1] = '各ニュース エントリの下に割り当てられたすべてのタグを表示するには、このオプションを選択します。これは、タグが有効になっているニュース テンプレートを使用する場合にのみ機能します。 news_full_tags';
$GLOBALS['TL_LANG']['tl_module']['event_showtags'][0] = 'イベントタグを表示';
$GLOBALS['TL_LANG']['tl_module']['event_showtags'][1] = '各イベントの下に割り当てられたすべてのタグを表示するには、このオプションを選択します。これは、タグが有効になっているイベント テンプレートを使用する場合にのみ機能します。イベント_..._タグ';
$GLOBALS['TL_LANG']['tl_module']['tag_ignore'][0] = 'タグを無視する';
$GLOBALS['TL_LANG']['tl_module']['tag_ignore'][1] = 'このモジュールがタグ関連のアクションを無視するように強制します (例: 指定されたタグのニュース エントリのみを表示します)';
$GLOBALS['TL_LANG']['tl_module']['keep_url_params'][0] = 'URLパラメータを保持する';
$GLOBALS['TL_LANG']['tl_module']['keep_url_params'][1] = 'Contao 固有の URL パラメーター (ニュース アーカイブの日付パラメーターなど) をタグ リンク内に保持します。';
$GLOBALS['TL_LANG']['tl_module']['objecttype'][0] = 'オブジェクトの種類';
$GLOBALS['TL_LANG']['tl_module']['objecttype'][1] = 'このリストに表示するオブジェクトのタイプを選択してください。';
$GLOBALS['TL_LANG']['tl_module']['tagsource'][0] = 'タグソース';
$GLOBALS['TL_LANG']['tl_module']['tagsource'][1] = 'このモジュールでタグリストを作成するために使用されるテーブルを選択してください。';
$GLOBALS['TL_LANG']['tl_module']['pagesource'][0] = 'ページ';
$GLOBALS['TL_LANG']['tl_module']['pagesource'][1] = 'オブジェクト リストの作成に使用するページを選択してください。サブページを含むページを選択すると、すべてのサブページも使用されます。';
$GLOBALS['TL_LANG']['tl_module']['articlelist_template'][0] = '記事リストのテンプレート';
$GLOBALS['TL_LANG']['tl_module']['articlelist_template'][1] = 'ここで記事リストのテンプレートを選択できます。';
$GLOBALS['TL_LANG']['tl_module']['cloud_template'][0] = 'タグクラウドテンプレート';
$GLOBALS['TL_LANG']['tl_module']['cloud_template'][1] = 'ここでタグクラウドテンプレートを選択できます。';
$GLOBALS['TL_LANG']['tl_module']['scope_template'][0] = 'タグスコープテンプレート';
$GLOBALS['TL_LANG']['tl_module']['scope_template'][1] = 'ここでタグスコープテンプレートを選択できます。';
$GLOBALS['TL_LANG']['tl_module']['clear_text'][0] = 'タグスコープのタイトル';
$GLOBALS['TL_LANG']['tl_module']['clear_text'][1] = 'タグスコープのタイトルを入力してください。タイトルは、タグの範囲をクリアし、選択したすべてのタグを削除するハイパーリンクです。';
$GLOBALS['TL_LANG']['tl_module']['show_empty_scope'][0] = '空のスコープを表示';
$GLOBALS['TL_LANG']['tl_module']['show_empty_scope'][1] = 'アクティブなタグがない場合でもタグのスコープを表示します。';
$GLOBALS['TL_LANG']['tl_module']['tag_show_reset'][0] = 'クリアオプションを表示';
$GLOBALS['TL_LANG']['tl_module']['tag_show_reset'][1] = '選択したタグをすべてクリアするには、ハイパーリンクを表示します。';
$GLOBALS['TL_LANG']['tl_module']['hide_on_empty'][0] = 'フィルタリングされた出力のみ';
$GLOBALS['TL_LANG']['tl_module']['hide_on_empty'][1] = 'グローバル記事リストは常に 1 つ以上のタグがフィルター処理された出力を生成することを期待します。タグ フィルターを使用しない場合、空のリストが表示されます。';
$GLOBALS['TL_LANG']['tl_module']['tag_alltags'] = 'すべてのタグ';
$GLOBALS['TL_LANG']['tl_module']['tag_relatedtags'] = '関連タグ';
$GLOBALS['TL_LANG']['tl_module']['tl_content'] = 'コンテンツ要素';
$GLOBALS['TL_LANG']['tl_module']['tl_article'] = '記事';
$GLOBALS['TL_LANG']['tl_module']['tl_news'] = 'ニュース記事';
$GLOBALS['TL_LANG']['tl_module']['tag_clear_tags'] = '選択したタグをクリアします';
$GLOBALS['TL_LANG']['tl_module']['tl_calendar_events'] = 'イベント';
$GLOBALS['TL_LANG']['tl_module']['tl_page'] = 'ページ';
$GLOBALS['TL_LANG']['tl_module']['tags'] = 'タグ';
$GLOBALS['TL_LANG']['tl_module']['top_tags'] = 'トップ %s のタグ';
$GLOBALS['TL_LANG']['tl_module']['showtags_legend'] = 'タグ設定';
$GLOBALS['TL_LANG']['tl_module']['tagscope_legend'] = 'タグスコープの設定';
$GLOBALS['TL_LANG']['tl_module']['size_legend'] = '数とサイズの設定';
$GLOBALS['TL_LANG']['tl_module']['tagextension_legend'] = '追加のタグリスト';
$GLOBALS['TL_LANG']['tl_module']['datasource_legend'] = 'データソース設定';
$GLOBALS['TL_LANG']['tl_module']['object_selection_legend'] = 'オブジェクトの種類';
$GLOBALS['TL_LANG']['tl_module']['tag_articles'][0] = '記事';
$GLOBALS['TL_LANG']['tl_module']['tag_articles'][1] = 'タグ クラウドの構築に記事が使用されているページを選択してください。サブページを含むページにチェックを入れると、すべてのサブページの記事も使用されます。';
$GLOBALS['TL_LANG']['tl_module']['show_in_column'][0] = '特定の列に制限する';
$GLOBALS['TL_LANG']['tl_module']['show_in_column'][1] = '記事リストの出力をページ テンプレートの特定の列に制限します。';
$GLOBALS['TL_LANG']['tl_module']['linktoarticles'][0] = '記事リストへのリンク';
$GLOBALS['TL_LANG']['tl_module']['linktoarticles'][1] = '記事へのリンクを含む記事リストを作成する場合はチェックを入れます。記事を含むページへのリンクを含む記事リストを作成する場合はチェックを外します。';
$GLOBALS['TL_LANG']['tl_module']['restrict_to_column'][0] = '特定の列に制限する';
$GLOBALS['TL_LANG']['tl_module']['restrict_to_column'][1] = 'タグ クラウドをページ テンプレートの特定の列の記事のタグに制限します。';
$GLOBALS['TL_LANG']['tl_module']['articlelist_tpl'][0] = '記事リストのテンプレート';
$GLOBALS['TL_LANG']['tl_module']['articlelist_tpl'][1] = 'ここで記事リストのテンプレートを選択できます。';
$GLOBALS['TL_LANG']['tl_module']['article_showtags'][0] = '記事のタグを表示する';
$GLOBALS['TL_LANG']['tl_module']['article_showtags'][1] = '各記事の下に割り当てられたすべてのタグを表示するには、このオプションを選択します。これは、タグが有効になっている記事テンプレートを使用している場合にのみ機能します。 mod_global_articlelist';
$GLOBALS['TL_LANG']['tl_module']['articlelist_firstorder'][0] = '最初の並べ替え基準';
$GLOBALS['TL_LANG']['tl_module']['articlelist_firstorder'][1] = '結果として得られる記事リストの最初の並べ替え基準を選択します。';
$GLOBALS['TL_LANG']['tl_module']['articlelist_secondorder'][0] = '2 番目の並べ替え基準';
$GLOBALS['TL_LANG']['tl_module']['articlelist_secondorder'][1] = '結果として得られる記事リストの 2 番目の並べ替え基準を選択します。';
$GLOBALS['TL_LANG']['tl_module']['tag_content_pages'][0] = 'ページ';
$GLOBALS['TL_LANG']['tl_module']['tag_content_pages'][1] = 'タグ クラウドの構築にコンテンツ要素が使用されているページを選択してください。サブページを含むページを選択すると、すべてのサブページのコンテンツ要素も使用されます。';
$GLOBALS['TL_LANG']['tl_module']['tag_calendars'][0] = 'カレンダー';
$GLOBALS['TL_LANG']['tl_module']['tag_calendars'][1] = 'タグクラウドの構築に使用するカレンダーを選択してください。';
$GLOBALS['TL_LANG']['tl_module']['tag_membergroups'][0] = 'メンバーグループ';
$GLOBALS['TL_LANG']['tl_module']['tag_membergroups'][1] = 'メンバー タグ クラウドを構築するには、1 つ以上のメンバー グループを選択してください。';
$GLOBALS['TL_LANG']['tl_module']['tag_news_archives'][0] = 'ニュースアーカイブ';
$GLOBALS['TL_LANG']['tl_module']['tag_news_archives'][1] = 'タグクラウドの構築に使用されるニュースアーカイブを選択してください。';
