<?php 

namespace App\Schema;

use AbieSoft\Application\Mysql\DB;
use AbieSoft\Application\Mysql\Schema;
class users extends Schema 
{

    public function buattabel()
    {
        $schema = new Schema;
        $schema->paragrap(nama:'alamat');
        $schema->teks(nama:'email', unique:true);
        $schema->enum(nama:'jenis_kelamin', data:['Laki-laki','Perempuan']);
        $schema->teks(nama:'nama');
        $schema->tanggal(nama:'tgl_lahir');
        $schema->angka(nama:'umur', default: 0);
        $sql = $schema->create('users');
        DB::terhubung()->query($sql);
        $this->buatdata();
    }

    public function buatdata()
    {
        
        DB::terhubung()->input('users', [
            'id' => '1',
            'nama' => 'AbieSoft',
            'email' => 'abiesoft@email.com',
            'jenis_kelamin' => 'Laki-laki',
            'alamat' => 'Cirebon',
            'tgl_lahir' => '2006-01-01 00:00:00',
            'umur' => '17',
            'status' => '1',
            'dibuat' => '2023-12-01 01:06:50',
        ]);
        
        DB::terhubung()->input('users', [
            'id' => '2',
            'nama' => 'Hiluna',
            'email' => 'hiluna@email.com',
            'jenis_kelamin' => 'Perempuan',
            'alamat' => 'Cirebon',
            'tgl_lahir' => '2007-02-02 00:00:00',
            'umur' => '16',
            'status' => '0',
            'dibuat' => '2023-12-01 01:06:50',
        ]);
    }
}
$create = new users();
$create->buattabel();
