<?php

namespace App;

class Application extends \Core\ApplicationCore
{

    public function run()
    {

        $this->filter()->notify();

    }


}
