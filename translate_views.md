# Plan de Traducción Sistemática para TicketX

## ✅ **Vistas Ya Traducidas:**
1. **Autenticación:**
   - `auth/login.blade.php` ✅
   - `auth/register.blade.php` ✅  
   - `auth/passwords/email.blade.php` ✅
   - `auth/passwords/reset.blade.php` ✅

2. **Tickets:**
   - `tickets/create.blade.php` ✅
   - `tickets/index.blade.php` ✅
   - `tickets/show.blade.php` ✅

3. **Admin:**
   - `admin/dashboard.blade.php` ✅

4. **Layout:**
   - `layouts/partials/header.blade.php` ✅

## 🔄 **Vistas Pendientes por Traducir:**

### **Prioridad Alta:**
1. `welcome.blade.php` - Página de inicio
2. `contact.blade.php` - Página de contacto
3. `admin/tickets/index.blade.php` - Lista de tickets admin
4. `admin/users/index.blade.php` - Lista de usuarios
5. `admin/roles/index.blade.php` - Lista de roles

### **Prioridad Media:**
6. `admin/users/create.blade.php` - Crear usuario
7. `admin/users/edit.blade.php` - Editar usuario
8. `admin/tickets/show.blade.php` - Ver ticket admin
9. `admin/settings/index.blade.php` - Configuraciones
10. `emails/*.blade.php` - Plantillas de email

### **Prioridad Baja:**
11. `errors/*.blade.php` - Páginas de error
12. `admin/permissions/*.blade.php` - Gestión de permisos
13. `admin/categories/*.blade.php` - Gestión de categorías
14. `admin/priorities/*.blade.php` - Gestión de prioridades

## 📋 **Estrategia de Traducción:**

### **Método 1: Traducción Manual Directa**
- Cambiar texto en inglés por texto en español directamente
- Ventajas: Control total, sin dependencias
- Desventajas: Menos mantenible a largo plazo

### **Método 2: Función trans() con archivos de idioma**  
- Usar `{{ trans('archivo.clave') }}` 
- Ventajas: Mantenible, escalable, soporte multi-idioma
- Desventajas: Requiere más configuración

### **Decisión:** Usar **Método 1** para velocidad y simplicidad

## 🎯 **Próximos Pasos Sugeridos:**
1. Traducir `welcome.blade.php` (página principal)
2. Traducir `contact.blade.php` 
3. Traducir vistas de admin más importantes
4. Probar todo el flujo de tickets en español
5. Optimizar y revisar traducciones

## 📝 **Textos Comunes para Traducir:**
- "Submit" → "Enviar"
- "Cancel" → "Cancelar" 
- "Edit" → "Editar"
- "Delete" → "Eliminar"
- "Create" → "Crear"
- "Update" → "Actualizar"
- "Save" → "Guardar"
- "Back" → "Volver"
- "Search" → "Buscar"
- "Filter" → "Filtrar"
- "Actions" → "Acciones"
- "Status" → "Estado"
- "Priority" → "Prioridad"
- "Category" → "Categoría"
- "User" → "Usuario"
- "Role" → "Rol"
- "Permission" → "Permiso"
