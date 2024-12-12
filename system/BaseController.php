<?php

/**
 * BaseController.php
 *
 * Ushbu fayl asosiy kontroller sinfini taqdim etadi, u orqali boshqa kontrollerlar yaratish uchun
 * umumiy funksiyalar va asosiy imkoniyatlar taqdim etiladi.
 *
 * @package    CodeIgniter Alternative
 * @subpackage System
 * @version    1.0.0
 * @date       2024-12-01
 * 
 * @description
 * Ushbu sinf quyidagi asosiy funksiyalarni bajaradi:
 *
 * 1. **Session boshqaruvi**:
 *    - Sinf ishga tushganda sessiyani avtomatik boshlaydi.
 * 
 * 2. **Yo'naltirish (Redirect)**:
 *    - `to($url)` - foydalanuvchini berilgan URL manziliga yo'naltiradi.
 *    - `base_url($path)` - saytning asosiy URL manziliga nisbiy yo'lni birlashtiradi.
 * 
 * 3. **Xabarlarni filtr qilish**:
 *    - `filterMessage($message)` - foydalanuvchi kiritgan ma'lumotlarni xavfsiz qilish uchun maxsus belgilarni olib tashlaydi.
 *
 * 4. **Log qilish**:
 *    - `logError($message)` - tizimda yuz bergan xatolarni kunlik log fayllarida saqlaydi.
 *
 * 5. **Ko'rinishni (View) yuklash**:
 *    - `view($view, $data)` - berilgan ko'rinish faylini yuklaydi va unga ma'lumotlarni uzatadi.
 *    - Agar ko'rinish fayli topilmasa, 500 xatolik sahifasini ko'rsatadi.
 *
 * 6. **Xatoliklarni ko'rsatish**:
 *    - `showError($title, $message)` - foydalanuvchi uchun chiroyli xatolik sahifasini ko'rsatadi.
 *    - `show404()` - 404 xatolik (sahifa topilmadi) sahifasini qaytaradi.
 *    - `show500($message)` - 500 xatolik (ichki server xatosi) sahifasini qaytaradi.
 *
 * 7. **Noyob foydalanuvchi identifikatori yaratish**:
 *    - `generateUserId()` - har bir foydalanuvchi uchun noyob va tasodifiy ID generatsiya qiladi.
 *
 * @class BaseController
 * 
 * @methods
 * - `__construct()`: Sinfni ishga tushirish va sessiyani boshlash.
 * - `to($url)`: Foydalanuvchini boshqa URL manzilga yo'naltirish.
 * - `redirect()`: Yo'naltirish uchun tayyor obyektni qaytarish (chainable redirect).
 * - `base_url($path)`: Saytning asosiy URLiga nisbatan yo'l hosil qilish.
 * - `filterMessage($message)`: Kiritilgan ma'lumotni xavfsiz shaklga keltirish.
 * - `logError($message)`: Tizimdagi xatoliklarni log fayliga yozish.
 * - `view($view, $data)`: Ko'rinish faylini yuklash va ma'lumot uzatish.
 * - `showError($title, $message)`: Foydalanuvchi uchun xatolik sahifasini ko'rsatish.
 * - `show404()`: 404 xatolik sahifasini ko'rsatish.
 * - `show500($message)`: 500 xatolik sahifasini ko'rsatish.
 * - `generateUserId()`: Noyob foydalanuvchi ID generatsiya qilish.
 *
 * @properties
 * - `logError()`: Xatoliklarni yozish uchun loglash funksiyasi.
 *
 * Ushbu sinf MVC frameworkingizda barcha kontrollerlar uchun asosiy bo'lib xizmat qiladi.
 */

namespace System;

require_once 'vendor/autoload.php';

class BaseController
{
    public function __construct()
    {
        session_start();
    }

    public function to($url)
    {
        header("Location: $url");
        exit();
    }

    public function redirect()
    {
        return $this; 
    }

    public function base_url($path = '')
    {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
        
        return $protocol . '://' . $_SERVER['HTTP_HOST'] . '/' . ltrim($path, '/');
    }

    public function filterMessage($message)
    {
        $pattern = '/[\"<>\/*\&\%\$\#\(\)\[\]\{\}]/';

        $cleanedMessage = preg_replace($pattern, '', $message);

        $cleanedMessage = str_replace(["'", '`'], "‘", $cleanedMessage);

        if ($cleanedMessage !== $message) {
            return $cleanedMessage;
        }

        return $message;
    }

    protected function logError($message)
    {
        $logDir = __DIR__ . '/../writable/logs';
        date_default_timezone_set("Asia/Tashkent");
        if (!is_dir($logDir)) {
            mkdir($logDir, 0777, true);
        }
        
        $logFile = $logDir . '/error_' . date('Y-m-d') . '.log';
        $dateTime = date('Y-m-d H:i:s');
        $logMessage = "[{$dateTime}] ERROR: {$message}\n";
        
        file_put_contents($logFile, $logMessage, FILE_APPEND);
    }

    protected function view($view, $data = [])
    {
        try {
            extract($data);
            $viewFile = "app/Views/{$view}.php";
            if (file_exists($viewFile)) {
                require_once $viewFile;
            } else {
                throw new \Exception("View file \"{$view}.php\" not found.");
            }
        } catch (\Exception $e) {
            $this->logError($e->getMessage()); 
            $this->showError("500 Internal Server Error", $e->getMessage());
        }
    }

    private function showError($title, $message)
    {
        echo "
        <!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>{$title}</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f4f4f4;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                    margin: 0;
                    color: #333;
                }
                .error-container {
                    background-color: #fff;
                    padding: 20px;
                    border-radius: 8px;
                    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                    text-align: center;
                    max-width: 600px;
                    width: 100%;
                }
                .error-container h1 {
                    font-size: 48px;
                    color: #e74c3c;
                    margin-bottom: 20px;
                }
                .error-container p {
                    font-size: 18px;
                    color: #555;
                }
                .error-container a {
                    text-decoration: none;
                    color: #3498db;
                    font-weight: bold;
                    margin-top: 20px;
                    display: inline-block;
                }
                .error-container a:hover {
                    text-decoration: underline;
                }
            </style>
        </head>
        <body>
            <div class='error-container'>
                <h1>{$title}</h1>
                <p>{$message}</p>
                <a href='/'>Go back to homepage</a>
            </div>
        </body>
        </html>
        ";
    }

    public function show404()
    {
        header("HTTP/1.1 404 Not Found");
        $this->logError("404 Not Found - The page you are looking for could not be found.");
        $this->view('errors/404');
    }

    public function show500($message)
    {
        header('HTTP/1.1 503 Service Temporarily Unavailable');
        $this->logError("500 Internal Server Error - {$message}");
        $this->showError("500 Internal Server Error", $message);
    }

    /**
     * Noyob user_id generatsiya qilish.
     * 
     * Har bir foydalanuvchi uchun noyob va tasodifiy ID yaratadi.
     * 
     * @return string
     */
    protected function generateUserId()
    {
        return uniqid('USER-');
    }

}
?>