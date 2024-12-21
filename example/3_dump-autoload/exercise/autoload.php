<?php

declare(strict_types=1);

require __DIR__.'/autoload_files.php';
function loadClass(string $class)
{
    $psr4Map = require __DIR__.'/autoload_classmap_psr4.php';
    $elements = explode('\\', $class);
    while ($elements) {
        $search = implode('\\', $elements).'\\';
        if (array_key_exists($search, $psr4Map)) {
            $packageRootPath = $psr4Map[$search];
            $sub = str_replace($search, '', $class);
            $subPath = str_replace('\\', '/', $sub);
            $filePath = $packageRootPath.$subPath.'.php';

            require realpath($filePath);
        }
        array_pop($elements);
    }
}

spl_autoload_register('loadClass');
