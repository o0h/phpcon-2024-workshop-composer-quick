f<?php
processDumpAutoload(__DIR__ . '/vendor'); // この内部で `procedure3_1` が呼ばれます

function procedure3_4(
    string $vendorDirPath,
    string $psr4ClassMapPath,
    string $eagerLoadFilesPath,
    string $psr4ClassLoaderPath,
): void
{
    $autoloaderScript = <<<CODE
<?php
/* === STEP-4 ココから === */

/* === STEP-4 ココまで === */
CODE;

    file_put_contents("{$vendorDirPath}/autoload.php", $autoloaderScript);
}

