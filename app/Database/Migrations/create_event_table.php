<?php

use App\Models\UserModel;

class CreateEventTable {
    public function up() {
        $userModel = new UserModel();
        $userModel->createEventTable();
    }
    
    public function down() {
        // Joriy jadvalini o'chirish uchun kod
    }
}
?>