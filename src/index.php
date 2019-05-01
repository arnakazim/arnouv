<?php

$lang = 'fr-FR'; // Default language
$langDir = 'json' . DIRECTORY_SEPARATOR . 'lang';

$page = 'index'; // default page
$pageDir = 'html';

// contact form
$displayFormSuccess = false;
if (!empty($_POST)) {
    $post = (object) $_POST;
    
    if (isset($post->email,  $post->name, $post->message)) {
        $post->email = htmlspecialchars($post->email);
        $post->name = htmlspecialchars($post->name);
        $post->message = htmlspecialchars($post->message);

        $message = 'Sent from arnaudouvrier.fr (' . date('Y-m-d H-i-s') . ') by '
            . $post->name . ' <' . $post->email . '>:' . "\r\n\r\n"
            . $post->message;

        $to = 'arnaud@arnaudouvrier.fr';
        $subject = $post->name . ' has contacted you';
        $headers = 'From: noreply@arnaudouvrier.fr' . "\r\n" . 'Reply-to: ' . $post->email . "\r\n";

        @mail($to, $subject, $message, $headers);
        $displayFormSuccess = true;
    }
}

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

$pageHtml = str_replace(
    '%{displayFormSuccess}%',
    ($displayFormSuccess) ? 'display: block;' : 'display: none;',
    $pageHtml
);

$pageHtml = str_replace(
    '%{language}%',
    substr($lang, 0, 2),
    $pageHtml
);

foreach ($strings as $name => $value) {
    $pageHtml = str_replace('%{' . $name . '}%', $value, $pageHtml);
}

echo $pageHtml;
