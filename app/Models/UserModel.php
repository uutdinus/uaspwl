<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users'; // Nama tabel di database
    protected $primaryKey = 'id'; // Nama kolom primary key

    protected $allowedFields = ['name', 'email', 'username', 'password', 'role']; // Kolom-kolom yang dapat diisi

    protected $useTimestamps = true; // Aktifkan penggunaan timestamp

    // Aturan validasi untuk data yang dimasukkan
    protected $validationRules = [
        'name' => 'required',
        'email' => 'required|valid_email|is_unique[users.email]',
        'username' => 'required|is_unique[users.username]',
        'password' => 'required|min_length[8]',

    ];

    // Pesan kesalahan untuk aturan validasi
    protected $validationMessages = [
        'email.is_unique' => 'Email sudah digunakan.',
        'username.is_unique' => 'Nama pengguna sudah digunakan.',

    ];
}
