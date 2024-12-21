<?php
processDumpAutoload(__DIR__ . '/vendor'); // この内部で `procedure3_1` が呼ばれます

function procedure3_2(string $vendorDirPath): string
{
    $eagerLoadFiles = [];

    $packageFiles = glob("{$vendorDirPath}/*/*/composer.json");
    foreach ($packageFiles as $packageFile) {
        /* === STEP-2 ココから === */
        $package = json_decode(file_get_contents($packageFile), true);
        $packageEagerLoadFiles = $package['autoload']['files'] ?? null;
        if (!$packageEagerLoadFiles) {
            continue;
        }
        $packageDir = dirname($packageFile);
        foreach ($packageEagerLoadFiles as $eagerLoadFile) {
            $eagerLoadFiles[] = "{$packageDir}/{$eagerLoadFile}";
        }
        /* === STEP-2 ココまで === */
    }

    $eagerLoadFilesPath = $vendorDirPath . '/autoload_files.php';

    file_put_contents(
        $eagerLoadFilesPath,
       '<?php return '.var_export($eagerLoadFiles, true).';',
    );

    return $eagerLoadFilesPath;
}

