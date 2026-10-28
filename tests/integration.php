<?php
$app = getenv('TAGS_TEST_APP') ?: '/var/www/html';
require $app.'/vendor/autoload.php';
$root=dirname(__DIR__);
$map=[];
foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root.'/src')) as $file) {
    if($file->getExtension()==='php' && preg_match('/namespace ([^;]+);/', file_get_contents($file), $m)) $map[trim($m[1]).'\\'.$file->getBasename('.php')]=(string)$file;
}
spl_autoload_register(static function($class)use($map){if(isset($map[$class])) require $map[$class];});
class TagsTestKernel extends Contao\ManagerBundle\HttpKernel\ContaoKernel {
    public function registerBundles(): array { return [...parent::registerBundles(), new Hschottm\TagsBundle\HschottmTagsBundle()]; }
    public function getCacheDir(): string { return sys_get_temp_dir().'/contao-tags-test-'.substr(hash('sha256', (string) getenv('TAGS_TEST_APP')), 0, 12); }
}
$kernel=TagsTestKernel::fromInput($app,new Symfony\Component\Console\Input\ArrayInput(['--env'=>'prod']));
$kernel->boot();
$c=$kernel->getContainer();
$request=Symfony\Component\HttpFoundation\Request::create('http://localhost/contao');
$request->attributes->set('_scope','backend');
$c->get('request_stack')->push($request);
$c->get('contao.framework')->initialize();
foreach (['tl_article','tl_content','tl_files','tl_module','tl_member','tl_news','tl_calendar_events','tl_faq','tl_tag'] as $table) {
    Contao\Controller::loadDataContainer($table);
    echo "DCA $table loaded\n";
}
$twig=$c->get('twig');
foreach(glob($root.'/src/Resources/contao/templates/*/*.twig') as $file) {
    $twig->load('@Contao/'.basename($file));
    echo 'Twig '.basename($file)." loaded\n";
}

function check(bool $condition, string $message): void {
    if (!$condition) throw new RuntimeException($message);
}
foreach ($map as $class => $path) check(class_exists($class), $class.' did not load');

$context = [
    'class'=>'test', 'cssID'=>'', 'headline'=>'Tags', 'hl'=>'h2', 'style'=>'',
    'showTags'=>true, 'show_tags'=>true, 'showTagClass'=>true, 'url'=>'/test?x=1&y=2',
    'tags'=>[['tag'=>'Rock & <Jazz>', 'tagcount'=>2, 'url'=>'/test', 'tag_name'=>'Rock & <Jazz>', 'tag_count'=>2, 'tag_class'=>'size2', 'tag_url'=>'/test']],
    'arrTags'=>['C++'], 'tag_urls'=>['C++'=>'/only'], 'delete_urls'=>['C++'=>'/remove'],
    'empty_url'=>'/reset','lngTags'=>'Tags','selectedtags'=>1,'lngEmpty'=>'Reset',
    'pageID'=>17, 'jumpTo'=>true, 'relatedtags'=>[], 'toptentags'=>[], 'topten'=>false,
    'strRelatedTags'=>'Related','strTopTenTags'=>'Top ten','strAllTags'=>'All tags','tagcount'=>1,
    'expandedRelated'=>true,'expandedTopTen'=>false,'expandedAll'=>true,
    'tags_activetags'=>[], 'pages'=>[], 'articles'=>[], 'contentElements'=>[], 'empty'=>'Empty',
    'news'=>[],'events'=>[],'other_pages'=>[],'lngNews'=>'News','lngEvents'=>'Events','lngPages'=>'Pages','lngOtherPages'=>'Other',
    'teaserOnly'=>false, 'noMarkup'=>true, 'elements'=>['<p>Article</p>'],
];
foreach (['tags_inserttag','tags_feed','mod_article_tags','mod_tagcloud'] as $name) {
    $html=$twig->render('@Contao/'.$name.'.html.twig',$context);
    check(str_contains($html,'Rock &amp; &lt;Jazz&gt;'), $name.' must escape tag labels');
}
foreach (['mod_tagscope','mod_global_articlelist','mod_tag_contentlist','mod_tag_listbycategory'] as $name) $twig->render('@Contao/'.$name.'.html.twig',$context);
check(str_contains($twig->render('@Contao/taglist.html.twig',['showTags'=>true,'tags'=>['<a href="/test">Test</a>']]),'<a href="/test">Test</a>'), 'Keep generated links');
check(trim($twig->render('@Contao/tags_used.html.twig',['tags'=>['A','B']]))==='(A+B)', 'Used tags');
echo "Template rendering and escaping passed.\n";

// Temporary tables shadow the application tables only for this connection.
// No existing records are read or modified by the following database tests.
$db=$c->get('database_connection');
$db->executeStatement('CREATE TEMPORARY TABLE tl_tag (id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, tid INT UNSIGNED NOT NULL, tag VARCHAR(100) NOT NULL, from_table VARCHAR(100) NOT NULL)');
$db->executeStatement('CREATE TEMPORARY TABLE tl_files (id INT UNSIGNED PRIMARY KEY, path VARCHAR(255) NOT NULL)');
foreach ([[1,"O'Reilly",'tl_news'],[1,'PHP','tl_news'],[1,'Guide','tl_news'],[2,'PHP','tl_news'],[3,'Other','tl_news'],[11,'C++','tl_files']] as [$tid,$tag,$table]) $db->insert('tl_tag',['tid'=>$tid,'tag'=>$tag,'from_table'=>$table]);
Contao\Input::setGet('tag', null);
Contao\Input::setGet('related', null);
check(Hschottm\TagsBundle\TagHelper::findTaggedIds('tl_news')===null,'Absent filter');
check(array_map('intval',Hschottm\TagsBundle\TagHelper::findTaggedIds('tl_news'," O'Reilly "))===[1],'Quote in configured tag');
check(Hschottm\TagsBundle\TagHelper::findTaggedIds('tl_news','Missing')===[],'Unmatched filter remains empty');
Contao\Input::setGet('tag','PHP');
Contao\Input::setGet('related','Guide');
check(array_map('intval',Hschottm\TagsBundle\TagHelper::findTaggedIds('tl_news'))===[1],'Intersection of selected tags');
check(Hschottm\TagsBundle\TagHelper::findTaggedIds('tl_news','Missing')===[],'No fallback after empty configured match');
check(Hschottm\TagsBundle\TagHelper::findTaggedIds('tl_news','',true)===null,'Ignore request tags');
Contao\Input::setGet('tag','Missing');
Contao\Input::setGet('related','PHP');
check(Hschottm\TagsBundle\TagHelper::findTaggedIds('tl_news')===[],'Related tag must not revive empty intersection');

$db->insert('tl_files',['id'=>11,'path'=>'files/source/a.jpg']);
$db->insert('tl_files',['id'=>12,'path'=>'files/copy/a.jpg']);
$dc=(new ReflectionClass(Contao\DC_Folder::class))->newInstanceWithoutConstructor();
$listener=new Hschottm\TagsBundle\EventListener\DataContainer\FileCallbackListener($db);
$listener->onCopyFile('files/source','files/copy',$dc);
check($db->fetchOne('SELECT tag FROM tl_tag WHERE tid = 12 AND from_table = ?', ['tl_files'])==='C++','Copy folder tags');
$listener->onDeleteFile('files/copy',$dc);
check((int)$db->fetchOne('SELECT COUNT(*) FROM tl_tag WHERE tid = 12')===0,'Delete folder tags');
check((int)$db->fetchOne('SELECT COUNT(*) FROM tl_tag WHERE tid = 11')===1,'Keep original tags');
echo "Tag filtering and file callbacks passed.\n";

Contao\System::loadLanguageFile('default', 'en');
// Tag widgets must retain invalid input without overwriting persisted tags.
set_error_handler(static function(int $severity, string $message, string $file, int $line): bool {
    if ($severity & (E_WARNING | E_NOTICE | E_USER_WARNING)) throw new ErrorException($message,0,$severity,$file,$line);
    return false;
});
$widget = new Hschottm\TagsBundle\TagField(['id'=>'tags','name'=>'tags','table'=>'tl_news','dataContainer'=>(object)['activeRecord'=>(object)['id'=>1]], 'mandatory'=>true]);
$html=$widget->generate();
check(str_contains($html,'data-tag-target="ctrl_tags"'), 'Native backend tag selection');
check(!str_contains($html,'javascript:'),'No inline JavaScript tag values');
check(str_contains($html, 'focus->contao--scroll-offset#store'), 'Core backend scroll controller');
check(!str_contains($html, 'Backend.getScrollOffset'), 'No obsolete scroll handler');
check($widget->value === '', 'Rendering preserves backend persistence placeholder');
$wizardWidget = new Hschottm\TagsBundle\TagField(['id'=>'wizardtags','name'=>'tags','table'=>'tl_news','dataContainer'=>(object)['activeRecord'=>(object)['id'=>1]], 'wizard'=>'<span>Wizard</span>']);
check(str_contains($wizardWidget->generate(), '<span>Wizard</span>'), 'Core backend wizard rendering');
$before=$db->fetchFirstColumn('SELECT tag FROM tl_tag WHERE tid=1 AND from_table=? ORDER BY tag',['tl_news']);
Contao\Input::setPost('tags','');
$widget->validate();
check($widget->hasErrors(),'Required tags validation');
check(str_contains($widget->generate(), 'value=""'), 'Invalid empty input is not replaced with saved tags');
check($db->fetchFirstColumn('SELECT tag FROM tl_tag WHERE tid=1 AND from_table=? ORDER BY tag',['tl_news'])===$before, 'Invalid input preserves tags');
$widget = new Hschottm\TagsBundle\TagField(['id'=>'tags','name'=>'tags','table'=>'tl_news','dataContainer'=>(object)['activeRecord'=>(object)['id'=>1]]]);
Contao\Input::setPost('tags','C++, PHP');
$widget->validate();
check(!$widget->hasErrors(),'Valid tags accepted');
check($db->fetchFirstColumn('SELECT tag FROM tl_tag WHERE tid=1 AND from_table=? ORDER BY tag',['tl_news'])===['C++','PHP'],'Valid tags saved');
Contao\Input::setPost('tags','');
$widget->validate();
check((int)$db->fetchOne('SELECT COUNT(*) FROM tl_tag WHERE tid=1 AND from_table=?',['tl_news'])===0,'Clear tags');
echo "Backend tag widget validation passed.\n";
restore_error_handler();

$html=$twig->render('@Contao/news_full_tags.html.twig', [
    'class'=>'','newsHeadline'=>'News', 'datetime'=>'2026-10-25', 'date'=>'25.10.2026','author'=>'',
    'hasSubHeadline'=>false,'hasText'=>Contao\Template::once(static fn()=>false),
    'text'=>Contao\Template::once(static fn()=>''), 'addBefore'=>false, 'teaser'=>'<p>Teaser</p>',
    'addImage'=>false, 'enclosure'=>[], 'getSchemaOrgData'=>static fn()=>['@type'=>'NewsArticle','headline'=>'News'],
    'showTags'=>true,'showTagClass'=>true,'taglist'=>[['url'=>'<a href="/tag/php">PHP</a>','class'=>'php']],
]);
check(str_contains($html,'<p>Teaser</p>') && str_contains($html,'/tag/php'),'News template with lazy core content');

class TestMemberTagField extends Hschottm\TagsBundle\TagFieldMemberFrontend {
    protected function readTags() { return '100%,C++'; }
    protected function saveTags($value) { return ''; }
}
$db->insert('tl_tag',['tid'=>100,'tag'=>'100%','from_table'=>'tl_member']);
$memberWidget=new TestMemberTagField(['id'=>'membertags','name'=>'tags','type'=>'text']);
check(str_contains($memberWidget->generate(),'value="100%,C++"'),'Member tags render percent signs');
check($memberWidget->value==='', 'Member tag names must not enter char(1) placeholder column');
$memberWidget->value = '<invalid>"&';
$memberWidget->addError('Invalid tag');
check(str_contains($memberWidget->generate(), 'value="&lt;invalid&gt;&quot;&amp;"'), 'Core escapes invalid member input');
check($memberWidget->value === '', 'Invalid rendering preserves member persistence placeholder');
// Even if core rendering fails, its temporary display value must not leak.
class ThrowingMemberTagField extends TestMemberTagField {
    public function getAttributes($arrSkip = []) { throw new RuntimeException('render failed'); }
}
$failingWidget = new ThrowingMemberTagField(['id'=>'failtags','name'=>'tags']);
try {
    $failingWidget->generate();
    throw new LogicException('Expected rendering failure');
} catch (RuntimeException $e) {
    check($e->getMessage() === 'render failed', 'Expected core rendering exception');
}
check($failingWidget->value === '', 'Rendering exception restores member persistence mode');
echo "News and member widget rendering passed.\n";
$db->executeStatement("CREATE TEMPORARY TABLE tl_news (id INT UNSIGNED PRIMARY KEY, pid INT UNSIGNED, start VARCHAR(10), stop VARCHAR(10), published CHAR(1), featured CHAR(1), date INT UNSIGNED)");
foreach ([[1,'1'],[2,'']] as [$id,$published]) $db->insert('tl_news',['id'=>$id,'pid'=>1,'start'=>'','stop'=>'','published'=>$published,'featured'=>'','date'=>time()]);
check(Hschottm\TagsBundle\TagsNewsModel::countPublishedByPidsAndIds([1],[])===0, 'Empty news selection');
check((int)Hschottm\TagsBundle\TagsNewsModel::countPublishedByPidsAndIds([1],[1,2])===1,'Only published news outside preview');
check((int)Hschottm\TagsBundle\TagsNewsModel::countPublishedFromToByPidsAndIds(0,time()+1,[1],[1,2])===1,'News archive publication filtering');
echo "News model publication and empty-selection tests passed.\n";

require __DIR__.'/hooks.php';
