<?php

use App\Models\UserModel;

class CreatePatentTable {
    public function up() {
        $userModel = new UserModel();
        $userModel->createPatentTable();
    }
    
    public function down() {
        // Joriy jadvalini o'chirish uchun kod
    }
}
?>