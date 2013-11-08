<?php
	
class TagsRunonceJob extends Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->import('Database');
	}
	 
	public function run()
	{
		if ($this->Database->tableExists('tl_tag')) 
		{
			if (!$this->Database->fieldExists('tid', 'tl_tag'))
			{
				//Feld anlegen
				$this->Database->execute("ALTER TABLE `tl_tag` ADD `tid` int(10) unsigned NOT NULL default '0'");
				$this->Database->execute("UPDATE tl_tag SET tid=id");
				$this->Database->execute("ALTER TABLE `tl_tag` ADD KEY `tid` (`tid`)");
				$this->Database->execute("ALTER TABLE `tl_tag` DROP INDEX `id`");
				$this->Database->execute("ALTER TABLE `tl_tag` DROP `id`");
				$this->Database->execute("ALTER TABLE `tl_tag` ADD `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY AFTER `tid`");
			} 
		}
	}
}

$objTagsRunonceJob = new TagsRunonceJob();
$objTagsRunonceJob->run();

