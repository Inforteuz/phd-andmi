<?php

namespace App\Controllers;

use App\Models\ChatModel;
use App\Models\AdminModel;
use App\Models\UserModel;
use System\BaseController;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use DateTime;

class AdminController extends BaseController
{
    public function dashboard()
    {
        session_start();
        $role = $_SESSION['role'] ?? null;
        $user_id = $_SESSION['user_id'] ?? null;
        
        $adminModel = new AdminModel();
        $userModel = new UserModel();
        $image_url = $adminModel->getUserProfilePicture($user_id);
        $notificationsCount = $userModel->getChatNotificationsCount();
        $documentCounts = $adminModel->getAllDocumentsCount(); 
        $totalUsers = $adminModel->countUsers();

        $statusCounts = [
            'tasdiqlandi' => [
                'mundarija' => $adminModel->countStatus('mundarija', 'Tasdiqlandi'),
                'maqola' => $adminModel->countStatus('maqola', 'Tasdiqlandi'),
                'patents' => $adminModel->countStatus('patents', 'Tasdiqlandi'),
                'works' => $adminModel->countStatus('works', 'Tasdiqlandi'),
                'certificates' => $adminModel->countStatus('certificates', 'Tasdiqlandi')
            ],
            'kutilmoqda' => [
                'mundarija' => $adminModel->countStatus('mundarija', 'Kutilmoqda'),
                'maqola' => $adminModel->countStatus('maqola', 'Kutilmoqda'),
                'patents' => $adminModel->countStatus('patents', 'Kutilmoqda'),
                'works' => $adminModel->countStatus('works', 'Kutilmoqda'),
                'certificates' => $adminModel->countStatus('certificates', 'Kutilmoqda')
            ],
            'raddetildi' => [
                'mundarija' => $adminModel->countStatus('mundarija', 'Rad etildi'),
                'maqola' => $adminModel->countStatus('maqola', 'Rad etildi'),
                'patents' => $adminModel->countStatus('patents', 'Rad etildi'),
                'works' => $adminModel->countStatus('works', 'Rad etildi'),
                'certificates' => $adminModel->countStatus('certificates', 'Rad etildi')
            ]
        ];

        $uploadedFiles = $adminModel->countUploadedFiles();

        if ($role === 'superadmin' || $role === 'admin') {
            $this->view('admin/index', [
                'image_url' => $image_url,
                'totalUsers' => $totalUsers,
                'notificationsCount' => $notificationsCount,
                'uploadedFiles' => $uploadedFiles,
                'statusCounts' => $statusCounts,
                'documentCounts' => $documentCounts,
            ]);
        } elseif ($role === 'user') {
            $this->view('user/index');
        } else {
            $this->to('/');
        }
    }

    public function index()
    {
        session_start();
        $role = $_SESSION['role'] ?? null;
        $user_id = $_SESSION['user_id'] ?? null;
        
        $adminModel = new AdminModel();
        $userModel = new UserModel();
        $image_url = $adminModel->getUserProfilePicture($user_id);
        $notificationsCount = $userModel->getChatNotificationsCount();
        $totalUsers = $adminModel->countUsers();
        $documentCounts = $adminModel->getAllDocumentsCount(); 

        $statusCounts = [
            'tasdiqlandi' => [
                'mundarija' => $adminModel->countStatus('mundarija', 'Tasdiqlandi'),
                'maqola' => $adminModel->countStatus('maqola', 'Tasdiqlandi'),
                'patents' => $adminModel->countStatus('patents', 'Tasdiqlandi'),
                'works' => $adminModel->countStatus('works', 'Tasdiqlandi'),
                'certificates' => $adminModel->countStatus('certificates', 'Tasdiqlandi')
            ],
            'kutilmoqda' => [
                'mundarija' => $adminModel->countStatus('mundarija', 'Kutilmoqda'),
                'maqola' => $adminModel->countStatus('maqola', 'Kutilmoqda'),
                'patents' => $adminModel->countStatus('patents', 'Kutilmoqda'),
                'works' => $adminModel->countStatus('works', 'Kutilmoqda'),
                'certificates' => $adminModel->countStatus('certificates', 'Kutilmoqda')
            ],
            'raddetildi' => [
                'mundarija' => $adminModel->countStatus('mundarija', 'Rad etildi'),
                'maqola' => $adminModel->countStatus('maqola', 'Rad etildi'),
                'patents' => $adminModel->countStatus('patents', 'Rad etildi'),
                'works' => $adminModel->countStatus('works', 'Rad etildi'),
                'certificates' => $adminModel->countStatus('certificates', 'Rad etildi')
            ]
        ];

        $uploadedFiles = $adminModel->countUploadedFiles();

        if ($role === 'superadmin' || $role === 'admin') {
            $this->view('admin/index', [
                'image_url' => $image_url,
                'totalUsers' => $totalUsers,
                'uploadedFiles' => $uploadedFiles,
                'notificationsCount' => $notificationsCount,
                'statusCounts' => $statusCounts,
                'documentCounts' => $documentCounts,
            ]);
        } elseif ($role === 'user') {
            $this->view('user/index');
        } else {
            $this->to('/');
        }
    }

    public function login_history($param = null)
    {
        session_start();
        $role = $_SESSION["role"] ?? null;
        $degree = $_SESSION["degree"] ?? null;
        $user_id = $_SESSION["user_id"] ?? null;

        if (($role !== "admin" && empty($degree)) || ($role !== "superadmin" && empty($degree))) {
            $this->to("/");
            return;
        }

        $adminModel = new AdminModel();
        $userModel = new UserModel();
        $login_history = $adminModel->getLoginHistory($user_id);
        $image_url = $adminModel->getUserProfilePicture($user_id);
        $notificationsCount = $userModel->getChatNotificationsCount();
        $documentCounts = $adminModel->getAllDocumentsCount();

        if ($param !== null) {
            $this->to("/admin/login-history");
        } else {
            $this->view("admin/login-history", [
                "title" => "PhD-DsC Hisobot Platformasi | Kirish tarixi",
                "login_history" => $login_history,
                'notificationsCount' => $notificationsCount,
                "image_url" => $image_url,
                "documentCounts" => $documentCounts,
            ]);
        }
    }

    public function chat_with_users()
    {
        session_start();
        $role = $_SESSION["role"] ?? null;
        $user_id = $_SESSION["user_id"] ?? null;

        if (!in_array($role, ["superadmin", "admin"])) {
            $this->to("/");
            return;
        }

        $adminModel = new AdminModel();
        $userModel = new UserModel();
        $image_url = $adminModel->getUserProfilePicture($user_id);
        $notificationsCount = $userModel->getChatNotificationsCount();
        $documentCounts = $adminModel->getAllDocumentsCount();
        $chatModel = new ChatModel();
        $users = $chatModel->getUsers();

        $this->view("admin/chat-with-users", [
            "users" => $users,
            "notificationsCount" => $notificationsCount,
            "image_url" => $image_url,
            "documentCounts" => $documentCounts,
        ]);
    }

    public function send_message()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $user_id = $data["user_id"] ?? null;
        $message = $data["message"] ?? null;
        $admin_id = $_SESSION["user_id"] ?? null;

        if (empty($user_id) || empty($message)) {
            echo json_encode([
                "status" => "error",
                "message" =>
                    'Foydalanuvchi yoki xabar bo’sh bo’lishi mumkin emas',
            ]);
            return;
        }

        try {
            $chatModel = new ChatModel();
            $chatModel->saveChat($admin_id, $message, $user_id);
            echo json_encode(["status" => "success"]);
        } catch (\Exception $e) {
            echo json_encode([
                "status" => "error",
                "message" => $e->getMessage(),
            ]);
        }
    }

    public function delete_message()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $message_id = $data["message_id"] ?? null;
        $admin_id = $data["admin_id"] ?? null;

        if (empty($message_id) || empty($admin_id)) {
            echo json_encode([
                "status" => "error",
                "message" => "Xabar ID yoki admin ID kiritilmagan",
            ]);
            return;
        }

        try {
            $chatModel = new ChatModel();
            $isDeleted = $chatModel->deleteMessage($message_id, $admin_id);

            if ($isDeleted) {
                echo json_encode(["status" => "success"]);
            } else {
                echo json_encode([
                    "status" => "error",
                    "message" => 'Xabarni o’chirishda xato yuz berdi',
                ]);
            }
        } catch (\Exception $e) {
            echo json_encode([
                "status" => "error",
                "message" => $e->getMessage(),
            ]);
        }
    }

    public function fetch_chat($userId)
    {
        if (empty($userId)) {
            echo json_encode([
                "status" => "error",
                "message" => "Foydalanuvchi ID kiritilmagan",
            ]);
            return;
        }

        try {
            $chatModel = new ChatModel();
            $chats = $chatModel->fetchsChat($userId);
            echo json_encode(["status" => "success", "chats" => $chats]);
        } catch (\Exception $e) {
            echo json_encode([
                "status" => "error",
                "message" => $e->getMessage(),
            ]);
        }
    }

    public function fetch_users()
    {
        session_start();
        $role = $_SESSION["role"] ?? null;

        if (!in_array($role, ["superadmin", "admin"])) {
            echo json_encode([
                "status" => "error",
                "message" => 'Ruxsat yo’q',
            ]);
            return;
        }

        $chatModel = new ChatModel();
        $users = $chatModel->getUsers();

        echo json_encode(["status" => "success", "users" => $users]);
    }

    public function add_events() {
    session_start();
    $role = $_SESSION['role'] ?? null;
    $user_id = $_SESSION['user_id'] ?? null;

    if (!in_array($role, ['superadmin', 'admin'])) {
        $this->to('/');
        return;
    }

    $adminModel = new AdminModel();
    $userModel = new UserModel();
    $events = $adminModel->getEvents();
    $image_url = $adminModel->getUserProfilePicture($user_id);
    $notificationsCount = $userModel->getChatNotificationsCount();
    $documentCounts = $adminModel->getAllDocumentsCount();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = $_POST['title'] ?? null;
        $description = $_POST['description'] ?? null;
        $event_date = $_POST['event_date'] ?? null;
        $user = $_POST['user'] ?? 'all';

        if ($event_date) {
            $event_date = DateTime::createFromFormat('Y-m-d\TH:i', $event_date);
            if (!$event_date) {
                echo json_encode(['status' => 'error', 'message' => 'Sanani to’g’ri formatda kiriting.']);
                return;
            }
            $event_date = $event_date->format('Y-m-d H:i:s');
        }

        if (!$title || !$event_date) {
            echo json_encode(['status' => 'error', 'message' => 'Tadbir nomi va sanasi talab qilinadi.']);
            return;
        }

        if ($user !== 'all' && $user !== 'Barcha foydalanuvchilarga') {
            $user = $adminModel->getUserIdByLogin($user);
            if (!$user) {
                echo json_encode(['status' => 'error', 'message' => 'Foydalanuvchi topilmadi.']);
                return;
            }
        } else {
            $user = 'all';
        }

        try {
            $adminModel->addEvent($title, $description, $event_date, $user);
            echo json_encode(['status' => 'success', 'message' => 'Tadbir muvaffaqiyatli qo’shildi.']);
        } catch (\Exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'Tadbirni qo’shishda xato yuz berdi: ' . $e->getMessage()]);
        }
    } else {
        $this->view('admin/add-events', [
            'title' => "PhD-DsC Hisobot Platformasi | Tadbir qo'shish",
            'events' => $events,
            'notificationsCount' => $notificationsCount,
            'image_url' => $image_url,
            'documentCounts' => $documentCounts,
        ]);
    }
    }

    public function update_event() {
    session_start();
    $role = $_SESSION['role'] ?? null;

    if (!in_array($role, ['superadmin', 'admin'])) {
        $this->to('/');
        return;
    }

    $adminModel = new AdminModel();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'] ?? null;
        $title = $_POST['title'] ?? null;
        $description = $_POST['description'] ?? null;
        $event_date = $_POST['event_date'] ?? null;
        $user = $_POST['user'] ?? 'all';

        if (!$title || !$event_date || !$id) {
            echo json_encode(['status' => 'error', 'message' => 'Tadbir nomi, sanasi va ID talab qilinadi.']);
            return;
        }

        try {
            $event_date = DateTime::createFromFormat('Y-m-d\TH:i', $event_date)->format('Y-m-d H:i:s');
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'Sanani to‘g‘ri formatda kiriting.']);
            return;
        }

        if ($user !== 'all' && $user !== 'Barcha foydalanuvchilarga') {
            $user = $adminModel->getUserIdByLogin($user);
            if (!$user) {
                echo json_encode(['status' => 'error', 'message' => 'Foydalanuvchi topilmadi.']);
                return;
            }
        } else {
            $user = 'all';
        }

        try {
            $adminModel->updateEvent($id, $title, $description, $event_date, $user);
            echo json_encode(['status' => 'success', 'message' => 'Tadbir muvaffaqiyatli yangilandi.']);
        } catch (\Exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'Tadbirni yangilashda xato yuz berdi: ' . $e->getMessage()]);
        }
    }
    }

    public function delete_event() {
        session_start();
        $role = $_SESSION['role'] ?? null;

        if (!in_array($role, ['superadmin', 'admin'])) {
            $this->to('/');
            return;
        }

        $adminModel = new AdminModel();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;

            if (!$id) {
                echo json_encode(['status' => 'error', 'message' => 'ID talab qilinadi.']);
                return;
            }

            try {
                $adminModel->deleteEvent($id);
                echo json_encode(['status' => 'success', 'message' => 'Tadbir muvaffaqiyatli o’chirildi.']);
            } catch (\Exception $e) {
                echo json_encode(['status' => 'error', 'message' => 'Tadbirni o’chirishda xato yuz berdi: ' . $e->getMessage()]);
            }
        }
    }

    public function get_event_details() {
        $adminModel = new AdminModel();
        $id = $_GET['id'] ?? null;
        if ($id) {
            $event = $adminModel->getEventDetails($id);
            echo json_encode(['status' => 'success', 'event' => $event]);
        }
    }

    public function users_management() {
    session_start();
    $role = $_SESSION['role'] ?? null;
    $user_id = $_SESSION['user_id'] ?? null;

    $adminModel = new AdminModel();
    $userModel = new UserModel();
    $users = $adminModel->getAllUsers();
    $image_url = $adminModel->getUserProfilePicture($user_id);
    $notificationsCount = $userModel->getChatNotificationsCount();
    $documentCounts = $adminModel->getAllDocumentsCount();

    if (!in_array($role, ['superadmin', 'admin'])) {
        $this->to('/');
        return;
    }

    $this->view("admin/users-management", [
            'title' => "PhD-DsC Hisobot Platformasi | Foydalanuvchilarni boshqarish",
            'notificationsCount' => $notificationsCount,
            'image_url' => $image_url,
            'users' => $users,
            'documentCounts' => $documentCounts,
        ]);
    }

    public function save_user() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user_id = $this->generateUserId();
        $fullname = $_POST['fullname'] ?? null;
        $middlename = $_POST['middlename'] ?? null;
        $degree = $_POST['educationType'] ?? null;
        $login = $_POST['login'] ?? null;
        $password = $_POST['password'] ?? null;
        $gender = $_POST['gender'] ?? null;
        $passportSeries = $_POST['passportSeries'] ?? null;
        $pnifl = $_POST['pnifl'] ?? null;
        $speciality_name = $_POST['specialtyName'] ?? null;
        $speciality_number = $_POST['specialtyNumber'] ?? null;
        $role = $_POST['role'] ?? 'user';

        $adminModel = new AdminModel();
        $image_url = null;

        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = "assets/uploads/{$user_id}/";
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $imageName = basename($_FILES['photo']['name']);
            $targetFile = $uploadDir . $imageName;

            if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetFile)) {
                $image_url = $targetFile;
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Rasmni yuklashda xatolik yuz berdi']);
                return;
            }
        }

        try {
            $adminModel->addUser(
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
                $image_url
            );
            echo json_encode(['status' => 'success', 'message' => 'Foydalanuvchi muvaffaqiyatli qo‘shildi']);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'Foydalanuvchini qo‘shishda xatolik yuz berdi']);
        }
    }
    }

    public function get_user() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
        $user_id = $_POST['id'];
        $userid = $_SESSION['user_id'];

        $adminModel = new AdminModel();

        if (empty($userid)) {
                echo json_encode(['status' => 'error', 'message' => 'Siz tizimga kirmagansiz.']);
                return;
        }

        try {
            $user = $adminModel->getUser($user_id);
            
            if ($user) {
                echo json_encode([
                    'success' => true,
                    'data' => $user
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Foydalanuvchi topilmadi'
                ]);
            }
        } catch (\Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Xatolik yuz berdi: ' . $e->getMessage()
            ]);
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Noto’g’ri so’rov'
        ]);
    }
    }

    public function update_user() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user_id = $_POST['user_id'];
        $fullname = $_POST['editFio'] ?? null;
        $middlename = $_POST['editMiddlename'] ?? null;
        $login = $_POST['editLogin'] ?? null;
        $password = $_POST['editPassword'] ?? null;
        $gender = $_POST['editGender'] ?? null;
        $passportSeries = $_POST['editPassportSeries'] ?? null;
        $pnifl = $_POST['editPnifl'] ?? null;
        $speciality_name = $_POST['editSpecialtyName'] ?? null;
        $speciality_number = $_POST['editSpecialtyNumber'] ?? null;
        $degree = $_POST['editEducationType'] ?? null;
        $role = $_POST['role'] ?? 'user';
        $status = $_POST['editAccountStatus'] ?? 'active';
        $image_url = $_POST['image_url'] ?? null;

        if ($degree === "Administrator") {
            $role = "superadmin";
        }

        $adminModel = new AdminModel();

        try {
            if (isset($_FILES['editPhoto']) && $_FILES['editPhoto']['error'] == 0) {
                $uploadDir = "assets/uploads/{$user_id}/";
                $image_url = $this->uploadImage($_FILES['editPhoto'], $uploadDir);
            }

            if (empty($image_url)) {
                $image_url = 'assets/img/person.png';
            }

            if (!empty($password) && !preg_match('/^\$2y\$/', $password)) {
                $password = password_hash($password, PASSWORD_DEFAULT);
            }

            $updated = $adminModel->updateUser(
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
                $status,
                $image_url
            );

            if ($updated) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Foydalanuvchi ma’lumotlari muvaffaqiyatli yangilandi.'
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Foydalanuvchi ma’lumotlarini yangilashda xatolik yuz berdi.'
                ]);
            }
        } catch (\Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Xatolik yuz berdi: ' . $e->getMessage()
            ]);

        }
    }
    }

    private function uploadImage($file, $uploadDir) {
        $uploadPath = $uploadDir . basename($file['name']);
        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            return $uploadPath;
        }
        return null;
    }

    public function delete_user() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
        $user_id = $_POST['id'];

        $adminModel = new AdminModel();

        try {
            $deleted = $adminModel->deleteUser($user_id);

            if ($deleted) {
                $userFolderPath = 'assets/uploads/' . $user_id;
                if (is_dir($userFolderPath)) {
                    $this->deleteUserFolder($userFolderPath);
                }

                echo json_encode([
                    'success' => true,
                    'message' => 'Foydalanuvchi muvaffaqiyatli o’chirildi.'
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Foydalanuvchini o’chirishda xatolik yuz berdi.'
                ]);
            }
        } catch (\Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Xatolik yuz berdi: ' . $e->getMessage()
            ]);
        }
    }
    }

    private function deleteUserFolder($folderPath) {
    if (is_dir($folderPath)) {
        $files = array_diff(scandir($folderPath), array('.', '..'));
        foreach ($files as $file) {
            $filePath = $folderPath . DIRECTORY_SEPARATOR . $file;
            if (is_dir($filePath)) {
                $this->deleteUserFolder($filePath);
            } else {
                unlink($filePath);
            }
        }
        rmdir($folderPath);
    }
    }

    public function export_users_to_excel() {

    $adminModel = new AdminModel();
    $users = $adminModel->getAllUsers();

    if (empty($users)) {
        echo 'Eksport qilinadigan foydalanuvchilar topilmadi.';
        exit();
    }

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $sheet->setCellValue('A1', 'ID')
          ->setCellValue('B1', 'Platforma IDsi')
          ->setCellValue('C1', 'Login')
          ->setCellValue('D1', 'FIO')
          ->setCellValue('E1', 'Otasining ismi')
          ->setCellValue('F1', 'Jinsi')
          ->setCellValue('G1', 'Ta’lim turi')
          ->setCellValue('H1', 'Ixtisosligi raqami')
          ->setCellValue('I1', 'Ixtisosligi nomi')
          ->setCellValue('J1', 'Pasport seriya va raqami')
          ->setCellValue('K1', 'PNIFL')
          ->setCellValue('L1', 'Akkaunt statusi');

    $headerStyle = [
        'font' => [
            'bold' => true,
            'color' => ['argb' => 'FFFFFF'],
            'size' => 12,
            'name' => 'Arial'
        ],
        'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
        ],
        'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'startColor' => ['argb' => '4F81BD']
        ],
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => ['argb' => '000000']
            ]
        ]
    ];

    $sheet->getStyle('A1:L1')->applyFromArray($headerStyle);

    $row = 2;
    foreach ($users as $user) {
        $sheet->setCellValue("A{$row}", $user['id'])
              ->setCellValue("B{$row}", $user['user_id'])
              ->setCellValue("C{$row}", $user['login'])
              ->setCellValue("D{$row}", $user['fullname'])
              ->setCellValue("E{$row}", $user['middlename']) 
              ->setCellValue("F{$row}", $user['gender'])
              ->setCellValue("G{$row}", $user['degree']) 
              ->setCellValue("H{$row}", $user['speciality_number'] ?? '')
              ->setCellValue("I{$row}", $user['speciality_name'] ?? '')
              ->setCellValue("J{$row}", $user['passportSeries'])
              ->setCellValueExplicit("K{$row}", $user['pnifl'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
              ->setCellValue("L{$row}", $user['status']);
        $row++;
    }

    $sheet->getStyle("A2:L{$row}")->applyFromArray([
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => ['argb' => '000000']
            ]
        ]
    ]);

    foreach (range('A', 'L') as $column) {
        $sheet->getColumnDimension($column)->setAutoSize(true);
    }

    $fileName = 'users-PhD-DsC_' . date('Y-m-d_H-i-s') . '.xlsx';

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header("Content-Disposition: attachment; filename={$fileName}");
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');

    exit;
    }

    public function activity_documents()
    {
    session_start();
    $role = $_SESSION['role'] ?? null;
    $user_id = $_SESSION['user_id'] ?? null;

    $adminModel = new AdminModel();
    $userModel = new UserModel();
    $image_url = $adminModel->getUserProfilePicture($user_id);
    $notificationsCount = $userModel->getChatNotificationsCount();

    $activityDocuments = $adminModel->getActivityDocuments();
    $documentCounts = $adminModel->getAllDocumentsCount();

    foreach ($activityDocuments as &$document) {
        $userLogin = $adminModel->getUserLoginById($document['user_id']);
        $document['user_login'] = $userLogin ? $userLogin : 'N/A'; 
    }

    if (!in_array($role, ['superadmin', 'admin'])) {
        $this->to('/');
        return;
    }

    $this->view("admin/activity-documents", [
        'title' => "PhD-DsC Hisobot Platformasi | Faoliyat",
        'notificationsCount' => $notificationsCount,
        'image_url' => $image_url,
        'activityDocuments' => $activityDocuments,
        'documentCounts' => $documentCounts,
    ]);
    }

    public function export_activity_documents_to_excel() {
    $adminModel = new AdminModel();
    $activityDocuments = $adminModel->getActivityDocuments();

    if (empty($activityDocuments)) {
    echo json_encode(['success' => false, 'message' => 'Eksport qilinadigan hujjatlar topilmadi.']);
    echo "<script>
            setTimeout(function() {
                window.history.back();
            }, 2000);
          </script>";
    exit();
    }

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $sheet->setCellValue('A1', 'ID')
          ->setCellValue('B1', 'Familasi va Ismi')
          ->setCellValue('C1', 'Jinsi')
          ->setCellValue('D1', 'Tug’ilgan joyi')
          ->setCellValue('E1', 'Tug’ilgan sanasi')
          ->setCellValue('F1', 'Hozirgi yashash joyi')
          ->setCellValue('G1', 'Yashash joyi holati')
          ->setCellValue('H1', 'PNIFL (JSHSHIR)')
          ->setCellValue('I1', 'Ayni damdagi ish joyi')
          ->setCellValue('J1', 'Lavozimi')
          ->setCellValue('K1', 'Bakalaviriat (Mutaxasislik nomi)')
          ->setCellValue('L1', 'Diplom seriya va raqami (Bakalaviriat)')
          ->setCellValue('M1', 'Bakalaviriat diplomi berilgan sana')
          ->setCellValue('N1', 'Magistratura (Mutaxasislik nomi)')
          ->setCellValue('O1', 'Diplom seriya va raqami (Magistratura)')
          ->setCellValue('P1', 'Magistratura diplomi berilgan sana')
          ->setCellValue('Q1', 'Doktorantura ixtisosligi (shifr, nomi)')
          ->setCellValue('R1', 'Yo’nalish nomi')
          ->setCellValue('S1', 'Dissertatsiya mavzusi')
          ->setCellValue('T1', 'Ilmiy rahbarining F.I.Osi')
          ->setCellValue('U1', 'Ilmiy rahbarining Ish joyi')
          ->setCellValue('V1', 'Ilmiy darajasi')
          ->setCellValue('W1', 'Ilmiy unvoni')
          ->setCellValue('X1', 'Qabul qilingan yili')
          ->setCellValue('Y1', 'Bosqich')
          ->setCellValue('Z1', 'Ta’lim turi')
          ->setCellValue('AA1', 'Buyruq raqami va sanasi')
          ->setCellValue('AB1', 'Ixtisoslik bo’yicha nazariy-metodologik dastur')
          ->setCellValue('AC1', 'Yakka tartibdagi rejaning mavjudligi')
          ->setCellValue('AD1', 'Akademik harakatchanlik mavjudligi')
          ->setCellValue('AE1', 'Stajirovkaga yuborgan tashkilot nomi')
          ->setCellValue('AF1', 'Stajirovkaga o’tgan tashkilot nomi')
          ->setCellValue('AG1', 'Stajirovka o’tagan davlati nomi')
          ->setCellValue('AH1', 'Muddatidan (Boshlanish sanasi)')
          ->setCellValue('AI1', 'Muddatigacha (Tugash sanasi)');

    $headerStyle = [
        'font' => [
            'bold' => true,
            'color' => ['argb' => 'FFFFFF'],
            'size' => 12,
            'name' => 'Arial'
        ],
        'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
        ],
        'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'startColor' => ['argb' => '4F81BD']
        ],
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => ['argb' => '000000']
            ]
        ]
    ];

    $sheet->getStyle('A1:AI1')->applyFromArray($headerStyle);
    $sheet->getColumnDimension('A')->setWidth(5);  
    $sheet->getColumnDimension('B')->setWidth(20); 
    $sheet->getColumnDimension('C')->setWidth(15); 
    $sheet->getColumnDimension('D')->setWidth(25); 
    $sheet->getColumnDimension('E')->setWidth(20); 
    $sheet->getColumnDimension('F')->setWidth(35); 
    $sheet->getColumnDimension('G')->setWidth(20);  
    $sheet->getColumnDimension('H')->setWidth(20);
    $sheet->getColumnDimension('I')->setWidth(25); 
    $sheet->getColumnDimension('J')->setWidth(20); 
    $sheet->getColumnDimension('K')->setWidth(35); 
    $sheet->getColumnDimension('L')->setWidth(35); 
    $sheet->getColumnDimension('M')->setWidth(35); 
    $sheet->getColumnDimension('N')->setWidth(35); 
    $sheet->getColumnDimension('O')->setWidth(35); 
    $sheet->getColumnDimension('P')->setWidth(35); 
    $sheet->getColumnDimension('Q')->setWidth(35); 
    $sheet->getColumnDimension('R')->setWidth(20); 
    $sheet->getColumnDimension('S')->setWidth(30); 
    $sheet->getColumnDimension('T')->setWidth(30);
    $sheet->getColumnDimension('U')->setWidth(30);
    $sheet->getColumnDimension('V')->setWidth(20); 
    $sheet->getColumnDimension('W')->setWidth(20); 
    $sheet->getColumnDimension('X')->setWidth(15); 
    $sheet->getColumnDimension('Y')->setWidth(15); 
    $sheet->getColumnDimension('Z')->setWidth(20); 
    $sheet->getColumnDimension('AA')->setWidth(40);
    $sheet->getColumnDimension('AB')->setWidth(50);
    $sheet->getColumnDimension('AC')->setWidth(40);
    $sheet->getColumnDimension('AD')->setWidth(30);
    $sheet->getColumnDimension('AE')->setWidth(30); 
    $sheet->getColumnDimension('AF')->setWidth(30);
    $sheet->getColumnDimension('AG')->setWidth(45);
    $sheet->getColumnDimension('AH')->setWidth(30);
    $sheet->getColumnDimension('AI')->setWidth(30);

    $row = 2;
    foreach ($activityDocuments as $document) {
        $sheet->setCellValue("A{$row}", $document['id'])
              ->setCellValue("B{$row}", $document['fio'])
              ->setCellValue("C{$row}", $document['gender'])
              ->setCellValue("D{$row}", $document['birthplace'])
              ->setCellValue("E{$row}", $document['birthdate'])
              ->setCellValue("F{$row}", $document['residence'])
              ->setCellValue("G{$row}", $document['residenceStatus'])
              ->setCellValueExplicit("H{$row}", $document['pnifl'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
              ->setCellValue("I{$row}", $document['currentJob'])
              ->setCellValue("J{$row}", $document['position'])
              ->setCellValue("K{$row}", $document['bachelor'])
              ->setCellValue("L{$row}", $document['bachelorDiploma'])
              ->setCellValue("M{$row}", $document['bachelorDate'])
              ->setCellValue("N{$row}", $document['master'])
              ->setCellValue("O{$row}", $document['masterDiploma'])
              ->setCellValue("P{$row}", $document['masterDate'])
              ->setCellValue("Q{$row}", $document['doctorateSpecialty'])
              ->setCellValue("R{$row}", $document['directionName'])
              ->setCellValue("S{$row}", $document['dissertationTopic'])
              ->setCellValue("T{$row}", $document['supervisorFio'])
              ->setCellValue("U{$row}", $document['supervisorWorkplace'])
              ->setCellValue("V{$row}", $document['supervisorDegree'])
              ->setCellValue("W{$row}", $document['supervisorTitle'])
              ->setCellValue("X{$row}", $document['admissionYear'])
              ->setCellValue("Y{$row}", $document['stage'])
              ->setCellValue("Z{$row}", $document['educationType'])
              ->setCellValue("AA{$row}", $document['orderNumber'])
              ->setCellValue("AB{$row}", $document['theoreticalProgramText'])
              ->setCellValue("AC{$row}", $document['individualPlanText'])
              ->setCellValue("AD{$row}", $document['participationInCompetitions'])
              ->setCellValue("AE{$row}", $document['organizationSent'])
              ->setCellValue("AF{$row}", $document['organizationReceived'])
              ->setCellValue("AG{$row}", $document['country'])
              ->setCellValue("AH{$row}", $document['startDate'])
              ->setCellValue("AI{$row}", $document['endDate']);
        $row++;
    }

    $writer = new Xlsx($spreadsheet);

    $fileName = 'faoliyat_PhD-DsC_' . date('Y-m-d_H-i-s') . '.xlsx';

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header("Content-Disposition: attachment; filename={$fileName}");
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');

    exit;
    }

    public function export_user_activity_documents_to_excel()
    {

    $user_id = $_POST['user_id']; 

    $adminModel = new AdminModel();
    $userLogin = $adminModel->getUserLoginById($user_id); 

    if (!$userLogin) {
        echo json_encode(['success' => false, 'message' => 'Foydalanuvchi topilmadi.']);
        exit();
    }

    $activityDocuments = $adminModel->getActivityDocumentsByUserId($user_id);

    if (empty($activityDocuments)) {
        echo json_encode(['success' => false, 'message' => 'Eksport qilinadigan hujjatlar topilmadi.']);
        exit();
    }

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $sheet->setCellValue('A1', 'ID')
          ->setCellValue('B1', 'Familasi va Ismi')
          ->setCellValue('C1', 'Jinsi')
          ->setCellValue('D1', 'Tug’ilgan joyi')
          ->setCellValue('E1', 'Tug’ilgan sanasi')
          ->setCellValue('F1', 'Hozirgi yashash joyi')
          ->setCellValue('G1', 'Yashash joyi holati')
          ->setCellValue('H1', 'PNIFL (JSHSHIR)')
          ->setCellValue('I1', 'Ayni damdagi ish joyi')
          ->setCellValue('J1', 'Lavozimi')
          ->setCellValue('K1', 'Bakalaviriat (Mutaxasislik nomi)')
          ->setCellValue('L1', 'Diplom seriya va raqami (Bakalaviriat)')
          ->setCellValue('M1', 'Bakalaviriat diplomi berilgan sana')
          ->setCellValue('N1', 'Magistratura (Mutaxasislik nomi)')
          ->setCellValue('O1', 'Diplom seriya va raqami (Magistratura)')
          ->setCellValue('P1', 'Magistratura diplomi berilgan sana')
          ->setCellValue('Q1', 'Doktorantura ixtisosligi (shifr, nomi)')
          ->setCellValue('R1', 'Yo’nalish nomi')
          ->setCellValue('S1', 'Dissertatsiya mavzusi')
          ->setCellValue('T1', 'Ilmiy rahbarining F.I.Osi')
          ->setCellValue('U1', 'Ilmiy rahbarining Ish joyi')
          ->setCellValue('V1', 'Ilmiy darajasi')
          ->setCellValue('W1', 'Ilmiy unvoni')
          ->setCellValue('X1', 'Qabul qilingan yili')
          ->setCellValue('Y1', 'Bosqich')
          ->setCellValue('Z1', 'Ta’lim turi')
          ->setCellValue('AA1', 'Buyruq raqami va sanasi')
          ->setCellValue('AB1', 'Ixtisoslik bo’yicha nazariy-metodologik dastur')
          ->setCellValue('AC1', 'Yakka tartibdagi rejaning mavjudligi')
          ->setCellValue('AD1', 'Akademik harakatchanlik mavjudligi')
          ->setCellValue('AE1', 'Stajirovkaga yuborgan tashkilot nomi')
          ->setCellValue('AF1', 'Stajirovkaga o’tgan tashkilot nomi')
          ->setCellValue('AG1', 'Stajirovka o’tagan davlati nomi')
          ->setCellValue('AH1', 'Muddatidan (Boshlanish sanasi)')
          ->setCellValue('AI1', 'Muddatigacha (Tugash sanasi)');

    $headerStyle = [
        'font' => [
            'bold' => true,
            'color' => ['argb' => 'FFFFFF'],
            'size' => 12,
            'name' => 'Arial'
        ],
        'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
        ],
        'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'startColor' => ['argb' => '4F81BD']
        ],
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => ['argb' => '000000']
            ]
        ]
    ];

    $sheet->getStyle('A1:AI1')->applyFromArray($headerStyle);
    $sheet->getColumnDimension('A')->setWidth(5);  
    $sheet->getColumnDimension('B')->setWidth(20); 
    $sheet->getColumnDimension('C')->setWidth(15); 
    $sheet->getColumnDimension('D')->setWidth(25); 
    $sheet->getColumnDimension('E')->setWidth(20); 
    $sheet->getColumnDimension('F')->setWidth(35); 
    $sheet->getColumnDimension('G')->setWidth(20);  
    $sheet->getColumnDimension('H')->setWidth(20);
    $sheet->getColumnDimension('I')->setWidth(25); 
    $sheet->getColumnDimension('J')->setWidth(20); 
    $sheet->getColumnDimension('K')->setWidth(35); 
    $sheet->getColumnDimension('L')->setWidth(35); 
    $sheet->getColumnDimension('M')->setWidth(35); 
    $sheet->getColumnDimension('N')->setWidth(35); 
    $sheet->getColumnDimension('O')->setWidth(35); 
    $sheet->getColumnDimension('P')->setWidth(35); 
    $sheet->getColumnDimension('Q')->setWidth(35); 
    $sheet->getColumnDimension('R')->setWidth(20); 
    $sheet->getColumnDimension('S')->setWidth(30); 
    $sheet->getColumnDimension('T')->setWidth(30);
    $sheet->getColumnDimension('U')->setWidth(30);
    $sheet->getColumnDimension('V')->setWidth(20); 
    $sheet->getColumnDimension('W')->setWidth(20); 
    $sheet->getColumnDimension('X')->setWidth(15); 
    $sheet->getColumnDimension('Y')->setWidth(15); 
    $sheet->getColumnDimension('Z')->setWidth(20); 
    $sheet->getColumnDimension('AA')->setWidth(40);
    $sheet->getColumnDimension('AB')->setWidth(50);
    $sheet->getColumnDimension('AC')->setWidth(40);
    $sheet->getColumnDimension('AD')->setWidth(30);
    $sheet->getColumnDimension('AE')->setWidth(30); 
    $sheet->getColumnDimension('AF')->setWidth(30);
    $sheet->getColumnDimension('AG')->setWidth(45);
    $sheet->getColumnDimension('AH')->setWidth(30);
    $sheet->getColumnDimension('AI')->setWidth(30);

    $row = 2;
    foreach ($activityDocuments as $document) {
        $sheet->setCellValue("A{$row}", $document['id'])
              ->setCellValue("B{$row}", $document['fio'])
              ->setCellValue("C{$row}", $document['gender'])
              ->setCellValue("D{$row}", $document['birthplace'])
              ->setCellValue("E{$row}", $document['birthdate'])
              ->setCellValue("F{$row}", $document['residence'])
              ->setCellValue("G{$row}", $document['residenceStatus'])
              ->setCellValueExplicit("H{$row}", $document['pnifl'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
              ->setCellValue("I{$row}", $document['currentJob'])
              ->setCellValue("J{$row}", $document['position'])
              ->setCellValue("K{$row}", $document['bachelor'])
              ->setCellValue("L{$row}", $document['bachelorDiploma'])
              ->setCellValue("M{$row}", $document['bachelorDate'])
              ->setCellValue("N{$row}", $document['master'])
              ->setCellValue("O{$row}", $document['masterDiploma'])
              ->setCellValue("P{$row}", $document['masterDate'])
              ->setCellValue("Q{$row}", $document['doctorateSpecialty'])
              ->setCellValue("R{$row}", $document['directionName'])
              ->setCellValue("S{$row}", $document['dissertationTopic'])
              ->setCellValue("T{$row}", $document['supervisorFio'])
              ->setCellValue("U{$row}", $document['supervisorWorkplace'])
              ->setCellValue("V{$row}", $document['supervisorDegree'])
              ->setCellValue("W{$row}", $document['supervisorTitle'])
              ->setCellValue("X{$row}", $document['admissionYear'])
              ->setCellValue("Y{$row}", $document['stage'])
              ->setCellValue("Z{$row}", $document['educationType'])
              ->setCellValue("AA{$row}", $document['orderNumber'])
              ->setCellValue("AB{$row}", $document['theoreticalProgramText'])
              ->setCellValue("AC{$row}", $document['individualPlanText'])
              ->setCellValue("AD{$row}", $document['participationInCompetitions'])
              ->setCellValue("AE{$row}", $document['organizationSent'])
              ->setCellValue("AF{$row}", $document['organizationReceived'])
              ->setCellValue("AG{$row}", $document['country'])
              ->setCellValue("AH{$row}", $document['startDate'])
              ->setCellValue("AI{$row}", $document['endDate']);
        $row++;
    }

    $writer = new Xlsx($spreadsheet);

    $fileName = "{$userLogin}_PhD-DsC_" . date('Y-m-d_H-i-s') . '.xlsx'; 

    $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/assets/uploads/' . $user_id;
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true); 
    }

    $filePath = $uploadDir . '/' . $fileName;
    $writer = new Xlsx($spreadsheet);
    $writer->save($filePath);

    $fileUrl = '/assets/uploads/' . $user_id . '/' . $fileName;

    echo json_encode(['success' => true, 'download_url' => $this->base_url($fileUrl)]);
    exit();
    }

    public function delete_activity_document() { 
    if (isset($_POST['user_id']) && !empty($_POST['user_id'])) {
        $user_id = (string)$_POST['user_id'];

        $adminModel = new AdminModel();

        $files = [
            'theoreticalProgramFile',
            'individualPlanFile',
            'academicFile',
            'fileUpload',
        ];

        foreach ($files as $file) {
            $fileUrl = $adminModel->getFileUrlByUserId($user_id, $file);
            if (!empty($fileUrl) && file_exists($fileUrl)) {
                if (unlink($fileUrl)) {
                    $this->logError("Fayl o'chirildi: " . $fileUrl);
                } else {
                    $this->logError("Faylni o'chirishda xatolik yuz berdi: " . $fileUrl);
                }
            } else {
                $this->logError("Fayl topilmadi: " . $fileUrl);
            }
        }

        header('Content-Type: application/json');
        try {
            $deleted = $adminModel->deleteActivity($user_id);

            if ($deleted) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Foydalanuvchi ma’lumotlari muvaffaqiyatli o’chirildi.'
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Foydalanuvchini ma’lumotlari o’chirishda xatolik yuz berdi.'
                ]);
            }
        } catch (\Exception $e) {
            $this->logError('Xatolik: ' . $e->getMessage());
            echo json_encode([
                'success' => false,
                'message' => 'Xatolik yuz berdi: ' . $e->getMessage()
            ]);
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Foydalanuvchi ID berilmagan.'
        ]);
    }
    }

    public function guide_documents()
    {
    session_start();
    $role = $_SESSION['role'] ?? null;
    $user_id = $_SESSION['user_id'] ?? null;

    $adminModel = new AdminModel();
    $userModel = new UserModel();
    $image_url = $adminModel->getUserProfilePicture($user_id);
    $notificationsCount = $userModel->getChatNotificationsCount();

    $guideDocuments = $adminModel->getGuideDocuments();
    $documentCounts = $adminModel->getAllDocumentsCount();

    foreach ($guideDocuments as &$document) {
        $userLogin = $adminModel->getUserLoginById($document['user_id']);
        $document['user_login'] = $userLogin ? $userLogin : 'N/A'; 
    }

    if (!in_array($role, ['superadmin', 'admin'])) {
        $this->to('/');
        return;
    }

    $this->view("admin/guide-documents", [
        'title' => "PhD-DsC Hisobot Platformasi | Mundarija",
        'notificationsCount' => $notificationsCount,
        'image_url' => $image_url,
        'guideDocuments' => $guideDocuments,
        'documentCounts' => $documentCounts,
    ]);
    }

    public function approveGuideDocument()
    {
        $document_id = $_POST['document_id'] ?? null;
        
        if (!$document_id) {
            echo json_encode(['status' => 'error', 'message' => 'Dokument ID topilmadi.']);
            return;
        }

        $adminModel = new AdminModel();
        $result = $adminModel->approveGuideDocument($document_id);

        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Vazifa tasdiqlandi.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Vazifa tasdiqlanmadi, xatolik yuz berdi.']);
        }
    }

    public function cancelGuideDocument()
    {
        $document_id = $_POST['document_id'] ?? null;
        $cancel_reason = $_POST['cancel_reason'] ?? null;

        if (!$document_id || !$cancel_reason) {
            echo json_encode(['status' => 'error', 'message' => 'Dokument ID yoki sabab kiritilmagan.']);
            return;
        }

        $adminModel = new AdminModel();
        $result = $adminModel->cancelGuideDocument($document_id, $cancel_reason);

        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Vazifa bekor qilindi.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Vazifa bekor qilinmadi.']);
        }
    }

    public function deleteGuideDocument()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $documentId = isset($_POST['document_id']) ? $_POST['document_id'] : null;

            if ($documentId) {
                try {
                    $adminModel = new AdminModel();
                    $adminModel->deleteGuideDocument($documentId);
                    echo json_encode(['status' => 'success', 'message' => 'Hujjat muvaffaqiyatli o’chirildi.']);
                } catch (Exception $e) {
                    echo json_encode(['status' => 'error', 'message' => 'Xatolik yuz berdi: ' . $e->getMessage()]);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Hujjat IDsi topilmadi.']);
            }
        }
    }

    public function export_guide_to_excel() { 
    $adminModel = new AdminModel();
    $documents = $adminModel->getAllGuide(); 

    if (empty($documents)) {
        echo 'Eksport qilinadigan hujjatlar topilmadi.';
        echo "<script>
            setTimeout(function() {
                window.history.back();
            }, 2000);
          </script>";
        exit();
    }

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $sheet->setCellValue('A1', 'ID')
          ->setCellValue('B1', 'Yuboruvchi')
          ->setCellValue('C1', 'Ta’lim turi')
          ->setCellValue('D1', 'Bosqich')
          ->setCellValue('E1', 'Raqami')
          ->setCellValue('F1', 'Bajarilgan ishlar')
          ->setCellValue('G1', 'Yuklangan hujjat vazifasi')
          ->setCellValue('H1', 'Qo’shimcha ish bajarilishi bo’yicha izoh')
          ->setCellValue('I1', 'Fayl nomi')
          ->setCellValue('J1', 'Tasdiqlangan/Bekor qilingan')
          ->setCellValue('K1', 'Izoh')
          ->setCellValue('L1', 'Ish unumdorligi');

    $headerStyle = [
        'font' => [
            'bold' => true,
            'color' => ['argb' => 'FFFFFF'],
            'size' => 12,
            'name' => 'Arial'
        ],
        'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
        ],
        'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'startColor' => ['argb' => '4F81BD']
        ],
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => ['argb' => '000000']
            ]
        ]
    ];

    $sheet->getStyle('A1:L1')->applyFromArray($headerStyle);

    $row = 2;
    foreach ($documents as $document) {
        $userLogin = $adminModel->getUserLoginById($document['user_id']);
        $fileName = basename($document['file_url']);
        $status = ($document['is_rejected'] == 1) ? 'Rad etildi' : 'Tasdiqlandi';
        $rejectedText = ($document['is_rejected'] == 1) ? $document['rejected_text'] : '';

        $educationType = $document['education_type'];
        $stage = $document['stage'];
        $totalTasks = 0;

        if ($educationType == 'Stajor taqiqotchi (PhD)') {
            $totalTasks = 12;
        } elseif (in_array($educationType, ['Tayanch doktorant (PhD)', 'Maqsadli tayanch doktorant (PhD)', 'Mustaqil izlanuvchi (PhD)'])) {
            if ($stage == 1) {
                $totalTasks = 12;
            } elseif ($stage == 2) {
                $totalTasks = 10;
            } elseif ($stage == 3) {
                $totalTasks = 12;
            }
        } elseif (in_array($educationType, ['Doktorant (DSc)', 'Maqsadli doktorantura (DSc)', 'Mustaqil izlanuvchi (DSc)'])) {
            if ($stage == 1) {
                $totalTasks = 8;
            } elseif ($stage == 2) {
                $totalTasks = 7;
            } elseif ($stage == 3) {
                $totalTasks = 5;
            }
        }

        $completedTasks = count($adminModel->getGuideDocumentsByUserId($document['user_id'], $educationType, $stage, 'Tasdiqlandi'));

        $efficiency = ($totalTasks > 0) ? round(($completedTasks / $totalTasks) * 100, 2) : 0;

        $sheet->setCellValue("A{$row}", $document['id'])
              ->setCellValue("B{$row}", $userLogin)
              ->setCellValue("C{$row}", $educationType)
              ->setCellValue("D{$row}", $stage)
              ->setCellValue("E{$row}", $document['number'])
              ->setCellValue("F{$row}", $document['planned_works'])
              ->setCellValue("G{$row}", $document['researcher_tasks'])
              ->setCellValue("H{$row}", $document['additional_work'])
              ->setCellValue("I{$row}", $fileName)
              ->setCellValue("J{$row}", $status)
              ->setCellValue("K{$row}", $rejectedText)
              ->setCellValue("L{$row}", ($status == 'Tasdiqlandi') ? $efficiency . '%' : '');
        $row++;
    }

    $sheet->getStyle("A2:L{$row}")->applyFromArray([
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => ['argb' => '000000']
            ]
        ]
    ]);

    foreach (range('A', 'L') as $column) {
        $sheet->getColumnDimension($column)->setAutoSize(true);
    }

    $fileName = 'mundarija_PhD-DsC_' . date('Y-m-d_H-i-s') . '.xlsx';

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header("Content-Disposition: attachment; filename={$fileName}");
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');

    exit;
    }

    public function article_documents()
    {
    session_start();
    $role = $_SESSION['role'] ?? null;
    $user_id = $_SESSION['user_id'] ?? null;

    $adminModel = new AdminModel();
    $userModel = new UserModel();
    $image_url = $adminModel->getUserProfilePicture($user_id);
    $notificationsCount = $userModel->getChatNotificationsCount();

    $articleDocuments = $adminModel->getArticleDocuments();
    $documentCounts = $adminModel->getAllDocumentsCount();

    foreach ($articleDocuments as &$document) {
        $userLogin = $adminModel->getUserLoginById($document['user_id']);
        $document['user_login'] = $userLogin ? $userLogin : 'N/A'; 
    } 

    if (!in_array($role, ['superadmin', 'admin'])) {
        $this->to('/');
        return;
    }

    $this->view("admin/article-documents", [
        'title' => "PhD-DsC Hisobot Platformasi | Maqola",
        'notificationsCount' => $notificationsCount,
        'image_url' => $image_url,
        'articleDocuments' => $articleDocuments,
        'documentCounts' => $documentCounts,
    ]);
    }

    public function approveArticleDocument()
    {
        $document_id = $_POST['document_id'] ?? null;
        
        if (!$document_id) {
            echo json_encode(['status' => 'error', 'message' => 'Dokument ID topilmadi.']);
            return;
        }

        $adminModel = new AdminModel();
        $result = $adminModel->approveArticleDocument($document_id);

        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Maqola tasdiqlandi.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Maqola tasdiqlanmadi, xatolik yuz berdi.']);
        }
    }

    public function cancelArticleDocument()
    {
        $document_id = $_POST['document_id'] ?? null;
        $cancel_reason = $_POST['cancel_reason'] ?? null;

        if (!$document_id || !$cancel_reason) {
            echo json_encode(['status' => 'error', 'message' => 'Dokument ID yoki sabab kiritilmagan.']);
            return;
        }

        $adminModel = new AdminModel();
        $result = $adminModel->cancelArticleDocument($document_id, $cancel_reason);

        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Maqola bekor qilindi.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Maqola bekor qilinmadi.']);
        }
    }

    public function deleteArticleDocument()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $documentId = isset($_POST['document_id']) ? $_POST['document_id'] : null;

            if ($documentId) {
                try {
                    $adminModel = new AdminModel();
                    $adminModel->deleteArticleDocument($documentId);
                    echo json_encode(['status' => 'success', 'message' => 'Hujjat muvaffaqiyatli o’chirildi.']);
                } catch (Exception $e) {
                    echo json_encode(['status' => 'error', 'message' => 'Xatolik yuz berdi: ' . $e->getMessage()]);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Hujjat IDsi topilmadi.']);
            }
        }
    }

    public function export_articles_to_excel() {
    $adminModel = new AdminModel();
    $articles = $adminModel->getAllArticle(); 

    if (empty($articles)) {
        echo json_encode(['success' => false, 'message' => 'Eksport qilinadigan maqolalar topilmadi.']);
        echo "<script>
                setTimeout(function() {
                    window.history.back();
                }, 2000);
              </script>";
        exit();
    }

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $sheet->setCellValue('A1', 'ID')
          ->setCellValue('B1', 'Yuboruvchi')
          ->setCellValue('C1', 'Jurnal turi')
          ->setCellValue('D1', 'Nashr etilgan davlat nomi')
          ->setCellValue('E1', 'Jurnal nomi')
          ->setCellValue('F1', 'Maqola nomi')
          ->setCellValue('G1', 'Nashr yili va oyi')
          ->setCellValue('H1', 'Materialning internet havolasi')
          ->setCellValue('I1', 'Mualliflar soni')
          ->setCellValue('J1', 'Mualliflar')
          ->setCellValue('K1', 'Maqola fayli')
          ->setCellValue('L1', 'Tasdiqlangan/Bekor qilingan')
          ->setCellValue('M1', 'Izoh');

    $headerStyle = [
        'font' => [
            'bold' => true,
            'color' => ['argb' => 'FFFFFF'],
            'size' => 12,
            'name' => 'Arial'
        ],
        'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
        ],
        'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'startColor' => ['argb' => '4F81BD']
        ],
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => ['argb' => '000000']
            ]
        ]
    ];

    $sheet->getStyle('A1:M1')->applyFromArray($headerStyle);

    $row = 2;
    foreach ($articles as $article) {
        $userLogin = $adminModel->getUserLoginById($article['user_id']);

        $sheet->setCellValue("A{$row}", $article['id'])
              ->setCellValue("B{$row}", $userLogin)
              ->setCellValue("C{$row}", $article['journalType'])
              ->setCellValue("D{$row}", $article['publishCountry'])
              ->setCellValue("E{$row}", $article['journalName'])
              ->setCellValue("F{$row}", $article['articleTitle'])
              ->setCellValue("G{$row}", $article['publishDate'])
              ->setCellValue("H{$row}", $article['articleLink'])
              ->setCellValue("I{$row}", $article['authorCount'])
              ->setCellValue("J{$row}", $article['authors'])
              ->setCellValue("K{$row}", basename($article['articleFile']))
              ->setCellValue("L{$row}", ($article['is_rejected'] == 0) ? 'Tasdiqlandi' : 'Rad etildi');
        
        if ($article['is_rejected'] == 1) {
            $sheet->setCellValue("M{$row}", $article['rejected_text']);
        }

        $row++;
    }

    $sheet->getStyle("A2:M{$row}")->applyFromArray([
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => ['argb' => '000000']
            ]
        ]
    ]);

    foreach (range('A', 'M') as $column) {
        $sheet->getColumnDimension($column)->setAutoSize(true);
    }

    $fileName = 'maqolalar_PhD_DsC_' . date('Y-m-d_H-i-s') . '.xlsx'; 

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header("Content-Disposition: attachment; filename={$fileName}");
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');

    exit;
    }

    public function patent_documents()
    {
    session_start();
    $role = $_SESSION['role'] ?? null;
    $user_id = $_SESSION['user_id'] ?? null;

    $adminModel = new AdminModel();
    $userModel = new UserModel();
    $image_url = $adminModel->getUserProfilePicture($user_id);
    $notificationsCount = $userModel->getChatNotificationsCount();

    $patentDocuments = $adminModel->getPatentDocuments();
    $documentCounts = $adminModel->getAllDocumentsCount();

    foreach ($patentDocuments as &$document) {
        $userLogin = $adminModel->getUserLoginById($document['user_id']);
        $document['user_login'] = $userLogin ? $userLogin : 'N/A'; 
    } 

    if (!in_array($role, ['superadmin', 'admin'])) {
        $this->to('/');
        return;
    }

    $this->view("admin/patent-documents", [
        'title' => "PhD-DsC Hisobot Platformasi | Patent",
        'notificationsCount' => $notificationsCount,
        'image_url' => $image_url,
        'patentDocuments' => $patentDocuments,
        'documentCounts' => $documentCounts,
    ]);
    }

    public function approvePatentDocument()
    {
        $document_id = $_POST['document_id'] ?? null;
        
        if (!$document_id) {
            echo json_encode(['status' => 'error', 'message' => 'Dokument ID topilmadi.']);
            return;
        }

        $adminModel = new AdminModel();
        $result = $adminModel->approvePatentDocument($document_id);

        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Patent tasdiqlandi.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Patent tasdiqlanmadi, xatolik yuz berdi.']);
        }
    }

    public function cancelPatentDocument()
    {
        $document_id = $_POST['document_id'] ?? null;
        $cancel_reason = $_POST['cancel_reason'] ?? null;

        if (!$document_id || !$cancel_reason) {
            echo json_encode(['status' => 'error', 'message' => 'Dokument ID yoki sabab kiritilmagan.']);
            return;
        }

        $adminModel = new AdminModel();
        $result = $adminModel->cancelPatentDocument($document_id, $cancel_reason);

        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Patent hujjati bekor qilindi.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Patent hujjati bekor qilinmadi.']);
        }
    }

    public function deletePatentDocument()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $documentId = isset($_POST['document_id']) ? $_POST['document_id'] : null;

            if ($documentId) {
                try {
                    $adminModel = new AdminModel();
                    $adminModel->deletePatentDocument($documentId);
                    echo json_encode(['status' => 'success', 'message' => 'Hujjat muvaffaqiyatli o’chirildi.']);
                } catch (Exception $e) {
                    echo json_encode(['status' => 'error', 'message' => 'Xatolik yuz berdi: ' . $e->getMessage()]);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Hujjat IDsi topilmadi.']);
            }
        }
    }

    public function export_patents_to_excel() {
    $adminModel = new AdminModel();
    $patents = $adminModel->getAllPatent();

    if (empty($patents)) {
        echo json_encode(['success' => false, 'message' => 'Eksport qilinadigan patentlar topilmadi.']);
        echo "<script>
                setTimeout(function() {
                    window.history.back();
                }, 2000);
              </script>";
        exit();
    }

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $sheet->setCellValue('A1', 'ID')
          ->setCellValue('B1', 'Yuboruvchi')
          ->setCellValue('C1', 'Ishlanma turi')
          ->setCellValue('D1', 'Int.mulk nomi')
          ->setCellValue('E1', 'Int.mulk raqami')
          ->setCellValue('F1', 'Sanasi')
          ->setCellValue('G1', 'Mualliflar soni')
          ->setCellValue('H1', 'Mualliflar')
          ->setCellValue('I1', 'Patent fayli')
          ->setCellValue('J1', 'Tasdiqlangan/Bekor qilingan')
          ->setCellValue('K1', 'Izoh');

    $headerStyle = [
        'font' => [
            'bold' => true,
            'color' => ['argb' => 'FFFFFF'],
            'size' => 12,
            'name' => 'Arial'
        ],
        'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
        ],
        'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'startColor' => ['argb' => '4F81BD']
        ],
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => ['argb' => '000000']
            ]
        ]
    ];

    $sheet->getStyle('A1:K1')->applyFromArray($headerStyle);

    $row = 2;
    foreach ($patents as $patent) {
        $userLogin = $adminModel->getUserLoginById($patent['user_id']);
        
        $status = ($patent['status'] == 'Tasdiqlandi') ? 'Tasdiqlandi' : (($patent['status'] == 'Rad etildi') ? 'Rad etildi' : 'Kutilmoqda');
        
        $rejectedText = ($patent['is_rejected'] == 1) ? $patent['rejected_text'] : '';

        $sheet->setCellValue("A{$row}", $patent['id'])
              ->setCellValue("B{$row}", $userLogin)
              ->setCellValue("C{$row}", $patent['patent_type'])
              ->setCellValue("D{$row}", $patent['intellectual_property_name'])
              ->setCellValue("E{$row}", $patent['intellectual_property_number'])
              ->setCellValue("F{$row}", $patent['patent_date'])
              ->setCellValue("G{$row}", $patent['author_count'])
              ->setCellValue("H{$row}", $patent['authors'])
              ->setCellValue("I{$row}", basename($patent['patent_file']))
              ->setCellValue("J{$row}", $status)
              ->setCellValue("K{$row}", $rejectedText);

        $row++;
    }

    $sheet->getStyle("A2:K{$row}")->applyFromArray([
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => ['argb' => '000000']
            ]
        ]
    ]);

    foreach (range('A', 'K') as $column) {
        $sheet->getColumnDimension($column)->setAutoSize(true);
    }

    $fileName = 'patentlar_PhD_DsC_' . date('Y-m-d_H-i-s') . '.xlsx';

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header("Content-Disposition: attachment; filename={$fileName}");
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');

    exit;
    }

    public function textbook_documents()
    {
    session_start();
    $role = $_SESSION['role'] ?? null;
    $user_id = $_SESSION['user_id'] ?? null;

    $adminModel = new AdminModel();
    $userModel = new UserModel();
    $image_url = $adminModel->getUserProfilePicture($user_id);
    $notificationsCount = $userModel->getChatNotificationsCount();

    $works = $adminModel->getDarslikDocuments();
    $documentCounts = $adminModel->getAllDocumentsCount();

    foreach ($works as &$document) {
        $userLogin = $adminModel->getUserLoginById($document['user_id']);
        $document['user_login'] = $userLogin ? $userLogin : 'N/A'; 
    } 

    if (!in_array($role, ['superadmin', 'admin'])) {
        $this->to('/');
        return;
    }

    $this->view("admin/textbook-documents", [
        'title' => "PhD-DsC Hisobot Platformasi | Darslik",
        'notificationsCount' => $notificationsCount,
        'image_url' => $image_url,
        'works' => $works,
        'documentCounts' => $documentCounts,
    ]);
    }

    public function approveIshlanmaDocument()
    {
        $document_id = $_POST['work_id'] ?? null;
        
        if (!$document_id) {
            echo json_encode(['status' => 'error', 'message' => 'Dokument ID topilmadi.']);
            return;
        }

        $adminModel = new AdminModel();
        $result = $adminModel->approveDarslikDocument($document_id);

        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Darslik tasdiqlandi.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Darslik tasdiqlanmadi, xatolik yuz berdi.']);
        }
    }

    public function cancelIshlanmaDocument()
    {
        $document_id = $_POST['work_id'] ?? null;
        $cancel_reason = $_POST['cancel_reason'] ?? null;

        if (!$document_id || !$cancel_reason) {
            echo json_encode(['status' => 'error', 'message' => 'Dokument ID yoki sabab kiritilmagan.']);
            return;
        }

        $adminModel = new AdminModel();
        $result = $adminModel->cancelDarslikDocument($document_id, $cancel_reason);

        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Darslik bekor qilindi.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Darslik bekor qilinmadi.']);
        }
    }

    public function deleteIshlanmaDocument()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $documentId = isset($_POST['work_id']) ? $_POST['work_id'] : null;

            if ($documentId) {
                try {
                    $adminModel = new AdminModel();
                    $adminModel->deleteDarslikDocument($documentId);
                    echo json_encode(['status' => 'success', 'message' => 'Hujjat muvaffaqiyatli o’chirildi.']);
                } catch (Exception $e) {
                    echo json_encode(['status' => 'error', 'message' => 'Xatolik yuz berdi: ' . $e->getMessage()]);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Hujjat IDsi topilmadi.']);
            }
        }
    }

    public function export_darslik_to_excel() {  
    $adminModel = new AdminModel();
    $works = $adminModel->getAllDarslik();   

    if (empty($works)) {
        echo json_encode(['success' => false, 'message' => 'Eksport qilinadigan ishlanmalar topilmadi.']); 
        echo "<script>
                setTimeout(function() {
                    window.history.back();
                }, 2000);
              </script>";
        exit();
    }

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $sheet->setCellValue('A1', 'ID')
          ->setCellValue('B1', 'Yuboruvchi')
          ->setCellValue('C1', 'Ishlanma turi')
          ->setCellValue('D1', 'Nomi')
          ->setCellValue('E1', 'Guvohnoma raqami')
          ->setCellValue('F1', 'Sanasi')
          ->setCellValue('G1', 'Mualliflar soni')
          ->setCellValue('H1', 'Mualliflar')
          ->setCellValue('I1', 'Ishlanma fayli')
          ->setCellValue('J1', 'Tasdiqlangan/Bekor qilingan')
          ->setCellValue('K1', 'Izoh');

    $headerStyle = [
        'font' => [
            'bold' => true,
            'color' => ['argb' => 'FFFFFF'],
            'size' => 12,
            'name' => 'Arial'
        ],
        'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
        ],
        'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'startColor' => ['argb' => '4F81BD']
        ],
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => ['argb' => '000000']
            ]
        ]
    ];

    $sheet->getStyle('A1:K1')->applyFromArray($headerStyle);

    $row = 2;
    foreach ($works as $work) {
        $userLogin = $adminModel->getUserLoginById($work['user_id']);

        $sheet->setCellValue("A{$row}", $work['id'])
              ->setCellValue("B{$row}", $userLogin)
              ->setCellValue("C{$row}", $work['work_type'])
              ->setCellValue("D{$row}", $work['work_name'])
              ->setCellValue("E{$row}", $work['certificate_number'])
              ->setCellValue("F{$row}", $work['work_date'])
              ->setCellValue("G{$row}", $work['author_count'])
              ->setCellValue("H{$row}", $work['authors'])
              ->setCellValue("I{$row}", basename($work['file_name']))
              ->setCellValue("J{$row}", ($work['status'] == 'Tasdiqlandi') ? 'Tasdiqlangan' : (($work['status'] == 'Rad etildi') ? 'Bekor qilingan' : 'Kutilmoqda'));
        if ($work['is_rejected'] == 1) {
            $sheet->setCellValue("K{$row}", $work['rejected_text']);
        }

        $row++;
    }

    $sheet->getStyle("A2:K{$row}")->applyFromArray([
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => ['argb' => '000000']
            ]
        ]
    ]);

    foreach (range('A', 'K') as $column) {
        $sheet->getColumnDimension($column)->setAutoSize(true);
    }

    $fileName = 'ishlanmalar_PhD_DsC_' . date('Y-m-d_H-i-s') . '.xlsx';  

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header("Content-Disposition: attachment; filename={$fileName}");
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');

    exit;
    }

    public function language_documents()
    {
    session_start();
    $role = $_SESSION['role'] ?? null;
    $user_id = $_SESSION['user_id'] ?? null;

    $adminModel = new AdminModel();
    $userModel = new UserModel();
    $image_url = $adminModel->getUserProfilePicture($user_id);
    $notificationsCount = $userModel->getChatNotificationsCount();

    $certificates = $adminModel->getSertifikatDocuments();
    $documentCounts = $adminModel->getAllDocumentsCount();

    foreach ($certificates as &$document) {
        $userLogin = $adminModel->getUserLoginById($document['user_id']);
        $document['user_login'] = $userLogin ? $userLogin : 'N/A'; 
    } 

    if (!in_array($role, ['superadmin', 'admin'])) {
        $this->to('/');
        return;
    }

    $this->view("admin/certificates-documents", [
        'title' => "PhD-DsC Hisobot Platformasi | Til",
        'notificationsCount' => $notificationsCount,
        'image_url' => $image_url,
        'certificates' => $certificates,
        'documentCounts' => $documentCounts,
    ]);
    }

    public function approveSertifikatDocument()
    {
        $document_id = $_POST['certificate_id'] ?? null;
        
        if (!$document_id) {
            echo json_encode(['status' => 'error', 'message' => 'Dokument ID topilmadi.']);
            return;
        }

        $adminModel = new AdminModel();
        $result = $adminModel->approveSertifikatDocument($document_id);

        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Sertifikat tasdiqlandi.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Sertifikat tasdiqlanmadi, xatolik yuz berdi.']);
        }
    }

    public function cancelSertifikatDocument()
    {
        $document_id = $_POST['certificate_id'] ?? null;
        $cancel_reason = $_POST['cancel_reason'] ?? null;

        if (!$document_id || !$cancel_reason) {
            echo json_encode(['status' => 'error', 'message' => 'Dokument ID yoki sabab kiritilmagan.']);
            return;
        }

        $adminModel = new AdminModel();
        $result = $adminModel->cancelSertifikatDocument($document_id, $cancel_reason);

        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Sertifikat bekor qilindi.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Sertifikat bekor qilinmadi.']);
        }
    }

    public function deleteSertifikatDocument()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $documentId = isset($_POST['certificate_id']) ? $_POST['certificate_id'] : null;

            if ($documentId) {
                try {
                    $adminModel = new AdminModel();
                    $adminModel->deleteSertifikatDocument($documentId);
                    echo json_encode(['status' => 'success', 'message' => 'Hujjat muvaffaqiyatli o’chirildi.']);
                } catch (Exception $e) {
                    echo json_encode(['status' => 'error', 'message' => 'Xatolik yuz berdi: ' . $e->getMessage()]);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Hujjat IDsi topilmadi.']);
            }
        }
    }

    public function export_certificates_to_excel() {  
    $adminModel = new AdminModel();
    $certificates = $adminModel->getAllSertifikat();   

    if (empty($certificates)) {
        echo json_encode(['success' => false, 'message' => 'Eksport qilinadigan sertifikatlar topilmadi.']); 
        echo "<script>
                setTimeout(function() {
                    window.history.back();
                }, 2000);
              </script>";
        exit();
    }

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $sheet->setCellValue('A1', 'ID')
          ->setCellValue('B1', 'Yuboruvchi')
          ->setCellValue('C1', 'Til turi')
          ->setCellValue('D1', 'Til')
          ->setCellValue('E1', 'Daraja')
          ->setCellValue('F1', 'Olingan sana')
          ->setCellValue('G1', 'Til fayli')
          ->setCellValue('H1', 'Tasdiqlangan/Bekor qilingan')
          ->setCellValue('I1', 'Izoh');

    $headerStyle = [
        'font' => [
            'bold' => true,
            'color' => ['argb' => 'FFFFFF'],
            'size' => 12,
            'name' => 'Arial'
        ],
        'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
        ],
        'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'startColor' => ['argb' => '4F81BD']
        ],
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => ['argb' => '000000']
            ]
        ]
    ];

    $sheet->getStyle('A1:I1')->applyFromArray($headerStyle);

    $row = 2;
    foreach ($certificates as $certificate) {
        $userLogin = $adminModel->getUserLoginById($certificate['user_id']);

        $sheet->setCellValue("A{$row}", $certificate['id'])
              ->setCellValue("B{$row}", $userLogin)
              ->setCellValue("C{$row}", $certificate['certificate_type'])
              ->setCellValue("D{$row}", $certificate['language_name'])
              ->setCellValue("E{$row}", $certificate['language_level'])
              ->setCellValue("F{$row}", $certificate['certificate_date'])
              ->setCellValue("G{$row}", basename($certificate['certificate_file']))
              ->setCellValue("H{$row}", ($certificate['status'] == 'Tasdiqlangan') ? 'Tasdiqlangan' : (($certificate['status'] == 'Rad etildi') ? 'Bekor qilingan' : 'Kutilmoqda'));
        
        if ($certificate['is_rejected'] == 1) {
            $sheet->setCellValue("I{$row}", $certificate['rejected_text']);
        }

        $row++;
    }

    $sheet->getStyle("A2:I{$row}")->applyFromArray([
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => ['argb' => '000000']
            ]
        ]
    ]);

    foreach (range('A', 'I') as $column) {
        $sheet->getColumnDimension($column)->setAutoSize(true);
    }

    $fileName = 'sertifikatlar_PhD_DsC_' . date('Y-m-d_H-i-s') . '.xlsx';  

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header("Content-Disposition: attachment; filename={$fileName}");
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');

    exit;
    }

    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();

        $this->view("home/index", [
            "logoutMessage" => "Siz tizimdan chiqdingiz!",
        ]);
    }
}

?>