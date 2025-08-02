<?php
// Укажи свой e-mail
$to = 'contacto@vehimovil.com';

// Получаем данные из формы
$nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
$placas = isset($_POST['placas']) ? trim($_POST['placas']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$telefono = isset($_POST['telefono']) ? trim($_POST['telefono']) : '';
$comentarios = isset($_POST['comentarios']) ? trim($_POST['comentarios']) : '';

// Простая проверка, что обязательные поля заполнены
if ($nombre && $placas && $email) {
    // Заголовки письма
    $subject = "Nueva solicitud de revisión de multas - Vehimovil";
    $headers = "From: Vehimovil <noreply@vehimovil.com>\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Текст письма
    $body = "Nueva solicitud de revisión de multas recibida:\n\n";
    $body .= "Nombre: $nombre\n";
    $body .= "Placas: $placas\n";
    $body .= "Email: $email\n";
    $body .= "Teléfono: " . ($telefono ?: 'No proporcionado') . "\n";
    $body .= "Comentarios: " . ($comentarios ?: 'Sin comentarios adicionales') . "\n";
    $body .= "Servicio: Revisión de Multas\n";
    $body .= "Fecha: " . date('d/m/Y H:i:s') . "\n\n";
    $body .= "Este es un servicio informativo privado. No se realizan gestiones oficiales.\n\n";
    $body .= "---\n";
    $body .= "Enviado desde el formulario de Vehimovil\n";

    // Отправка письма
    if (mail($to, $subject, $body, $headers)) {
        echo "success";
    } else {
        echo "error";
    }
} else {
    echo "error";
}
?> 