<?php
const ROOT_DIR = __DIR__;

require ROOT_DIR . '/vendor/autoload.php';

\Infrastructure\Infrastructure::loadEnviromentSettings();

require ROOT_DIR . '/application/routes.php';

