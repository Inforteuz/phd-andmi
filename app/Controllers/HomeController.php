<?php

/**
 * HomeController.php
 *
 * Ushbu fayl, foydalanuvchi tizimiga kirish va chiqish jarayonlarini boshqaruvchi controller'ni o'z ichiga oladi.
 * Foydalanuvchining roli va darajasiga qarab, uni tegishli sahifalarga yo'naltiradi:
 * - Agar foydalanuvchi "superadmin" yoki "admin" bo'lsa, admin paneliga yo'naltiriladi.
 * - Agar foydalanuvchi "user" bo'lsa, foydalanuvchi paneliga yo'naltiriladi.
 * - Agar foydalanuvchi tizimga kirgan bo'lmasa yoki boshqa holatlar yuzaga kelsa, u holda asosiy sahifaga (`home/index`) yo'naltiriladi.
 * 
 * Ushbu controller `BaseController` sinfiga meros qilib olingan va uning umumiy metodlarini ishlatadi.
 * 
 * @package    CodeIgniter Alternative
 * @subpackage Controllers
 * @author     Oyatillo
 * @version    1.0.0
 * @date       2024-12-01
 * 
 * @description
 * 1. `index()` metodida foydalanuvchining roli va darajasi tekshiriladi, va mos ravishda tegishli dashboard'ga yo'naltiriladi.
 * 2. `logoutMessage()` metodida foydalanuvchi tizimdan chiqqanidan keyin chiqariladigan xabarni ko'rsatadi.
 * 
 * Ushbu controller foydalanuvchi sesiyasini boshqarish, yo'naltirish va asosiy sahifada ko'rsatiladigan ma'lumotlarni 
 * uzatish uchun ishlatiladi.
 */

namespace App\Controllers;

use System\BaseController;

class HomeController extends BaseController
{
    /**
     * Foydalanuvchi tizimiga kirish jarayonini boshqaradi.
     * 
     * Agar foydalanuvchi "superadmin" yoki "admin" bo'lsa, admin dashboard'iga yo'naltiriladi.
     * Agar foydalanuvchi "user" bo'lsa, foydalanuvchi dashboard'iga yo'naltiriladi.
     * Boshqa holatlarda, foydalanuvchi tizimdan chiqgan bo'lsa, asosiy sahifaga ko'rsatiladi.
     */
    public function index()
    {
        session_start();

        $role = $_SESSION['role'] ?? null;
        $degree = $_SESSION['degree'] ?? null;

        if ($role === 'superadmin' && $degree == 'Administrator' || $role === 'admin' && $degree == 'Administrator') {
            $this->to('/admin/dashboard');
        } elseif ($role === 'user') {
            $this->to('/user/dashboard');
        } else {
            session_unset();
            session_destroy();
            $this->view('home/index');
        }
    }
    /**
     * Tizimdan chiqish xabarini ko'rsatadi.
     * 
     * Foydalanuvchi tizimdan chiqganligi haqida xabarni asosiy sahifada ko'rsatadi.
     */
    public function logoutMessage()
    {
        $this->view('home/index', [
            'logoutMessage' => 'Siz tizimdan chiqdingiz!'
        ]);
    }
}
?>