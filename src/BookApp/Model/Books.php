<?php

namespace BookApp\Model;


class Books
{
    protected $db;


    public function __construct() {
        $this->db = new \PDO('sqlite:' . BASE_DIR . '/../../db/books.db');
    }

    public function getAll(?string $filter_name = null, ?string $filter_author = null, ?int $filter_year = null): ?array {
        $params = [];
        $where = '';

        if ($filter_name !== null) {
            $where .= ($where === '') ? ' WHERE LOWER(`name`) LIKE ?' : ' AND LOWER(`name`) LIKE ?';
            $params[] = '%' . mb_strtolower($filter_name) . '%';
        }

        if ($filter_author !== null) {
            $where .= ($where === '') ? ' WHERE `author` = ?' : ' AND `author` = ?';
            $params[] = $filter_author;
        }

        if ($filter_year !== null) {
            $where .= ($where === '') ? ' WHERE `year` = ?' : ' AND `year` = ?';
            $params[] = $filter_year;
        }

        $stmt = $this->db->prepare('SELECT `id`, `year`, `name`, `author`, `added`, `isbn` FROM `books`' . $where);

        if ($stmt->execute($params)) {
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        return null;
    }

    public function add(string $name, string $author, int $year, ?string $isbn): bool {
        $last_id = $this->getLastId();

        if ($last_id !== -1) {
            $stmt = $this->db->prepare('INSERT INTO `books` (`id`, `year`, `name`, `author`, `added`, `isbn`) VALUES (?, ?, ?, ?, ?, ?)');
            $exec = $stmt->execute([
                $last_id + 1,
                $year,
                $name,
                $author,
                date('Y-m-d H:i:s'),
                ($isbn)?: ''
            ]);

            return $exec;
        }

        return false;
    }

    public function remove(int $id): bool {
        $stmt = $this->db->prepare('DELETE FROM `books` WHERE `id` = ?');
        return $stmt->execute([$id]);
    }

    public function getAuthors(): ?array {
        $stmt = $this->db->prepare('SELECT DISTINCT `author` FROM `books`');

        if ($stmt->execute()) {
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        return null;
    }

    public function getYears(): ?array {
        $stmt = $this->db->prepare('SELECT DISTINCT `year` FROM `books`');

        if ($stmt->execute()) {
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        return null;
    }

    private function getLastId(): int {
        $stmt = $this->db->prepare('SELECT `id` FROM `books` ORDER BY `id` DESC LIMIT 1');

        if ($stmt->execute()) {
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);

            if (isset($result['id'])) {
                return (int)$result['id'];
            }

            return 0;
        }

        return -1;
    }
}
