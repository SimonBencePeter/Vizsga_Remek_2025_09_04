<?php

class Database {
    private static $pdo = null;

   
    public static function connect(): PDO {
        if (self::$pdo) return self::$pdo;

        $cfg = require APP_PATH . '/config/database.php';
        try {
            self::$pdo = new PDO(
                $cfg['dsn'],
                $cfg['user'],
                $cfg['password'],
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_hungarian_ci"
                ]
            );
        } catch (PDOException $e) {
            throw new RuntimeException('Nem sikerült csatlakozni az adatbázishoz.');
        }
        return self::$pdo;
    }

    public static function query($sql, $params = []) {
        $stmt = self::connect()->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public static function fetch($sql, $params = []) {
        return self::query($sql, $params)->fetch();
    }

    public static function fetchAll($sql, $params = []) {
        return self::query($sql, $params)->fetchAll();
    }

    public static function insert($table, $data) {
        $fields = array_keys($data);
        $placeholders = ':' . implode(', :', $fields);
        $sql = "INSERT INTO `$table` (`" . implode('`, `', $fields) . "`) VALUES ($placeholders)";
        self::query($sql, $data);
        return self::connect()->lastInsertId();
    }

    public static function update($table, $data, $where) {
        $set = [];
        foreach ($data as $field => $value) {
            $set[] = "`$field` = :$field";
        }

        $whereClause = [];
        foreach ($where as $field => $value) {
            $whereClause[] = "`$field` = :where_$field";
        }

        $sql = "UPDATE `$table` SET " . implode(', ', $set) . " WHERE " . implode(' AND ', $whereClause);
        $params = array_merge($data, array_combine(
            array_map(fn($k) => "where_$k", array_keys($where)),
            array_values($where)
        ));

        return self::query($sql, $params)->rowCount();
    }

    public static function delete($table, $where) {
        $whereClause = [];
        foreach ($where as $field => $value) {
            $whereClause[] = "`$field` = :$field";
        }
        $sql = "DELETE FROM `$table` WHERE " . implode(' AND ', $whereClause);
        return self::query($sql, $where)->rowCount();
    }
}
