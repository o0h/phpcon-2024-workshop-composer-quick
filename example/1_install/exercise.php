<?php

declare(strict_types=1);

$workingDir = getcwd();

$cliOpts = getopt('c:');
if (!array_key_exists('c', $cliOpts)) {
    echo 'composer.lockファイルの位置を指定してください(-c)' . PHP_EOL;

    exit(1);
}

$lockJsonPath = $cliOpts['c'];
if (!file_exists($lockJsonPath)) {
    echo "{$lockJsonPath}が存在しません" . PHP_EOL;

    exit(1);
}

$lockJson = file_get_contents($lockJsonPath);
$lock = json_decode($lockJson);

$tmpDir = $workingDir . '/tmp';
@mkdir($tmpDir);

foreach (['packages', 'packages-dev'] as $packagesFieldName) {
    foreach ($lock->{$packagesFieldName} as $package) {
        // file get
        $ch = curl_init($package->dist->url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . getenv('GITHUB_OAUTH_TOKEN'),
                'User-Agent: MyPHPApp/1.0',
            ],
        ]);
        $dist = curl_exec($ch);

        // create zip stream
        $fp = tmpfile();
        fwrite($fp, $dist);
        $zip = new ZipArchive();
        $zip->open(stream_get_meta_data($fp)['uri']);

        // extract (tmp)
        for ($i = 0; $i < $zip->numFiles; ++$i) {
            $zip->extractTo($tmpDir, $zip->getNameIndex($i));
        }

        // install
        $target = "{$workingDir}/vendor/{$package->name}";
        mkdir($target, 0777, true);
        rename("{$tmpDir}/{$zip->getNameIndex(0)}", $target);

        // tear down
        $zip->close(); // Close the zip archive
        unset($fp);
    }
}

rmdir($tmpDir);
