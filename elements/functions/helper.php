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

function fieldInput(string $id, string $titre, string $typeInput, string $property = NULL): string
{
   return <<<HTML
   <div class="field">
        <label for="$id">$titre</label>
        <div class="control">
            <input class="input" type="$typeInput" id="$id" $property>
        </div>
    </div>
HTML;
}