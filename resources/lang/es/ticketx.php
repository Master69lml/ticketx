<?php

return [
    // Navegación
    'navigation' => [
        'home' => 'Inicio',
        'dashboard' => 'Panel de Control',
        'tickets' => 'Tickets',
        'users' => 'Usuarios',
        'roles' => 'Roles',
        'permissions' => 'Permisos',
        'settings' => 'Configuraciones',
        'profile' => 'Perfil',
        'logout' => 'Cerrar Sesión',
        'login' => 'Iniciar Sesión',
        'register' => 'Registrarse',
    ],
    
    // Tickets
    'tickets' => [
        'title' => 'Tickets',
        'create' => 'Crear Ticket',
        'new_ticket' => 'Nuevo Ticket',
        'open_tickets' => 'Tickets Abiertos',
        'closed_tickets' => 'Tickets Cerrados',
        'my_tickets' => 'Mis Tickets',
        'all_tickets' => 'Todos los Tickets',
        'subject' => 'Asunto',
        'description' => 'Descripción',
        'priority' => 'Prioridad',
        'category' => 'Categoría',
        'status' => 'Estado',
        'created_at' => 'Creado en',
        'updated_at' => 'Actualizado en',
        'assigned_to' => 'Asignado a',
        'comments' => 'Comentarios',
        'add_comment' => 'Agregar Comentario',
        'close_ticket' => 'Cerrar Ticket',
        'reopen_ticket' => 'Reabrir Ticket',
    ],
    
    // Estados
    'status' => [
        'open' => 'Abierto',
        'in_progress' => 'En Progreso',
        'closed' => 'Cerrado',
        'reopened' => 'Reabierto',
    ],
    
    // Prioridades
    'priority' => [
        'low' => 'Baja',
        'normal' => 'Normal',
        'high' => 'Alta',
        'critical' => 'Crítica',
    ],
    
    // Usuarios
    'users' => [
        'title' => 'Usuarios',
        'create' => 'Crear Usuario',
        'edit' => 'Editar Usuario',
        'name' => 'Nombre',
        'email' => 'Correo Electrónico',
        'password' => 'Contraseña',
        'confirm_password' => 'Confirmar Contraseña',
        'role' => 'Rol',
        'avatar' => 'Avatar',
        'profile' => 'Perfil',
    ],
    
    // Formularios
    'forms' => [
        'save' => 'Guardar',
        'cancel' => 'Cancelar',
        'edit' => 'Editar',
        'delete' => 'Eliminar',
        'create' => 'Crear',
        'update' => 'Actualizar',
        'submit' => 'Enviar',
        'search' => 'Buscar',
        'filter' => 'Filtrar',
        'reset' => 'Restablecer',
    ],
    
    // Mensajes
    'messages' => [
        'success' => [
            'created' => 'Creado exitosamente.',
            'updated' => 'Actualizado exitosamente.',
            'deleted' => 'Eliminado exitosamente.',
            'saved' => 'Guardado exitosamente.',
        ],
        'error' => [
            'not_found' => 'No encontrado.',
            'unauthorized' => 'No autorizado.',
            'validation_failed' => 'Error de validación.',
            'something_went_wrong' => 'Algo salió mal.',
        ],
    ],
    
    // Páginas generales
    'welcome' => [
        'title' => 'Bienvenido a :name',
        'description' => ':name es un sistema de tickets de soporte de código abierto. Está construido con el increíble Framework Laravel. Incluye inicios de sesión con Socialite, roles y permisos, sistema de tickets, plantillas de correo responsivas y mucho más.',
        'create_account' => 'Crear Cuenta',
        'my_profile' => 'Mi Perfil',
    ],
    
    // Autenticación
    'auth' => [
        'login_title' => 'Iniciar Sesión',
        'register_title' => 'Registrarse',
        'forgot_password' => '¿Olvidaste tu contraseña?',
        'remember_me' => 'Recordarme',
        'sign_in' => 'Iniciar Sesión',
        'sign_up' => 'Registrarse',
        'sign_in_message' => 'Inicia sesión para comenzar tu sesión',
        'sign_up_message' => 'Regístrate para crear una nueva cuenta',
        'reset_password' => 'Restablecer Contraseña',
        'send_reset_link' => 'Enviar Enlace de Restablecimiento',
    ],
];
