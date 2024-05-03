<!-- list the files in the root directory -->

<?php
define("ROOT", __DIR__);

$dir = __DIR__;

function listFiles($dir, $rootDir, $depth = 0) {
    $files = scandir($dir);
    $indent = str_repeat("&nbsp;&nbsp;", $depth);

    echo "<ul>";
    foreach ($files as $file) {
        if ($file !== "." && $file !== "..") {
            $filePath = $dir . "/" . $file;
            $relativeFilePath = str_replace(
                realpath($rootDir),
                "",
                realpath($filePath),
            );
            if (is_dir($filePath)) {
                echo "<li>$indent<span>📂</span> $file</li>";
                listFiles($filePath, $rootDir, $depth + 1);
            } else {
                $ext = pathinfo($file, PATHINFO_EXTENSION);
                if ($ext === "php" || $ext === "html") {
                    echo "<li>$indent<a href='$relativeFilePath'>$file</a></li>";
                }
            }
        }
    }
    echo "</ul>";
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Directory Listing</title>
        <style>
            body {
                font-size: 18px;
            }
            li {
                list-style-type: none;
                padding: 0 0 5px 5px;
            }
        </style>
    </head>

    <body>
        <?php listFiles($dir, ROOT); ?>
    </body>
</html>
