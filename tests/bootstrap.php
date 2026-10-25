<?php

// Use the real Contao classes, with only application services isolated from the CMS.
require getenv('TAGS_TEST_AUTOLOAD') ?: dirname(__DIR__).'/vendor/autoload.php';

$root = dirname(__DIR__);
$map = [];
foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root.'/src')) as $file) {
    if ($file->getExtension() !== 'php' || !preg_match('/namespace ([^;]+);/', file_get_contents($file), $match)) {
        continue;
    }
    $map[$match[1].'\\'.$file->getBasename('.php')] = (string) $file;
}
spl_autoload_register(static function ($class) use ($map): void {
    if (isset($map[$class])) {
        require $map[$class];
    }
});

$container = new Symfony\Component\DependencyInjection\ContainerBuilder();
$container->setParameter('kernel.debug', false);
$container->setParameter('kernel.charset', 'UTF-8');
$container->setParameter('kernel.project_dir', $root);
$container->set(Contao\Config::class, (new ReflectionClass(Contao\Config::class))->newInstanceWithoutConstructor());
$stack = new Symfony\Component\HttpFoundation\RequestStack();
$stack->push(Symfony\Component\HttpFoundation\Request::create('/tags'));
$container->set('request_stack', $stack);
$storage = new Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage();
$backendUser = (new ReflectionClass(Contao\BackendUser::class))->newInstanceWithoutConstructor();
$storage->setToken(new Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken($backendUser, 'contao_backend', ['ROLE_ADMIN']));
$container->set('security.token_storage', $storage);
$matcher = new class implements Symfony\Component\HttpFoundation\RequestMatcherInterface {
    public function matches(Symfony\Component\HttpFoundation\Request $request): bool { return false; }
};
$scope = new Contao\CoreBundle\Routing\ScopeMatcher($matcher, $matcher, $stack);
$container->set('contao.routing.scope_matcher', $scope);
$container->set('contao.twig.interop.context_factory', new Contao\CoreBundle\Twig\Interop\ContextFactory($scope));
$loader = new class extends Twig\Loader\FilesystemLoader {
    public function getFirst($name, $theme = null) { return $name.'.html.twig'; }
    public function getCurrentThemeSlug() { return null; }
};
foreach (glob($root.'/src/Resources/contao/templates/*', GLOB_ONLYDIR) as $directory) {
    $loader->addPath($directory, 'Contao');
}
$twig = new Twig\Environment($loader, ['autoescape' => 'contao_html']);
$escaper = new Contao\CoreBundle\Twig\Interop\ContaoEscaper();
$twig->getRuntime(Twig\Runtime\EscaperRuntime::class)->setEscaper('contao_html', $escaper->escapeHtml(...));
$twig->addGlobal('contao', ['request_token' => 'test-token']);
$twig->addFilter(new Twig\TwigFilter('insert_tag_raw', static fn($value) => $value, ['is_safe' => ['html']]));
$container->set('twig', $twig);
$container->set('contao.twig.filesystem_loader', $loader);
Contao\System::setContainer($container);
$GLOBALS['TL_LANGUAGE'] = 'en';
$GLOBALS['TL_LANG']['MSC']['mandatory'] = 'Mandatory';
$GLOBALS['TL_LANG']['ERR']['mandatory'] = 'Please fill in %s';
require $root.'/src/Resources/contao/languages/en/default.php';

function check(bool $condition, string $message): void {
    if (!$condition) throw new RuntimeException($message);
}
