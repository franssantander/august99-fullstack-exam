<?php
require '../config/Database.php';
require '../models/Book.php';

$db = (new Database())->connect();
$book = new Book($db);

$id = $_POST['id'];
$data = [
    'title' => $_POST['title'],
    'isbn' => $_POST['isbn'],
    'author' => $_POST['author'],
    'publisher' => $_POST['publisher'],
    'year_published' => $_POST['year_published'],
    'category' => $_POST['category'],
];

if ($book->update($id, $data)) {
    echo json_encode(['status' => 'success', 'message' => 'Book updated successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to update book']);
}