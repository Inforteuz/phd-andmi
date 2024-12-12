<?php

/**
 * BaseModel.php
 *
 * Ushbu fayl Custom MVC frameworkingiz uchun asosiy model sinfini taqdim etadi.
 * Ushbu sinf orqali barcha boshqa modellarga umumiy funksionallarni taqdim etish mumkin.
 *
 * @package    CodeIgniter Alternative
 * @subpackage System
 * @version    1.0.1
 * @date       2024-12-02
 *
 * @description
 * Ushbu sinf quyidagi asosiy funksiyalarni ta'minlaydi:
 *
 * 1. **Ma'lumotlar bazasi bilan bog'lanish**:
 *    - `__construct()` orqali Database obyektini ishga tushiradi.
 *    - Ushbu obyekt ma'lumotlar bazasi bilan oson ishlash uchun foydalaniladi.
 *
 * 2. **So'rovlar bajarish (Query Execution)**:
 *    - `query($sql, $params)` - SQL so'rovlari va parametrlar orqali ma'lumotlar bazasiga murojaat qiladi
 *      va natijani qaytaradi.
 *
 * 3. **Log qilish**:
 *    - `logError($message)` - ma'lumotlar bazasi yoki boshqa xatoliklarni log fayliga yozish imkonini beradi.
 *
 * 4. **Jadval yaratish**:
 *    - `createTableIfNotExists($tableName, $schema)` - Jadval mavjud bo'lmasa, uni yaratadi.
 *
 * @class BaseModel
 *
 * @methods
 * - `__construct()`: Sinf obyektini ishga tushirish va ma'lumotlar bazasi ulanishini o'rnatish.
 * - `query($sql, $params)`: Ma'lumotlar bazasiga SQL so'rovini yuborish va natijalarni olish.
 * - `logError($message)`: Xatoliklarni loglash uchun maxsus funksiya.
 * - `createTableIfNotExists($tableName, $schema)`: Jadvalni yaratish.
 *
 * @properties
 * - `$db`: Database sinfidan obyekt, ma'lumotlar bazasi bilan o'zaro ishlash uchun ishlatiladi.
 *
 * @example
 * ```php
 * class UserModel extends BaseModel
 * {
 *     public function getAllUsers()
 *     {
 *         $sql = "SELECT * FROM users";
 *         return $this->query($sql);
 *     }
 * }
 * ```
 */

namespace System;

class BaseModel
{
    protected $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    /**
     * Prepare an SQL statement
     *
     * @param string $sql
     * @param array $params
     * @return PDOStatement
     */
    public function prepare($sql, $params = [])
    {
        try {
            return $this->db->getConnection()->prepare($sql);
        } catch (\PDOException $e) {
            $this->logError("Query failed: " . $e->getMessage());
            throw new \Exception("So'rov bajarishda xatolik yuz berdi.");
        }
    }
    /**
     * Insert data into a table.
     *
     * @param string $table
     * @param array $data
     * @return bool
     */
    public function insert($table, $data)
    {
        $columns = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));

        $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";

        $stmt = $this->prepare($sql, $data);

        try {
            return $stmt->execute($data);
        } catch (\PDOException $e) {
            $this->logError("Insert failed: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Execute the query and return the results.
     *
     * @param string $sql
     * @param array $params
     * @return array
     */
    protected function query($sql, $params = [])
    {
        date_default_timezone_set("Asia/Tashkent");
        try {
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            $this->logError("Query failed: " . $e->getMessage(), $sql);
            throw new \Exception("So'rov bajarishda xatolik yuz berdi.");
        }
    }

    /**
     * Log errors into the log file.
     *
     * @param string $message
     * @param string|null $sql
     */
    protected function logError($message, $sql = null)
    {
        $logDir = __DIR__ . "/../writable/logs";
        date_default_timezone_set("Asia/Tashkent");

        if (!is_dir($logDir)) {
            mkdir($logDir, 0777, true);
        }

        $logFile = $logDir . "/error_" . date("Y-m-d") . ".log";
        $dateTime = date("Y-m-d H:i:s");
        $logMessage = "[{$dateTime}] ERROR: {$message}";

        if ($sql) {
            $logMessage .= " | SQL: {$sql}";
        }

        $logMessage .= "\n";

        file_put_contents($logFile, $logMessage, FILE_APPEND);
    }

    /**
     * Create table if not exists.
     *
     * @param string $tableName
     * @param string $schema
     */
    protected function createTableIfNotExists($tableName, $schema)
    {
        try {
            $createTableSQL = "CREATE TABLE IF NOT EXISTS {$tableName} ({$schema}) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

            $this->query($createTableSQL);
        } catch (Exception $e) {
            $this->logError("Jadvalni yaratishda xatolik: {$e->getMessage()}");
        }
    }

    /**
     * createUser
     *
     * This function inserts the default super admin user into the "users" table.
     * User information is predetermined and the password is stored as hashed.
     */
    public function createUser()
    {
    $data = [
        "user_id" => "USER-67485ced924fb",
        "fullname" => "Super Admin",
        "middlename" => "XXX",
        "login" => "admin",
        "password" =>
            '$2y$10$pXh1xJb6XISaC94yYHtcauQ12Mp0MZOOV71bvmz/jBKU6kTfhpluW', //admin123 (hashlangan)
        "gender" => "Erkak",
        "passportSeries" => "AC1475293",
        "pnifl" => "36556247564",
        "speciality_name" => "Dasturchi",
        "speciality_number" => "777",
        "degree" => "Administrator",
        "image_url" => "assets/uploads/USER-67485ced924fb/admin.jpg",
        "role" => "admin",
        "status" => "active",
        "created_at" => "2004-04-07 00:00:00",
    ];

    $sql = "SELECT COUNT(*) FROM users WHERE login = :login";
    $stmt = $this->prepare($sql);
    $stmt->bindParam(':login', $data['login']);
    $stmt->execute();
    $userExists = $stmt->fetchColumn();

    if ($userExists > 0) {
        return false; 
    }

    $this->insert("users", $data);
    return true;
    }
}

?>