<?php
require '../config/Database.php';
require '../models/Book.php';

$db = (new Database())->connect();
$book = new Book($db);

$id = $_POST['id'];

if ($book->delete($id)) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error']);
}
