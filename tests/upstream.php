<?php
/** Fail visibly when a core method we partly copied changes. Never refresh blindly. */
require getenv('TAGS_TEST_AUTOLOAD') ?: dirname(__DIR__).'/vendor/autoload.php';

$checks = json_decode(file_get_contents(__DIR__.'/upstream.json'), true, flags: JSON_THROW_ON_ERROR);
foreach ($checks as $check) {
    $method = new ReflectionMethod($check['class'], $check['method']);
    $lines = file($method->getFileName());
    $code = implode('', array_slice($lines, $method->getStartLine()-1, $method->getEndLine()-$method->getStartLine()+1));
    $normalized = '';
    foreach (token_get_all("<?php\n".$code) as $token) {
        if (is_array($token)) {
            if (in_array($token[0], [T_OPEN_TAG,T_WHITESPACE,T_COMMENT,T_DOC_COMMENT], true)) continue;
            $normalized .= $token[1];
        } else {
            $normalized .= $token;
        }
    }
    if (hash('sha256', $normalized) !== $check['sha256']) {
        fwrite(STDERR, $check['class'].'::'.$check['method']." changed since Contao ".$check['version'].". Review ".$check['adaptation']." and docs/UPSTREAM.md before updating this fingerprint.\n");
        exit(1);
    }
}
echo "Upstream methods for the two remaining core adaptations are unchanged since Contao 5.7.15.\n";
