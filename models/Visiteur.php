<?php

class Visiteur extends Commun {
    public function __construct()
    {
        parent::__construct();
    }

    function test()
    {
        var_dump($this->pdo);
    }
}