<?php

$lang = 'en_US'; // Default language
$langDir = 'json' . DIRECTORY_SEPARATOR . 'lang';

$page = 'index'; // default page
$pageDir = 'html';

// if lang is set in the get request, we overide the default lang value
if (isset($_GET['lang'])) {
    // List all avalailable languages available in the json/lang directory
    $availableLanguages = array();
    $langFiles = array_diff(scandir($langDir), array('..', '.'));

    foreach($langFiles as $k => $v) {
        if(substr($v, -5) === '.json') {
            $availableLanguages[] = substr($v, 0, -5);
        }
    }

    // if language is available
    if (in_array($_GET['lang'], $availableLanguages)) {
        $lang = $_GET['lang'];
    }
}

$langFile = $langDir . DIRECTORY_SEPARATOR . $lang . '.json';
$strings = json_decode(file_get_contents($langFile)); // get the srings defined in the lang file

// if page is set in the request
if (isset($_GET['page'])) {
    $page = $_GET['page'];
}

$pageHtml = file_get_contents($pageDir. DIRECTORY_SEPARATOR . $page . '.html');

foreach ($strings as $name => $value) {
    $pageHtml = str_replace('%{' . $name . '}%', $value, $pageHtml);
}

echo $pageHtml;
