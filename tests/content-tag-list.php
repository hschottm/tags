<?php
namespace Contao {
class System {
    public static bool $preview = false;
    public static function getContainer() { return new class {
        public function get($id) { return new class {
            public function hasBackendUser() { return false; }
            public function hasFrontendUser() { return false; }
            public function isPreviewMode() { return System::$preview; }
        }; }
    }; }
}
class Database {
    public static array $queue = [];
    public static function getInstance() { return new self; }
    public function prepare($sql) { return $this; }
    public function execute(...$args) { return array_shift(self::$queue); }
}
}
namespace Hschottm\TagsBundle {
class TagList {
    protected $arrCloudTags = [];
    protected function cloud_tags($tags) { return $tags; }
}
// Optional path permits verifying this regression against an older release.
require $argv[1] ?? dirname(__DIR__).'/src/Resources/contao/classes/TagListContentElements.php';
class Probe extends TagListContentElements {
    public function collect() { $this->arrPages = [1]; $this->getContentElementsForPages(); return $this->arrContentElements; }
}
set_error_handler(static function ($severity, $message) { throw new \RuntimeException($message); });
foreach ([false, true] as $preview) {
    \Contao\System::$preview = $preview;
    foreach ([[], [['tag_name'=>'Music', 'tag_count'=>2]]] as $expected) {
        \Contao\Database::$queue = [
            new class { public function fetchEach($key) { return [10]; } },
            new class { public function fetchEach($key) { return [20,21]; } },
        ];
        $probe = new Probe;
        if ($probe->collect() !== [20,21]) throw new \RuntimeException('Content IDs lost');
        \Contao\Database::$queue = [new class($expected) {
            public int $numRows; public string $tag = 'Music'; public int $count = 2; private bool $read = false;
            public function __construct($rows) { $this->numRows = count($rows); }
            public function next() { if ($this->read || !$this->numRows) return false; $this->read = true; return true; }
        }];
        if ($probe->getTagList() !== $expected) throw new \RuntimeException('Incorrect tag aggregation');
    }
}
echo "OK: public/preview content collection and empty/populated tag lists\n";
}
