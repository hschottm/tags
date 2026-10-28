<?php
// Database regression coverage using connection-local temporary tables only.
require __DIR__.'/bootstrap.php';
$url = parse_url(getenv('DATABASE_URL'));
$db = Doctrine\DBAL\DriverManager::getConnection([
    'driver' => 'pdo_mysql', 'host' => $url['host'], 'port' => $url['port'] ?? 3306,
    'user' => $url['user'], 'password' => $url['pass'], 'dbname' => ltrim($url['path'], '/'),
]);
$db->executeStatement('CREATE TEMPORARY TABLE tl_tag (id INT AUTO_INCREMENT PRIMARY KEY, tid INT NOT NULL, tag VARCHAR(100) NOT NULL, from_table VARCHAR(100) NOT NULL)');
$db->executeStatement("CREATE TEMPORARY TABLE tl_content (id INT PRIMARY KEY, pid INT, ptable VARCHAR(100))");
$db->executeStatement('CREATE TEMPORARY TABLE tl_article (id INT PRIMARY KEY, pid INT)');
function dataContainer(string $table, int $id): Contao\DC_Table {
    $dc = (new ReflectionClass(Contao\DC_Table::class))->newInstanceWithoutConstructor();
    (new ReflectionProperty(Contao\DC_Table::class, 'strTable'))->setValue($dc, $table);
    $dc->id = $id;
    return $dc;
}
foreach (['Article'=>'tl_article','Content'=>'tl_content','News'=>'tl_news','Calendar'=>'tl_calendar_events','Faq'=>'tl_faq','Member'=>'tl_member'] as $name=>$table) {
    $class = 'Hschottm\\TagsBundle\\EventListener\\DataContainer\\'.$name.'CallbackListener';
    $listener = new $class($db);
    foreach (["O'Reilly", '日本語 & فارسی'] as $tag) $db->insert('tl_tag', ['tid'=>10,'tag'=>$tag,'from_table'=>$table]);
    $db->insert('tl_tag', ['tid'=>10,'tag'=>'Other table','from_table'=>'unrelated']);
    // These are the same source/target arguments passed by DC_Table::copyChildren().
    $listener->{'onCopy'.$name}(20, dataContainer($table,10));
    $tags = $db->fetchFirstColumn('SELECT tag FROM tl_tag WHERE tid = ? AND from_table = ? ORDER BY id', [20,$table]);
    check($tags === ["O'Reilly", '日本語 & فارسی'], $name.' copies tags to the new record');
    $listener->{'onCopy'.$name}(30, dataContainer($table,999));
    check((int)$db->fetchOne('SELECT COUNT(*) FROM tl_tag WHERE tid = 30')===0, $name.' handles sources without tags');
    $listener->{'onDelete'.$name}(dataContainer($table,20),0);
    check((int)$db->fetchOne('SELECT COUNT(*) FROM tl_tag WHERE tid = ? AND from_table = ?', [20,$table])===0, $name.' deletes copied tags');
    check((int)$db->fetchOne('SELECT COUNT(*) FROM tl_tag WHERE tid = ? AND from_table = ?', [10,$table])===2, $name.' retains source tags');
    $db->executeStatement('DELETE FROM tl_tag');
}
// Deleting an article/page only removes the corresponding article/content tags.
$db->insert('tl_article',['id'=>100,'pid'=>1]);
$db->insert('tl_article',['id'=>200,'pid'=>2]);
foreach ([[101,100,'tl_article'],[102,100,'tl_news'],[201,200,'tl_article']] as [$id,$pid,$ptable]) {
    $db->insert('tl_content',compact('id','pid','ptable'));
    $db->insert('tl_tag',['tid'=>$id,'tag'=>'Keep scope','from_table'=>'tl_content']);
}
foreach ([100,200] as $id) $db->insert('tl_tag',['tid'=>$id,'tag'=>'Article','from_table'=>'tl_article']);
(new Hschottm\TagsBundle\EventListener\DataContainer\PageCallbackListener($db))->onDeletePage(dataContainer('tl_page',1),0);
check((int)$db->fetchOne('SELECT COUNT(*) FROM tl_tag WHERE tid IN (100,101)')===0, 'Page removes its article and content tags');
check((int)$db->fetchOne('SELECT COUNT(*) FROM tl_tag')===3, 'Page preserves unrelated tags and content parents');
(new Hschottm\TagsBundle\EventListener\DataContainer\ArticleCallbackListener($db))->onDeleteArticle(dataContainer('tl_article',200),0);
check((int)$db->fetchOne('SELECT COUNT(*) FROM tl_tag')===1, 'Article removes its child content tags only');
echo "Six copy/delete callbacks and page/article cascades passed.\n";
