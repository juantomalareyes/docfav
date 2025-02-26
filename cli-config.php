<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;

require_once __DIR__ . '/src/Config/bootstrap.php';

return ConsoleRunner::createHelperSet($entityManager);