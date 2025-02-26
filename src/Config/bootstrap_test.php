<?php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\DriverManager;

require_once __DIR__ . '/../../vendor/autoload.php';

// Configuración de conexión para la base de datos de pruebas
$dbParams = [
    'dbname' => 'test_database',
    'user' => 'test_user',
    'password' => 'test_password',
    'host' => 'mysql',
    'port' => '3306',
    'driver' => 'pdo_mysql',
];

// $config = ORMSetup::createAttributeMetadataConfiguration([__DIR__ . '/../Domain/Entities'], true);
$config = Setup::createAnnotationMetadataConfiguration(
    [__DIR__ . '/../Domain/Entities'], // Directorio de entidades
    true, // Modo desarrollo
    null, // Directorio de proxies
    null, // Caché
    false // No usar Simple Annotation Reader
);
$connection = DriverManager::getConnection($dbParams, $config);
$entityManager = EntityManager::create($connection, $config); 

return $entityManager;