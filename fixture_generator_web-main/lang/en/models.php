<?php

return [
    'user' => [
        'model_name' => 'Kullanıcı',

        'student_no' => 'Öğrenci Numarası',
        'group_id' => 'Sınıfı/Grubu',
        'school' => 'Okulu',

        'name' => 'İsim',
        'surname' => 'Soyisim',
        'full_name' => 'Ad Soyad',
        'email' => 'E-Posta',
        'phone' => 'Telefon',
        'tc' => 'TC',
        'birthdate' => 'Doğum Tarihi',
        'address' => 'Adres',
        'role_id' => 'Rol',
        'password' => 'Şifre',
        'job' => 'Meslek',
        'gender' => 'Cinsiyet',

        'register_date' => 'Kayıt Tarihi',
        'parent_info' => 'Veli Bilgileri',
        'student_info' => 'Öğrenci Bilgileri',

        'is_active' => 'Aktiflik Durumu',
        'is_verified' => 'Onaylandı Mı?',
        'profile_image' => 'Profil Resmi',
        'can_tutor' => 'Birebir ders verebilir mi?',
        'password_again' => 'Şifre Tekrarı',
    ],

    'notification' => [
        'models_name' => 'Bildirimler',
        'title' => 'Başlık',
        'content' => 'İçerik',
        'type_id' => 'Alıcılar',
        'created_at' => 'Gönderim Tarihi',
    ],

    'role' => [],

    'role' => [
        'model_name' => 'Roller',
        'name' => 'Rol Adı',
    ],

    'sms' => [
        'model_name' => 'SMS',
        'user_id' => 'Kullanıcı',
        'message' => 'Mesaj',
        'type' => 'Tür',
        'status' => 'Durum',
        'created_at' => 'Gönderim Tarihi',
    ],




    'team' => [
        'name' => 'Name',
        'province_id' => 'Province',
        'is_active' => 'Is Active',
    ],

    "season" => [
        "name" => "Name",
        "gap" => "Gap between periods",
        "start_date" => "Start Date",
        "end_date" => "End Date",
    ]
];
