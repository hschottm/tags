<?php
require __DIR__.'/bootstrap.php';
foreach ($map as $class=>$file) check(class_exists($class),'Cannot load '.$class);
foreach (glob($root.'/src/Resources/contao/templates/*/*.twig') as $file) $twig->load('@Contao/'.basename($file));
check(Hschottm\TagsBundle\TagHelper::decode(null)==='', 'Absent tag request');
check(Hschottm\TagsBundle\TagHelper::decode(Hschottm\TagsBundle\TagHelper::encode('PHP/Symfony'))==='PHP/Symfony','Tag encoding');
$html=$twig->render('@Contao/tags_inserttag.html.twig',['tags'=>[['tag'=>'<script>alert(1)</script>', 'url'=>'/tags', 'tagcount'=>1]]]);
check(!str_contains($html,'<script>'),'Escape tag text');
$GLOBALS['FE_MOD']=['miscellaneous'=>[]];
require $root.'/src/Resources/contao/config/config.php';
check(!isset($GLOBALS['FE_MOD']['news']) && !isset($GLOBALS['FE_MOD']['events']) && !isset($GLOBALS['FE_MOD']['faq']), 'Do not register absent optional modules');
check($GLOBALS['BE_FFL']['tag']===Hschottm\TagsBundle\TagField::class, 'Backend widget registered');
echo 'Loaded '.count($map)." classes, compiled 11 Twig templates; encoding and optional module registration passed.\n";
