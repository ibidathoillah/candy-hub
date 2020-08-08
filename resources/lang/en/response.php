<?php

return [
    'error' => [
        '200'            => 'Anda tidak bisa membuat kesalahan pada 200 kode respon',
        'unauthorized'   => 'Unauthorized',
        'wrong_args'     => 'Argumen salah',
        'not_found'      => 'Sumber daya tidak ditemukan',
        'internal'       => 'Kesalahan server internal',
        'forbidden'      => 'Terlarang',
        'invalid_lang'   => 'Kode bahasa tidak valid {:lang}',
        'minimum_record' => 'Anda harus memiliki setidaknya 1 record yang diaktifkan dalam database',
        'expired'        => 'Resource ini telah kadaluarsa',
    ],
    'success' => [
        'sync' => ':element berhasil disinkronkan',
    ],
    'token' => [
        'missing' => 'Token otorisasi tidak ada dari permintaan',
        'expired' => 'Token otorisasi telah kadaluarsa',
        'invalid' => 'Token otorisasi tidak valid',
    ],
];
