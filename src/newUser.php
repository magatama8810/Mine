<?php
$host = 'localhost';
$dbUser = 'magatama';  
$dbPass = '8810';  
$dbName = 'test';          

$mysqli = new mysqli($host, $dbUser, $dbPass, $dbName);

if ($mysqli->connect_error) {
    echo $mysqli->connect_error;
    exit();
}

$username = trim(htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8'));
$password = trim(htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8'));

$password_hash = hash("sha256", $password);

if(!empty($username)){
// データベースにユーザ情報をINSERT
$stmt = $mysqli->prepare("INSERT INTO trx_users (user_name, password) VALUES (?, ?)");
$stmt->bind_param('ss', $username, $password_hash);

if ($stmt->execute()) {
    echo "ユーザ情報が正常に登録されました。";
} else {
    echo "エラーが発生しました: " . $stmt->error;
}

// ステートメントを閉じる
$stmt->close();

// データベース接続を閉じる
$mysqli->close();


}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
    <h2>ユーザ追加</h2>
    <form action="newUser.php" method="post">
        ユーザ: <input type="text" name="username" required/><br/>
        パスワード: <input type="password" name="password" required/><br/>
        <a href="http://localhost:8080/login.php">ログインはこちら
            <br/>
        <input type="submit" />
    </form>
</body>
</html>

