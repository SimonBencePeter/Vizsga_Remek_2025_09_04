<?php
class Company {
    public static function getAll(): array {
        return Database::fetchAll("
            SELECT 
              id,
              COALESCE(name,'')             AS name,
              COALESCE(city,'')             AS city,
              COALESCE(address,'')          AS address,
              COALESCE(contact_person,'')   AS contact_person,
              COALESCE(contact_email,'')    AS contact_email,
              COALESCE(contact_phone,'')    AS contact_phone
            FROM companies
            ORDER BY name
        ");
    }

    public static function find(int $id): ?array {
        return Database::fetch("
            SELECT 
              id,
              COALESCE(name,'')             AS name,
              COALESCE(city,'')             AS city,
              COALESCE(address,'')          AS address,
              COALESCE(contact_person,'')   AS contact_person,
              COALESCE(contact_email,'')    AS contact_email,
              COALESCE(contact_phone,'')    AS contact_phone
            FROM companies
            WHERE id = ?
        ", [$id]) ?: null;
    }

    public static function create(array $data): int {
    Database::query(
        "INSERT INTO companies (name, city, address, contact_person, contact_email, contact_phone) 
         VALUES (:name, :city, :address, :person, :email, :phone)",
        [
            ':name' => $data['name'],
            ':city' => $data['city'],
            ':address' => $data['address'] ?? '',
            ':person' => $data['contact_person'] ?? '',
            ':email' => $data['contact_email'] ?? '',
            ':phone' => $data['contact_phone'] ?? ''
        ]
    );
    return (int) Database::connect()->lastInsertId();
}


    public static function update(int $id, array $data): bool {
    return Database::query(
        "UPDATE companies 
         SET 
            name = :name,
            city = :city,
            address = :address,
            contact_person = :person,
            contact_email = :email,
            contact_phone = :phone
         WHERE id = :id",
        [
            ':id' => $id,
            ':name' => $data['name'],
            ':city' => $data['city'],
            ':address' => $data['address'] ?? '',
            ':person' => $data['contact_person'] ?? '',
            ':email' => $data['contact_email'] ?? '',
            ':phone' => $data['contact_phone'] ?? ''
        ]
    ) !== false;
}


    public static function delete(int $id): bool {
        return Database::query("DELETE FROM companies WHERE id = ?", [$id])->rowCount() > 0;
    }
}
