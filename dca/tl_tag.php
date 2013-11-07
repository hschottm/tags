<?php

/**
 * Table tl_tag
 */
$GLOBALS['TL_DCA']['tl_tag'] = array
(

	// Config
	'config' => array
	(
		'doNotCopyRecords'            => true,
		'sql' => array
		(
			'keys' => array
			(
				'id' => 'index',
				'tag' => 'index',
				'from_table' => 'index'
			)
		)
	),

	// Fields
	'fields' => array
	(
		'id' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'tag' => array
		(
			'sql'                     => "varchar(100) NOT NULL default ''"
		),
		'from_table' => array
		(
			'sql'                     => "varchar(100) NOT NULL default ''"
		),
	)
);

