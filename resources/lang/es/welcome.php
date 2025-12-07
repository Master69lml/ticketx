<?php

return [
    'title' => '¡Bienvenido a ' . app(\App\Settings::class)->first()->site_name . '!',
    'description' => 'Sistema de soporte de tickets de código abierto. Está construido con el excelente framework Laravel. Incluye inicios de sesión con Socialite, roles y permisos, sistema de tickets, plantillas de correo electrónico responsivas y mucho más.',
    'create_account' => 'Crear Cuenta',
    'my_profile' => 'Mi Perfil',
];
