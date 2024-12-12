<?php

/**
 * AuthenticateController.php
 *
 * Ushbu fayl foydalanuvchi autentifikatsiyasi (kirish tizimi) uchun mas'ul bo'lgan controllerni o'z ichiga oladi.
 * Foydalanuvchining login va parol ma'lumotlarini tekshirib, sessiya boshlatadi yoki xato xabarlarini qaytaradi.
 * 
 * Xususiyatlari:
 * - CSRF tokenni tekshirish orqali so'rovlarni xavfsiz qilish.
 * - Foydalanuvchi sessiyasini boshqarish.
 * - Kirish tarixini qayd etish (muvaffaqiyatli va muvaffaqiyatsiz urinishlar).
 * - JSON formatda javoblarni qaytarish.
 * 
 * Ushbu controller `BaseController` sinfiga meros qilib olingan va umumiy metodlar bilan birgalikda ishlatiladi.
 * 
 * @package    CodeIgniter Alternative
 * @subpackage Controllers
 * @author     Oyatillo
 * @version    1.0.0
 * @date       2024-12-01
 * 
 * @description
 * 1. `index()` metodi:
 *    - Faqat POST so'rovlarini qabul qiladi.
 *    - Foydalanuvchi ma'lumotlarini (login va parol) tekshiradi.
 *    - Agar autentifikatsiya muvaffaqiyatli bo'lsa, sessiya o'rnatadi va foydalanuvchini tizimga kiritadi.
 *    - CSRF tokenni tekshiradi va xato bo'lsa, javobni JSON ko'rinishida qaytaradi.
 *    - Foydalanuvchi kirish tarixini IP-manzil bilan birgalikda qayd etadi.
 * 2. Xato holatlarda foydalanuvchiga kerakli xabarlarni JSON ko'rinishida qaytaradi.
 * 
 * Maqsad:
 * Foydalanuvchining xavfsiz autentifikatsiyasi va tizimga kirish jarayonini boshqarish.
 */

namespace App\Controllers;

use System\BaseController;
use App\Models\UserModel;
use System\Security\Csrf;

class AuthenticateController extends BaseController {

    public function index() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $username = trim($_POST['username']);
            $password = trim($_POST['password']);
            $token = filter_input(INPUT_POST, 'csrf_frontend', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            header('Content-Type: application/json'); 

            if (!\System\Security\Csrf::verifyToken($_POST['csrf_frontend'])) {
                echo json_encode([
                    'success' => false,
                    'message' => 'So‘rov noto‘g‘ri yoki eskirgan, iltimos sahifani yangilang!'
                ]);
                return;
            }

            $userModel = new UserModel();
            $user = $userModel->checkLogin($username, $password);

            if ($user) {
                session_start();
                $_SESSION['role'] = $user['role'];
                $_SESSION['degree'] = $user['degree'];
                $_SESSION['image_url'] = $user['image_url'];
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['fullname'] = $user['fullname'];

                $ipAddress = $_SERVER['REMOTE_ADDR'];
                $userModel->logLoginHistory($user['user_id'], $user['fullname'], $ipAddress, $user['login'], 'success');

                echo json_encode(['success' => true, 'role' => $user['role'], 'message' => 'Ma‘lumotlaringiz tasdiqlandi!']);
            } else {
                $userId = $userModel->getUserIdByLogin($username);
                if ($userId) {
                    $ipAddress = $_SERVER['REMOTE_ADDR'];
                    $userModel->logLoginHistory($userId, $user['fullname'] ?? 'Noma‘lum foydalanuvchi', $ipAddress, $username, 'failed');
                } 
                echo json_encode(['success' => false, 'message' => 'Noto‘g‘ri login yoki parol!']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Faqat POST so‘rovi qabul qilinadi.']);
        }
    }
}
?>