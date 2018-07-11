<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>PHPのサンプル</title>
  </head>
  <body>
      <?php
      //mysqliクラスのオブジェクトを作成
      $mysqli = new mysqli('localhost', 'root', '', 'hello');
      //エラーが発生したら
      if ($mysqli->connect_error){
        print("接続失敗：" . $mysqli->connect_error);
        exit();
      }
      //datasテーブルから日付の降順でデータを取得
      $result = $mysqli->query("SELECT * FROM datas ORDER BY created DESC");
      if($result){
        //1行ずつ取り出し
        while($row = $result->fetch_object()){
          //エスケープして表示
          $username = htmlspecialchars($row->username);
          $comment = htmlspecialchars($row->comment);
          $created = htmlspecialchars($row->created);
          print("$username : $comment ($created)<br>");
        }
      }
      //プリペアドステートメントを作成　ユーザ入力を使用する箇所は?にしておく
      $stmt = $mysqli->prepare("INSERT INTO datas (username,mailAddress, comment) VALUES (?,?,?)");
      //$_POST["name"]に名前が、$_POST["message"]に本文が格納されているとする。
      //?の位置に値を割り当てる
      $stmt->bind_param('sss', $_POST["username"], $_POST["mailAddress"],$_POST["comment"]);
      //実行
      $stmt->execute();
      //切断
      $mysqli->close();
      ?>

      <p>コメントしてください。</p>
      <form method="POST" action="sql_select.php">
        <p><label>名前:<input name="username" placeholder="山田太郎"></label></p>
        <p><label>メールアドレス:<input type="email" name="mailAddress" placeholder="info@example.com"></label></p>
        <p><label>コメント:<input name="comment" /></label></p>
        <input type="submit" value="送信" />
      </form>


  </body>
</html>
