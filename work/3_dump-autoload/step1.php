<?php
processDumpAutoload(__DIR__ . '/vendor'); // この内部で `procedure3_1` が呼ばれます

function procedure3_1 (string $vendorDirPath): string
{
    $psr4ClassMap = [];
    $packageFiles = glob("{$vendorDirPath}/*/*/composer.json");
    foreach ($packageFiles as $packageFile) {
        /* === STEP-1 ココから === */



        /* === STEP-1 ココまで === */
    }

    $psr4ClassMapPath = $vendorDirPath . '/autoload_classmap_psr4.php';
    file_put_contents(
        $psr4ClassMapPath,
        '<?php return '.var_export($psr4ClassMap, true).';'
    );

    return $psr4ClassMapPath;
}

