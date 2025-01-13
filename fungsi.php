<!-- Kumpulan fungsi PHP & JS -->

<?php
include "config.php";
function cleanString($string)
{
    $string = str_replace(' ', '-', $string);
    $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string);

    return preg_replace('/-+/', '', $string);
}
function getPath()
{
    global $projek_name;
    $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $path = parse_url($url, PHP_URL_PATH);
    $path_parts = explode('/', rtrim($path, '/'));

    $index = array_search($projek_name, $path_parts);
    if ($index !== false) {
        $path_parts = array_slice($path_parts, $index + 1);
    }

    $relative_path = implode('/', $path_parts);
    $relative_path = explode('?', $relative_path)[0];
    $relative_path = explode('#', $relative_path)[0];
    
    $endWithPhp = str_ends_with($relative_path, ".php");
    if (!$relative_path || !$endWithPhp) $relative_path = (!$endWithPhp ? $relative_path . "/" : "") ."index";
    $relative_path = explode('.', $relative_path)[0];
    if(!str_starts_with($relative_path, "/")) $relative_path = "/" . $relative_path;
    
    return $relative_path;
}

function strSlice($string, $split, $from, $to)
{
    return implode(" ", array_slice(explode($split, $string), $from, $to));
}
?>

<script>
    function getPath() {
        var url = window.location.href;
        var path = new URL(url).pathname;
        var last_part = path.split('/').pop();
        var filename = last_part.split('.')[0];

        return filename;
    }
</script>