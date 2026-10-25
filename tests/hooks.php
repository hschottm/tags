<?php
// Loaded by integration.php inside the real kernel, using its temporary tables.
use Hschottm\TagsBundle\EventListener\CalendarEventsListener;
use Hschottm\TagsBundle\EventListener\EventReaderTemplateListener;
use Hschottm\TagsBundle\EventListener\NewsListListener;
use Hschottm\TagsBundle\Service\TagFilter;
use Hschottm\TagsBundle\Service\TagView;

$filter = $c->get(TagFilter::class);
$newsHooks = new NewsListListener($filter);
$view = new TagView();
$calendarHook = new CalendarEventsListener($filter, $view);
$readerHook = $c->get(EventReaderTemplateListener::class);
foreach (['newsListCountItems','newsListFetchItems','getAllEvents','parseTemplate'] as $hook) check(!empty($GLOBALS['TL_HOOKS'][$hook]), 'Registered '.$hook);
check($GLOBALS['FE_MOD']['news']['newsreader'] === Contao\ModuleNewsReader::class, 'Keep core news reader');
check($GLOBALS['FE_MOD']['events']['calendar'] === Contao\ModuleCalendar::class, 'Keep core calendar');

$db->executeStatement('ALTER TABLE tl_news ADD headline VARCHAR(255) NOT NULL DEFAULT \'\'');
$db->executeStatement('UPDATE tl_news SET headline = ? WHERE id = 1', ['Zulu']);
$db->insert('tl_news',['id'=>3,'pid'=>1,'start'=>'','stop'=>'','published'=>'1','featured'=>'1','date'=>time()-60,'headline'=>'Alpha']);
$db->insert('tl_news',['id'=>4,'pid'=>1,'start'=>(string)(time()+3600),'stop'=>'','published'=>'1','featured'=>'0','date'=>time(),'headline'=>'Future']);
foreach ([1,2,3,4] as $id) $db->insert('tl_tag',['tid'=>$id,'tag'=>'HookTest','from_table'=>'tl_news']);
Contao\Input::setGet('tag',null);
Contao\Input::setGet('related',null);

class HookNewsList extends Hschottm\TagsBundle\ModuleNewsListTags {
    public function run(array $data): array {
        foreach ($data as $key=>$value) $this->$key=$value;
        $this->Template=new Contao\FrontendTemplate('mod_newslist');
        $this->compile();
        return $this->Template->getData();
    }
    protected function parseArticles($articles, $addArchive=false) {
        return array_map(static fn($row)=>(int)$row['id'], $articles->fetchAll());
    }
}
$module=(new ReflectionClass(HookNewsList::class))->newInstanceWithoutConstructor();
$data=['id'=>901,'type'=>'newslist','news_archives'=>[1],'tag_filter'=>'HookTest','tag_ignore'=>false,'skipFirst'=>0,'numberOfItems'=>0,'perPage'=>1,'news_featured'=>'all_items','news_order'=>'order_headline_asc'];
$result=$module->run($data);
check($result['articles']===[3], 'Core news list: sorted first page');
check($result['tags_total_found']===2,'Core news list: filtered publication-aware total');
check($result['pagination'] instanceof Contao\CoreBundle\Pagination\LegacyTemplatePaginationProxy, 'Use Contao 5.7 pagination');
$request->query->set('page_n901',2);
$result=$module->run($data);
check($result['articles']===[1], 'Core news list: filtered second page');
$request->query->remove('page_n901');
$result=$module->run(array_replace($data,['tag_filter'=>'NoMatches']));
check($result['articles']===[] && $result['tags_total_found']===0,'Empty filtered list never falls back to all news');
$result=$module->run(array_replace($data,['skipFirst'=>1,'perPage'=>0,'numberOfItems'=>1]));
check($result['articles']===[1],'Core news list: skipFirst and item limit');
$result=$module->run(array_replace($data,['news_featured'=>'featured','perPage'=>0]));
check($result['articles']===[3],'Core featured filter');
$module->tag_filter='';
check($newsHooks->countItems([1],null,$module)===false && $newsHooks->fetchItems([1],null,0,0,$module)===false,'Unfiltered hooks delegate to core/other hooks');

class HookNewsArchive extends Hschottm\TagsBundle\ModuleNewsArchiveTags {
    public function run(array $data): array {
        foreach ($data as $key=>$value) $this->$key=$value;
        $this->Template=new Contao\FrontendTemplate('mod_newsarchive');
        $this->compile();
        return $this->Template->getData();
    }
    protected function parseArticles($articles, $addArchive=false) {
        return array_map(static fn($row)=>(int)$row['id'], $articles->fetchAll());
    }
}
$archive=(new ReflectionClass(HookNewsArchive::class))->newInstanceWithoutConstructor();
$archiveData=['id'=>902,'headline'=>'Archive','news_archives'=>[1],'tag_filter'=>'HookTest','tag_ignore'=>true,'perPage'=>1,'news_jumpToCurrent'=>'all_items','news_order'=>'order_headline_asc'];
$result=$archive->run($archiveData);
check($result['articles']===[3] && $result['tags_total_found']===2,'Archive sorting and total');
$request->query->set('page_a902',2);
check($archive->run($archiveData)['articles']===[1],'Archive second page');
$request->query->remove('page_a902');
$result=$archive->run(array_replace($archiveData,['perPage'=>0]));
check($result['articles']===[3,1] && $result['tags_total_found']===2,'Archive sorting/total without pagination');

// Repeated occurrences keep their keys and payload, and inherit tag variables.
$GLOBALS['objPage']=null;
$db->insert('tl_tag',['tid'=>42,'tag'=>'CalendarTest','from_table'=>'tl_calendar_events']);
$events=[20261025=>[1000=>[['id'=>42,'details'=>'One'],['id'=>43,'details'=>'Other']]],20261026=>[2000=>[['id'=>42,'details'=>'Repeat']]]];
$calendar=(new ReflectionClass(Contao\ModuleCalendar::class))->newInstanceWithoutConstructor();
$calendar->tag_filter='CalendarTest';
$result=$calendarHook($events,[1],0,9999,$calendar);
check(count($result[20261025][1000])===1 && isset($result[20261026][2000][0]),'Filter recurring calendar events');
check($result[20261025][1000][0]['tags']===['CalendarTest'] && $result[20261026][2000][0]['details']==='Repeat','Enrich event data without replacing recurrence data');
$calendar->tag_filter='Missing';
check($calendarHook($events,[1],0,9999,$calendar)===[],'Remove empty event buckets');
$feed=(new ReflectionClass(Contao\ModuleNewsReader::class))->newInstanceWithoutConstructor();
$feed->tag_filter='Missing';
check($calendarHook($events,[1],0,9999,$feed)===$events,'Unrelated modules/feeds untouched');

$reader=(new ReflectionClass(Contao\ModuleEventReader::class))->newInstanceWithoutConstructor();
$reader->cal_template='custom_event';
$reader->event_showtags=true;
$templateFactory=static function() {
    $template=new Contao\FrontendTemplate('custom_event');
    $template->id=42;
    $template->calendar=(object)['id'=>1];
    $template->getSchemaOrgData=static fn()=>[];
    return $template;
};
$readerHook->withModule($reader, function()use($reader,$readerHook,$templateFactory) {
    $outer=$templateFactory();
    $readerHook($outer);
    check($outer->tags===['CalendarTest'],'Reader uses custom template and module context');
    $inner=clone $reader;
    $inner->event_showtags=false;
    try {
        $readerHook->withModule($inner,function()use($readerHook,$templateFactory) {
            $template=$templateFactory();
            $readerHook($template);
            check($template->showTags===false && $template->tags===[],'Nested reader settings isolated');
            throw new RuntimeException('Expected nested error');
        });
    } catch (RuntimeException $e) {
        if ($e->getMessage()!=='Expected nested error') throw $e;
    }
    $outer=$templateFactory();
    $readerHook($outer);
    check($outer->tags===['CalendarTest'],'Outer reader context restored after exception');
});
$outside=$templateFactory();
$readerHook($outside);
check($outside->tags===null,'Reader context cleared after compile');
echo "Hook integration: core news pagination, archive, recurring events and nested readers passed.\n";

$reader->cal_template='taglist';
$parsed='';
$schemaCalls=0;
$readerHook->withModule($reader,function()use(&$parsed,&$schemaCalls) {
    $template=new Contao\FrontendTemplate('taglist');
    $template->id=42;
    $template->calendar=(object)['id'=>1];
    $template->getSchemaOrgData=static function()use(&$schemaCalls) { ++$schemaCalls; return []; };
    $parsed=$template->parse(); // Execute the registered hook through the real Twig bridge.
});
check(str_contains($parsed,'CalendarTest') && $schemaCalls===0,'Registered parseTemplate hook enriches Twig without evaluating lazy schema');

$db->executeStatement('CREATE TEMPORARY TABLE tl_faq_category (id INT PRIMARY KEY, title VARCHAR(255), jumpTo INT)');
$db->executeStatement('CREATE TEMPORARY TABLE tl_faq (id INT PRIMARY KEY, pid INT, question VARCHAR(255), published CHAR(1), sorting INT)');
foreach ([81001,81002] as $id) $db->insert('tl_faq_category',['id'=>$id,'title'=>'Category '.$id,'jumpTo'=>1]);
foreach ([[81001,81001,'1'],[81002,81002,'1'],[81003,81002,'']] as [$id,$pid,$published]) $db->insert('tl_faq',['id'=>$id,'pid'=>$pid,'question'=>'Question '.$id,'published'=>$published,'sorting'=>$id]);
foreach ([81002,81003] as $id) $db->insert('tl_tag',['tid'=>$id,'tag'=>'FaqTest','from_table'=>'tl_faq']);
class HookFaqList extends Hschottm\TagsBundle\ModuleFaqListTags {
    public function run(): array {
        $this->faq_categories=[81001,81002];
        $this->Template=new Contao\FrontendTemplate('mod_faqlist');
        $this->compile();
        return $this->Template->faq;
    }
    protected function generateFaqLink($faq) { return '/faq/'.$faq->id; }
}
$faq=(new ReflectionClass(HookFaqList::class))->newInstanceWithoutConstructor();
Contao\Input::setGet('tag','FaqTest');
$groups=$faq->run();
check(count($groups)===1 && (int)$groups[0]['id']===81002 && count($groups[0]['items'])===1,'FAQ filters items and removes empty categories, preserving publication rules');
check($groups[0]['items'][0]['href']==='/faq/81002' && $groups[0]['class']==='first last odd','FAQ keeps core links and legacy template classes');
Contao\Input::setGet('tag','Missing');
check($faq->run()===[],'Empty FAQ match');
Contao\Input::setGet('tag',null);
check(count($faq->run())===2,'Unfiltered FAQ list delegates to core');
echo "Registered Twig hook and core FAQ post-filtering passed.\n";
