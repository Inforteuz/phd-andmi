<?php

/**
 * UserController.php
 *
 * Bu fayl PHP framework'ida foydalanuvchi (user) bilan bog'liq amallarni bajarish uchun mo'ljallangan.
 * Foydalanuvchi ma'lumotlarini olish, qo'shish, yangilash va o'chirish kabi funksiyalarni o'z ichiga oladi.
 * Ushbu model `users` jadvali bilan bog'liq bo'lib, foydalanuvchi malumotlarini saqlash va qayta ishlashda ishlatiladi.
 * 
 * @package    CodeIgniter Alternative
 * @subpackage Models
 * @author     Oyatillo
 * @version    1.0.0
 * @date       2024-12-01
 * 
 * @description
 * Ushbu fayl quyidagi funksiyalarni o'z ichiga olishi mumkin:
 *  - Foydalanuvchini dashboardi (`dashboard()`)
 *  - Foydalanuvchini bosh sahifasi (`index()`)
 *  - Foydalanuvchi portfoliosi (`portfolio()`)
 *  - Foydalanuvchini chat (`chat()`)
 * 
 * Ushbu fayl framework ichidagi `Model` sinfiga meros qilib olingan bo'lib, ma'lumotlar bazasi bilan
 * bog'lanish va SQL so'rovlarini bajarishda foydalaniladi.
 */

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\ChatModel;
use System\BaseController;
use PDO;

class UserController extends BaseController
{
    public function dashboard($param = null)
    {
    session_start();

    $role = $_SESSION['role'] ?? null;
    $degree = $_SESSION['degree'] ?? null;
    $user_id = $_SESSION['user_id'] ?? null;

    $userModel = new UserModel();
    $notificationsCount = $userModel->getChatNotificationsCount();
    $image_url = $userModel->getUserProfilePicture($user_id);
    $statusCounts = $userModel->getStatusCounts($user_id);
    $userEvents = $userModel->getUserEvents($user_id);

    $scientificCounts = [];
    $tables = ['mundarija', 'maqola', 'patents', 'works', 'certificates'];

    foreach ($tables as $table) {
        $scientificCounts[$table] = 0;

        if (isset($statusCounts[$table])) {
            foreach ($statusCounts[$table] as $status => $count) {
                $scientificCounts[$table] += $count;
            }
        }
    }

    if ($role === "user" && !empty($degree)) {
        if ($param !== null) {
            $this->to('/user/dashboard');
        } else {
            $this->view('user/index', [
                'title' => 'PhD-DsC Hisobot Platformasi | Bosh sahifa',
                'notificationsCount' => $notificationsCount,
                'statusCounts' => $statusCounts,
                'image_url' => $image_url,
                'scientificCounts' => $scientificCounts,
                'userEvents' => $userEvents,
            ]);
        }
    } else {
        $this->to('/');
    }
    }

    public function index($param = null)
    {
    session_start();

    $role = $_SESSION['role'] ?? null;
    $degree = $_SESSION['degree'] ?? null;
    $user_id = $_SESSION['user_id'] ?? null;

    $userModel = new UserModel();
    $notificationsCount = $userModel->getChatNotificationsCount();
    $image_url = $userModel->getUserProfilePicture($user_id);
    $statusCounts = $userModel->getStatusCounts($user_id);
    $userEvents = $userModel->getUserEvents($user_id);

    $scientificCounts = [];
    $tables = ['maqola', 'patents', 'works', 'certificates'];

    foreach ($tables as $table) {
        $scientificCounts[$table] = 0;

        if (isset($statusCounts[$table])) {
            foreach ($statusCounts[$table] as $status => $count) {
                $scientificCounts[$table] += $count;
            }
        }
    }

    if ($role === "user" && !empty($degree)) {
        if ($param !== null) {
            $this->to('/user/dashboard');
        } else {
            $this->view('user/index', [
                'title' => 'PhD-DsC Hisobot Platformasi | Bosh sahifa',
                'notificationsCount' => $notificationsCount,
                'statusCounts' => $statusCounts,
                'image_url' => $image_url,
                'scientificCounts' => $scientificCounts,
                'userEvents' => $userEvents,
            ]);
        }
    } else {
        $this->to('/');
    }
    }

    public function portfolio()
    {
        session_start();
        $role = $_SESSION['role'] ?? null;
        $degree = $_SESSION['degree'] ?? null;
        $user_id = $_SESSION['user_id'] ?? null;

        $userModel = new UserModel();
        $notificationsCount = $userModel->getChatNotificationsCount();
        $mundarijaData = $userModel->getMundarijaData($user_id);
        $maqolalar = $userModel->getAllMaqolalar($user_id);
        $image_url = $userModel->getUserProfilePicture($user_id);
        $patents = $userModel->getAllPatents($user_id);
        $darsliklar = $userModel->getAllDarslik($user_id);
        $sertifikatlar = $userModel->getAllSertifikat($user_id);
        $statusCounts = $userModel->getStatusCounts($user_id);
        $userEvents = $userModel->getUserEvents($user_id);

        if ($role === "user" && !empty($degree)) {
            $this->view('user/portfolio', [
                'title' => 'PhD-DsC Hisobot Platformasi | Portfolio',
                'notificationsCount' => $notificationsCount,
                'mundarijaData' => $mundarijaData,
                'maqolalar' => $maqolalar,
                'image_url' => $image_url,
                'patents' => $patents,
                'darsliklar' => $darsliklar,
                'sertifikatlar' => $sertifikatlar,
                'userEvents' => $userEvents,
            ]);
        } else {
            $this->to('/');
        }
    }

    public function chat($param = null)
    {
        session_start();

        $role = $_SESSION['role'] ?? null;
        $degree = $_SESSION['degree'] ?? null;
        $user_id = $_SESSION['user_id'] ?? null;

        $userModel = new UserModel();
        $notificationsCount = $userModel->getChatNotificationsCount();
        $image_url = $userModel->getUserProfilePicture($user_id);
        $userEvents = $userModel->getUserEvents($user_id);

        if ($role === "user" && !empty($degree)) {
            if ($param !== null) {
                $this->to('/user/chat');
            } else {
                $this->view('user/chat', [
                    'title' => 'PhD-DsC Hisobot Platformasi | Admin bilan chat',
                    'notificationsCount' => $notificationsCount,
                    'image_url' => $image_url,
                    'userEvents' => $userEvents,
                ]);
            }
        } else {
            $this->to('/');
        }
    }

    public function login_history($param = null)
    {
        session_start();

        $role = $_SESSION['role'] ?? null;
        $degree = $_SESSION['degree'] ?? null;
        $user_id = $_SESSION['user_id'] ?? null;

        $userModel = new UserModel();
        $notificationsCount = $userModel->getChatNotificationsCount();
        $login_history = $userModel->getLoginHistory($user_id);
        $image_url = $userModel->getUserProfilePicture($user_id);
        $userEvents = $userModel->getUserEvents($user_id);

        if ($role === "user" && !empty($degree)) {
            if ($param !== null) {
                $this->to('/user/login-history');
            } else {
                $this->view('user/login-history', [
                    'title' => 'PhD-DsC Hisobot Platformasi | Kirish tarixi',
                    'login_history' => $login_history, 
                    'notificationsCount' => $notificationsCount,
                    'image_url' => $image_url,
                    'userEvents' => $userEvents,
                ]);
            }
        } else {
            $this->to('/');
        }
    }

    public function fetchChat()
        {
            session_start();
            header('Content-Type: application/json');

            $currentUserId = $_SESSION['user_id'] ?? null;
            $role = $_SESSION['role'] ?? null;

            if (!$currentUserId) {
                echo json_encode(['status' => 'error', 'message' => 'Siz tizimga kirmagansiz.']);
                return;
            }

            $chatModel = new ChatModel();

            try {
                $chats = $chatModel->fetchChats($currentUserId);
                
                if (empty($chats)) {
                    echo json_encode(['status' => 'error', 'message' => 'Xabarlar topilmadi.']);
                    return;
                }

                echo json_encode(['status' => 'success', 'data' => $chats, 'current_user_id' => $currentUserId]);

            } catch (\Exception $e) {
                $this->logError($e->getMessage());
                echo json_encode(['status' => 'error', 'message' => 'Xabarlarni o‘qishda xatolik yuz berdi.']);
            }
        }

        public function sendMessage()
        {
        session_start();
        $userId = $_SESSION['user_id'] ?? null;
        $message = trim($_POST['message'] ?? '');
        $recipientId = $_POST['message_for_user_id'] ?? 'admin';

        if (!$userId) {
            echo json_encode(['status' => 'error', 'message' => 'Siz tizimga kirmagansiz.']);
            return;
        }

        if (empty($message)) {
            echo json_encode(['status' => 'error', 'message' => 'Xabar bo‘sh bo‘lmasligi kerak.']);
            return;
        }

        $message = $this->filterMessage($message);
        $chatModel = new ChatModel();

            $recipientId = $chatModel->getAdminId();
            $chatModel->saveChat($userId, $message, $recipientId);

            echo json_encode(['status' => 'success', 'message' => 'Xabar muvaffaqiyatli yuborildi.']);
        }

        public function deleteMessage()
        {
        session_start();
        header('Content-Type: application/json');

        $currentUserId = $_SESSION['user_id'] ?? null;
        $id = $_POST['id'] ?? null;

        if (!$currentUserId) {
                echo json_encode(['status' => 'error', 'message' => 'Siz tizimga kirmagansiz.']);
                return;
        }

        if (!$currentUserId || !$id) {
            echo json_encode(['status' => 'error', 'message' => 'Ma‘lumot yetarli emas.']);
            return;
            exit();
        }

        $chatModel = new ChatModel();

        try {
            $result = $chatModel->deleteMessage($id, $currentUserId);
            if ($result) {
                echo json_encode(['status' => 'success', 'message' => 'Xabar o‘chirildi.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Xabarni o‘chirib bo‘lmaydi yoki mavjud emas.']);
            }
        } catch (\Exception $e) {
            $this->logError($e->getMessage());
            echo json_encode(['status' => 'error', 'message' => 'Xabarni o‘chirishda xatolik yuz berdi.']);
        }
    }
    
    public function saveFaoliyat()
{
    session_start();

    $role = $_SESSION['role'] ?? null;
    $degree = $_SESSION['degree'] ?? null;
    $user_id = $_SESSION['user_id'] ?? null;

    $userModel = new UserModel();
    $notificationsCount = $userModel->getChatNotificationsCount();
    $image_url = $userModel->getUserProfilePicture($user_id);
    $userEvents = $userModel->getUserEvents($user_id);

    if ($role === "user" && !empty($degree)) {
        $existingData = $userModel->getUserFaoliyatData($user_id);

        if ($existingData) {
            $this->view('user/portfolio', [
                'title' => 'PhD-DsC Hisobot Platformasi | Portfolio',
                'notificationsCount' => $notificationsCount,
                'image_url' => $image_url,
                'userEvents' => $userEvents,
                'errorMessage' => 'Siz oldin ma‘lumot kiritgansiz, ma‘lumotni admin orqali yangilashingiz mumkin.'
            ]);
            return;
        }

        $uploadDir = __DIR__ . "/../../assets/uploads/{$user_id}/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fields = [
            'fio', 'gender', 'birthplace', 'birthdate', 'residence', 'residenceStatus', 'passportNumber', 'pnifl', 
            'currentJob', 'position', 'bachelor', 'bachelorDiploma', 'bachelorDate', 'master', 'masterDiploma', 
            'masterDate', 'doctorateSpecialty', 'directionName', 'dissertationTopic', 'supervisorFio', 
            'supervisorWorkplace', 'supervisorDegree', 'supervisorTitle', 'admissionYear', 'stage', 'educationType', 
            'orderNumber', 'theoreticalProgramText', 'theoreticalProgramFile', 'individualPlanText', 'individualPlanFile', 
            'participationInCompetitions', 'academicFile', 'organizationSent', 'organizationReceived', 'country', 
            'startDate', 'endDate'
        ];

        $data = ['user_id' => $user_id];
        foreach ($fields as $field) {
            $data[$field] = isset($_POST[$field]) && trim($_POST[$field]) !== '' ? filter_var(trim($_POST[$field]), FILTER_SANITIZE_SPECIAL_CHARS) : null;
        }

        $allowedFileTypes = [
            'pdf' => 'application/pdf',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'xls' => 'application/vnd.ms-excel',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'ppt' => 'application/vnd.ms-powerpoint',
            'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation'
        ];

        $maxFileSize = 20 * 1024 * 1024;

        $fileFields = ['theoreticalProgramFile', 'individualPlanFile', 'academicFile', 'fileUpload'];

        foreach ($fileFields as $fileField) {
            if (isset($_FILES[$fileField]) && $_FILES[$fileField]['error'] === UPLOAD_ERR_OK) {
                $fileTmpName = $_FILES[$fileField]['tmp_name'];
                $fileName = $_FILES[$fileField]['name'];
                $fileSize = $_FILES[$fileField]['size'];
                $fileType = $_FILES[$fileField]['type'];

                $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                if (!array_key_exists($fileExt, $allowedFileTypes) || !in_array($fileType, $allowedFileTypes)) {
                    $this->view('user/portfolio', [
                        'title' => 'PhD-DsC Hisobot Platformasi | Portfolio',
                        'notificationsCount' => $notificationsCount,
                        'image_url' => $image_url,
                        'userEvents' => $userEvents,
                        'errorMessage' => 'Fayl turi noto‘g‘ri. Faqat PDF, Word, Excel yoki PowerPoint fayllari qabul qilinadi.'
                    ]);
                    return;
                }

                if ($fileSize > $maxFileSize) {
                    $this->view('user/portfolio', [
                        'title' => 'PhD-DsC Hisobot Platformasi | Portfolio',
                        'notificationsCount' => $notificationsCount,
                        'image_url' => $image_url,
                        'userEvents' => $userEvents,
                        'errorMessage' => 'Fayl hajmi 20MBdan oshmasligi kerak.'
                    ]);
                    return;
                }

                $filePath = $uploadDir . basename($fileName);
                if (move_uploaded_file($fileTmpName, $filePath)) {
                    $fileUrl = "assets/uploads/{$user_id}/" . basename($fileName);
                    $data[$fileField] = $fileUrl;
                } else {
                    $this->logError("Fayl saqlanmagan: " . $_FILES[$fileField]['name']);
                    $data[$fileField] = null;
                }
            } else {
                $this->logError("Fayl yuklanmagan yoki xatolik yuz berdi: " . ($_FILES[$fileField]['error'] ?? 'Not uploaded'));
                $data[$fileField] = null;
            }
        }

        $isSaved = $userModel->saveFaoliyatData($data);

        if ($isSaved) {
            $this->view('user/portfolio', [
                'title' => 'PhD-DsC Hisobot Platformasi | Portfolio',
                'notificationsCount' => $notificationsCount,
                'image_url' => $image_url,
                'userEvents' => $userEvents,
                'successMessage' => 'Ma‘lumotlaringiz muvaffaqiyatli saqlandi.'
            ]);
        } else {
            $this->view('user/portfolio', [
                'title' => 'PhD-DsC Hisobot Platformasi | Portfolio',
                'notificationsCount' => $notificationsCount,
                'image_url' => $image_url,
                'userEvents' => $userEvents,
                'errorMessage' => 'Ma‘lumotlar saqlanishda xatolik yuz berdi.'
            ]);
        }
    } else {
        $this->to('/');
    }
    }

    public function getMundarijaChartData()
    {
        $user_id = $_POST['user_id'] ?? null;

        if (!$user_id) {
            echo json_encode(['status' => 'error', 'message' => 'Siz tizimga kirmagansiz.']);
            return;
        }

        $userModel = new UserModel();
        $statistics = $userModel->getMundarijaStatistics($user_id);

        if ($statistics) {
            header('Content-Type: application/json');

            function randomColor() {
                return '#' . dechex(rand(0x000000, 0xFFFFFF));
            }

            $randomColors = [
                randomColor(),
                randomColor(),
                randomColor()
            ];

            $data = [
                'datasets' => [
                    [
                        'data' => [
                            $statistics['Tasdiqlandi'],
                            $statistics['kutilmoqda'],
                            $statistics['Rad etildi']
                        ],
                        'backgroundColor' => $randomColors,
                        'hoverBackgroundColor' => $randomColors,
                        'hoverBorderColor' => "rgba(234, 236, 244, 1)"
                    ]
                ],
                'labels' => [
                    "Bajarilgan ishlar", 
                    "Kutilayotgan ishlar", 
                    "Rad etilgan ishlar"
                ]
            ];

            echo json_encode([
                'chartData' => $data,
                'taskNames' => $statistics['task_names'],
                'educationType' => $statistics['education_type'],
                'stage' => $statistics['stage'],
                'totalTasks' => $statistics['total_tasks']
            ]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Ma‘lumotlar topilmadi']);
        }
    }

    public function saveMundarija()
    {
    session_start();

    $role = $_SESSION['role'] ?? null;
    $degree = $_SESSION['degree'] ?? null;
    $user_id = $_SESSION['user_id'] ?? null;

    $userModel = new UserModel();
    $notificationsCount = $userModel->getChatNotificationsCount();
    $image_url = $userModel->getUserProfilePicture($user_id);
    $userEvents = $userModel->getUserEvents($user_id);

    if ($role === "user" && !empty($degree)) {
        $uploadDir = __DIR__ . "/../../assets/uploads/{$user_id}/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $educationType = $_POST['educationType'] ?? null;
        $stage = $_POST['stage'] ?? null;
        $number = $_POST['number'] ?? null;
        $additionalWork = $_POST['additionalWork'] ?? null;
        $plannedWorks = $_POST['planned_works'] ?? [];
        $researcherTasks = $_POST['researcher_tasks'] ?? [];
        $plannedWorks = str_replace(['[', ']', '"'], '', $plannedWorks);
        $researcherTasks = str_replace(['[', ']', '"'], '', $researcherTasks);
        $file = $_FILES['fileUpload'] ?? null;

        $data = [
            'user_id' => $user_id,
            'educationType' => filter_var(trim(str_replace('_', ' ', $educationType)), FILTER_SANITIZE_SPECIAL_CHARS),
            'stage' => filter_var(trim($stage), FILTER_SANITIZE_SPECIAL_CHARS),
            'number' => filter_var(trim($number), FILTER_SANITIZE_NUMBER_INT),
            'additionalWork' => filter_var(trim($additionalWork), FILTER_SANITIZE_SPECIAL_CHARS),
            'plannedWorks' => $plannedWorks,
            'researcherTasks' => $researcherTasks
        ];

        $allowedFileTypes = [
            'pdf' => 'application/pdf',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'xls' => 'application/vnd.ms-excel',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'ppt' => 'application/vnd.ms-powerpoint',
            'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation'
        ];

        $maxFileSize = 20 * 1024 * 1024;

        if ($file && $file['error'] === UPLOAD_ERR_OK) {
            $fileTmpName = $file['tmp_name'];
            $fileName = $file['name'];
            $fileSize = $file['size'];
            $fileType = $file['type'];

            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            if (!array_key_exists($fileExt, $allowedFileTypes) || !in_array($fileType, $allowedFileTypes)) {
                $this->view('user/portfolio', [
                    'title' => 'PhD-DsC Hisobot Platformasi | Portfolio',
                    'notificationsCount' => $notificationsCount,
                    'image_url' => $image_url,
                    'userEvents' => $userEvents,
                    'errorMessage' => 'Fayl turi noto‘g‘ri. Faqat PDF, Word, Excel yoki PowerPoint fayllari qabul qilinadi.'
                ]);
                return;
            }

            if ($fileSize > $maxFileSize) {
                $this->view('user/portfolio', [
                    'title' => 'PhD-DsC Hisobot Platformasi | Portfolio',
                    'notificationsCount' => $notificationsCount,
                    'image_url' => $image_url,
                    'userEvents' => $userEvents,
                    'errorMessage' => 'Fayl hajmi 20MBdan oshmasligi kerak.'
                ]);
                return;
            }

            $filePath = $uploadDir . basename($fileName);
            if (move_uploaded_file($fileTmpName, $filePath)) {
                $fileUrl = "assets/uploads/{$user_id}/" . basename($fileName);
                $data['fileUpload'] = $fileUrl;
            } else {
                $this->logError("Fayl saqlanmagan: " . $file['name']);
                $data['fileUpload'] = null; 
            }
        } else {
            $data['fileUpload'] = null;
        }

        $isSaved = $userModel->saveMundarijaData($data);

        if ($isSaved) {
            $this->view('user/portfolio', [
                'title' => 'PhD-DsC Hisobot Platformasi | Portfolio',
                'notificationsCount' => $notificationsCount,
                'image_url' => $image_url,
                'userEvents' => $userEvents,
                'successMessage' => 'Mundarija muvaffaqiyatli saqlandi!'
            ]);
        } else {
            $this->view('user/portfolio', [
                'title' => 'PhD-DsC Hisobot Platformasi | Portfolio',
                'notificationsCount' => $notificationsCount,
                'image_url' => $image_url,
                'userEvents' => $userEvents,
                'errorMessage' => 'Mundarija saqlanishda xatolik yuz berdi.'
            ]);
        }
    } else {
        $this->to('/');
    }
    }

    public function deleteMundarija() {
    header('Content-Type: application/json');
    
    $id = $_POST['id'] ?? null;
    $userModel = new UserModel();
    $user_id = $_SESSION['user_id'] ?? null;

    if (!$user_id) {
        echo json_encode(['status' => 'error', 'message' => 'Siz tizimga kirmagansiz.']);
        return;
    }

    if ($id) {
        $mundarija = $userModel->getMundarijaById($id);
        if ($mundarija) {
            $file_path = $mundarija['file_url'];
            
            if (file_exists($file_path)) {
                unlink($file_path);
            }
            
            if ($userModel->deleteMundarija($id)) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Mundarija muvaffaqiyatli o‘chirildi va fayl serverdan o‘chirildi.'
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Mundarijani o‘chirishda xatolik yuz berdi.'
                ]);
            }
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Mundarija topilmadi.'
            ]);
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'ID ko‘rsatilmagan.'
        ]);
    }
    }

    public function saveMaqola()
    {
    session_start();

    $role = $_SESSION['role'] ?? null;
    $user_id = $_SESSION['user_id'] ?? null;

    $userModel = new UserModel();
    $notificationsCount = $userModel->getChatNotificationsCount();
    $image_url = $userModel->getUserProfilePicture($user_id);
    $userEvents = $userModel->getUserEvents($user_id);

    if ($role === "user" && $user_id) {
        $journalType = $_POST['journalType'] ?? null;
        $publishCountry = $_POST['publishCountry'] ?? null;
        $journalName = $_POST['journalName'] ?? null;
        $articleTitle = $_POST['articleTitle'] ?? null;
        $publishDate = $_POST['publishDate'] ?? null;
        $articleLink = $_POST['articleLink'] ?? null;
        $authorCount = $_POST['authorCountM'] ?? null;
        $authors = $_POST['authorsM'] ?? null;
        $articleFile = $_FILES['articleFile'] ?? null;

        if ($authorCount === '' || !is_numeric($authorCount)) {
            $authorCount = 0;
        }

        if ($journalType) {
            $journalType = str_replace('_', ' ', $journalType);
        }

        $data = [
            'user_id' => $user_id,
            'journalType' => filter_var(trim($journalType), FILTER_SANITIZE_SPECIAL_CHARS),
            'publishCountry' => filter_var(trim($publishCountry), FILTER_SANITIZE_SPECIAL_CHARS),
            'journalName' => filter_var(trim($journalName), FILTER_SANITIZE_SPECIAL_CHARS),
            'articleTitle' => filter_var(trim($articleTitle), FILTER_SANITIZE_SPECIAL_CHARS),
            'publishDate' => filter_var(trim($publishDate), FILTER_SANITIZE_NUMBER_INT),
            'articleLink' => filter_var(trim($articleLink), FILTER_SANITIZE_URL),
            'authorCount' => filter_var(trim($authorCount), FILTER_SANITIZE_NUMBER_INT),
            'authors' => filter_var(trim($authors), FILTER_SANITIZE_SPECIAL_CHARS)
        ];

        $allowedFileTypes = ['pdf' => 'application/pdf', 'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
        $maxFileSize = 20 * 1024 * 1024;

        if ($articleFile && $articleFile['error'] === UPLOAD_ERR_OK) {
            $fileTmpName = $articleFile['tmp_name'];
            $fileName = $articleFile['name'];
            $fileSize = $articleFile['size'];
            $fileType = $articleFile['type'];

            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            if (!array_key_exists($fileExt, $allowedFileTypes) || !in_array($fileType, $allowedFileTypes)) {
                $this->view('user/portfolio', [
                    'title' => 'PhD-DsC Hisobot Platformasi | Portfolio',
                    'notificationsCount' => $notificationsCount,
                    'image_url' => $image_url,
                    'userEvents' => $userEvents,
                    'errorMessage' => 'Fayl turi noto‘g‘ri. Faqat PDF yoki Word fayllari qabul qilinadi.'
                ]);
                return;
            }

            if ($fileSize > $maxFileSize) {
                $this->view('user/portfolio', [
                    'title' => 'PhD-DsC Hisobot Platformasi | Portfolio',
                    'notificationsCount' => $notificationsCount,
                    'image_url' => $image_url,
                    'userEvents' => $userEvents,
                    'errorMessage' => 'Fayl hajmi 20MBdan oshmasligi kerak.'
                ]);
                return;
            }

            $uploadDir = __DIR__ . "/../../assets/uploads/{$user_id}/";
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $filePath = $uploadDir . basename($fileName);
            if (move_uploaded_file($fileTmpName, $filePath)) {
                $data['articleFile'] = "assets/uploads/{$user_id}/" . basename($fileName);
            } else {
                $data['articleFile'] = null;
            }
        } else {
            $data['articleFile'] = null;
        }

        $isSaved = $userModel->saveMaqolaData($data);

        if ($isSaved) {
            $this->view('user/portfolio', [
                'title' => 'PhD-DsC Hisobot Platformasi | Portfolio',
                'notificationsCount' => $notificationsCount,
                'image_url' => $image_url,
                'userEvents' => $userEvents,
                'successMessage' => 'Maqola muvaffaqiyatli saqlandi!'
            ]);
        } else {
            $this->view('user/portfolio', [
                'title' => 'PhD-DsC Hisobot Platformasi | Portfolio',
                 'notificationsCount' => $notificationsCount,
                 'image_url' => $image_url,
                 'userEvents' => $userEvents,
                'errorMessage' => 'Maqola saqlanishda xatolik yuz berdi.'
            ]);
        }
    } else {
        $this->to('/');
    }
    }  

    public function deleteMaqola() {
    header('Content-Type: application/json');
    
    $id = $_POST['id'] ?? null;
    $userModel = new UserModel();
    $user_id = $_SESSION['user_id'] ?? null;

    if (!$user_id) {
        echo json_encode(['status' => 'error', 'message' => 'Siz tizimga kirmagansiz.']);
        return;
    }

    if ($id) {
        $maqola = $userModel->getMaqolaById($id);
        if ($maqola) {
            $file_path = $maqola['articleFile'];
            
            if (file_exists($file_path)) {
                unlink($file_path);
            }
            
            if ($userModel->deleteMaqola($id)) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Maqola muvaffaqiyatli o‘chirildi va fayl serverdan o‘chirildi.'
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Maqolani o‘chirishda xatolik yuz berdi.'
                ]);
            }
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Maqola topilmadi.'
            ]);
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'ID ko\'rsatilmagan.'
        ]);
    }
    }

    public function savePatent() {
    session_start();

    $role = $_SESSION['role'] ?? null;
    $user_id = $_SESSION['user_id'] ?? null;

    $userModel = new UserModel();
    $notificationsCount = $userModel->getChatNotificationsCount();
    $image_url = $userModel->getUserProfilePicture($user_id);
    $userEvents = $userModel->getUserEvents($user_id);

    if ($role === "user") {
        $patentType = $_POST['patentType'] ?? null;
        $intellectualPropertyName = $_POST['intellectualPropertyName'] ?? null;
        $intellectualPropertyNumber = $_POST['intellectualPropertyNumber'] ?? null;
        $patentDate = $_POST['patentDate'] ?? null;
        $authorCount = $_POST['authorCountP'] ?? null;
        $authors = $_POST['authorsP'] ?? null;
        $file = $_FILES['patentFile'] ?? null;

        $uploadDir = __DIR__ . "/../../assets/uploads/{$user_id}/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        if ($authorCount === '' || !is_numeric($authorCount)) {
            $authorCount = 0;
        }

        $allowedFileTypes = ['pdf' => 'application/pdf', 'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
        $maxFileSize = 20 * 1024 * 1024;

        $fileUrl = null;
        if ($file && $file['error'] === UPLOAD_ERR_OK) {
            $fileTmpName = $file['tmp_name'];
            $fileName = $file['name'];
            $fileSize = $file['size'];
            $fileType = $file['type'];

            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            if (!array_key_exists($fileExt, $allowedFileTypes) || !in_array($fileType, $allowedFileTypes)) {
                $this->view('user/portfolio', [
                    'title' => 'PhD-DsC Hisobot Platformasi | Portfolio',
                    'notificationsCount' => $notificationsCount,
                    'image_url' => $image_url,
                    'userEvents' => $userEvents,
                    'errorMessage' => 'Fayl turi noto‘g‘ri. Faqat PDF yoki DOCX fayllari qabul qilinadi.'
                ]);
                return;
            }

            if ($fileSize > $maxFileSize) {
                $this->view('user/portfolio', [
                    'title' => 'PhD-DsC Hisobot Platformasi | Portfolio',
                    'notificationsCount' => $notificationsCount,
                    'image_url' => $image_url,
                    'userEvents' => $userEvents,
                    'errorMessage' => 'Fayl hajmi 20MBdan oshmasligi kerak.'
                ]);
                return;
            }

            $filePath = $uploadDir . basename($fileName);
            if (move_uploaded_file($fileTmpName, $filePath)) {
                $fileUrl = "assets/uploads/{$user_id}/" . basename($fileName);
            } else {
                $this->logError("Fayl saqlanmagan: " . $file['name']);
            }
        }

        $data = [
            'user_id' => $user_id,
            'patent_type' => filter_var(trim($patentType), FILTER_SANITIZE_SPECIAL_CHARS),
            'intellectual_property_name' => filter_var(trim($intellectualPropertyName), FILTER_SANITIZE_SPECIAL_CHARS),
            'intellectual_property_number' => filter_var(trim($intellectualPropertyNumber), FILTER_SANITIZE_SPECIAL_CHARS),
            'patent_date' => $patentDate,
            'author_count' => filter_var(trim($authorCount), FILTER_SANITIZE_NUMBER_INT),
            'authors' => filter_var(trim($authors), FILTER_SANITIZE_SPECIAL_CHARS),
            'patent_file' => $fileUrl,
            'is_rejected' => 0,
            'rejected_text' => null
        ];

        $isSaved = $userModel->savePatentData($data);

        if ($isSaved) {
            $this->view('user/portfolio', [
                'title' => 'PhD-DsC Hisobot Platformasi | Portfolio',
                'notificationsCount' => $notificationsCount,
                'image_url' => $image_url,
                'userEvents' => $userEvents,
                'successMessage' => 'Patent ma‘lumotlari muvaffaqiyatli saqlandi!'
            ]);
        } else {
            $this->view('user/portfolio', [
                'title' => 'PhD-DsC Hisobot Platformasi | Portfolio',
                'notificationsCount' => $notificationsCount,
                'image_url' => $image_url,
                'userEvents' => $userEvents,
                'errorMessage' => 'Patent ma‘lumotlarini saqlanishda xatolik yuz berdi.'
            ]);
        }
    } else {
        $this->to('/');
    }
    }

    public function deletePatent() {
    header('Content-Type: application/json');
    
    $id = $_POST['id'] ?? null;
    $userModel = new UserModel();
    $user_id = $_SESSION['user_id'] ?? null;

    if (!$user_id) {
        echo json_encode(['status' => 'error', 'message' => 'Siz tizimga kirmagansiz.']);
        return;
    }

    if ($id) {
        $patent = $userModel->getPatentById($id);
        if ($patent) {
            $file_path = $patent['patent_file'];

            if (file_exists($file_path)) {
                unlink($file_path);
            }
            
            if ($userModel->deletePatent($id)) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Yozuv muvaffaqiyatli o‘chirildi va fayl serverdan o‘chirildi.'
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Yozuvni o‘chirishda xatolik yuz berdi.'
                ]);
            }
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Patent topilmadi.'
            ]);
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'ID ko‘rsatilmagan.'
        ]);
    }
    }

    public function saveDarslik() {
    session_start();

    $role = $_SESSION['role'] ?? null;
    $user_id = $_SESSION['user_id'] ?? null;

    $userModel = new UserModel();
    $notificationsCount = $userModel->getChatNotificationsCount();
    $image_url = $userModel->getUserProfilePicture($user_id);
    $userEvents = $userModel->getUserEvents($user_id);

    if ($role === "user") {
        $workType = $_POST['workType'] ?? null;
        $workName = $_POST['workName'] ?? null;
        $certificateNumber = $_POST['certificateNumber'] ?? null;
        $workDate = $_POST['workDate'] ?? null;
        $authorCount = $_POST['authorCountD'] ?? null;
        $authors = $_POST['authorsD'] ?? null;
        $file = $_FILES['workFile'] ?? null;

        $uploadDir = __DIR__ . "/../../assets/uploads/{$user_id}/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        if ($authorCount === '' || !is_numeric($authorCount)) {
            $authorCount = 0;
        }
        
        $allowedFileTypes = ['pdf' => 'application/pdf', 'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
        $maxFileSize = 20 * 1024 * 1024;

        $fileUrl = null;
        if ($file && $file['error'] === UPLOAD_ERR_OK) {
            $fileTmpName = $file['tmp_name'];
            $fileName = $file['name'];
            $fileSize = $file['size'];
            $fileType = $file['type'];

            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            if (!array_key_exists($fileExt, $allowedFileTypes) || !in_array($fileType, $allowedFileTypes)) {
                $this->view('user/portfolio', [
                    'title' => 'PhD-DsC Hisobot Platformasi | Portfolio',
                    'notificationsCount' => $notificationsCount,
                    'image_url' => $image_url,
                    'userEvents' => $userEvents,
                    'errorMessage' => 'Fayl turi noto‘g‘ri. Faqat PDF yoki DOCX fayllari qabul qilinadi.'
                ]);
                return;
            }

            if ($fileSize > $maxFileSize) {
                $this->view('user/portfolio', [
                    'title' => 'PhD-DsC Hisobot Platformasi | Portfolio',
                    'notificationsCount' => $notificationsCount,
                    'image_url' => $image_url,
                    'userEvents' => $userEvents,
                    'errorMessage' => 'Fayl hajmi 20MBdan oshmasligi kerak.'
                ]);
                return;
            }

            $filePath = $uploadDir . basename($fileName);
            if (move_uploaded_file($fileTmpName, $filePath)) {
                $fileUrl = "assets/uploads/{$user_id}/" . basename($fileName);
            } else {
                $this->logError("Fayl saqlanmagan: " . $file['name']);
            }
        }

        $data = [
            'user_id' => $user_id,
            'work_type' => filter_var(trim($workType), FILTER_SANITIZE_SPECIAL_CHARS),
            'work_name' => filter_var(trim($workName), FILTER_SANITIZE_SPECIAL_CHARS),
            'certificate_number' => filter_var(trim($certificateNumber), FILTER_SANITIZE_SPECIAL_CHARS),
            'work_date' => $workDate,
            'author_count' => filter_var(trim($authorCount), FILTER_SANITIZE_NUMBER_INT),
            'authors' => filter_var(trim($authors), FILTER_SANITIZE_SPECIAL_CHARS),
            'file_name' => $fileUrl,
            'status' => 'Kutilmoqda', 
            'rejected_text' => null, 
        ];

        $isSaved = $userModel->saveDarslikData($data);

        if ($isSaved) {
            $this->view('user/portfolio', [
                'title' => 'PhD-DsC Hisobot Platformasi | Portfolio',
                'notificationsCount' => $notificationsCount,
                'image_url' => $image_url,
                'userEvents' => $userEvents,
                'successMessage' => 'Darslik ma‘lumotlari muvaffaqiyatli saqlandi!'
            ]);
        } else {
            $this->view('user/portfolio', [
                'title' => 'PhD-DsC Hisobot Platformasi | Portfolio',
                'notificationsCount' => $notificationsCount,
                'image_url' => $image_url,
                'userEvents' => $userEvents,
                'errorMessage' => 'Darslik ma‘lumotlarini saqlanishda xatolik yuz berdi.'
            ]);
        }
    } else {
        $this->to('/');
    }
    }

    public function deleteDarslik() {
    header('Content-Type: application/json');
    
    $id = $_POST['id'] ?? null;
    $userModel = new UserModel();
    $user_id = $_SESSION['user_id'] ?? null;

    if (!$user_id) {
        echo json_encode(['status' => 'error', 'message' => 'Siz tizimga kirmagansiz.']);
        return;
    }

    if ($id) {
        $work = $userModel->getDarslikById($id, $user_id);
        
        if ($work) {
            $file_path = $work['file_name'];

            if (file_exists($file_path)) {
                unlink($file_path);
            }

            if ($userModel->deleteDarslik($id)) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Ishlanma muvaffaqiyatli o‘chirildi va fayl serverdan o‘chirildi.'
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Ishlanmani o‘chirishda xatolik yuz berdi.'
                ]);
            }
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Ishlanma topilmadi.'
            ]);
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'ID ko‘rsatilmagan.'
        ]);
    }
    }

    public function saveSertifikat() {
    session_start();

    $role = $_SESSION['role'] ?? null;
    $user_id = $_SESSION['user_id'] ?? null;

    $userModel = new UserModel();
    $notificationsCount = $userModel->getChatNotificationsCount();
    $image_url = $userModel->getUserProfilePicture($user_id);
    $userEvents = $userModel->getUserEvents($user_id);

    if ($role === "user") {
        $certificateType = $_POST['certificateType'] ?? null;
        $languageName = $_POST['languageName'] ?? null;
        $languageLevel = $_POST['languageLevel'] ?? null;
        $certificateDate = $_POST['certificateDate'] ?? null;
        $status = 'Kutilmoqda';
        $file = $_FILES['certificateFile'] ?? null;

        $uploadDir = __DIR__ . "/../../assets/uploads/{$user_id}/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $allowedFileTypes = ['pdf' => 'application/pdf', 'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
        $maxFileSize = 20 * 1024 * 1024;

        $fileUrl = null;
        if ($file && $file['error'] === UPLOAD_ERR_OK) {
            $fileTmpName = $file['tmp_name'];
            $fileName = $file['name'];
            $fileSize = $file['size'];
            $fileType = $file['type'];

            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            if (!array_key_exists($fileExt, $allowedFileTypes) || !in_array($fileType, $allowedFileTypes)) {
                $this->view('user/portfolio', [
                    'title' => 'PhD-DsC Hisobot Platformasi | Portfolio',
                    'notificationsCount' => $notificationsCount,
                    'image_url' => $image_url,
                    'userEvents' => $userEvents,
                    'errorMessage' => 'Fayl turi noto‘g‘ri. Faqat PDF yoki DOCX fayllari qabul qilinadi.'
                ]);
                return;
            }

            if ($fileSize > $maxFileSize) {
                $this->view('user/portfolio', [
                    'title' => 'PhD-DsC Hisobot Platformasi | Portfolio',
                    'notificationsCount' => $notificationsCount,
                    'image_url' => $image_url,
                    'userEvents' => $userEvents,
                    'errorMessage' => 'Fayl hajmi 20MBdan oshmasligi kerak.'
                ]);
                return;
            }

            $filePath = $uploadDir . basename($fileName);
            if (move_uploaded_file($fileTmpName, $filePath)) {
                $fileUrl = "assets/uploads/{$user_id}/" . basename($fileName);
            } else {
                $this->logError("Fayl saqlanmagan: " . $file['name']);
            }
        }

        $data = [
            'user_id' => $user_id,
            'certificate_type' => filter_var(trim($certificateType), FILTER_SANITIZE_SPECIAL_CHARS),
            'language_name' => filter_var(trim($languageName), FILTER_SANITIZE_SPECIAL_CHARS),
            'language_level' => filter_var(trim($languageLevel), FILTER_SANITIZE_SPECIAL_CHARS),
            'certificate_date' => $certificateDate,
            'certificate_file' => $fileUrl,
            'status' => $status,
            'is_rejected' => 0,
            'rejected_text' => null,
        ];

        $isSaved = $userModel->saveSertifikatData($data);

        if ($isSaved) {
            $this->view('user/portfolio', [
                'title' => 'PhD-DsC Hisobot Platformasi | Portfolio',
                'notificationsCount' => $notificationsCount,
                'image_url' => $image_url,
                'userEvents' => $userEvents,
                'successMessage' => 'Sertifikat ma‘lumotlari muvaffaqiyatli saqlandi!'
            ]);
        } else {
            $this->view('user/portfolio', [
                'title' => 'PhD-DsC Hisobot Platformasi | Portfolio',
                'notificationsCount' => $notificationsCount,
                'image_url' => $image_url,
                'userEvents' => $userEvents,
                'errorMessage' => 'Sertifikat ma‘lumotlarini saqlanishda xatolik yuz berdi.'
            ]);
        }
    } else {
        $this->to('/');
    }
    }

    public function deleteSertifikat() {
    header('Content-Type: application/json');

    $id = $_POST['id'] ?? null;
    $userModel = new UserModel();
    $user_id = $_SESSION['user_id'] ?? null;

    if (!$user_id) {
        echo json_encode(['status' => 'error', 'message' => 'Siz tizimga kirmagansiz.']);
        return;
    }

    if ($id) {
        $sertifikat = $userModel->getSertifikatById($id, $user_id);

        if ($sertifikat) {
            $file_path = $sertifikat['certificate_file'];

            if (file_exists($file_path)) {
                unlink($file_path);
            }

            if ($userModel->deleteSertifikat($id)) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Sertifikat muvaffaqiyatli o‘chirildi va fayl serverdan o‘chirildi.'
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Sertifikatni o‘chirishda xatolik yuz berdi.'
                ]);
            }
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Sertifikat topilmadi.'
            ]);
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'ID ko‘rsatilmagan.'
        ]);
    }
    }

    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();

        $this->view('home/index', [
            'logoutMessage' => 'Siz tizimdan chiqdingiz!'
        ]);
    }
}
?>