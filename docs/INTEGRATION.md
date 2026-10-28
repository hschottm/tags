# Integrating tags into extensions


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
| maxtags    | Count `integer`      |    The maximum number of tags that should be shown above the input field. This may be helpful if you have a large number of tags. If the maximum number is lower than the number of all tags, the component takes the tags with the most selections first and hides tags which are used rarely. |
