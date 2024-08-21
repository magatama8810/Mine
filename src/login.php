<?php
session_start();

$mysqli = new mysqli('localhost', 'magatama','8810', 'test');
if($mysqli->connect_error){
    echo $mysqli->connect_error;
    exit();
}

// 既にログインしているか確認
if(isset($_SESSION['user_id'])) {
    echo "既にログインしています";
    exit();
}

$username = htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8');
$password = htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8');

$password_hash = hash("sha256", $password);

$stmt = $mysqli->prepare("SELECT id, user_name FROM trx_users WHERE user_name = ? AND password = ?");
$stmt->bind_param('ss', $username, $password_hash);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($user_id, $user_name);
    $stmt->fetch();
    
    $_SESSION['user_id'] = $user_id;
    $_SESSION['user_name'] = $user_name;
    
    echo "ようこそ " . $_SESSION['user_name'] . "さん。";
} else {
    echo "ユーザー名またはパスワードが正しくありません。";
}

$stmt->close();
$mysqli->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
    <h2>ログイン</h2>
    <form action="login.php" method="post">
        ユーザ: <input type="text" name="username" /><br/>
        パスワード: <input type="password" name="password" /><br/>
	<input type="submit" />
        <a href="http://localhost:8080/logout.php">ログアウトはこちら
    </form>
</body>
</html>

