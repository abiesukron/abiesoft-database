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
dan ini adalah isi default schema yang sudah dibuat :
```
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

# Membuat Kolom Di Schema Tabel
Sebelum kita membuat kolom untuk tabel users, berikut adalah hal-hal yang perlu diperhatikan untuk menulis kolom di schema tabel.
| Nama | Keterangan | Opsi |
| --- | --- | --- |
| `teks` | Teks simpel atau string | nama, panjang, default, null, unique |
| `paragrap` | Paragrap atau teks panjang | nama, null |
| `tanggal` | Tanggal berformat DATETIME | nama, null |
| `angka` | Angka | nama, panjang, default, null, unique |
| `enum` | Pilihan | nama, data, default |
| `boolean` | Boolean | nama, default |

sekarang kita update file <code>schema/users.php</code> yang sudah kita generate secara otomatis, menambahkan kolom nama, email,jenis kelamin, alamat dan umur pada function <code>buattabel</code> :
```
$schema->teks(nama: 'nama');
$schema->teks(nama: 'email', unique:true);
$schema->enum(nama: 'jenis_kelamin', data:['Laki-laki','Perempuan']);
$schema->paragrap(nama: 'alamat');
$schema->tanggal(nama: 'tgl_lahir');
$schema->angka(nama: 'umur');
$schema->boolean(nama: 'status');
```
menjadi seperti ini :
```
namespace App\Schema;

use AbieSoft\Application\Mysql\DB;
use AbieSoft\Application\Mysql\Schema;
class users extends Schema 
{

    public function buattabel()
    {
        $schema = new Schema;

        $schema->teks(nama: 'nama');
        $schema->teks(nama: 'email', unique:true);
        $schema->enum(nama: 'jenis_kelamin', data:['Laki-laki','Perempuan']);
        $schema->paragrap(nama: 'alamat');
        $schema->tanggal(nama: 'tgl_lahir');
        $schema->angka(nama: 'umur');
        $schema->boolean(nama: 'status');

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
sedangkan untuk function <code>buatdata</code> adalah untuk membuat sample data, kita bisa membuat 1 atau lebih data. contoh kita buat 2 data seperti ini :
```
DB::terhubung()->input('users', [
    'nama' => 'AbieSoft',
    'email' => 'abiesoft@email.com',
    'jenis_kelamin' => 'Laki-laki',
    'alamat' => 'Cirebon',
    'tgl_lahir' => '2006-01-01 00:00:00',
    'umur' => 17,
    'status' => 1,
]);

DB::terhubung()->input('users', [
    'nama' => 'Hiluna',
    'email' => 'hiluna@email.com',
    'jenis_kelamin' => 'Perempuan',
    'alamat' => 'Cirebon',
    'tgl_lahir' => '2007-02-02 00:00:00',
    'umur' => 16,
    'status' => 0,
]);
```
jadi seperti ini :
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

        $schema->teks(nama: 'nama');
        $schema->teks(nama: 'email', unique:true);
        $schema->enum(nama: 'jenis_kelamin', data:['Laki-laki','Perempuan']);
        $schema->paragrap(nama: 'alamat');
        $schema->tanggal(nama: 'tgl_lahir');
        $schema->angka(nama: 'umur');
        $schema->boolean(nama: 'status');

        $sql = $schema->create('users');
        DB::terhubung()->query($sql);
        $this->buatdata();
    }

    public function buatdata()
    {
        DB::terhubung()->input('users', [
            'nama' => 'AbieSoft',
            'email' => 'abiesoft@email.com',
            'jenis_kelamin' => 'Laki-laki',
            'alamat' => 'Cirebon',
            'tgl_lahir' => '2006-01-01 00:00:00',
            'umur' => 17,
            'status' => 1,
        ]);

        DB::terhubung()->input('users', [
            'nama' => 'Hiluna',
            'email' => 'hiluna@email.com',
            'jenis_kelamin' => 'Perempuan',
            'alamat' => 'Cirebon',
            'tgl_lahir' => '2007-02-02 00:00:00',
            'umur' => 16,
            'status' => 0,
        ]);
    }
}
$create = new users();
$create->buattabel();

```