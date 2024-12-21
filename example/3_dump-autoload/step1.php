<?php
processDumpAutoload(__DIR__ . '/vendor'); // この内部で `procedure3_1` が呼ばれます

function procedure3_1 (string $vendorDirPath): string
{
    $psr4ClassMap = [];
    $packageFiles = glob("{$vendorDirPath}/*/*/composer.json");
    foreach ($packageFiles as $packageFile) {
        /* === STEP-1 ココから === */
        $package = json_decode(file_get_contents($packageFile), true);
        $packagePsr4ClassMaps = $package['autoload']['psr-4'] ?? null;
        if (!$packagePsr4ClassMaps) {
            continue;
        }
        $packageDir = dirname($packageFile);
        foreach ($packagePsr4ClassMaps as $namespace => $dirName) {
            if (!array_key_exists($namespace, $psr4ClassMap)) {
                $psr4ClassMap[$namespace] = [];
            }
            $psr4ClassMap[$namespace][] = rtrim("{$packageDir}/{$dirName}", '/');
        }
        /* === STEP-1 ココまで === */
    }

    $psr4ClassMapPath = $vendorDirPath . '/autoload_classmap_psr4.php';
    file_put_contents(
        $psr4ClassMapPath,
        '<?php return '.var_export($psr4ClassMap, true).';'
    );

    return $psr4ClassMapPath;
}

