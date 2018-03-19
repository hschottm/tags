Contao tags extension
=====================

# tags extension

tags is a Contao extension that provides an architecture to tag any Contao element. It comes with a generalized database structure to save the tags and it can be used to visualize existing tags. tags also comes with ready-to-use tag support for Contao articles, news articles and calendar events.

Developers may use the tags architecture to add tag support for their components as well. The module provides an input field widget for the actual data container and supports storing and retrieving of tags from the database. With JavaScript activated it is also possible to add and remove tags with a simple mouse click in the backend tag input field.

![tag input field in the Contao backend](https://cloud.githubusercontent.com/assets/873113/12077851/a925f4fa-b1f8-11e5-9cc9-711ab8341217.png)

The screenshot shows that the HTML title attribute of the tag URL contains the name of the tag and the number of the tagged entities, e.g. Logging (2) means that the tag logging has been used two times for the selected object type (in this case news articles).

Please note that you can only use one tag input field in a data container because the tag widget uses the data source of the parent data container.

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

Besides the general tag cloud module, tags comes with five more specialized tag cloud modules:

* Tag Cloud (Articles)
* Tag Cloud (News)
* Tag Cloud (Events)
* Tag Cloud (Members)
* Tag Cloud (Content Elements)

In Tag Cloud (Events) for instance you can filter the tags by using only selected calendars for the tag cloud generation.

The tags extension comes with default tag support for the following Contao elements:

* News articles
* Articles
* Content elements
* Calendar events
* Members

### Using tag clouds to redirect to other Contao modules

For a meaningful usage of a tag cloud you should enter a destination page in the redirect settings of the tag cloud module. The destination page should contain the tag cloud module (if you want to use the related tags) and one of the following Contao modules which have been modified by the tags extension:

* Module News archive: Shows all news articles that are tagged with a selected tag. The heading of the news archive will be shown with the selected tag and the number of selections.
* Module Newslist: Shows all news articles that are tagged with a selected tag. The heading of the news archive will be shown with the selected tag and the number of selections.
* Module Global article list: Show a list of articles that are tagged with a selected tag. The heading of the article list will be shown with the selected tag and the number of selections.
* Module Event list: Shows all events of selected calenders that are tagged with a selected tag. The heading of the event list will be shown with the selected tag and the number of selections.
* Module Calendar: Shows all events that are tagged with a selected tag. Output the tags of an event when you change the default calendar template.
* Module Tag object list: Shows lists of content elements (pages, articles, content elements) with given tags.

### Showing the assigned tags in the frontend

For news articles and articles you can show the assigned tags at the bottom of the content. Therefore you can check the Show article tags or Show news tags option in the particular module and select a destination page for the tag hyperlinks.

The Ignore tags setting ignores all tag related URL parameters. This means that news lists or other modules using this settings cannot be filtered by tags. This is helpful if you have multiple lists on the same page and only want a specific list to be filtered by tags.

These tag settings are available for the modules News reader, News archive, and Article list (Tags). Article list (Tags) is only available if you install the add-on extension tags_articles.

![Tags settings for news objects](https://cloud.githubusercontent.com/assets/873113/12077870/4b6a902c-b1f9-11e5-87f1-32902be026d0.png)

An additional tag list is only shown if you're using a template that is capable of evaluating the tag list template variables. You may check the template news_full_tags for further details. You can make any other template ready for this feature if you copy and paste the related code into the template:

```php
<?php if ($this->showTags): ?>
 
<?php if (count($this->taglist)): ?>
<ul class="tag-chain">
<?php $counter = 0; foreach ($this->taglist as $tag): ?>
<li class="tag-chain-item<?php if ($counter == 0) echo ' first'; ?>
<?php if ($counter == count($this->taglist)-1) echo ' last'; ?>
<?php if ($this->showTagClass) echo ' ' . $tag['class']; ?>"><?php echo $tag['url']; ?></li>
<?php $counter++; endforeach; ?>
</ul>
<?php endif; ?>
<?php endif; ?>
```

The CSS styles for this output are already defined in the example CSS files tags_orange.css and tags_oxygen.css. You might use these files as a basis for your own style definitions. A news entry with its assigned tags will look as follows:

![Additional tags at the bottom of a news list entry](https://cloud.githubusercontent.com/assets/873113/12077872/58849b90-b1f9-11e5-9b49-b6e92f243b04.png)

For **calendar modules** it's up to you if you want to show the tags of an event in the calendar. To do so, you need to modify the default calendar template `cal_default` or you create your own `cal_default` based template. To show the tags you can access the `tags` or `taglist` fields of the respective events, e.g.

```php
          <?php foreach ($day['events'] as $event): ?>
            <div class="event cal_<?= $event['parent'] ?><?= $event['class'] ?>">
              <a href="<?= $event['href'] ?>" title="<?= $event['title'] ?> (<?php if ($event['day']) echo $event['day'] . ', '; ?><?= $event['date'] ?><?php if ($event['time']) echo ', ' .  $event['time']; ?>)"<?= $event['target'] ?>><?= $event['link'] ?></a>
              <div>
              	<?php foreach ($event['taglist'] as $tagdata): ?>
              		<div class="<?= $tagdata['class'] ?>"><?= $tagdata['url'] ?></div>
              	<?php endforeach; ?>
              </div>
            </div>
          <?php endforeach; ?>
```

The `tags` field contains an array with all available tags for an event, e.g.

```php
Array(
  [0] => conference
  [1] => meeting
)
```

The `taglist` field contains an array of arrays which contain the URL for the tag, the tag name and the tag class, e.g.

```php
Array(
  [0] => Array(
    [url] => <a href=".../tags/conference.html">conference</a>
    [tag] => conference
    [class] => conference
  )
  [1] => Array(
    [url] => <a href=".../tags/meeting.html">meeting</a>
    [tag] => meeting
    [class] => meeting
  )
)
```


## Content elements

The tags extension extends the Contao content element Heading and introduces an additional parameter Show with tags only into the expert settings. If you check this option Contao only shows the heading if one or more tags are used on the content page, e.g. if the page was opened from a tag cloud.

![Checkbox 'Show with tags only' in the heading content element](https://cloud.githubusercontent.com/assets/873113/12077875/656687c4-b1f9-11e5-90e7-9279ec22195c.png)

You can use this element in combination with the insert tag {{tags_used}} to show a tag specific heading for your content, e.g. Selected Participants {{tags_used}} => Selected Participants (Congress+October+New York)

## Insert Tags

tags adds the following Insert Tags to Contao:

* {{tags_used}}: Will be replaced with a list of the used tags, e.g. (Contao+Extension+tags)
* {{tags_news::news_id}}: Will be replaced with the list of tags that is assigned to the given news article, e.g. {{tags_news:1}} shows the tags of the news article with ID 1.
* {{tags_event::event_id}}: Will be replaced with the list of tags that is assigned to the given calendar event, e.g. {{tags_event:1}} shows the tags of the calendar event with ID 1.
* {{tags_article::article_id}}: Will be replaced with the list of tags that is assigned to the given article, e.g. {{tags_article:1}} shows the tags of the article with ID 1.
* {{tags_article_url::article_id}}:Will be replaced with the list of linked tags that is assigned to the given article, e.g. {{tags_article_url:1}} shows the tags of the article with ID 1 and links every tag to the page that contains the article.
* {{tags_content::content_id}}: Will be replaced with the list of tags that is assigned to the given content element, e.g. {{tags_content:1}} shows the tags of the content element with ID 1.

## Additional Contao modules

The tags extension comes with the following new Contao modules:

### Globale article list

The global article list shows a list of all available articles for a given selected tag.

### Special settings for news modules

The news modules Newsreader, News archive, and Newslist use an additional parameter to ignore all tag settings. This might be helpfull if you have multiple modules on a page and only one module should be able to filter its content by a selected tag. If you check the Ignore tags option in the Tag settings section, the modules will ignore any tag related actions.

News modules also contain a Tag filter where you can add a comma separated list of tags. The content of the modules will be filtered by default using the entered tags. This might be helpful if you want to show only lists which are assigned with certain tags.

### Tag object lists

The frontend module Tag object lists can create lists of content elements filtered by given tags. The available object types are the three content element types Page, Article, and Content element. The Object type is the element that will be shown and linked in the generated list if a tag exists, e.g. an object type Pages creates a list URL's to Contao pages, an object type Articles shows links to Contao articles.

The Tag source defines which tag sources are used to generate the list. If you choose tl_article for example, only article tags will be considered.

The Pages selection is used to define a root page for the available content element links. Only links to this page its subpages will be considered for the list.

Example:
* Object type: Pages
* Tag source: tl_article
* Pages: Website root

This creates a list of links to pages that is created from article tags. Only links to the selected website will be considered.

![Tag object list settings](https://cloud.githubusercontent.com/assets/873113/12077878/70aa1f88-b1f9-11e5-8a3e-5773eef28869.png)

## Hints for extension developers

Users who just want to use the tags extension can skip the following paragraph.

### Adding tag support for Contao data containers

To add tag support in the Contao backend, you need to complete the following steps:

1. To show a tag input field, you must create a database field for the data container. You only need a small database field because the tags are saved in a separate table but you need the field to embedd the input field in the data container. All tags will be saved in the database table tl_tag which is provided by the tags extension.
2. You need to embed the input field in the DCA configuration array of your module

```php
$GLOBALS['TL_DCA']['tl_literature']['palettes']['default'] = 'title,author,description,tags,content';
```

```php
$GLOBALS['TL_DCA']['tl_literature']['fields']['tags'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['MSC']['tags'],
	'inputType'               => 'tag',
	'eval'                    => array('tl_class'=>'clr long'),
	'sql'                     => "char(1) NOT NULL default ''"
);
```

The tags extension already provides the language variable `$GLOBALS['TL_LANG']['MSC']['tags']` as a default identifier for tag fields. You may change this of course to another value.

During the validation in the save process the tags module automatically saves the entered tags in the database table tl_tag. For every tag it stores the ID of the actual data container (table field "id"), the name of the data container (table field "from_table"), and the tag value (table field "tag").

### Options of the eval array of a tag widget

| Key        | Value           | Description  |
| ---------- |-------------| -----|
| table      | Source table `string` | Name of the source table of the tag data. Default is the name of the actual DCA data container. |
| isTag      | true/false `boolean`      |   If true (default) the tags will be saved in a separate tag table (tl_tags). If false, the content of the tag field will be saved in the associated database field of the data container. In this case you'll need more than a char(1) database field. |
| isTag      | Count `integer`      |    The maximum number of tags that should be shown above the input field. This may be helpful if you have a large number of tags. If the maximum number is lower than the number of all tags, the component takes the tags with the most selections first and hides tags which are used rarely. |


