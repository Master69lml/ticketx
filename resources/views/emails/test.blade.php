<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .email-content {
            background-color: white;
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header {
            border-bottom: 3px solid #007bff;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            color: #007bff;
        }
        .footer {
            border-top: 1px solid #ddd;
            padding-top: 15px;
            margin-top: 20px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="email-content">
            <div class="header">
                <h1>AWS SES Email Configuration Test</h1>
            </div>

            <p>¡Hola!</p>

            <p>Este es un correo de prueba para verificar que la configuración de AWS SES funciona correctamente en tu sistema TicketX.</p>

            <p><strong>Si recibiste este correo, significa que:</strong></p>
            <ul>
                <li>✓ Las credenciales de AWS SES son válidas</li>
                <li>✓ La dirección de correo de envío (no-reply@teo.com.py) está verificada en AWS SES</li>
                <li>✓ La configuración de SMTP está correctamente establecida</li>
                <li>✓ Los correos de tickets y comentarios se enviarán correctamente</li>
            </ul>

            <p>A partir de ahora, todos los correos de apertura de tickets, comentarios y notificaciones se enviarán a través de AWS SES.</p>

            <div class="footer">
                <p>Este es un correo automático. Por favor no respondas a este mensaje.</p>
                <p>Sistema TicketX - Powered by Sportty</p>
            </div>
        </div>
    </div>
</body>
</html>
