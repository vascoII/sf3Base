<?php

namespace Vasco\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class VascoUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
