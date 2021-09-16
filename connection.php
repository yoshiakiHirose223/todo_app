<?php
require_once('config.php');
require_once('session.php');

function connectPdo()
{
    try {
        return new PDO(DSN, DB_USER, DB_PASSWORD);
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit();
    }
}

function createTodoData($todoText)
{
    $dbh = connectPdo();
    $sql = 'INSERT INTO todos (user_id, content) VALUES (:user_id, :todoText)';
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':user_id', getUserIdFromSession(), PDO::PARAM_INT);
    $stmt->bindValue(':todoText', $todoText, PDO::PARAM_STR);
    $stmt->execute();
}

function getAllRecords()
{
    $dbh = connectPdo();
    $sql = 'SELECT * FROM todos WHERE user_id = :user_id AND deleted_at IS NULL';
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':user_id', getUserIdFromSession(), PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

function updateTodoData($post)
{
    $dbh = connectPdo();
    $sql = 'UPDATE todos SET content = :todoText WHERE user_id = :user_id AND id = :id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':todoText', $post['content'], PDO::PARAM_STR);
    $stmt->bindValue(':user_id', getUserIdFromSession(), PDO::PARAM_INT);
    $stmt->bindValue(':id', $post['id'], PDO::PARAM_INT);
    $stmt->execute();
}

function getTodoTextById($id)
{
    $dbh = connectPdo();
    $sql = 'SELECT * FROM todos WHERE user_id = :user_id AND id = :id AND deleted_at IS NULL';
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':user_id', getUserIdFromSession(), PDO::PARAM_INT);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $data = $stmt->fetch();
    return $data['content'];
}

function deleteTodoData($id)
{
    $dbh = connectPdo();
    $now = date('Y-m-d H:i:s');
    $sql = 'UPDATE todos SET deleted_at = :now WHERE user_id = :user_id AND id = :id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':now', $now, PDO::PARAM_STR);
    $stmt->bindValue(':user_id', getUserIdFromSession(), PDO::PARAM_INT);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
}

function createUser($aud)
{
    $dbh = connectPdo();
    $sql = 'INSERT INTO users (aud) VALUES (:aud)';
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':aud', $aud, PDO::PARAM_STR);
    $stmt->execute();
}

function getUserIdByAud($aud)
{
    $dbh = connectPdo();
    $sql = 'SELECT id FROM users WHERE aud = :aud';
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':aud', $aud, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch();
}

function canCreateUser($aud)
{
    $userId = getUserIdByAud($aud);
    if ($userId) {
        return false;
    } else {
        return true;
    }
}