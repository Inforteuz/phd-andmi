<?php

use App\Models\UserModel;

class CreateLoginHistoryTable {
    public function up() {
        $userModel = new UserModel();
        $userModel->createLoginHistoryTable();
    }
    
    public function down() {
        // Joriy jadvalini o'chirish uchun kod
    }
}
?>