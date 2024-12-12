<?php

use App\Models\UserModel;

class CreateMundarijaTable {
    public function up() {
        $userModel = new UserModel();
        $userModel->createMundarijaTable();
    }
    
    public function down() {
        // Joriy jadvalini o'chirish uchun kod
    }
}
?>