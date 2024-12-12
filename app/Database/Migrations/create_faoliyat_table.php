<?php

use App\Models\UserModel;

class CreateFaoliyatTable {
    public function up() {
        $userModel = new UserModel();
        $userModel->createFaoliyatTable();
    }
    
    public function down() {
        // Joriy jadvalini o'chirish uchun kod
    }
}
?>