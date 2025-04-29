<?php
require '../config/Database.php';
require '../models/Book.php';

$db = (new Database())->connect();
$book = new Book($db);

$books = $book->getAll();

echo json_encode($books);