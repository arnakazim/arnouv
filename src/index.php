<?php

$availableLanguages = array(
    "fr_FR",
    "en_US"
);

$lang = 'en_US';
if (isset($_GET['lang'])) {
    if (in_array($_GET['lang'], $availableLanguages)) {
        $lang = $_GET['lang'];
    }
}

$langFile = 'json' . DIRECTORY_SEPARATOR . 'lang' . DIRECTORY_SEPARATOR . $lang . '.json';
$strings = json_decode(file_get_contents($langFile));

$page = 'index';
if (isset($_GET['page'])) {
    $page = $_GET['page'];
}

$pageHtml = file_get_contents($page . '.html');

foreach ($strings as $name => $value) {
    $pageHtml = str_replace('%{' . $name . '}%', $value, $pageHtml);
}

echo $pageHtml;
