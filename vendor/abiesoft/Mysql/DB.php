<?php

namespace AbieSoft\Application\Mysql;

use AbieSoft\Application\Utilities\Config;
use PDO;
use PDOException;

class DB
{
    private static $terhubung = null;

    private
        $_pdo,
        $_query,
        $_error = false,
        $_hasil,
        $_hitung = 0;

    public function __construct()
    {
        try {
            $this->_pdo = new PDO(
                "mysql:host=" . Config::envReader('DBS_HOST') . ";
                dbname=" . Config::envReader('DBS_NAME'),
                Config::envReader('DBS_USER'),
                Config::envReader('DBS_PASS')
            );
        } catch (PDOException $error) {
            echo "\n\e[0;31mPesan error\e[0m : ". $error->getMessage()."\n\n";
            exit();
        }
    }

    public static function terhubung()
    {
        if (!isset(self::$terhubung)) {
            return new DB();
        }
        return self::$terhubung;
    }

    public function query(string $sql, array $params = [])
    {

        try {
            $this->_error = false;
            if ($this->_query = $this->_pdo->prepare($sql)) {
                $x = 1;
                if (count($params)) {
                    foreach ($params as $p) {
                        $this->_query->bindValue($x, $p);
                        $x++;
                    }
                }
                if ($this->_query->execute()) {
                    $this->_hasil        = $this->_query->fetchAll(PDO::FETCH_OBJ);
                    $this->_hitung       = $this->_query->rowCount();
                } else {
                    $this->_error = true;
                }
            }
            return $this;
        } catch (PDOException $error) {
            echo "\n\e[0;31mPesan error\e[0m : ". $error->getMessage()."\n\n";
            exit();
        }
    }

    public function action(string $action, string $tabel, array $where = [])
    {
        if (count($where) === 3) {
            $daftarsimbol = array('=', '>', '<', '<=', '>=');
            $kolom  = $where[0];
            $simbol = $where[1];
            $nilai  = $where[2];
            if (in_array($simbol, $daftarsimbol)) {
                $sql = "{$action} FROM {$tabel} WHERE {$kolom} {$simbol} ?";
                if (!$this->query($sql, array($nilai))->error()) {
                    return $this;
                }
            }
        }
        return false;
    }


    /*
        Contoh input ke tabel users
        Format Penulisan
        DB::terhubung()->input('users', array(['nama' => $nama, 'alamat' => $alamat ]));
    */

    public function input(string $tabel, array $kolom)
    {
        if (count($kolom)) {
            $keys = array_keys($kolom);
            $value = null;
            $x = 1;

            foreach ($kolom as $k) {
                $value .= '?';
                if ($x < count($kolom)) {
                    $value .= ', ';
                }
                $x++;
            }

            $sql = "INSERT INTO {$tabel} (`" . implode('`, `', $keys) . "`) VALUES ({$value})";


            if (!$this->query($sql, $kolom)->error()) {
                return true;
            }
        }
        return false;
    }

    /*
        Contoh memperbarui data ke tabel users
        Format Penulisan
        DB::terhubung()->perbarui('users', $id, array(['nama' => $nama, 'alamat' => $alamat ]));
    */

    public function perbarui(string $tabel, string $id, array $kolom)
    {
        $set = '';
        $x = 1;
        foreach ($kolom as $nama => $value) {
            $set .= "{$nama} = ?";
            if ($x < count($kolom)) {
                $set .= ', ';
            }
            $x++;
        }
        $sql = "UPDATE {$tabel} SET {$set} WHERE id = '" . $id . "' ";
        if (!$this->query($sql, $kolom)->error()) {
            return true;
        }
        return false;
    }

    public function toString(string $tabel, string $kolom, string $id)
    {
        $cek = $this->query("SELECT {$kolom} FROM {$tabel} WHERE id = '" . $id . "' ");
        if ($cek->hitung()) {
            foreach ($cek->hasil() as $c) {
                return $c->$kolom;
            }
        }
    }

    public function bySlug(string $tabel, string $kolom, string $slug)
    {
        $result = $this->query("SELECT {$kolom} FROM {$tabel} WHERE slug = '" . $slug . "' ")->json();
        return $result;
    }

    /*
        Contoh menghapus data dari tabel users
        Format Penulisan
        DB::terhubung()->hapus('users', array('id_users', '=', 'id'));
    */
    public function hapus(string $tabel, array $where)
    {
        return  $this->action('DELETE ', $tabel, $where);
    }

    /*
        Contoh menampilkan data awal dari tabel users
        Format Penulisan
        DB::terhubung()->cekdata('users', array('id_users', '=', 'id'));
    */

    public function cekdata(string $tabel, array $rwhere): bool
    {
        $total = count($rwhere);
        $x = 1;
        $where = "";
        foreach ($rwhere as $k => $v) {
            if (count(explode("!", $k)) > 1) {
                $operator = " != ";
                $k = explode("!", $k)[1];
            } else {
                $k = $k;
                $operator = " = ";
            }

            if ($x != $total) {
                $and = " AND ";
            } else {
                $and = "";
            }

            $where .= $k . $operator . "'" . $v . "'" . $and;

            $x++;
        }

        $cek = $this->query("SELECT * FROM {$tabel} WHERE {$where} ");
        if (!$cek->hitung()) {
            return false;
        } else {
            return true;
        }
    }

    /*
        Contoh menampilkan data awal dari tabel users
        Format Penulisan
        DB::terhubung()->tampilkan('users', array('id_users', '=', 'id'));
    */

    public function tampilkan(string $tabel, array $where)
    {
        return $this->action('SELECT *', $tabel, $where);
    }

    public function hasil(): array
    {
        return $this->_hasil;
    }

    public function json()
    {
        return json_encode($this->_hasil);
    }

    public function error(): bool
    {
        return $this->_error;
    }

    public function awal(): object
    {
        return $this->hasil()[0];
    }

    public function hitung(): int
    {
        return $this->_hitung;
    }
}
