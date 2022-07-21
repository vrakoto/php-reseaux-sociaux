<?php

function includeCSS(string $nomFichier): string
{
    $path = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'CSS' . DIRECTORY_SEPARATOR . $nomFichier . '.css';
    return <<<HTML
    <link rel="stylesheet" href="$path">
HTML;
}

function nav_item(string $lien, string $titre): string
{
    $active = "";
    if (strpos($_SERVER['REQUEST_URI'], $lien)) {
        $active = 'has-text-white has-background-black-ter';
    } else {
        $active = 'has-text-grey-light';
    }

    return <<<HTML
    <a href="$lien" class="$active navbar-item">$titre</a>
HTML;

}

function generateString(int $length): string
{
    return substr(str_shuffle(MD5(microtime())), 0, $length);
}