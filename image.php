<?php

function getNewestFile($dir)
{
    $valid_file_types = array('jpg');

    $newest_file = null;
    $newest_file_time = -1;
    foreach (scandir($dir) as $filename) {
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        if (!in_array($ext, $valid_file_types)) {
            continue;
        }

        $file_modification_time = filemtime($dir . '/' . $filename);
        if (time() - $file_modification_time < 10) {
            continue;
        }
        if ($file_modification_time > $newest_file_time) {
            $newest_file_time = $file_modification_time;
            $newest_file = $filename;
        }
    }

    return $newest_file;
}

$newest_file = getNewestFile('.');
header("Content-type: image/jpeg");
header('Content-Disposition: filename="image.jpg"');

readfile($newest_file);
