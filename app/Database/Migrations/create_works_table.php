<?php

use App\Models\UserModel;

class CreateWorksTable {
    public function up() {
        $userModel = new UserModel();
        $userModel->createDarslikTable();
    }
    
    public function down() {
        // Joriy jadvalini o'chirish uchun kod
    }
}
?>