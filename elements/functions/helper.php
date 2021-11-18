<?php

function includeCSS(string $nomFichier): string
{
    return <<<HTML
    <link rel="stylesheet" href="elements/css/$nomFichier.css">
HTML;
}