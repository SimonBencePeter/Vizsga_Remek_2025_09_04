<?php

class User
{
    
    public static function all(): array {
        return Database::fetchAll(
            "SELECT id, username, full_name, role, created_at 
             FROM users ORDER BY id DESC"
        );
    }

    
    public static function find(int $id): ?array {
        return Database::fetch(
            "SELECT id, username, full_name, role 
             FROM users WHERE id = ?",
            [$id]
        );
    }

   
    public static function findByUsername(string $username): ?array {
        $row = Database::fetch(
            "SELECT id, username, password_hash, full_name, role 
             FROM users WHERE username = ? LIMIT 1",
            [$username]
        );
        return $row ?: null;
    }

    
    public static function create(array $data): int {
        $hash = password_hash($data['password'], PASSWORD_DEFAULT);
        return Database::insert('users', [
            'username' => $data['username'],
            'full_name' => $data['full_name'],
            'password_hash' => $hash,
            'role' => $data['role'] ?? 'user'
        ]);
    }

    
    public static function update(int $id, array $data): bool {
        return Database::update('users', [
            'full_name' => $data['full_name'],
            'role' => $data['role']
        ], ['id' => $id]) > 0;
    }

    
    public static function updatePassword(int $id, string $newPassword): bool {
        $hash = password_hash($newPassword, PASSWORD_DEFAULT);
        return Database::update('users', [
            'password_hash' => $hash
        ], ['id' => $id]) > 0;
    }

    public static function delete(int $id): bool {
        return Database::delete('users', ['id' => $id]) > 0;
    }
}
