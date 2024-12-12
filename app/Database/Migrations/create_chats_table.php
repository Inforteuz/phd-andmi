<?php

use App\Models\UserModel;

class CreateChatsTable {
    public function up() {
        $userModel = new UserModel();
        $userModel->createChatsTable();
    }
    
    public function down() {
        // Joriy jadvalini o'chirish uchun kod
    }
}
?>