<?php
session_start();

$mysqli = new mysqli('localhost', 'magatama', '8810', 'test');

if ($mysqli->connect_error) {
    die("接続失敗: " . $mysqli->connect_error);
}


$sql = "SELECT trx_comments.id, trx_users.user_name, trx_comments.text 
        FROM trx_comments 
        INNER JOIN trx_users ON trx_comments.user_id = trx_users.id";
$result = $mysqli->query($sql);

echo "<table>\n";
echo "<tr><th>ID</th><th>ユーザ名</th><th>コメント</th></tr>\n";
while ($row = $result->fetch_assoc()) {
    echo "<tr>\n";
    echo "<td>{$row['id']}</td>\n";
    echo "<td>{$row['user_name']}</td>\n";
    echo "<td>{$row['text']}</td>\n";
    echo "</tr>\n";
}
echo "</table>\n";

if (isset($_SESSION['user_id'])) {

    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    $csrf_token = $_SESSION['csrf_token'];

    echo <<<FORM
    <h2>コメント投稿</h2>
    <form action="comments.php" method="post">
        <textarea name="comment_text" required></textarea><br>
        <input type="hidden" name="csrf_token" value="$csrf_token">
        <input type="submit" value="投稿">
    </form>
FORM;
}

$mysqli->close();
?>
