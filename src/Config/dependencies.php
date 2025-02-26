<?php

use App\Infrastructure\Persistence\DoctrineUserRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Domain\Repositories\UserRepositoryInterface;
use App\Application\UseCases\RegisterUserUseCase;
use Psr\EventDispatcher\EventDispatcherInterface;
use App\Infrastructure\Controllers\RegisterUserController;
use App\Application\EventHandlers\SendWelcomeEmailHandler;
use Symfony\Component\EventDispatcher\EventDispatcher;
use App\Domain\Events\UserRegisteredEvent;
use DI\Container;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\Tools\Setup;
use Doctrine\DBAL\DriverManager;

$container = new Container();



$config = Setup::createAnnotationMetadataConfiguration(
    [__DIR__ . '/../Domain/Entities'], // Directorio de entidades
    true, // Modo desarrollo
    null, // Directorio de proxies
    null, // Caché
    false // No usar Simple Annotation Reader
);

$connection = DriverManager::getConnection([
    'dbname' => $_ENV['DB_NAME'] ?? 'test_database',
    'user' => $_ENV['DB_USER'] ?? 'test_user',
    'password' => $_ENV['DB_PASS'] ?? 'test_password',
    'host' => $_ENV['DB_HOST'] ?? 'mysql',
    'driver' => 'pdo_mysql',
]);

$entityManager = EntityManager::create($connection, $config);

// Definir dependencias en el contenedor
$container->set(EntityManagerInterface::class, $entityManager);

$container->set(UserRepositoryInterface::class, function () use ($entityManager) {
    return new DoctrineUserRepository($entityManager);
});

// Asegurar que EventDispatcherInterface tenga una implementación
// $container->set(EventDispatcherInterface::class, function () {
//     return new class implements EventDispatcherInterface {
//         public function dispatch(object $event) {
//             // Aquí puedes manejar los eventos si los necesitas
//             return $event;
//         }
//     };
// });

$container->set(EventDispatcherInterface::class, function () {
    $dispatcher = new EventDispatcher();
    $dispatcher->addListener(UserRegisteredEvent::class, [new SendWelcomeEmailHandler(), 'handle']);
    return $dispatcher;
});

$container->set(RegisterUserUseCase::class, function () use ($container) {
    return new RegisterUserUseCase(
        $container->get(UserRepositoryInterface::class),
        $container->get(EventDispatcherInterface::class)
    );
});

$container->set(RegisterUserController::class, function () use ($container) {
    return new RegisterUserController($container->get(RegisterUserUseCase::class));
});

return $container;
