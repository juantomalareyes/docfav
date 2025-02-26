<?php

namespace App\Application\EventHandlers;

use App\Domain\Events\UserRegisteredEvent;

class SendWelcomeEmailHandler
{
    public function handle(UserRegisteredEvent $event)
    {
        // Simulación de envío de correo (esto debería usar un servicio de email real)
        echo "📧 Enviando correo de bienvenida a: " . $event->email() . "\n";
    }
}