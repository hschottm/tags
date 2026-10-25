# Contao extension points and remaining core adaptations

Reviewed against **Contao 5.7.15**, the latest official stable 5.7.x tag verified on 2026-10-25 using the [official repository tags](https://github.com/contao/contao/tags). The installed archive, news-list, TextField and FormText source files were byte-for-byte identical to the official 5.7.15 sources. Existing frontend module types and tag template variables remain available.

## Hook-based integration

| Area | Extension point | Tags implementation |
| --- | --- | --- |
| News list count and retrieval | `newsListCountItems`, `newsListFetchItems` | `EventListener/NewsListListener.php`; Contao retains pagination, limits and rendering. Return `false` without a tag filter to allow the normal core/other-hook path. |
| News item tags, including the reader | `parseArticles` | `EventListener/ParseArticlesListener.php`; uses the hook's module argument, not static global settings. |
| Calendar and event list | `getAllEvents` | `EventListener/CalendarEventsListener.php`; filter and enrich the generated events before core pagination/rendering. Recurrence keys and other event data are preserved. Feed pseudo-modules are excluded. |
| Event reader tags | `parseTemplate` | `EventListener/EventReaderTemplateListener.php`; the tiny reader subclass scopes the listener around `parent::compile()`. A stack with `try/finally` handles nested readers and exceptions. Custom event template names are supported; lazy content/schema closures are not evaluated by the listener. |
| FAQ list | `parent::compile()` and structured template data | `ModuleFaqListTags` removes unmatched items and empty categories. This is safe because the core FAQ list has no pagination. Core URL generation, publication rules and cache tags remain in use. It can fetch more records/cache tags than the filtered result needs. |
| News model queries | `buildFindQuery`, `buildCountQuery` | `TagsNewsModel` adds an ID predicate through a per-query option; inherited core methods supply publication, preview, featured and date rules. No global model replacement or current-filter variable. |

`Service/TagFilter.php` centralizes tag matching. A null result means no filter, an empty array means no matches. `Service/TagView.php` centralizes the legacy-compatible `tags`, `taglist`, `showTags` and `showTagClass` variables. Thin news/event list subclasses only add module-level tag metadata after `parent::compile()`.

The core calendar and news reader are no longer replaced in `FE_MOD`. Their former Tags classes remain empty compatibility subclasses for external references. The old `TagsFaqModel` API also remains as a small compatibility adapter.

## Remaining copied/adapted fragments

### News archive compilation

- Local: `src/Resources/contao/modules/ModuleNewsArchiveTags.php::compileFromParent()`.
- Source package/file: `contao/news-bundle/contao/modules/ModuleNewsArchive.php`.
- Source method: `Contao\ModuleNewsArchive::compile()`.
- Reviewed source: [Contao 5.7.15](https://github.com/contao/contao/blob/5.7.15/news-bundle/contao/modules/ModuleNewsArchive.php).
- Reason: the archive invokes static model count/fetch methods directly and exposes no equivalent of the news-list query hooks. Filtering after pagination would produce incorrect pages and totals.
- Changes: calculate the filtered total, use `TagsNewsModel` with ID constraints for both fetch paths, and expose `tags_total_found`. All changes inside the copied method have `TAGS` markers; the copied region has `BEGIN/END CORE ADAPTATION` markers. The surrounding `compile()` method and `tags_activetags` assignment are Tags code.
- This update includes the 5.7 pagination factory/proxy and passes the core sorting options in both fetch paths.

### News list sorting

- Local: `src/EventListener/NewsListListener.php::fetchItems()`.
- Source package/file: `contao/news-bundle/contao/modules/ModuleNewsList.php`.
- Source fragment: the `Determine sorting` block in `Contao\ModuleNewsList::fetchItems()`.
- Reviewed source: [Contao 5.7.15](https://github.com/contao/contao/blob/5.7.15/news-bundle/contao/modules/ModuleNewsList.php).
- Reason: the fetch hook returns before the core reaches its sorting block. The hook therefore mirrors the small order mapping and `featured_first` prefix. It does not copy list compilation or pagination.

## Widget copies replaced with parent rendering

`TagField::generate()` and `TagFieldMemberFrontend::generate()` now prepend the tag cloud to `parent::generate()`. Their historical copies of `TextField` / `FormText` input markup have been removed. Rendering therefore follows the installed Contao version (reviewed and tested with 5.7.15), including escaping, attributes, backend Stimulus scroll handling and wizard output.

Both widgets temporarily set the display value to saved tags, or preserve submitted input on validation errors, and restore the previous value with `try/finally`. The member widget additionally scopes its `value` getter to parent rendering: outside rendering it continues returning the empty persistence placeholder, preventing tag names from entering the member's char(1) column. Exceptions also restore this mode. Tests cover escaping, invalid input, persistence placeholders, wizard output and exception cleanup.

## Complete class/inheritance audit (2026-10-25)

All **53 remaining classes under `src/`** were inventoried with PHP reflection against the installed Contao 5.7.15 dependencies. Locally declared methods were compared with their nearest ancestor implementation, including inherited grandparents and private methods. Abstract extension points, calls to `parent::…`, and shared method names alone are not classified as code copies. Helpers with renamed methods (notably `compileFromParent`) and the hook sorting fragment were also inspected. This audit identifies current duplication; it cannot establish the original release of historical copied code without historical sources.

### Internal parent-code duplication

These are maintenance dependencies within Tags, not additional Contao core copies. Class comments identify their shared source.

| Classes | Duplicated/adapted parent code |
| --- | --- |
| `TagListArticles`, `TagListContentElements`, `TagListEvents`, `TagListMembers`, `TagListNews` | `TagList::getRelatedTagList()` / `getTagList()`: tag intersection, aggregation and cloud construction, with specialized source queries. Magic getters/setters extend local configuration and otherwise delegate. |
| `TagListContentElements` | Additionally repeats `TagList::getRelevantPages()` verbatim apart from formatting. |
| `ModuleTagCloudArticles`, `ModuleTagCloudContent`, `ModuleTagCloudEvents`, `ModuleTagCloudMembers`, `ModuleTagCloudNews` | `ModuleTagCloud::generate()`: backend wildcard, template selection, cloud configuration, related/top tags and empty-result handling. They call `Module::generate()` directly to bypass their immediate parent's generic tag query. |
| `ModuleTaggedArticleList` | Parts of `ModuleGlobalArticlelist::generate()` / `compile()`: wildcard, recursion guard, article/page output and active-tag metadata, with scoped queries and per-article tags. |

Additional internal duplication outside parent/child relationships: page traversal in `TagList`, `TagListContentElements`, `ModuleTaggedArticleList`, `ModuleTagContentList`, and `ModuleTagListByCategory`; and tag-cloud/input handling in the two widgets. The commented-out `skipFirst` fragment in `ModuleTaggedArticleList::getArticlesForPages()` explicitly names the historical `system/modules/frontend/ModuleArticleList.php`, but is not executable code. `TagListMembers::isMemberOf()` resembles the historical user-group check; it is not an override (`TagList`/`System` have no such method), and its only local call is commented out. Its original provenance is not verified.

### Ancestor calls without copied implementations

| Classes | Classification |
| --- | --- |
| `ModuleNewsListTags`, `ModuleEventlistTags` | Parent compilation plus module tag metadata. |
| `ModuleEventReaderTags` | Scoped listener around parent compilation. |
| `ModuleFaqListTags` | Parent compilation followed by filtering/reindexing of result data; small local legacy CSS-class helper. |
| `ContentGalleryTags` | Filter file models before parent compilation; no gallery rendering copy. |
| `ContentHeadlineTags` | Conditional early return, otherwise parent generation. |
| `ModuleCalendarTags`, `ModuleNewsReaderTags` | Empty compatibility subclasses. |
| `TagsNewsModel`, `TagsFaqModel` | Query-option adapters that delegate to the inherited model methods. |
| `TagHelper`, `TagList` | Constructors delegate; own tag functionality. `TagList::__get()` is local configuration handling, not a copy of `System::__get()`. |
| `TagField`, `TagFieldMemberFrontend` | Rendering and validation delegate to the parent; scoped display values and magic methods add tag-specific behavior. No remaining core markup copy. |

### Removed legacy feed helpers

`CalendarTags` and `NewsTags` have been removed: `Calendar::addEvent()` is private in Contao 5.7.15, and `News::getLink()` no longer exists. Neither class was registered by this bundle. The empty `TagHelper::generateEventFeed()` / `generateNewsFeed()` methods, commented-out DCA registrations, and unused `showInFeeds` setting were removed with them. This does not remove Contao's own feed functionality.

### Remaining classes: own implementations / extension points

- `ModuleGlobalArticlelist`, `ModuleTagCloud`, `ModuleTagContentList`, `ModuleTagListByCategory`, `ModuleTagScope`: implement abstract `Module::compile()` and delegate frontend generation; no concrete parent compilation to copy.
- `TagModel`, `TagMemberHelper`: own methods; no overridden concrete ancestor methods.
- `HschottmTagsBundle`: own extension factory; `TagsExtension`: implements abstract DI loading; `Plugin`: implements the manager interface.
- `TagFilter`, `TagView`, `TagsInsertTag`: no parent class.
- `CalendarEventsListener`, `EventReaderTemplateListener`, `CompileArticleListener`, `ParseArticlesListener`, `NewsListListener`, `ReviseTableListener`: no parent class; the news sorting fragment is accounted for above.
- All eight data-container listeners (`ArticleCallbackListener`, `CalendarCallbackListener`, `ContentCallbackListener`, `FaqCallbackListener`, `FileCallbackListener`, `MemberCallbackListener`, `NewsCallbackListener`, `PageCallbackListener`): no parent class; their own tag copy/delete callbacks do not override core methods.

## Updating Contao

1. Run `php tests/upstream.php` against the installed dependencies. For an external installation, set `TAGS_TEST_AUTOLOAD` to its Composer autoloader.
2. The check compares token-based SHA-256 fingerprints of the two upstream methods. Whitespace/comments do not matter; code changes require review. It intentionally checks the whole `fetchItems()` method so hook contract changes also trigger review.
3. If it fails, compare the indicated upstream source with the reviewed version. Update the marked adaptation only where necessary, and update the version comments, this document and `tests/upstream.json` after review. Never refresh fingerprints just to make the test pass.
4. Run `tests/run.php`, `tests/javascript.cjs`, and `tests/integration.php`. The integration suite uses real Contao methods and temporary database tables to check filtering, publication, sorting, pagination and module-context isolation.

The fingerprint check watches the two remaining copied core methods. The widget rendering is inherited and covered by integration tests instead. Internal Tags copies and the removal of obsolete feed helpers are documented above, not covered by these fingerprints. It does not replace functional tests of the hook contracts when upgrading Contao.
