<?php
require_once 'config.php';
require_once 'connectiondb.php';
require_once 'tripledes.php';

class DataBase extends ConnectionDB {
    protected $table;

    public function __construct($table) {
        parent::__construct(Config::LOCALHOST, Config::USER, Config::PASSWORD, Config::DATABASE);
        $this->table = $table;
    }

    public function create(array $data) {
        $res = $this->sql_insert($this->table, $data);
        return $res;
    }

    public function read(array $where = ['1'=>'1']) {
        $res = $this->sql_first($this->table, $where);
        return $res;
    }

    public function readAll(array $where = ['1'=>'1'], array $order = ['1']) {
        $res = $this->sql_select($this->table, $where,['*'],$order);
        return $res;
    }

    public function update(array $data, array $where) {
        $res = $this->sql_update($this->table, $data, $where);
        return $res;
    }

    public function delete(array $where) {
        $res = $this->sql_delete($this->table, $where);
        return $res;
    }

    public function encrypt($data) {
        $td = new TripleDes(Config::SECRET_KEY_3DES, Config::IV_3DES);
        $hash = $td->encrypt($data);
        return $hash;
    }

    public function decrypt($hash) {
        $td = new TripleDes(Config::SECRET_KEY_3DES, Config::IV_3DES);
        $data = $td->decrypt($hash);
        return $data;
    }
}
?>
