<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// Получаем данные из формы
$nombre = $_POST['nombre'] ?? '';
$placas = $_POST['placas'] ?? '';
$email = $_POST['email'] ?? '';
$telefono = $_POST['telefono'] ?? '';
$comentarios = $_POST['comentarios'] ?? '';

// Проверяем обязательные поля
if (empty($nombre) || empty($placas) || empty($email)) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing required fields']);
    exit;
}

// Формируем тему письма
$subject = 'Nueva solicitud de revisión de multas - Vehimovil';

// Формируем тело письма
$message = "
Nueva solicitud de revisión de multas recibida:

Nombre: {$nombre}
Placas: {$placas}
Email: {$email}
Teléfono: " . ($telefono ? $telefono : 'No proporcionado') . "
Comentarios: " . ($comentarios ? $comentarios : 'Sin comentarios adicionales') . "
Servicio: Revisión de Multas
Fecha: " . date('Y-m-d H:i:s') . "

Este es un servicio informativo privado. No se realizan gestiones oficiales.
";

// Заголовки для email
$headers = array(
    'From: noreply@vehimovil.com',
    'Reply-To: ' . $email,
    'Content-Type: text/plain; charset=UTF-8',
    'X-Mailer: PHP/' . phpversion()
);

// Отправляем email
$to = 'shandomarco925@gmail.com';
$mail_sent = mail($to, $subject, $message, implode("\r\n", $headers));

if ($mail_sent) {
    echo json_encode(['success' => true, 'message' => 'Email sent successfully']);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to send email']);
}
?> 