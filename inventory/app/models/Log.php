<?php
class Log {

    public static function getAll(): array {
    return Database::fetchAll("SELECT 
        d.id,
        d.device_name,
        d.device_type,
        d.serial_number,
        d.company_id,
        d.status,
        CAST(d.is_invoiced AS UNSIGNED) AS is_invoiced,
        d.description,
        c.name AS company_name
    FROM devices d
    LEFT JOIN companies c ON d.company_id = c.id
    WHERE d.id = ?
", [$id]) ?: null;
}


    public static function add($userId, string $action, string $entity, int $entityId, $details = null) {
        return Database::query(
            "INSERT INTO logs (user_id, action, entity, entity_id, details) 
             VALUES (:user_id, :action, :entity, :entity_id, :details)",
            [
                ':user_id'   => $userId,
                ':action'    => $action,
                ':entity'    => $entity,
                ':entity_id' => $entityId,
                ':details'   => $details
            ]
        );
    }

    public static function addDiff($userId, string $action, string $entity, int $entityId, array $changes) {
        $payload = json_encode(['changes' => $changes], JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
        return self::add($userId, $action, $entity, $entityId, $payload);
    }
}
