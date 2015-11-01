<?php

namespace Mwc\Envoyer;

use Illuminate\Support\Facades\Config;

class Envoyer
{
    public function __construct($stage = null)
    {
        var_dump(Config::get('envoyer.name'));
    }
}