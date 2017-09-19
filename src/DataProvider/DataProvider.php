<?php

namespace Core\DataProvider;

interface DataProvider
{

    public function request($params);

    public function format($sourceData);

}