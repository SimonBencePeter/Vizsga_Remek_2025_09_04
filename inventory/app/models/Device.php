<?php

class Device
{
    
    public static function search(array $filters, int $limit = 20, int $offset = 0): array {
        [$whereSql, $params] = self::buildWhere($filters);

        $sql = "
            SELECT d.*, c.name AS company_name
            FROM devices d
            LEFT JOIN companies c ON d.company_id = c.id
            $whereSql
            ORDER BY d.id DESC
            LIMIT :limit OFFSET :offset
        ";

        $stmt = Database::connect()->prepare($sql);
        foreach ($params as $k => $v) $stmt->bindValue($k, $v);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    
    public static function count(array $filters): int {
        [$whereSql, $params] = self::buildWhere($filters);

        $sql = "
            SELECT COUNT(*) AS cnt
            FROM devices d
            LEFT JOIN companies c ON d.company_id = c.id
            $whereSql
        ";
        $stmt = Database::connect()->prepare($sql);
        foreach ($params as $k => $v) $stmt->bindValue($k, $v);
        $stmt->execute();
        $row = $stmt->fetch();
        return (int)($row['cnt'] ?? 0);
    }

    
    public static function find(int $id): ?array {
        return Database::fetch("
            SELECT d.*, c.name AS company_name
            FROM devices d
            LEFT JOIN companies c ON d.company_id = c.id
            WHERE d.id = ?
        ", [$id]) ?: null;
    }

    public static function create(array $data): int {
        Database::query("
            INSERT INTO devices (device_name, device_type, serial_number, company_id, status, is_invoiced, description)
            VALUES (:device_name, :device_type, :serial_number, :company_id, :status, :is_invoiced, :description)
        ", [
            ':device_name'   => $data['device_name'],
            ':device_type'   => $data['device_type'],
            ':serial_number' => $data['serial_number'],
            ':company_id'    => $data['company_id'] ?: null,
            ':status'        => $data['status'],
            ':is_invoiced'   => (int)($data['is_invoiced'] ?? 0),
            ':description'   => $data['description'] ?? null,
        ]);
        return (int) Database::connect()->lastInsertId();
    }

    public static function update(int $id, array $data): bool {
        return Database::query("
            UPDATE devices
               SET device_name   = :device_name,
                   device_type   = :device_type,
                   serial_number = :serial_number,
                   company_id    = :company_id,
                   status        = :status,
                   is_invoiced   = :is_invoiced,
                   description   = :description
             WHERE id = :id
        ", [
            ':device_name'   => $data['device_name'],
            ':device_type'   => $data['device_type'],
            ':serial_number' => $data['serial_number'],
            ':company_id'    => $data['company_id'] ?: null,
            ':status'        => $data['status'],
            ':is_invoiced'   => (int)($data['is_invoiced'] ?? 0),
            ':description'   => $data['description'] ?? null,
            ':id'            => $id
        ])->rowCount() > 0;
    }

    public static function delete(int $id): bool {
        return Database::query("DELETE FROM devices WHERE id = ?", [$id])->rowCount() > 0;
    }

  
    private static function buildWhere(array $filters): array {
        $w = [];
        $p = [];

        if (!empty($filters['company_id'])) {
            $w[] = 'd.company_id = :company_id';
            $p[':company_id'] = (int)$filters['company_id'];
        }
        if (!empty($filters['device_name'])) {
            $w[] = 'd.device_name LIKE :device_name';
            $p[':device_name'] = '%' . $filters['device_name'] . '%';
        }
        if (!empty($filters['serial_number'])) {
            $w[] = 'd.serial_number LIKE :serial_number';
            $p[':serial_number'] = '%' . $filters['serial_number'] . '%';
        }
        if (!empty($filters['device_type'])) {
            $w[] = 'd.device_type = :device_type';
            $p[':device_type'] = $filters['device_type'];
        }
        if (!empty($filters['status'])) {
            $w[] = 'd.status = :status';
            $p[':status'] = $filters['status'];
        }
        if (isset($filters['is_invoiced']) && $filters['is_invoiced'] !== '') {
            // '0' vagy '1'
            $w[] = 'd.is_invoiced = :is_invoiced';
            $p[':is_invoiced'] = (int)$filters['is_invoiced'];
        }

        $whereSql = count($w) ? ('WHERE ' . implode(' AND ', $w)) : '';
        return [$whereSql, $p];
    }
}
