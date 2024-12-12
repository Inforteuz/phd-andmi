<?php

use App\Models\UserModel;

class CreateSertifikatTable {
    public function up() {
        $userModel = new UserModel();
        $userModel->createSertifikatTable();
    }
    
    public function down() {
        // Joriy jadvalini o'chirish uchun kod
    }
}
?>