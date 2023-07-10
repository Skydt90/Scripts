<?php

$season = '07';
$showName = 'Dragon Ball Kai';
$episodeOffset = 140; # Minus 1 from season start
$folderPath = 'D:\Film & Serier\Tegnefilm\Dragon Ball Kai\Dragon Ball Kai - Season 7';

# Check if the directory exists
if (!file_exists($folderPath) || !is_dir($folderPath)) {
    die("Directory does not exist: $folderPath");
}

# Get all files from the directory
$files = scandir($folderPath);

foreach ($files as $file) {

    if ($file === '.' || $file === '..') {
        continue;
    }

    $filePath = $folderPath . '\\' . $file;

    if (is_file($filePath)) {

        $fileInfo = pathinfo($filePath);

        # Assuming the filename structure as "Episode 23 Vegeta's Covert Maneuvers! A Tragic Assault on the Namekians!"
        if (preg_match('/^Episode\s+(\d+)\s+(.+)/i', $fileInfo['filename'], $matches)) {

            $episode = str_pad($matches[1] - $episodeOffset, 2, '0', STR_PAD_LEFT);
            
            $episodeName = $matches[2];

            $newName = "$showName - S$season" . "E$episode - $episodeName." . $fileInfo['extension'];

            $newPath = $folderPath . '\\' . $newName;

            echo "Renamed $file to:\n$newName" . PHP_EOL . PHP_EOL;

            echo rename($filePath, $newPath) 
                ? "Renamed $file to:\n$newName" . PHP_EOL . PHP_EOL
                : "Failed to rename $file to $newName" . PHP_EOL . PHP_EOL;
        }
    }
}
