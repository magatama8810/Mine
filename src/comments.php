<?php
session_start();

$host = 'localhost';
$dbUser = 'magatama';  
$dbPass = '8810';  
$dbName = 'test';         

$mysqli = new mysqli($host, $dbUser, $dbPass, $dbName);

if ($mysqli->connect_error) {
    die("接続失敗: " . $mysqli->connect_error);
}

$user_id = $_SESSION['user_id'];

$comment = htmlspecialchars($_POST['comment'], ENT_QUOTES, 'UTF-8');
echo $comment;
var_dump($comment);

$stmt = $mysqli->prepare("INSERT INTO trx_comments (user_id, text) VALUES (?, ?)");
$stmt->bind_param('is', $user_id, $comment);

// クエリ実行とエラーチェック
if ($stmt->execute()) {
    echo "コメントが正常に登録されました。";
} else {
    echo "エラーが発生しました: " . $stmt->error;
}

// ステートメントを閉じる
$stmt->close();

// データベース接続を閉じる
$mysqli->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
    <h2>コメント追加</h2>
    <form action="comments.php" method="post">
        コメント: <input type="text" name="comment" required/><br/>
        <input type="submit" />
    </form>
</body>
</html>

