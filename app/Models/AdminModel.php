<?php

namespace App\Models;

use System\Database;
use System\BaseModel;
use PDO;

class AdminModel extends BaseModel
{
    protected $db;

    public function __construct()
    {
        $this->db = new Database();
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

    /**
     * Statustagi ma'lumotlarni hisoblash
     * 
     * @param string $table Jadval nomi
     * @param string $status Tasdiqlandi yoki Rad etildi
     * @return int Hisoblangan qiymat
     */
        public function countStatus($table, $status)
        {
        $sql = "SELECT COUNT(*) AS count FROM {$table} WHERE status = :status OR status IS NULL OR status = ''";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':status', $status, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return (int)$result['count'];
        } catch (\Exception $e) {
            $this->logError($e->getMessage());
            return 0;
        }
    }

    /**
     * Foydalanuvchilarni hisoblash
     * 
     * @return int
     */
        public function countUsers()
        {
        $sql = "SELECT COUNT(*) AS count FROM users";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return (int)$result['count'];
        } catch (\Exception $e) {
            $this->logError($e->getMessage());
            return 0;
        }
    }

    /**
     * Umumiy yuklangan fayllarni hisoblash
     * 
     * @return int
     */
        public function countUploadedFiles()
        {
        $tables = ['mundarija', 'maqola', 'patents', 'works', 'certificates'];
        $totalCount = 0;

        foreach ($tables as $table) {
            $totalCount += $this->countStatus($table, 'Tasdiqlandi');
            $totalCount += $this->countStatus($table, 'Kutilmoqda');
            $totalCount += $this->countStatus($table, 'Rad etildi');
        }

        return $totalCount;
    }
    /**
     * Jadvaldagi ma'lumotlar sonini olish
     *
     * Bu funksiya barcha kerakli jadvallar (faoliyat, mundarija, maqola, patents, works, certificates) uchun
     * umumiy ma'lumotlar sonini olishni amalga oshiradi.
     *
     * @return array Jadval nomlari va ularning ma'lumotlar sonini qaytaradi
     */
    public function getAllDocumentsCount()
    {
    $tables = [
        'faoliyat' => "SELECT COUNT(*) FROM faoliyat",
        'mundarija' => "SELECT COUNT(*) FROM mundarija WHERE status = 'Kutilmoqda'",
        'maqola' => "SELECT COUNT(*) FROM maqola WHERE status = 'Kutilmoqda'",
        'patents' => "SELECT COUNT(*) FROM patents WHERE status = 'Kutilmoqda'",
        'works' => "SELECT COUNT(*) FROM works WHERE status = 'Kutilmoqda'",
        'certificates' => "SELECT COUNT(*) FROM certificates WHERE status = 'Kutilmoqda'"
    ];

    $counts = [];
    foreach ($tables as $table => $sql) {
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $counts[$table] = $stmt->fetchColumn();
        } catch (\Exception $e) {
            $this->logError($e->getMessage());
            $counts[$table] = 0; 
        }
    }

    return $counts;
    }   

    /**
     * Faoliyat jadvalidan ma'lumotlarni olish.
     *
     * @return array Faoliyat jadvali ma'lumotlari
     */
    public function getActivityDocuments()
    {
        $sql = "
            SELECT * FROM faoliyat";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            $this->logError($e->getMessage());
            return [];
        }
    }

    /**
     * Mundarija jadvalidan ma'lumotlarni olish.
     *
     * @return array Mundarija jadvali ma'lumotlari
     */
    public function getGuideDocuments()
    {
        $sql = "
            SELECT * FROM mundarija";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            $this->logError($e->getMessage());
            return [];
        }
    }

    /**
     * Maqola jadvalidan ma'lumotlarni olish.
     *
     * @return array Maqola jadvali ma'lumotlari
     */
    public function getArticleDocuments()
    {
        $sql = "
            SELECT * FROM maqola";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            $this->logError($e->getMessage());
            return [];
        }
    }

    /**
     * Patents jadvalidan ma'lumotlarni olish.
     *
     * @return array Patent jadvali ma'lumotlari
     */
    public function getPatentDocuments()
    {
        $sql = "
            SELECT * FROM patents";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            $this->logError($e->getMessage());
            return [];
        }
    }

    /**
     * Works jadvalidan ma'lumotlarni olish.
     *
     * @return array Darslik jadvali ma'lumotlari
     */
    public function getDarslikDocuments()
    {
        $sql = "
            SELECT * FROM works";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            $this->logError($e->getMessage());
            return [];
        }
    }

    /**
     * Certificates jadvalidan ma'lumotlarni olish.
     *
     * @return array Til-sertifikatlari jadvali ma'lumotlari
     */
    public function getSertifikatDocuments()
    {
        $sql = "
            SELECT * FROM certificates";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            $this->logError($e->getMessage());
            return [];
        }
    }

    /**
     * Adminning login tarixini olish.
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

                if ($result) {
                    return $result;
                }

                return [];
            } catch (\Exception $e) {
                $this->logError($e->getMessage());
                return []; 
            }
        }

    public function getAllUsers()
    {
        $sql = "SELECT * FROM users";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            $this->logError($e->getMessage());
            return [];
        }
    }

    public function getAllGuide()
    {
        $sql = "SELECT * FROM mundarija";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            $this->logError($e->getMessage());
            return [];
        }
    }

    public function getAllArticle()
    {
        $sql = "SELECT * FROM maqola";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            $this->logError($e->getMessage());
            return [];
        }
    }

    public function getAllPatent()
    {
        $sql = "SELECT * FROM patents";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            $this->logError($e->getMessage());
            return [];
        }
    }

    public function getAllDarslik()
    {
        $sql = "SELECT * FROM works";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            $this->logError($e->getMessage());
            return [];
        }
    }

    public function getAllSertifikat()
    {
        $sql = "SELECT * FROM certificates";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            $this->logError($e->getMessage());
            return [];
        }
    }

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
     * Foydalanuvchining loginini olish (user_id orqali)
     *
     * @param string $userId Foydalanuvchining IDsi
     * @return string|null Foydalanuvchining login
     */
        public function getUserLoginById($userId)
        {
        $sql = "SELECT login FROM users WHERE user_id = :user_id LIMIT 1";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':user_id', $userId, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? $result['login'] : null;
        } catch (\Exception $e) {
            $this->logError($e->getMessage());
            return null;
        }
    }

    public function getFileUrlByUserId($user_id, $file) {
    try {
    $sql = "SELECT $file FROM faoliyat WHERE user_id = :user_id";
    $stmt = $this->db->prepare($sql);
    
    $stmt->bindValue(':user_id', (string)$user_id, PDO::PARAM_STR);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result[$file] ?? null;

    } catch (PDOException $e) {
        $this->logError($e->getMessage());
        return null;
    }
    }

    public function getActivityDocumentsByUserId($user_id)
    {
        $sql = "
            SELECT * FROM faoliyat WHERE user_id = :user_id";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':user_id', (string)$user_id, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            $this->logError($e->getMessage());
            return [];
        }
    }

    public function getGuideDocumentsByUserId($user_id)
    {
        $sql = "
            SELECT * FROM mundarija WHERE user_id = :user_id";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':user_id', (string)$user_id, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            $this->logError($e->getMessage());
            return [];
        }
    }

    public function getEvents() {
        $sql = "SELECT * FROM events ORDER BY event_date DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    }

    public function deleteEvent($id) {
        $sql = "DELETE FROM events WHERE id = :id";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (\Exception $e) {
            $this->logError($e->getMessage());
            throw $e;
        }
    }

    public function deleteActivity($user_id) {
        $sql = "DELETE FROM faoliyat WHERE user_id = :user_id LIMIT 1";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
            $stmt->execute();
        } catch (\Exception $e) {
            $this->logError($e->getMessage());
            throw $e;
        }
    }

    public function updateEvent($id, $title, $description, $event_date, $user) {
    $sql = "UPDATE events SET title = :title, description = :description, event_date = :event_date, user_id = :user_id WHERE id = :id";
    try {
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':title', $title, PDO::PARAM_STR);
        $stmt->bindValue(':description', $description, PDO::PARAM_STR);
        $stmt->bindValue(':event_date', $event_date, PDO::PARAM_STR);
        $stmt->bindValue(':user_id', $user, PDO::PARAM_STR);
        $stmt->execute();
    } catch (\Exception $e) {
        $this->logError($e->getMessage());
        throw $e;
    }
    }

    public function addEvent($title, $description, $event_date, $user) {
    $sql = "INSERT INTO events (title, description, event_date, user_id, created_at) VALUES (:title, :description, :event_date, :user_id, CURRENT_TIMESTAMP)";
    try {
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':title', $title, PDO::PARAM_STR);
        $stmt->bindValue(':description', $description, PDO::PARAM_STR);
        $stmt->bindValue(':event_date', $event_date, PDO::PARAM_STR);
        $stmt->bindValue(':user_id', $user, PDO::PARAM_STR);
        $stmt->execute();
    } catch (\Exception $e) {
        $this->logError($e->getMessage());
        throw $e;
    }
    }

    public function approveGuideDocument($document_id)
    {
        $sql = "UPDATE mundarija SET status = 'Tasdiqlandi', is_rejected = 0 WHERE id = :id";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $document_id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (\Exception $e) {
            $this->logError($e->getMessage());
            return false;
        }
    }

    public function cancelGuideDocument($document_id, $cancel_reason)
    {
    $sql = "UPDATE mundarija 
            SET status = 'Rad etildi', 
                rejected_text = :reason, 
                is_rejected = 1 
            WHERE id = :id"; 
    try {
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $document_id, PDO::PARAM_INT);
        $stmt->bindParam(':reason', $cancel_reason, PDO::PARAM_STR);
        return $stmt->execute();
    } catch (\Exception $e) {
        $this->logError($e->getMessage());
        return false;
    }
    }

    public function deleteGuideDocument($documentId)
        {
        $sql = "SELECT file_url FROM mundarija WHERE id = :documentId LIMIT 1";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':documentId', $documentId, PDO::PARAM_INT);
            $stmt->execute();
            $document = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($document) {
                $fileUrl = $document['file_url'];
                if (file_exists($fileUrl)) {
                    unlink($fileUrl);
                }

                $deleteSql = "DELETE FROM mundarija WHERE id = :documentId LIMIT 1";
                $deleteStmt = $this->db->prepare($deleteSql);
                $deleteStmt->bindValue(':documentId', $documentId, PDO::PARAM_INT);
                $deleteStmt->execute();

            } else {
                throw new Exception('Hujjat topilmadi.');
            }
        } catch (\Exception $e) {
            $this->logError($e->getMessage());
            throw $e;
        }
    }

    public function approveArticleDocument($document_id)
    {
        $sql = "UPDATE maqola SET status = 'Tasdiqlandi', is_rejected = 0 WHERE id = :id";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $document_id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (\Exception $e) {
            $this->logError($e->getMessage());
            return false;
        }
    }

    public function cancelArticleDocument($document_id, $cancel_reason)
    {
    $sql = "UPDATE maqola 
            SET status = 'Rad etildi', 
                rejected_text = :reason, 
                is_rejected = 1 
            WHERE id = :id"; 
    try {
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $document_id, PDO::PARAM_INT);
        $stmt->bindParam(':reason', $cancel_reason, PDO::PARAM_STR);
        return $stmt->execute();
    } catch (\Exception $e) {
        $this->logError($e->getMessage());
        return false;
    }
    }

    public function deleteArticleDocument($documentId)
        {
        $sql = "SELECT articleFile FROM maqola WHERE id = :documentId LIMIT 1";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':documentId', $documentId, PDO::PARAM_INT);
            $stmt->execute();
            $document = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($document) {
                $fileUrl = $document['articleFile'];
                if (file_exists($fileUrl)) {
                    unlink($fileUrl);
                }

                $deleteSql = "DELETE FROM maqola WHERE id = :documentId LIMIT 1";
                $deleteStmt = $this->db->prepare($deleteSql);
                $deleteStmt->bindValue(':documentId', $documentId, PDO::PARAM_INT);
                $deleteStmt->execute();

            } else {
                throw new Exception('Hujjat topilmadi.');
            }
        } catch (\Exception $e) {
            $this->logError($e->getMessage());
            throw $e;
        }
    }

     public function approvePatentDocument($document_id)
    {
        $sql = "UPDATE patents SET status = 'Tasdiqlandi', is_rejected = 0 WHERE id = :id";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $document_id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (\Exception $e) {
            $this->logError($e->getMessage());
            return false;
        }
    }

    public function cancelPatentDocument($document_id, $cancel_reason)
    {
    $sql = "UPDATE patents 
            SET status = 'Rad etildi', 
                rejected_text = :reason, 
                is_rejected = 1 
            WHERE id = :id"; 
    try {
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $document_id, PDO::PARAM_INT);
        $stmt->bindParam(':reason', $cancel_reason, PDO::PARAM_STR);
        return $stmt->execute();
    } catch (\Exception $e) {
        $this->logError($e->getMessage());
        return false;
    }
    }

    public function deletePatentDocument($documentId)
        {
        $sql = "SELECT patent_file FROM patents WHERE id = :documentId LIMIT 1";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':documentId', $documentId, PDO::PARAM_INT);
            $stmt->execute();
            $document = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($document) {
                $fileUrl = $document['patent_file'];
                if (file_exists($fileUrl)) {
                    unlink($fileUrl);
                }

                $deleteSql = "DELETE FROM patents WHERE id = :documentId LIMIT 1";
                $deleteStmt = $this->db->prepare($deleteSql);
                $deleteStmt->bindValue(':documentId', $documentId, PDO::PARAM_INT);
                $deleteStmt->execute();

            } else {
                throw new Exception('Hujjat topilmadi.');
            }
        } catch (\Exception $e) {
            $this->logError($e->getMessage());
            throw $e;
        }
    }

     public function approveDarslikDocument($document_id)
    {
        $sql = "UPDATE works SET status = 'Tasdiqlandi', is_rejected = 0 WHERE id = :id";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $document_id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (\Exception $e) {
            $this->logError($e->getMessage());
            return false;
        }
    }

    public function cancelDarslikDocument($document_id, $cancel_reason)
    {
    $sql = "UPDATE works 
            SET status = 'Rad etildi', 
                rejected_text = :reason, 
                is_rejected = 1 
            WHERE id = :id"; 
    try {
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $document_id, PDO::PARAM_INT);
        $stmt->bindParam(':reason', $cancel_reason, PDO::PARAM_STR);
        return $stmt->execute();
    } catch (\Exception $e) {
        $this->logError($e->getMessage());
        return false;
    }
    }

    public function deleteDarslikDocument($documentId)
        {
        $sql = "SELECT file_name FROM works WHERE id = :documentId LIMIT 1";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':documentId', $documentId, PDO::PARAM_INT);
            $stmt->execute();
            $document = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($document) {
                $fileUrl = $document['file_name'];
                if (file_exists($fileUrl)) {
                    unlink($fileUrl);
                }

                $deleteSql = "DELETE FROM works WHERE id = :documentId LIMIT 1";
                $deleteStmt = $this->db->prepare($deleteSql);
                $deleteStmt->bindValue(':documentId', $documentId, PDO::PARAM_INT);
                $deleteStmt->execute();

            } else {
                throw new Exception('Hujjat topilmadi.');
            }
        } catch (\Exception $e) {
            $this->logError($e->getMessage());
            throw $e;
        }
    }
    
    public function approveSertifikatDocument($document_id)
    {
        $sql = "UPDATE certificates SET status = 'Tasdiqlandi', is_rejected = 0 WHERE id = :id";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $document_id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (\Exception $e) {
            $this->logError($e->getMessage());
            return false;
        }
    }

    public function cancelSertifikatDocument($document_id, $cancel_reason)
    {
    $sql = "UPDATE certificates 
            SET status = 'Rad etildi', 
                rejected_text = :reason, 
                is_rejected = 1 
            WHERE id = :id"; 
    try {
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $document_id, PDO::PARAM_INT);
        $stmt->bindParam(':reason', $cancel_reason, PDO::PARAM_STR);
        return $stmt->execute();
    } catch (\Exception $e) {
        $this->logError($e->getMessage());
        return false;
    }
    }

    public function deleteSertifikatDocument($documentId)
        {
        $sql = "SELECT certificate_file FROM certificates WHERE id = :documentId LIMIT 1";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':documentId', $documentId, PDO::PARAM_INT);
            $stmt->execute();
            $document = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($document) {
                $fileUrl = $document['certificate_file'];
                if (file_exists($fileUrl)) {
                    unlink($fileUrl);
                }

                $deleteSql = "DELETE FROM certificates WHERE id = :documentId LIMIT 1";
                $deleteStmt = $this->db->prepare($deleteSql);
                $deleteStmt->bindValue(':documentId', $documentId, PDO::PARAM_INT);
                $deleteStmt->execute();

            } else {
                throw new Exception('Hujjat topilmadi.');
            }
        } catch (\Exception $e) {
            $this->logError($e->getMessage());
            throw $e;
        }
    }

    public function getEventDetails($id) {
        $sql = "SELECT * FROM events WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addUser(
    $user_id,
    $fullname,
    $middlename,
    $login,
    $password,
    $gender,
    $passportSeries,
    $pnifl,
    $speciality_name,
    $speciality_number,
    $degree,
    $role,
    $image_url = null
) {
    $sql = "INSERT INTO users 
            (user_id, fullname, middlename, login, password, gender, passportSeries, pnifl, speciality_name, speciality_number, degree, role, image_url, status, created_at) 
            VALUES 
            (:user_id, :fullname, :middlename, :login, :password, :gender, :passportSeries, :pnifl, :speciality_name, :speciality_number, :degree, :role, :image_url, 'active', CURRENT_TIMESTAMP)";

    try {
        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
        $stmt->bindValue(':fullname', $fullname, PDO::PARAM_STR);
        $stmt->bindValue(':middlename', $middlename, PDO::PARAM_STR);
        $stmt->bindValue(':login', $login, PDO::PARAM_STR);
        $stmt->bindValue(':password', password_hash($password, PASSWORD_DEFAULT), PDO::PARAM_STR);
        $stmt->bindValue(':gender', $gender, PDO::PARAM_STR);
        $stmt->bindValue(':passportSeries', $passportSeries, PDO::PARAM_STR);
        $stmt->bindValue(':pnifl', $pnifl, PDO::PARAM_STR);
        $stmt->bindValue(':speciality_name', $speciality_name, PDO::PARAM_STR);
        $stmt->bindValue(':speciality_number', $speciality_number, PDO::PARAM_STR);
        $stmt->bindValue(':degree', $degree, PDO::PARAM_STR);
        $stmt->bindValue(':role', $role, PDO::PARAM_STR);
        $stmt->bindValue(':image_url', $image_url, PDO::PARAM_STR);

        $stmt->execute();
        return true;
    } catch (\Exception $e) {
        $this->logError($e->getMessage());
        throw $e;
    }
}
    public function getUser($user_id) {
        $sql = "SELECT * FROM users WHERE id = :user_id LIMIT 1";
        
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                return null;
            }
        } catch (\Exception $e) {
            $this->logError($e->getMessage());
            throw $e;
        }
    }

    public function updateUser($user_id, $fullname, $middlename, $login, $password, $gender, $passportSeries, $pnifl, $speciality_name, $speciality_number, $degree, $role, $status, $image_url) {
    $sql = "UPDATE users SET 
                fullname = :fullname,
                middlename = :middlename,
                login = :login,
                password = :password,
                gender = :gender,
                passportSeries = :passportSeries,
                pnifl = :pnifl,
                speciality_name = :speciality_name,
                speciality_number = :speciality_number,
                degree = :degree,
                role = :role,
                status = :status,
                image_url = :image_url
            WHERE user_id = :user_id";

        try {
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
        $stmt->bindValue(':fullname', $fullname, PDO::PARAM_STR);
        $stmt->bindValue(':middlename', $middlename, PDO::PARAM_STR);
        $stmt->bindValue(':login', $login, PDO::PARAM_STR);

        if (!empty($password) && !preg_match('/^\$2y\$/', $password)) {
            $stmt->bindValue(':password', password_hash($password, PASSWORD_DEFAULT), PDO::PARAM_STR);
        } else {
            $stmt->bindValue(':password', $password, PDO::PARAM_STR);
        }

        $stmt->bindValue(':gender', $gender, PDO::PARAM_STR);
        $stmt->bindValue(':passportSeries', $passportSeries, PDO::PARAM_STR);
        $stmt->bindValue(':pnifl', $pnifl, PDO::PARAM_STR);
        $stmt->bindValue(':speciality_name', $speciality_name, PDO::PARAM_STR);
        $stmt->bindValue(':speciality_number', $speciality_number, PDO::PARAM_INT);
        $stmt->bindValue(':degree', $degree, PDO::PARAM_STR);
        $stmt->bindValue(':role', $role, PDO::PARAM_STR);
        $stmt->bindValue(':status', $status, PDO::PARAM_STR);
        $stmt->bindValue(':image_url', $image_url, PDO::PARAM_STR);

        $stmt->execute();
        return $stmt->rowCount() > 0;
    } catch (\Exception $e) {
        $this->logError($e->getMessage());
        throw $e;
    }
}
    public function deleteUser($user_id) {
        $sql = "DELETE FROM users WHERE user_id = :user_id";

        try {
            $stmt = $this->db->prepare($sql);

            $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);

            $stmt->execute();
            
            return $stmt->rowCount() > 0;
        } catch (\Exception $e) {
            $this->logError($e->getMessage());
            throw $e;
        }
    }
}

?>