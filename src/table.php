<?php

$mysqli = new mysqli('localhost', 'magatama', '8810', 'test');

if ($mysqli->connect_error) {
    echo $mysqli->connect_error;
    exit();
}

// 課題：結合したテーブルをSELECTして$result変数に格納する処理を書く
$sql = "
    SELECT 
        trx_comments.id,
        trx_users.user_name,
        trx_comments.text
    FROM 
        trx_comments
    INNER JOIN 
        trx_users
    ON 
        trx_comments.user_id = trx_users.id
";

$result = $mysqli->query($sql);

if (!$result) {
    echo "クエリの実行に失敗しました: " . $mysqli->error;
    exit();
}

echo "<table>\n";
echo "<tr><th>ID</th><th>ユーザ名</th><th>コメント</th></tr>\n";
while ($row = $result->fetch_assoc()) {
    $html = <<<TEXT
<tr>
  <td>{$row['id']}</td>
  <td>{$row['user_name']}</td>
  <td>{$row['text']}</td>
</tr>
TEXT;
    echo $html;
}
echo "</table>";

$result->free();

$mysqli->close();

?>

