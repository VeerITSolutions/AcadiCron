<?php

$directory = 'resources/views';

// Function to recursively rename files
function renameFiles($dir) {
    $files = scandir($dir);
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') {
            continue;
        }

        $path = $dir . '/' . $file;

        if (is_dir($path)) {
            renameFiles($path); // Recurse into subdirectories
        } else {
            // Check if the file is a .php file
            if (pathinfo($file, PATHINFO_EXTENSION) === 'php') {
                $newPath = $dir . '/' . pathinfo($file, PATHINFO_FILENAME) . '.blade.php';
                rename($path, $newPath);
                echo "Renamed $path to $newPath\n";
            }
        }
    }
}

// Start renaming files
renameFiles($directory);

echo "Conversion completed.\n";
