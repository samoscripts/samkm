<?php

namespace App\Controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class BaseController
{
    protected Environment $twig;
    public function __construct()
    {
        $loader = new FilesystemLoader('Views');
        $this->twig = new Environment($loader);
    }

}