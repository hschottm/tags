tags
====

# Module tags

tags is a Contao extension that provides an architecture to tag any Contao element. It comes with a generalized database structure to save the tags and it can be used to visualize existing tags. tags also comes with ready-to-use tag support for Contao articles, news articles and calendar events.

Developers may use the tags architecture to add tag support for their components as well. The module provides an input field widget for the actual data container and supports storing and retrieving of tags from the database. With JavaScript activated it is also possible to add and remove tags with a simple mouse click in the backend tag input field.

![tag input field in the Contao backend](https://cloud.githubusercontent.com/assets/873113/12077851/a925f4fa-b1f8-11e5-9cc9-711ab8341217.png)

The screenshot shows that the HTML title attribute of the tag URL contains the name of the tag and the number of the tagged entities, e.g. Logging (2) means that the tag logging has been used two times for the selected object type (in this case news articles).

Please note that you can only use one tag input field in a data container because the tag widget uses the data source of the parent data container.

## Hints for extension developers

Users who just want to use the tags extension can skip the following paragraph.

### Adding tag support for Contao data containers

To add tag support in the Contao backend, you need to complete the following steps:

1. To show a tag input field, you must create a database field for the data container. You only need a small database field because the tags are saved in a separate table but you need the field to embedd the input field in the data container. All tags will be saved in the database table tl_tag which is provided by the tags extension.
2. You need to embed the input field in the DCA configuration array of your module

The database field can be created in *config/database.sql* of your module, e.g.

```sql
CREATE TABLE `tl_literature` (
  `tags` CHAR(1) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
```

To add the tag field to the DCA configuration array, you must integrate it in one of the palettes of the configuration array and add a field definition, e.g.

```php
'' Palettes
'palettes' => array(
  'default' => 'title,author,description,tags,content'
),
'' Fields
'fields' => array(
  'tags' => array(
    'label'     => &$GLOBALS['TL_LANG']['MSC']['tags'],
    'inputType' => 'tag'
  )
),
```

The tags extension already provides the language variable `$GLOBALS['TL_LANG']['MSC']['tags']` as a default identifier for tag fields. You may change this of course to another value.

During the validation in the save process the tags module automatically saves the entered tags in the database table tl_tag. For every tag it stores the ID of the actual data container (table field "id"), the name of the data container (table field "from_table"), and the tag value (table field "tag").

### Options of the eval array of a tag widget

| Key        | Value           | Description  |
| ---------- |-------------| -----|
| table      | Source table `string` | Name of the source table of the tag data. Default is the name of the actual DCA data container. |
| isTag      | true/false `boolean`      |   If true (default) the tags will be saved in a separate tag table (tl_tags). If false, the content of the tag field will be saved in the associated database field of the data container. In this case you'll need more than a char(1) database field. |
| isTag      | Count `integer`      |    The maximum number of tags that should be shown above the input field. This may be helpful if you have a large number of tags. If the maximum number is lower than the number of all tags, the component takes the tags with the most selections first and hides tags which are used rarely. |

## Using tags in the Contao front end

The Contao module "Tag Cloud" is meant to present a tag cloud in the Contao front end. It generates an HTML list for a given set of tags (e.g. a data container). To present this list as a tag cloud, you'll have to define the associated CSS selectors in your site CSS file(s). tags already comes with two example style sheets tags_oxygen.css and tags_orange.css which can be found in the tl_files/tags directory of the installation package (or in the same directory of your Contao installation if you installed the module via the Contao extension repository). Please use these example files as basis of your own CSS definition because in some cases it matters that styles have to be defined invisible (e.g. for the "Top 10 tags" feature).

![Number and size settings of the tag cloud module](https://cloud.githubusercontent.com/assets/873113/12077854/c93707fc-b1f8-11e5-9e8c-e7e341104c4a.png)

The Number and size settings section lets you define some basic layout settings for the tag cloud. With the maximum number of tags you can limit the number of tags shown in the tag cloud. A value of 0 always shows all available tags, a value greater 0 only shows the most frequent tags according to the entered number. Please not that you should add a notice for your users if you don't show all available tags. The number of tag sizes limits the number of CSS class selectors for tag sizes. The default value of 4 generates 4 different CSS class styles for your tags (according to the occurrence of the tags): size1, size2, size3, and size4. If you change this number, you need to consider this in the definition of your CSS file. Use tag classname adds and additional CSS class for every tag that contains the name of the tag (blanks are replaced with an underscore). This allows you to individually style certain tags with your CSS file. The tag sports activities for example will get an additional CSS style sports_activity and can be changed to a huge size in your CSS file if you want to highlight this given tag.

The Use tag classname checkbox adds an additional CSS class name for every tag which consists of the name of the tag (only whitespaces are converted to underscores). This gives you the opportunity to define individual CSS styles for selected tags.

![Tag cloud template settings](https://cloud.githubusercontent.com/assets/873113/12077855/d7007c42-b1f8-11e5-93fd-456477d40602.png)

For the HTML code generation of the tag cloud you may choose a template from the Tag Cloud Template combo box. By default this is the mod_tagcloud template. You can create individual templates for your tag clouds if the templates start with mod_tagcloud e.g. mod_tagcloud_mine etc.

Show related tags adds a list of related tags to the frontend if a tag is selected. This shows all tags and their frequency that are defined together with the selected tag. If you click on a related tag, the selection of the results will be narrowed to all database entries that contain the selected tag and the selected related tag. The related tags view only works if the tag cloud module is integrated in the destination page of the tag cloud hyperlinks. Typically you position your tag cloud in a column on the left or right side and the results in the main column of the page.

![Additional tag lists settings in the tag cloud module](https://cloud.githubusercontent.com/assets/873113/12077856/e4eee3e8-b1f8-11e5-8538-e19444e66f44.png)

Top 10 Tags adds an additional tag cloud that contains only the 10 most frequently used tags. If you activate the Top 10 tags, you will see two additional selections:

* Expand Top 10 Tags: Check this box to expand the Top 10 Tags by default. This only works if JavaScript is enabled in the browser, otherwise the Top 10 Tags are expanded always.
* Expand All Tags: Check this box to expand the main tag cloud by default. This only works if JavaScript is enabled in the browser, otherwise the main tag cloud is expanded always.

![Redirect settings of the tag cloud module](https://cloud.githubusercontent.com/assets/873113/12077861/f243a790-b1f8-11e5-99c4-2f07cd86e70e.png)

In the redirect settings section select a destination page if you want to use hyperlinks for every tag in the tag cloud. The destination page will be called with the URL parameter tag=TAGNAME e.g. http://www.mydomain.tld/destination.html?tag=contao or http://www.mydomain.tld/destination/tag/contao.html if you use Contao URL rewriting.

Keep URL paramters preserves date specific URL parameters (for the actual time period) in news archives. If you use the tag cloud on the same page as a news archive, the selected time period will be used in the tag URL's too.

![Datasource settings of the tag cloud module](https://cloud.githubusercontent.com/assets/873113/12077865/03c7d798-b1f9-11e5-829c-725669f49847.png)

In the datasource settings you need to select the Contao source tables to generate your tag cloud. If you want to show tags for news articles you should check the tl_news table. You may uses specialized tag module add ons that are valid for certain Contao objects only such as tags_news, tags_articles, or tags_events. With these modules you don't need to select a datasource.

![Expert settings of the tag cloud module](https://cloud.githubusercontent.com/assets/873113/12077866/158fa15e-b1f9-11e5-8c60-6bf0834e5a83.png)

The expert settings should only be changed if you use your own datasources to feed the tag cloud. If you use the default solution coming with the tags module, please ignore this setting. Developers may define a different database table and a different database table field as a source for the tag cloud. You may also define additional CSS classes or ID's for your tag cloud to style the cloud with your custom CSS code.

If you've done anything by the book, you should see a similar output on your page:

![Frontend output of a tag cloud](https://cloud.githubusercontent.com/assets/873113/12077867/249f7250-b1f9-11e5-94f5-5ec715bafc62.png)

or with activated Top 10 Tags:

![Frontend output of a tag cloud and top ten tags](https://cloud.githubusercontent.com/assets/873113/12077868/30813aea-b1f9-11e5-93be-0a05e3919e85.png)

or with activated Top 10 Tags and related tags:

![Frontend output of a tag cloud, top ten tags, and related tags](https://cloud.githubusercontent.com/assets/873113/12077869/3cb56db8-b1f9-11e5-8711-e533f03ecd5f.png)

If more than one tag cloud (Top 10 and all tags) are shown, Contao adds a JavaScript that allows you to expand of collapse the tag clouds. Without JavaScript support the tags are always expanded. To make the JavaScript work you must use the CSS style definitions from the example CSS files tags_oxygen.css or tags_orange.css.

The tags extension comes with default tag support for the following Contao elements:

* News articles
* Articles
* Content elements
* Calendar events
