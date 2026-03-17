<?php
/**
 * Script para procesar trabajos de la cola manualmente
 * Ejecutar con: php process-queue.php
 */

require __DIR__ . '/bootstrap/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';

$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

$jobs = \DB::table('jobs')->get();

echo "Procesando " . count($jobs) . " trabajos pendientes...\n";

foreach ($jobs as $job) {
    try {
        $payload = json_decode($job->payload, true);
        
        // Obtener el comando serializado
        $command = unserialize(base64_decode($payload['data']['command']));
        
        // Ejecutar el comando
        app('Illuminate\Contracts\Bus\Dispatcher')->dispatchNow($command);
        
        // Eliminar del jobs table
        \DB::table('jobs')->where('id', $job->id)->delete();
        
        echo "[✓] Trabajo #" . $job->id . " procesado exitosamente\n";
    } catch (\Exception $e) {
        echo "[✗] Error procesando trabajo #" . $job->id . ": " . $e->getMessage() . "\n";
    }
}

echo "Proceso completado.\n";
