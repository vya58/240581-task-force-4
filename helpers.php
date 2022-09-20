<?php
// Формулы, используемые в проекте

/**
 * Функция получения путей всех файлов, расположенных в директории, с указанным расширением
 *
 * @param string $fileDirectory - путь к директории
 * @param string $extension расширение искомых файлов
 *
 * @return array $filesPaths - массив с путями к файлам с указанным расширением
 */
function getFilesPaths(string $fileDirectory, string $extension): array
{
    $filesPaths = [];
    $files = scandir($fileDirectory);

    foreach ($files as $file) {
        if (pathinfo($file, PATHINFO_EXTENSION) === $extension) {
            $filesPaths[] = "{$fileDirectory}/{$file}";
        }
    }
    return $filesPaths;
}
