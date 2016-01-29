<?php

namespace Ck\Laravel\Envoyer\Envoyer;

class Envoyer
{
    public function __construct($stage = null)
    {
        var_dump(Config::get('envoyer.name'));
    }


    public function getServers()
    {

    }
}