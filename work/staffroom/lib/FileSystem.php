<?php

declare(strict_types=1);


namespace Staffroom;

class FileSystem
{
    /**
     * @see \Composer\Util\Filesystem::rename
     */
    public static function move(string $from, string $to): int
    {
        $command = sprintf('mv %s %s', escapeshellarg($from), escapeshellarg($to));
        @exec($command, $output, $result);

        return $result;
    }

    public function rm()
    {
       //     $result = $this->getProcess()->execute(['mv', $source, $target], $output);
    }

    public static function unzip(string $zipFile, string $extractTo)
    {

    }

    public static function removeFileRecursive(string $dir): void
    {
        if (!file_exists($dir)) {
            return;
        }
        if (is_file($dir)) {
            unlink($dir);
            return;
        }
        if (!is_dir($dir)) {
            throw new \InvalidArgumentException("{$dir} はディレクトリではありません");
        }
        $iterator = new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS);
        $files = new \RecursiveIteratorIterator($iterator, \RecursiveIteratorIterator::CHILD_FIRST);

        foreach ($files as $file) {
            if ($file->isDir()) {
                rmdir($file->getRealPath());
            } else {
                unlink($file->getRealPath());
            }
        }
        rmdir($dir);
    }

}
