<?php

declare(strict_types=1);
use Symfony\Polyfill\Mbstring\Mbstring;

$workingDir = getcwd();

$cliOpts = getopt('c:');
if (!array_key_exists('c', $cliOpts)) {
    echo 'vendorディレクトリの位置を指定してください(-c)'.PHP_EOL;

    exit(1);
}

$vendorDir = $cliOpts['c'];
if (!is_dir($vendorDir)) {
    echo "{$vendorDir}が存在しません".PHP_EOL;

    exit(1);
}

$psr4ClassMaps = $autoloadFiles = [];

$packageFiles = glob("{$vendorDir}/*/*/composer.json");
foreach ($packageFiles as $packageFile) {
    $package = json_decode(file_get_contents($packageFile));
    $autoload = $package->autoload ?? null;
    if (!$autoload) {
        continue;
    }
    $packageDir = dirname($packageFile);
    $packagePsr4ClassMaps = $autoload->{'psr-4'} ?? [];
    foreach ($packagePsr4ClassMaps as $namespace => $dirName) {
        $psr4ClassMaps[$namespace] = "{$packageDir}/{$dirName}";
    }

    $packageAutoloadFiles = $autoload->files ?? [];
    foreach ($packageAutoloadFiles as $packageAutoloadFile) {
        $autoloadFiles[] = "{$packageDir}/{$packageAutoloadFile}";
    }
}

// vendorに配置
file_put_contents("{$vendorDir}/autoload_classmap_psr4.php", '<?php return '.var_export($psr4ClassMaps, true).';');
file_put_contents("{$vendorDir}/autoload_files.php", '<?php return '.var_export($autoloadFiles, true).';');
copy(__DIR__.'/autoload.php', "{$vendorDir}/autoload.php");

// test
require "{$vendorDir}/autoload.php";

class Logger implements \Psr\Log\LoggerInterface
{

    public function emergency(\Stringable|string $message, array $context = []): void
    {
        // TODO: Implement emergency() method.
    }

    public function alert(\Stringable|string $message, array $context = []): void
    {
        // TODO: Implement alert() method.
    }

    public function critical(\Stringable|string $message, array $context = []): void
    {
        // TODO: Implement critical() method.
    }

    public function error(\Stringable|string $message, array $context = []): void
    {
        // TODO: Implement error() method.
    }

    public function warning(\Stringable|string $message, array $context = []): void
    {
        // TODO: Implement warning() method.
    }

    public function notice(\Stringable|string $message, array $context = []): void
    {
        // TODO: Implement notice() method.
    }

    public function info(\Stringable|string $message, array $context = []): void
    {
        // TODO: Implement info() method.
    }

    public function debug(\Stringable|string $message, array $context = []): void
    {
        // TODO: Implement debug() method.
    }

    public function log($level, \Stringable|string $message, array $context = []): void
    {
        // TODO: Implement log() method.
    }
}
assert(class_exists(Mbstring::class));
