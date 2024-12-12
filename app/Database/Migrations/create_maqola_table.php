<?php

use App\Models\UserModel;

class CreateMaqolaTable {
    public function up() {
        $userModel = new UserModel();
        $userModel->createMaqolaTable();
    }
    
    public function down() {
        // Joriy jadvalini o'chirish uchun kod
    }
}
?>