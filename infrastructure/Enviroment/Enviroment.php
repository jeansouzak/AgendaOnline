<?php

namespace Infrastructure\Enviroment;


use MyCLabs\Enum\Enum;

class Enviroment extends Enum
{
    const DEV = 'local';
    const PRODUCTION = 'production';
    const HOMOLOG = 'homolog';
    const TEST = 'test';


}