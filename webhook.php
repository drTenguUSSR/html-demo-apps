<?php
/**
Как это запустить:Замените 'ВАШ_СЕКРЕТНЫЙ_КЛЮЧ_ИЗ_НАСТРОЕК_GITHUB' на строку,
 * которую вы ввели в поле Secret на GitHub.В переменной REPO_DIR укажите
 * правильный абсолютный путь к папке вашего сайта (его можно подсмотреть
 * в панели cPanel/Plesk в менеджере файлов).Замените main в команде
 * git pull origin main, если ваша ветка называется master.Залейте
 * этот файл в корень сайта на HelioHost, чтобы он был доступен по адресу https://yourdomain.com, и укажите этот URL на GitHub.
 */


// 1. НАСТРОЙКИ СЕКРЕТНОСТИ И ПУТЕЙ
define('GITHUB_SECRET', 'ВАШ_СЕКРЕТНЫЙ_КЛЮЧ_ИЗ_НАСТРОЕК_GITHUB');
define('REPO_DIR', '/home/ваш_логин/public_html'); // Полный путь к папке сайта на сервере

// 2. ПРОВЕРКА БЕЗОПАСНОСТИ (ХУК ОТ GITHUB)
$signature = $_SERVER['HTTP_X_HUB_SIGNATURE_256'] ?? '';

if (empty($signature)) {
    http_response_code(403);
    die('No signature header provided.');
}

// Получаем сырые данные запроса
$payload = file_get_contents('php://input');

// Вычисляем ожидаемую подпись
$expected_signature = 'sha256=' . hash_hmac('sha256', $payload, GITHUB_SECRET);

// Сравниваем подписи для защиты от посторонних запросов
if (!hash_equals($expected_signature, $signature)) {
    http_response_code(403);
    die('Invalid secret signature.');
}

// 3. ВЫПОЛНЕНИЕ ДЕПЛОЯ (ОБНОВЛЕНИЕ КОДА)
// Переходим в папку репозитория и выполняем pull
chdir(REPO_DIR);

// Выполняем команду git pull и записываем результат в логи
$output = [];
$return_var = 0;
exec('git pull origin main 2>&1', $output, $return_var);

// 4. ОТВЕТ И ЛОГИРОВАНИЕ
if ($return_var === 0) {
    http_response_code(200);
    echo "Deployment successful:\n" . implode("\n", $output);
} else {
    http_response_code(500);
    echo "Deployment failed (Error code $return_var):\n" . implode("\n", $output);
}
