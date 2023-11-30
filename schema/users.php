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
