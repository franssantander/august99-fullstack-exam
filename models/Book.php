<?php
class Book
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function add($data)
    {
        $stmt = $this->conn->prepare("INSERT INTO books (title, isbn, author, publisher, year_published, category) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $data['title'], $data['isbn'], $data['author'], $data['publisher'], $data['year_published'], $data['category']);
        return $stmt->execute();
    }

    public function getAll()
    {
        $result = $this->conn->query("SELECT * FROM books ORDER BY id DESC");
        $books = [];
        while ($row = $result->fetch_assoc()) {
            $books[] = $row;
        }
        return $books;
    }

    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM books WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function update($id, $data)
    {
        $stmt = $this->conn->prepare("UPDATE books SET title = ?, isbn = ?, author = ?, publisher = ?, year_published = ?, category = ? WHERE id = ?");
        $stmt->bind_param("ssssssi", $data['title'], $data['isbn'], $data['author'], $data['publisher'], $data['year_published'], $data['category'], $id);
        return $stmt->execute();
    }
}
