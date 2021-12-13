<?php

function includeCSS(string $nomFichier): string
{
    return <<<HTML
    <link rel="stylesheet" href="elements/css/$nomFichier.css">
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

function fieldInput(string $typeInput, string $id, string $iconClass, string $placeHolder, string $property = NULL): string
{
    return <<<HTML
    <div class="field mb-4">
        <span class="tag">$placeHolder</span>
        <p class="control has-icons-left has-icons-right">
            <input type="$typeInput" class="input" id="$id" placeholder="$placeHolder" required $property>
            <span class="icon is-small is-left">
                <i class="$iconClass"></i>
            </span>
        </p>
    </div>
HTML;
}

function fieldSelect(string $id, string $options): string
{
    
    return <<<HTML
    <div class="field">
        <p class="control has-icons-left">
            <select id="$id" class="input">
                $options
            </select>
            <span class="icon is-small is-left">
                <i class="fas fa-venus-mars"></i>
            </span>
        </p>
    </div>
HTML;
}

