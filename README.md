# Absensi Project for Interview

Fitur Utama

 - User Management 
 - Role 
 - Permission
 - Absensi for all user (login lalu checkin/checkout)
 - Pengajuan Ijin
 - Report Absensi
 - List Ijin

## Requirement
-   PHP >= 7.1.3
-   OpenSSL PHP Extension
-   PDO PHP Extension
-   Mbstring PHP Extension
-   Tokenizer PHP Extension
-   XML PHP Extension
-   Ctype PHP Extension
-   JSON PHP Extension
-  MYSQL database
-  Composer

## Step
- Clone
- Pastikan folder storage bisa diakses dan writeable oleh system
- Pastikan webserver sudah terkonfigurasi, gunakan virtualhost dan pakai hostname sesuai kemauan (contoh: cahayabaru.local)
- Pastikan host telah mengarah ke folder public, berikut contoh configurasi virtual host di XAMPP windows
 ```  
 <VirtualHost *:80>
    DocumentRoot "C:\[PATH-TO-PROJECT]\public"
	ServerName [HOSTNAME]
	ErrorLog "[PATH-TO-ERRORLOG]"
	CustomLog "[PATH-TO-ACCESSLOG]" common
    <Directory "C:\[PATH-TO-PROJECT]\public">
       AllowOverride All
       Options Indexes FollowSymLinks       
       Require all granted
    </Directory>
</VirtualHost>
```
- copy file `.env.example` menjadi `.env`
- ubahlah isi `.env` sesuai dengan settingan di server/komputer
- isilah `APP_URL` dan `API_DOMAIN` di `.env` sesuai dengan hostname (contoh: cahayabaru.local)
- pastikan setting DB telah sesuai dengan database yang akan digunakan (pastikan database kosong, untuk setup pertama)
- bila ada perubahan env pastikan telah melakukan `composer dump-autoload`
- lakukan `php artisan migrate`,  `php artisan db:seed`, `php artisan module:seed` secara berurutan
- akses website sesuai dengan hostname yang anda gunakan

## Dummy data

Dalam script seed terdapat beberapa contoh dummy data yang dapat digunakan untuk mencoba program, berikut adalah contoh user yang dapat digunakan untuk proses login

| username       |role                           |password                     |
|----------------|-------------------------------|-----------------------------|
|admin           | Superadmin                    |`qweasd`                     |
|hr1             | HR / Human Resource           |`qweasd`                     |
|employee1       | Employee / Pegawai            |`qweasd`                     |


## Permission

Masing - masing role mempunyai permission yang berbeda, anda dapat mencoba login sesuai dengan role yang anda mau, dan menu untuk setiap role akan berbeda.
