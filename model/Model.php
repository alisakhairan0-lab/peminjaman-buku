<?php
/**
 * Base Model Class
 */
require_once __DIR__ . '/../config/Database.php';

abstract class Model {
    protected $db;
    protected $table;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAll() {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table}");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getById($column, $id) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE {$column} = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function delete($column, $id) {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE {$column} = :id");
        return $stmt->execute([':id' => $id]);
    }
}
