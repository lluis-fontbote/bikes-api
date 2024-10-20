<?php

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    public function __construct($environment, $debug)
    {
        date_default_timezone_set( 'Europe/Madrid');
        parent::__construct($environment, $debug);
    }
}
