<?php

/**
 * ChatModel.php
 *
 * Ushbu fayl foydalanuvchilar o'rtasidagi chat funksiyalarini boshqaruvchi modelni o'z ichiga oladi.
 * Model ma'lumotlar bazasi bilan ishlash uchun mas'ul bo'lib, quyidagi asosiy vazifalarni bajaradi:
 * 
 * - Admin ID sini aniqlash.
 * - Foydalanuvchiga tegishli chatlarni olish va xabarlarni o'qilgan holatga o'tkazish.
 * - Yangi chat xabarlarini saqlash.
 * - Foydalanuvchi xabarlarini o'chirish.
 * - Xatolarni log qilish orqali kuzatib borish.
 * 
 * Ushbu model `System\Database` orqali ma'lumotlar bazasi bilan ishlaydi va PDO dan foydalanadi.
 * 
 * @package    CodeIgniter Alternative
 * @subpackage Models
 * @author     Oyatillo
 * @version    1.0.0
 * @date       2024-12-01
 * 
 * @description
 * 1. **Admin ID aniqlash**:
 *    - Adminning `user_id` sini ma'lumotlar bazasidan topadi.
 *    - Admin roli va `degree` maydonlarini tekshirish orqali natijani qaytaradi.
 * 
 * 2. **Chatlarni olish**:
 *    - Foydalanuvchiga tegishli barcha chatlarni `chats` jadvalidan oladi.
 *    - O'qilmagan xabarlarni avtomatik ravishda `is_read` maydonini yangilash orqali o'qilgan holatga o'tkazadi.
 *    - Xabarlarni tartiblangan holda qaytaradi (eng so'nggi xabarlardan boshlab).
 * 
 * 3. **Yangi chatni saqlash**:
 *    - Yangi xabarni `chats` jadvaliga qo'shadi.
 *    - Xabarni foydalanuvchi, qabul qiluvchi va yaratilgan vaqti bilan birga saqlaydi.
 * 
 * 4. **Xabarlarni o'chirish**:
 *    - Foydalanuvchi o'zi yuborgan xabarlarni o'chirishi mumkin.
 *    - Xabar `id` va foydalanuvchi `user_id` qiymatlari asosida o'chiriladi.
 * 
 * 5. **Xatolarni log qilish**:
 *    - Har qanday xato yuz berganda, uni `writable/logs` papkasiga saqlaydi.
 *    - Log fayllar kunlik formatda yoziladi (`error_Y-m-d.log`).
 *    - Xatolarni kuzatish va tuzatish uchun vaqt va xato haqida ma'lumot beradi.
 * 
 * Ushbu model chat tizimini boshqarish va ma'lumotlarni xavfsiz ishlatish uchun mo'ljallangan.
 */

namespace App\Models;

use System\Database;
use System\BaseModel;
use PDO;

class ChatModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    /**
     * Admin ID sini olish
     */

    public function getAdminId()
    {
        try {
            $sql = "
                SELECT user_id
                FROM users
                WHERE role = 'admin' AND degree = 'Administrator' 
                LIMIT 1
            ";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC)['user_id'] ?? null;
        } catch (\Exception $e) {
            $this->logError($e->getMessage());
            return null;
        }
    }

    public function getUsers()
{
    try {
        $sql = "SELECT id, user_id, image_url, degree, fullname FROM users WHERE role = 'user'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (\Exception $e) {
        $this->logError($e->getMessage());
        return [];
    }
}
    
    /**
     * Foydalanuvchiga tegishli barcha chatlarni olish
     */

    public function fetchChats($userId)
        {
            try {
                $updateSql = "
                    UPDATE chats 
                    SET is_read = 1
                    WHERE (user_id = :user_id OR message_for_user_id = :user_id)
                      AND is_read = 0;
                ";
                $updateStmt = $this->db->prepare($updateSql);
                $updateStmt->bindValue(':user_id', $userId, PDO::PARAM_STR);
                $updateStmt->execute();

                $sql = "
                    SELECT 
                        c.id, c.user_id, c.message, c.message_for_user_id, c.is_read, c.created_at, 
                        u.fullname, u.user_id AS sender_id, u.role, u.image_url AS user_image
                    FROM chats c
                    LEFT JOIN users u ON c.user_id = u.user_id COLLATE utf8mb4_unicode_ci
                    WHERE c.user_id = :user_id OR c.message_for_user_id = :user_id COLLATE utf8mb4_unicode_ci
                    ORDER BY c.created_at DESC
                    LIMIT 50;
                ";
                $stmt = $this->db->prepare($sql);
                $stmt->bindValue(':user_id', $userId, PDO::PARAM_STR);
                $stmt->execute();
                
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (\Exception $e) {
                $this->logError($e->getMessage());
                return [];
            }
        }

        public function fetchsChat($userId)
        {
            try {
                $sql = "
                    SELECT 
                        c.id, c.user_id, c.message, c.message_for_user_id, c.is_read, c.created_at, 
                        u.fullname, u.user_id AS sender_id, u.role, u.image_url AS user_image
                    FROM chats c
                    LEFT JOIN users u ON c.user_id = u.user_id COLLATE utf8mb4_unicode_ci
                    WHERE c.user_id = :user_id OR c.message_for_user_id = :user_id COLLATE utf8mb4_unicode_ci
                    ORDER BY c.created_at DESC
                    LIMIT 50;
                ";
                $stmt = $this->db->prepare($sql);
                $stmt->bindValue(':user_id', $userId, PDO::PARAM_STR);
                $stmt->execute();
                
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (\Exception $e) {
                $this->logError($e->getMessage());
                return [];
            }
        }

    /**
     * Chatni saqlash
     */

    public function saveChat($userId, $message, $messageForUserId)
    {
    try {
        // $message = $this->db->quote($message); 
        $sql = "
            INSERT INTO chats (user_id, message, message_for_user_id, is_read, created_at)
            VALUES (:user_id, :message, :message_for_user_id, 0, NOW())
        ";
        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(':user_id', $userId, PDO::PARAM_STR);
        $stmt->bindValue(':message', $message, PDO::PARAM_STR);
        $stmt->bindValue(':message_for_user_id', $messageForUserId, PDO::PARAM_STR);

        $stmt->execute();
    } catch (\Exception $e) {
        $this->logError($e->getMessage());
        }
    }

    /**
     * Xabarni o‘chirish
     */
    
    public function deleteMessage($id, $userId)
    {
        try {
            $sql = "DELETE FROM chats WHERE id = :id AND user_id = :user_id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_STR);
            return $stmt->execute();
        } catch (\Exception $e) {
            $this->logError($e->getMessage());
            return false;
        }
    }
    
    /**
     * Xatolarni log qilish
     */

    private function logError($message)
    {
        $logDir = __DIR__ . '/../../writable/logs';
        date_default_timezone_set("Asia/Tashkent");
        if (!is_dir($logDir)) {
            mkdir($logDir, 0777, true);
        }
        
        $logFile = $logDir . '/error_' . date('Y-m-d') . '.log';
        $dateTime = date('Y-m-d H:i:s');
        $logMessage = "[{$dateTime}] ERROR: {$message}\n";
        
        file_put_contents($logFile, $logMessage, FILE_APPEND);
    }
}
?>