<?php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\DriverManager;
use Symfony\Component\Dotenv\Dotenv;

require_once __DIR__ . '/../../vendor/autoload.php';

// Cargar variables de entorno
$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/../../.env');

$config = Setup::createAnnotationMetadataConfiguration(
    [__DIR__ . '/../Domain/Entities'], // Directorio de entidades
    true, // Modo desarrollo
    null, // Directorio de proxies
    null, // Caché
    false // No usar Simple Annotation Reader
);

$connectionParams = [
    'dbname'   => $_ENV['DB_NAME'],
    'user'     => $_ENV['DB_USER'],
    'password' => $_ENV['DB_PASS'],
    'host'     => $_ENV['DB_HOST'],
    'driver'   => 'pdo_mysql',
];

$entityManager = EntityManager::create(
    DriverManager::getConnection($connectionParams, $config),
    $config
);

return $entityManager;