<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {

    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        echo "不正なリクエストです。";
        exit();
    }

    $mysqli = new mysqli('localhost', 'magatama', '8810', 'test');

    if ($mysqli->connect_error) {
        die("接続失敗: " . $mysqli->connect_error);
    }

    $comment_text = htmlspecialchars($_POST['comment_text'], ENT_QUOTES, 'UTF-8');
    $user_id = $_SESSION['user_id'];

    if (empty($comment_text)) {
        echo "コメントが空です。";
        exit();
    }

  
    $stmt = $mysqli->prepare("INSERT INTO trx_comments (user_id, text) VALUES (?, ?)");
    $stmt->bind_param('is', $user_id, $comment_text);

    if ($stmt->execute()) {
        header('Location: table.php');

    } else {
        echo "エラーが発生しました: " . $stmt->error;
    }

    $stmt->close();
    $mysqli->close();


    unset($_SESSION['csrf_token']);
} else {
    echo "ログインが必要です。";
    exit();
}
?>
