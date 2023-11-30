# AbieSoft Database
Tool ini digunakan untuk mengelola database mysql. Tool simpel ini memungkinkan kita mengelola beberapa fitur sederhana yang tersedia di DBMS seperti membuat tabel atau menghapus tabel, mengimport tabel, membackup data, merestore data dan atau mereset data.

# Install
Silahkan cloning dulu source codenya bisa download, atau cloning dengan cara berikut :
```
git clone https://github.com/abiesukron/abiesoft-database 
```

# Konfigurasi
Buat file <code>.env</code> menggunakan <code>.env_sample</code> lalu atur konfigurasinya sesuai dengan database yang kita gunakan. Kemudian buka <code>Command Prompt</code> atau <code>Window PowerShell</code> untuk menjalankan code berikut :
```
php abiesoft version
```
Jika sudah menampilkan versi dari tool abiesoft, maka tool ini siap digunakan.

# Membuat Schema Tabel
Perintah untuk membuat sebuah schema tabel adalah sebagai berikut. Sebagai contoh kita akan membuat schema tabel untuk <code>users</code>, maka perintahnya adalah :
```
php abiesoft make:schema users
```
Hasilnya sebagai berikut :
```
Sukses! 
Lokasi: schema/users.php
```
dan ini adalah ini default schema yang sudah dibuat :
```
<?php 

namespace App\Schema;

use AbieSoft\Application\Mysql\DB;
use AbieSoft\Application\Mysql\Schema;
class users extends Schema 
{

    public function buattabel()
    {
        $schema = new Schema;
        /*
            contoh membuat kolom nama VARCHAR
            dengan panjang karakter 50
            $schema->teks(nama: 'nama', panjang: 50);
        */
        $sql = $schema->create('users');
        DB::terhubung()->query($sql);
        $this->buatdata();
    }

    public function buatdata()
    {
        /*
            DB::terhubung()->input('users', [
                'nama' => '',
            ]);
        */
    }
}
$create = new users();
$create->buattabel();

```

