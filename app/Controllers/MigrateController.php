<?php

namespace App\Controllers;

use App\Models\UserModel;

class MigrateController {
    
    /**
     * Migratsiyalarni ishga tushuruvchi metod
     * 
     * Ushbu metod `Database/Migrations/` papkasidagi barcha PHP fayllarni topadi va 
     * har bir faylni talab qilingan sinfga aylantiradi. Har bir migratsiya sinfi uchun 
     * `up()` metodini chaqiradi va shu tarzda bazadagi o'zgarishlarni amalga oshiradi.
     *
     * @return void
     */
    public function migrate() {

        // Migratsiya fayllarini olish: Database/Migrations papkasidagi barcha PHP fayllarni 
        // glob() yordamida topish
        $migrationFiles = glob(__DIR__ . '/../Database/Migrations/*.php');

        // Har bir migratsiya faylini o'qish va ishga tushurish
        foreach ($migrationFiles as $migrationFile) {

            // Har bir faylni o'z ichiga olish (require_once) va uni ishlatish
            require_once $migrationFile;

            // Fayl nomidan sinf nomini olish (masalan: migration_1.php -> Migration1)
            $className = basename($migrationFile, '.php');
            // Sinf nomini kerakli formatda o'zgartirish (kam harf bilan ajratilgan so'zlarni katta harfga aylantirish)
            $className = str_replace('_', '', ucwords($className, '_'));

            // Yaratilgan sinfdan obyekt yaratish
            $migration = new $className;

            // `up()` metodini chaqirish (bu metod ma'lum migratsiyani bajaradi)
            $migration->up();

            // Migratsiya ishga tushirildi, shuning uchun ushbu qatorni foydalanuvchi uchun xabar ko'rsatish maqsadida 
            // ishlatish mumkin lekin (komment qilingan, chunki bu har bir sahifada aks etishi mumkin!)
            // echo "Migratsiya ishlatildi: " . $className . "\n";
        }
    }
}
?>