<?php

/**

 * Database Connection Class (OOP Singleton Pattern)

 * UKK RPL Paket 4 - Perpustakaan Digital SMK

 */

class Database {
    private $host = "sql103.infinityfree.com";
    private $user = "if0_42759950";
    private $pass = "N4VhNZeZ2y";
    private $dbname = "if0_42759950_xii_rpl_1_alisa_paket4";
    private $charset = "utf8mb4";
    private static $instance = null;
    private $dbh;
    private $error;

    private function __construct() {
        $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->dbname . ";charset=" . $this->charset;
        $options = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            die("Koneksi Database Gagal: " . $this->error . "<br>Pastikan database <b>xii_rpl_1_alisa_paket4</b> sudah di-import di phpMyAdmin!");

        }

    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->dbh;
    }

}

?>