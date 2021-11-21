<?php

function includeCSS(string $nomFichier): string
{
    return <<<HTML
    <link rel="stylesheet" href="elements/css/$nomFichier.css">
HTML;
}

function generateString(int $length): string
{
    return substr(str_shuffle(MD5(microtime())), 0, $length);
}