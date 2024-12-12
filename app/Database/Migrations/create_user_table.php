<?php

use App\Models\UserModel;

class CreateUserTable {
    public function up() {
        $userModel = new UserModel();
        $userModel->createUserTable();
        $userModel->createUser();
    }
    
    public function down() {
        // Joriy jadvalini o'chirish uchun kod
    }
}
?>