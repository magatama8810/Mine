<?php
session_start();

if (isset($_SESSION['user_id'])) {
    // セッション変数を全てクリア
    $_SESSION = array();

    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    session_destroy();

    echo "ログアウトしました。";
} else {
    echo "セッションが存在しません。ログインしてください。";
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
    <h2>ログアウト</h2>
    <form action="logout.php" method="post">
	<button type="submit" name="logout" value="send">ログアウト</button>
        <br/>
	<a href="http://localhost:8080/login.php">ログインはこちら
        <br/>
        <a href="http://localhost:8080/newUser.php">新規の方はこちら
    </form>
</body>
</html>

