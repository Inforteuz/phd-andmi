<?php

/**
 * UserModel.php
 *
 * Ushbu fayl foydalanuvchi bilan bog'liq barcha ma'lumotlarni saqlash va olish uchun ishlatiladigan modelni o'z ichiga oladi.
 * Bu model foydalanuvchi ma'lumotlarini ma'lumotlar bazasiga kiritish, yangilash, o'chirish va o'qish operatsiyalarini bajaradi.
 * 
 * @package    CodeIgniter Alternative
 * @subpackage Models
 * @author     Oyatillo
 * @version    1.0.0
 * @date       2024-12-01
 * 
 * @description
 * Ushbu model quyidagi funksiyalarni bajaradi:
 * 1. `checkLogin($login, $password)` - Foydalanuvchining login va paroliga asoslangan tizimga kirish tekshiruvini amalga oshiradi.
 * 2. `saveFaoliyatData($data)` - Foydalanuvchining faoliyat ma'lumotlarini saqlash uchun ishlatiladi.
 * 3. `saveMundarijaData($data)` - Foydalanuvchining mundarija ma'lumotlarini saqlash uchun ishlatiladi.
 * 4. `getMundarijaData($user_id)` - Foydalanuvchining mundarija ma'lumotlarini bazadan olish uchun ishlatiladi.
 * 
 * Ushbu model `BaseModel` sinfiga meros qilib olingan va ma'lumotlar bazasi bilan ishlash uchun ishlatiladigan metodlar bilan ta'minlangan.
 * 
 * **Izohlar:**
 * - `checkLogin` metodida foydalanuvchi loginini va parolini tekshiradi, agar u faol bo'lsa, foydalanuvchi ma'lumotlarini qaytaradi.
 * - `saveFaoliyatData` va `saveMundarijaData` metodlari foydalanuvchidan kelgan ma'lumotlarni ma'lumotlar bazasiga saqlash uchun ishlatiladi.
 * - `getMundarijaData` metodida foydalanuvchining mundarija ma'lumotlarini bazadan olish jarayoni amalga oshiriladi.
 */

namespace App\Models;

use System\Database;
use System\BaseModel;
use PDO;

class UserModel extends BaseModel
{
    protected $db;

    /**
     * Konstruktor
     * 
     * Database ulanishini o'rnatadi va vaqt zonasini sozlaydi.
     */
    public function __construct()
    {
        $this->db = new Database();
    }

    public function createUserTable()
    {
        $usersTableSchema = "
            id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            user_id VARCHAR(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            fullname VARCHAR(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            middlename VARCHAR(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
            login VARCHAR(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            password VARCHAR(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            gender VARCHAR(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            passportSeries VARCHAR(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
            pnifl VARCHAR(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
            speciality_name VARCHAR(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
            speciality_number VARCHAR(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
            degree VARCHAR(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
            image_url VARCHAR(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            role VARCHAR(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            status ENUM('active', 'inactive') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            created_at DATETIME DEFAULT NULL
        ";

        $this->createTableIfNotExists('users', $usersTableSchema);
    }

    public function createChatsTable()
    {
        $chatTableSchema = "
            id INT(11) AUTO_INCREMENT PRIMARY KEY,
            user_id VARCHAR(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
            message TEXT COLLATE utf8mb4_general_ci DEFAULT NULL,
            message_for_user_id VARCHAR(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
            is_read TINYINT(1) NOT NULL DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ";

        $this->createTableIfNotExists('chats', $chatTableSchema);
    }

    public function createLoginHistoryTable()
    {
        $loginHistoryTableSchema = "
            id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            user_id VARCHAR(30) COLLATE utf8mb4_unicode_ci NOT NULL,
            fullname VARCHAR(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            ip_address VARCHAR(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            login VARCHAR(30) COLLATE utf8mb4_unicode_ci NOT NULL,
            status VARCHAR(50) COLLATE utf8mb4_unicode_ci NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ";

        $this->createTableIfNotExists('login_history', $loginHistoryTableSchema);
    }

    public function createFaoliyatTable()
    {
        $faoliyatTableSchema = "
            id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            user_id VARCHAR(30) COLLATE utf8mb4_unicode_ci NOT NULL,
            fio VARCHAR(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            gender VARCHAR(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            birthplace VARCHAR(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            birthdate DATE DEFAULT NULL,
            residence VARCHAR(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            residenceStatus VARCHAR(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            passportNumber VARCHAR(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            pnifl VARCHAR(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            currentJob VARCHAR(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            position VARCHAR(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            bachelor VARCHAR(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            bachelorDiploma VARCHAR(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            bachelorDate DATE DEFAULT NULL,
            master VARCHAR(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            masterDiploma VARCHAR(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            masterDate DATE DEFAULT NULL,
            doctorateSpecialty VARCHAR(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            directionName VARCHAR(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            dissertationTopic TEXT COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            supervisorFio VARCHAR(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            supervisorWorkplace VARCHAR(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            supervisorDegree VARCHAR(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            supervisorTitle VARCHAR(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            admissionYear YEAR(4) DEFAULT NULL,
            stage VARCHAR(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            educationType VARCHAR(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            orderNumber VARCHAR(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            theoreticalProgramText TEXT COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            theoreticalProgramFile VARCHAR(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            individualPlanText TEXT COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            individualPlanFile VARCHAR(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            participationInCompetitions TEXT COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            academicFile VARCHAR(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            organizationSent VARCHAR(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            organizationReceived VARCHAR(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            country VARCHAR(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            startDate DATE DEFAULT NULL,
            endDate DATE DEFAULT NULL,
            fileUpload VARCHAR(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ";

        $this->createTableIfNotExists('faoliyat', $faoliyatTableSchema);
    }

    public function createMaqolaTable()
    {
        $articlesTableSchema = "
            id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            user_id VARCHAR(30) COLLATE utf8mb4_unicode_ci NOT NULL,
            journalType VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
            publishCountry VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
            journalName VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
            articleTitle VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
            publishDate DATE NOT NULL,
            articleLink VARCHAR(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            authorCount INT(1) NOT NULL,
            authors TEXT COLLATE utf8mb4_unicode_ci NOT NULL,
            articleFile VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
            status VARCHAR(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            is_rejected TINYINT(1) DEFAULT 0,
            rejected_text TEXT COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ";

        $this->createTableIfNotExists('maqola', $articlesTableSchema);
    }

    public function createMundarijaTable()
    {
        $curriculumTableSchema = "
            id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            user_id VARCHAR(30) COLLATE utf8mb4_unicode_ci NOT NULL,
            education_type VARCHAR(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            stage INT(11) NOT NULL,
            number INT(11) NOT NULL,
            additional_work TEXT COLLATE utf8mb4_unicode_ci NOT NULL,
            planned_works TEXT COLLATE utf8mb4_unicode_ci NOT NULL,
            researcher_tasks TEXT COLLATE utf8mb4_unicode_ci NOT NULL,
            file_url VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
            status VARCHAR(20) COLLATE utf8mb4_unicode_ci DEFAULT 'Kutilmoqda',
            is_rejected TINYINT(1) DEFAULT 0,
            rejected_text TEXT COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ";

        $this->createTableIfNotExists('mundarija', $curriculumTableSchema);
    }

    public function createPatentTable()
    {
        $patentsTableSchema = "
            id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            user_id VARCHAR(30) COLLATE utf8mb4_unicode_ci NOT NULL,
            patent_type VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
            intellectual_property_name VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
            intellectual_property_number VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
            patent_date DATE NOT NULL,
            author_count INT(11) NOT NULL,
            authors TEXT COLLATE utf8mb4_unicode_ci NOT NULL,
            patent_file VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
            status VARCHAR(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            is_rejected TINYINT(1) DEFAULT 0,
            rejected_text TEXT COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ";

        $this->createTableIfNotExists('patents', $patentsTableSchema);
    }

    public function createEventTable()
    {
        $eventsTableSchema = "
            id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            user_id VARCHAR(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            title VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
            description TEXT COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            event_date DATETIME NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ";

        $this->createTableIfNotExists('events', $eventsTableSchema);
    }

    public function createSertifikatTable()
    {
        $certificatesTableSchema = "
            id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            user_id VARCHAR(30) COLLATE utf8mb4_unicode_ci NOT NULL,
            certificate_type VARCHAR(50) COLLATE utf8mb4_unicode_ci NOT NULL,
            language_name VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
            language_level ENUM('A1', 'A2', 'B1', 'B2', 'C1', 'C2') COLLATE utf8mb4_unicode_ci NOT NULL,
            certificate_date DATE NOT NULL,
            certificate_file VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
            status VARCHAR(30) COLLATE utf8mb4_unicode_ci NOT NULL,
            is_rejected TINYINT(1) DEFAULT 0,
            rejected_text TEXT COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ";

        $this->createTableIfNotExists('certificates', $certificatesTableSchema);
    }
    
    public function createDarslikTable()
    {
        $worksTableSchema = "
            id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            user_id VARCHAR(30) COLLATE utf8mb4_general_ci NOT NULL,
            work_type VARCHAR(255) COLLATE utf8mb4_general_ci NOT NULL,
            work_name VARCHAR(255) COLLATE utf8mb4_general_ci NOT NULL,
            certificate_number VARCHAR(255) COLLATE utf8mb4_general_ci NOT NULL,
            work_date DATE NOT NULL,
            author_count INT(11) NOT NULL,
            authors TEXT COLLATE utf8mb4_general_ci NOT NULL,
            file_name VARCHAR(255) COLLATE utf8mb4_general_ci NOT NULL,
            status ENUM('Tasdiqlandi', 'Kutilmoqda', 'Rad etildi') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Kutilmoqda',
            is_rejected TINYINT(1) DEFAULT 0,
            rejected_text TEXT COLLATE utf8mb4_general_ci DEFAULT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ";

        $this->createTableIfNotExists('works', $worksTableSchema);
    }

    /**
     * Foydalanuvchining login va paroliga asoslangan tizimga kirishini tekshiradi.
     * 
     * @param string $login Foydalanuvchining login nomi
     * @param string $password Foydalanuvchining paroli
     * @return mixed Foydalanuvchi ma'lumotlarini qaytaradi agar login va parol to'g'ri bo'lsa, aks holda null
     */
    public function checkLogin($login, $password)
    {
        $sql = "SELECT * FROM users WHERE login = :login AND status = 'active' LIMIT 1";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':login', $login, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result && password_verify($password, $result['password'])) {
                return $result;
            }
            return null;
        } catch (\Exception $e) {
            $this->logError($e->getMessage());
            return null;
        }
    }

    /**
     * Foydalanuvchining faoliyat ma'lumotlarini saqlash
     * 
     * @param array $data Foydalanuvchidan kelgan ma'lumotlar
     * @return bool Ma'lumotlar muvaffaqiyatli saqlanganda true, aks holda false
     */
    public function saveFaoliyatData($data)
    {
        $sql = "INSERT INTO faoliyat (
            user_id, fio, gender, birthplace, birthdate, residence, residenceStatus, passportNumber, pnifl, currentJob,
            position, bachelor, bachelorDiploma, bachelorDate, master, masterDiploma, masterDate, doctorateSpecialty,
            directionName, dissertationTopic, supervisorFio, supervisorWorkplace, supervisorDegree, supervisorTitle,
            admissionYear, stage, educationType, orderNumber, theoreticalProgramText, theoreticalProgramFile, individualPlanText,
            individualPlanFile, participationInCompetitions, academicFile, organizationSent, organizationReceived, country,
            startDate, endDate, fileUpload, created_at
        ) VALUES (
            :user_id, :fio, :gender, :birthplace, :birthdate, :residence, :residenceStatus, :passportNumber, :pnifl, :currentJob,
            :position, :bachelor, :bachelorDiploma, :bachelorDate, :master, :masterDiploma, :masterDate, :doctorateSpecialty,
            :directionName, :dissertationTopic, :supervisorFio, :supervisorWorkplace, :supervisorDegree, :supervisorTitle,
            :admissionYear, :stage, :educationType, :orderNumber, :theoreticalProgramText, :theoreticalProgramFile, :individualPlanText,
            :individualPlanFile, :participationInCompetitions, :academicFile, :organizationSent, :organizationReceived, :country,
            :startDate, :endDate, :fileUpload, CURRENT_TIMESTAMP
        )";

        try {
            $stmt = $this->db->prepare($sql);

            foreach ($data as $key => $value) {
                if ($value === null) {
                    $stmt->bindValue(":$key", null, PDO::PARAM_NULL);
                } else {
                    $stmt->bindValue(":$key", $value);
                }
            }

            $stmt->execute();

            return true;
        } catch (\Exception $e) {
            $this->logError($e->getMessage());
            return false;
        }
    }

    /**
     * Foydalanuvchining mundarija ma'lumotlarini saqlash
     * 
     * @param array $data Foydalanuvchidan kelgan ma'lumotlar
     * @return bool Ma'lumotlar muvaffaqiyatli saqlanganda true, aks holda false
     */
    public function saveMundarijaData($data)
    {
        $sql = "INSERT INTO mundarija (
            user_id, education_type, stage, number, additional_work, file_url, planned_works, researcher_tasks, created_at
        ) VALUES (
            :user_id, :educationType, :stage, :number, :additionalWork, :fileUpload, :plannedWorks, :researcherTasks, CURRENT_TIMESTAMP
        )";

        try {
            $stmt = $this->db->prepare($sql);
            foreach ($data as $key => $value) {
                if ($value === null) {
                    $stmt->bindValue(":$key", null, PDO::PARAM_NULL);
                } else {
                    $stmt->bindValue(":$key", $value);
                }
            }

            $stmt->execute();

            return true;
        } catch (\Exception $e) {
            $this->logError("SQL Error: " . $e->getMessage());
            return false;
        }
    }

    public function getStatusCounts($user_id)
    {
    $statusCounts = [];

    $tables = ['mundarija', 'maqola', 'patents', 'works', 'certificates'];

    foreach ($tables as $table) {
        $sql = "SELECT status, COUNT(*) as count FROM $table WHERE user_id = :user_id GROUP BY status";
        
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
            $stmt->execute();

            $statusCounts[$table] = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $statusCounts[$table][$row['status']] = (int)$row['count'];
            }

        } catch (\Exception $e) {
            $this->logError("SQL Error on table $table: " . $e->getMessage());
            $this->logError("Failed Query: $sql");
            $statusCounts[$table] = [];
        }
    }

    return $statusCounts;
    }

    public function getUserEvents($user_id)
    {
    date_default_timezone_set("Asia/Tashkent");
    $currentDate = date('Y-m-d H:i:s');

    $deleteSql = "DELETE FROM events WHERE event_date < :currentDate";
    $deleteStmt = $this->db->prepare($deleteSql);
    $deleteStmt->execute([':currentDate' => $currentDate]);

    $selectSql = "SELECT * FROM events WHERE user_id = :all OR user_id = :user_id";
    $selectStmt = $this->db->prepare($selectSql);
    $selectStmt->execute([
        ':all' => 'all',
        ':user_id' => $user_id
    ]);

    return $selectStmt->fetchAll(PDO::FETCH_ASSOC);
    }
 
    /**
     * Foydalanuvchining faoliyat ma'lumotlarini olish
     *
     * @param int $user_id Foydalanuvchining ID raqami
     * @return mixed Foydalanuvchining faoliyat ma'lumotlari yoki null
     */
    public function getUserFaoliyatData($user_id)
    {
        $sql = "SELECT * FROM faoliyat WHERE user_id = :user_id LIMIT 1";
        
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(":user_id", $user_id, PDO::PARAM_INT);
            $stmt->execute();

            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            return $data ? $data : null;
        } catch (\Exception $e) {
            $this->logError($e->getMessage());
            return null;
        }
    }

    /**
     * Foydalanuvchining mundarija ma'lumotlarini olish
     * 
     * @param int $user_id Foydalanuvchining ID si
     * @return array Foydalanuvchining mundarija ma'lumotlari
     */
    public function getMundarijaData($user_id)
    {
        $sql = "SELECT 
                    id, 
                    education_type, 
                    stage, 
                    number, 
                    additional_work, 
                    planned_works, 
                    researcher_tasks, 
                    file_url, 
                    status, 
                    is_rejected, 
                    rejected_text 
                FROM mundarija 
                WHERE user_id = :user_id 
                ORDER BY created_at DESC";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            $this->logError("SQL Error: " . $e->getMessage());
            return [];
        }
        }
    /**
     * Foydalanuvchining mundarija bo'yicha statistik ma'lumotlarini olish
     * 
     * @param string $user_id Foydalanuvchining ID-si
     * @return array Ma'lumotlar bo'yicha statistikalar (bajarilgan, kutilmoqda, rad etilgan vazifalar)
     */
    public function getMundarijaStatistics($user_id)
    {
    $sql = "SELECT education_type, stage, status, planned_works, researcher_tasks
            FROM mundarija 
            WHERE user_id = :user_id 
            ORDER BY created_at DESC";

    try {
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
        $stmt->execute();
        $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $statistics = [
            'Tasdiqlandi' => 0,
            'kutilmoqda' => 0,
            'Rad etildi' => 0,
            'task_names' => [],
            'total_tasks' => 0,
            'education_type' => '',
            'stage' => 1,
            'stage_tasks' => []
        ];

        foreach ($tasks as $task) {
            if ($statistics['education_type'] == '') {
                $statistics['education_type'] = $task['education_type'];
            }

            if ($statistics['stage'] == 1) {
                $statistics['stage'] = $task['stage'];
            }

            if ($task['status'] == 'Tasdiqlandi') {
                $statistics['Tasdiqlandi']++;
            } elseif ($task['status'] == 'Kutilmoqda') {
                $statistics['kutilmoqda']++;
            } elseif ($task['status'] == 'Rad etildi') {
                $statistics['Rad etildi']++;
            }

            $statistics['task_names'][] = $task['planned_works'] . " | " . $task['researcher_tasks'];
            $statistics['stage_tasks'][$task['stage']][] = $task;
        }

        $totalTasks = 0;

        if ($statistics['education_type'] === "Stajor taqiqotchi (PhD)" && $statistics['stage'] == 1) {
            $totalTasks = 12;
        } elseif ($statistics['education_type'] === "Tayanch doktorant (PhD)" || $statistics['education_type'] === "Maqsadli tayanch doktorant (PhD)" || $statistics['education_type'] === "Mustaqil izlanuvchi (PhD)") {
            if ($statistics['stage'] == 1) $totalTasks = 12;
            else if ($statistics['stage'] == 2) $totalTasks = 10;
            else if ($statistics['stage'] == 3) $totalTasks = 12;
        } elseif ($statistics['education_type'] === "Doktorant (DSc)" || $statistics['education_type'] === "Maqsadli doktorantura (DSc)" || $statistics['education_type'] === "Mustaqil izlanuvchi (DSc)") {
            if ($statistics['stage'] == 1) $totalTasks = 8;
            else if ($statistics['stage'] == 2) $totalTasks = 7;
            else if ($statistics['stage'] == 3) $totalTasks = 5;
        }
         
        $statistics['total_tasks'] = max($totalTasks, 0);

        return $statistics;
    } catch (\Exception $e) {
        $this->logError("SQL Error: " . $e->getMessage());
        return [];
    }
    }
    
    public function getMundarijaById($id) {
    $stmt = $this->db->prepare("SELECT file_url FROM mundarija WHERE id = :id LIMIT 1");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    /**
     * Foydalanuvchining mundarija ma'lumotlarini o'chirish
     * 
     * @param array $id Foydalanuvchidan kelgan ma'lumotlarni id bo'yicha o'chirish
     * 
     * @return bool Ma'lumotlar muvaffaqiyatli saqlanganda true, aks holda false
     */
    public function deleteMundarija($id) {
    $stmt = $this->db->prepare("DELETE FROM mundarija WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
    }
    public function getMaqolaById($id) {
    $stmt = $this->db->prepare("SELECT articleFile FROM maqola WHERE id = :id LIMIT 1");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    /**
     * Foydalanuvchining maqola ma'lumotlarini o'chirish
     * 
     * @param array $id Foydalanuvchidan kelgan ma'lumotlarni id bo'yicha o'chirish
     * 
     * @return bool Ma'lumotlar muvaffaqiyatli saqlanganda true, aks holda false
     */
    public function deleteMaqola($id) {
    $stmt = $this->db->prepare("DELETE FROM maqola WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
    }
    public function getPatentById($id) {
    $stmt = $this->db->prepare("SELECT patent_file FROM patents WHERE id = :id LIMIT 1");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getDarslikById($id) {
    $stmt = $this->db->prepare("SELECT file_name FROM works WHERE id = :id LIMIT 1");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getSertifikatById($id, $user_id) {
    $stmt = $this->db->prepare("SELECT certificate_file FROM certificates WHERE id = :id AND user_id = :user_id LIMIT 1");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function deletePatent($id) {
    $stmt = $this->db->prepare("DELETE FROM patents WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
    }
    public function deleteDarslik($id) {
    $stmt = $this->db->prepare("DELETE FROM works WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
    }
    public function deleteSertifikat($id) {
    $stmt = $this->db->prepare("DELETE FROM certificates WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
    }
    /**
     * Maqola ma'lumotlarini saqlash
     * 
     * @param array $data Foydalanuvchidan kelgan ma'lumotlar
     * @return bool Ma'lumotlar muvaffaqiyatli saqlanganda true, aks holda false
     */
    public function saveMaqolaData($data)
    {
    $sql = "INSERT INTO maqola (
        user_id, journalType, publishCountry, journalName, articleTitle, publishDate, articleLink, 
        authorCount, authors, articleFile, status, is_rejected, rejected_text, created_at
    ) VALUES (
        :user_id, :journalType, :publishCountry, :journalName, :articleTitle, :publishDate, :articleLink, 
        :authorCount, :authors, :articleFile, 'Kutilmoqda', FALSE, NULL, CURRENT_TIMESTAMP
    )";

    try {
        $stmt = $this->db->prepare($sql);

        foreach ($data as $key => $value) {
            if ($value === null) {
                $stmt->bindValue(":$key", null, PDO::PARAM_NULL);
            } else {
                $stmt->bindValue(":$key", $value);
            }
        }

        $stmt->execute();
        return true;
    } catch (\Exception $e) {
        $this->logError("SQL Error: " . $e->getMessage());
        return false;
    }
    }

    public function getAllMaqolalar($user_id)
    {
        $sql = "SELECT * FROM maqola WHERE user_id = :user_id ORDER BY created_at DESC";
        
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':user_id', $user_id);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            $this->logError("SQL Error: " . $e->getMessage());
            return [];
        }
    }

    public function getAllPatents($user_id)
    {
        $sql = "SELECT * FROM patents WHERE user_id = :user_id ORDER BY created_at DESC";
        
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':user_id', $user_id);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            $this->logError("SQL Error: " . $e->getMessage());
            return [];
        }
    }

    public function getAllDarslik($user_id)
    {
        $sql = "SELECT * FROM works WHERE user_id = :user_id ORDER BY created_at DESC";
        
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':user_id', $user_id);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            $this->logError("SQL Error: " . $e->getMessage());
            return [];
        }
    }

    public function getAllSertifikat($user_id) {
    $sql = "SELECT * FROM certificates WHERE user_id = :user_id ORDER BY created_at DESC";

    try {
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (\Exception $e) {
        $this->logError("SQL Error: " . $e->getMessage());
        return [];
    }
    }

    public function savePatentData($data) {
    $sql = "INSERT INTO patents (
        user_id, patent_type, intellectual_property_name, intellectual_property_number, patent_date, 
        author_count, authors, patent_file, status, is_rejected, rejected_text, created_at
    ) VALUES (
        :user_id, :patent_type, :intellectual_property_name, :intellectual_property_number, :patent_date,
        :author_count, :authors, :patent_file, 'Kutilmoqda', :is_rejected, :rejected_text, CURRENT_TIMESTAMP
    )";

    try {
        $stmt = $this->db->prepare($sql);

        foreach ($data as $key => $value) {
            if ($value === null) {
                $stmt->bindValue(":$key", null, PDO::PARAM_NULL);
            } else {
                $stmt->bindValue(":$key", $value);
            }
        }

        $stmt->execute();

        return true;
    } catch (\Exception $e) {
        $this->logError("SQL Error: " . $e->getMessage());
        return false;
    }
    }

    public function saveDarslikData($data) {
    $sql = "INSERT INTO works (
        user_id, work_type, work_name, certificate_number, work_date, 
        author_count, authors, file_name, status, rejected_text, created_at
    ) VALUES (
        :user_id, :work_type, :work_name, :certificate_number, :work_date,
        :author_count, :authors, :file_name, :status, :rejected_text, CURRENT_TIMESTAMP
    )";

    try {
        $stmt = $this->db->prepare($sql);

        foreach ($data as $key => $value) {
            if ($value === null) {
                $stmt->bindValue(":$key", null, PDO::PARAM_NULL);
            } else {
                $stmt->bindValue(":$key", $value);
            }
        }

        $stmt->execute();

        return true;
    } catch (\Exception $e) {
        $this->logError("SQL Error: " . $e->getMessage());
        return false;
    }
    }

    public function saveSertifikatData($data) {
    $sql = "INSERT INTO certificates (
        user_id, certificate_type, language_name, language_level, certificate_date, 
        certificate_file, status, is_rejected, rejected_text, created_at
    ) VALUES (
        :user_id, :certificate_type, :language_name, :language_level, :certificate_date, 
        :certificate_file, :status, :is_rejected, :rejected_text, CURRENT_TIMESTAMP
    )";

    try {
        $stmt = $this->db->prepare($sql);

        foreach ($data as $key => $value) {
            if ($value === null) {
                $stmt->bindValue(":$key", null, PDO::PARAM_NULL);
            } else {
                $stmt->bindValue(":$key", $value);
            }
        }

        $stmt->execute();

        return true;
    } catch (\Exception $e) {
        $this->logError("SQL Error: " . $e->getMessage());
        return false;
    }
    }

    /**
     * Log the login attempt in the login_history table.
     *
     * @param string $userId User's ID
     * @param string $ipAddress IP address of the user
     * @param string $status Login status (success or failed)
     */
    public function logLoginHistory($userId, $fullname, $ipAddress, $login, $status)
    {   
        $sql = "INSERT INTO login_history (user_id, fullname, ip_address, login, status, created_at) 
                VALUES (:user_id, :fullname, :ip_address, :login, :status, NOW())";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':user_id', $userId, PDO::PARAM_STR);
            $stmt->bindValue(':fullname', $fullname, PDO::PARAM_STR);
            $stmt->bindValue(':ip_address', $ipAddress, PDO::PARAM_STR);
            $stmt->bindValue(':login', $login, PDO::PARAM_STR);
            $stmt->bindValue(':status', $status, PDO::PARAM_STR);
            $stmt->execute();
        } catch (\Exception $e) {
            $this->logError($e->getMessage());
        }
    }

    /**
     * Foydalanuvchining chatlaridagi bildirishnomalar sonini qaytaradi.
     *
     * @return int
     */
    public function getChatNotificationsCount()
    {
        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            return 0;
        }

        $sql = "SELECT COUNT(*) FROM chats WHERE message_for_user_id = :user_id AND is_read = 0";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':user_id', $userId, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchColumn();

            return (int) $result;
        } catch (\Exception $e) {
            $this->logError($e->getMessage());
            return 0;
        }
    }
    /**
     * Foydalanuvchining IDsini login orqali topish.
     *
     * @return int
     */
    public function getUserIdByLogin($login)
    {
        $sql = "SELECT user_id FROM users WHERE login = :login LIMIT 1";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':login', $login, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                return $result['user_id'];
            }

            return null;
        } catch (\Exception $e) {
            $this->logError($e->getMessage());
            return null;
        }
    }
    /**
     * Foydalanuvchining login tarixini olish.
     *
     * @param string $userId Foydalanuvchining IDsi
     * @return array Kirish tarixlari ro'yxati
     */
    public function getLoginHistory($userId)
    {
        $sql = "SELECT * FROM login_history WHERE user_id = :user_id ORDER BY created_at DESC";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':user_id', $userId, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $result;
        } catch (\Exception $e) {
            $this->logError($e->getMessage());
            return [];
        }
    }
    
    /**
     * Foydalanuvchining profil rasmini olish.
     *
     * @param string $userId Foydalanuvchining IDsi
     * @return string|null Rasm URL manzili yoki null
     */

    public function getUserProfilePicture($userId)
    {
        $sql = "SELECT image_url FROM users WHERE user_id = :user_id LIMIT 1";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':user_id', $userId, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result && !empty($result['image_url'])) {
                return $result['image_url'];
            }

            return null;
        } catch (\Exception $e) {
            $this->logError($e->getMessage());
            return null;
        }
    }
}
?>