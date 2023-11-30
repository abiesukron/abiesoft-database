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

# Mengimport tabel
Untuk mengimport tabel gunakan perintah berikut :
```
php abiesoft db:import
```
setelah kita jalankan akan mendapatkan informasi bahwa tabel sudah diimport seperti ini :
```
-- Tabel users sudah diimport. 

Sukses! 
Total: 1 tabel 
```
Ketika kita menjalankan perintah ini, sistem akan membuatkan secara otomatis tabel <code>migrasi</code> sebagai tempat untuk menyimpan catatan tabel mana saja yang sudah diimport dan tabel mana yang belum diimport. jadi ketika kita menjalankan tabel import ini berulang tidak akan menimpa tabel yang sudah pernah kita import dan hanya akan mengimport tabel yang belum diimport saja.

# Membackup data
Untuk membackup data gunakan perintah berikut :
```
php abiesoft db:backup
```
lalu buat nama backup atau langsung enter lagi untuk nama backup secara default
```
Nama backup datanya apa?
Ketik nama backup (nama tidak menggunakan spasi), atau
Tekan [Enter] untuk melanjutkan dengan nama default
Nama backup : 
```
Jika data berhasil dibackup akan menampilkan informais seperti ini :
```
-- Tabel users sudah dibackup. 

Backup Selesai! 
Total: 1 tabel 
Lokasi: backup/abiesoft_01_12_2023_01 
```
Perintah backup ini hanya membackup tabel yang sudah berisi data.

# Merestore Data
Merestore atau memulihkan data, gunakan perintah berikut :
```
php abiesoft db:restore
```
lalu akan tampil data-data yang sudah pernah kita backup, pilih angkanya lalu enter seperti contoh berikut :
```
Silahkan pilih data yang akan direstore?
[1] abiesoft_01_12_2023_01
Tekan [Enter] untuk membatalkan
Angka pilihan anda :
```
setelah berhasil direstore akan ada informasi seperti ini :
```
-- Tabel users sudah direstore. 

Sukses! 
Total: 1 tabel dipulihkan
```

# Mereset Ulang Data
Mereset ulang data, gunakan perintah berikut :
```
php abiesoft db:refresh
```
perintah ini akan mengembalikan data seperti data yang ada di folder schema ketika pertama kali di import
setelah berhasil informasinya akan seperti ini :
```
-- Tabel users sudah dihapus. 
-- Tabel users sudah diimport. 

Sukses! 
Total: 1 tabel 
```