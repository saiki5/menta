<?php
session_start();
require_once 'Task.php';

// CSRF トークン生成
if (!isset($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}

$errors = [];
$tasks = Task::findAll();

// POST処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hash_equals($_SESSION['token'], $_POST['token'] ?? '')) {
        die('不正なリクエストです。');
    }

    $action = $_POST['action'] ?? '';
    try {
        switch ($action) {
            case 'create':
                Task::create($_POST['title'], $_POST['priority']);
                break;
            case 'update':
                Task::updateStatus($_POST['id'], isset($_POST['is_completed']));
                break;
            case 'edit':
                Task::updateTitle($_POST['id'], $_POST['title']);
                break;
            case 'delete':
                Task::delete($_POST['id']);
                break;
        }
    } catch (Exception $e) {
        $errors[] = $e->getMessage();
    }

    header("Location: index.php");
    exit;
}

include 'index.view.php';
