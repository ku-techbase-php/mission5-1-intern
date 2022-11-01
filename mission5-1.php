<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset ="UTF-8">
    <title>mission5-1</title>
</head>   
<body>
 　　
 　　<form action="" method="post">
  <input type="text" name="name"
  placeholder="名前" value="<?php if(!empty($edName)){echo $edName;}?>">
  <br>
  <input type="text" name="comment"
   placeholder="コメント" value="<?php if(!empty($edComment)){echo $edComment;} ?>">
   <input type="hidden" name="editnum" placeholder=""
   value="<?php if(!empty($edit)){echo $edit;} ?>">
   <br>
   <input type="text" name="comppass" placeholder="パスワード">
   <input type="submit" name="submit" >
   <br>
   <hr>
    
  <input type="text" name="delete" placeholder="削除対象番号">
   <br>
   <input type="text" name="delpass" placeholder="パスワード">
   <input type="submit" name="submit" value="削除" >
   <br>
   <hr>
    
   <input type="text" name="edit" placeholder="編集対象番号">
   <br>
   <input type="text" name="editpass" placeholder="パスワード">
   <input type="submit" name="submit" value="編集">
  <hr>
</form>
    
        
    <?php
    //データベース接続設定
    $dsn = 'データベース名';
    $user = 'ユーザー名';
    $password = 'パスワード';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    
    //接続した
    
    //データベース内にテーブルを作成
     $sql = "CREATE TABLE IF NOT EXISTS tb_2"
    ." ("
    . "id INT AUTO_INCREMENT PRIMARY KEY,"
    . "name char(32),"
    . "comment TEXT"
    .");";
    $stmt = $pdo->query($sql);
    
    //テーブル作成
    
 
  
  
  //送信ボタンが押されたとき
  if(!empty($_POST['submit'])) {
    $name = $_POST['name'];
    $comment = $_POST['comment'];
    $editnum = $_POST['editnum'];
  }

  //削除ボタンが押されたとき
  if(!empty($_POST['delete'])) {
    $delete = $_POST['delnum'];
    $delpass = $_POST['delpass'];
  }

  //編集ボタンが押されたとき
  if(!empty($_POST['edit'])) {
    $editnum = $_POST['editnum'];
    $editpass = $_POST['editpass'];
  }

   //削除機能
   if(!empty($delete)) {  
    $sql = 'SELECT * FROM tb_2 WHERE id=:id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $delete, PDO::PARAM_INT); 
    $stmt->execute();
    $results = $stmt->fetchAll();
    foreach ($results as $row) {
        if ($delpass == $row){
            $sql = 'DELETE FROM tb_2 WHERE id=:id';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $delete, PDO::PARAM_INT);
            $stmt->execute();
        }else{
            echo "パスワードが違います<br>";
        }
    }  
}

  //編集機能
  if(!empty($edit)) {
    $spl = 'SELECT * FORM tb_2 WHERE id=:id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(';id', $editnum,PDO::PARAM_INT);
    $stmt->execute();
    $results = $stmt->fetchAll();
    foreach($results as $row) {
      if($editpass == $row['compass']) {
        $editnum_form = $row['id'];
        $editname_form = $row['name'];
        $editcom_form = $row['comment'];
      } else {

        echo "パスワードが違います";
      }
    }
  }

 
 
 //名前とコメントとパスワードがあるなら
  $date=date("Y/m/d/ H:i:s");
 if(!empty($name) && !empty($comment)){

  //編集番号が送信されたなら編集モード
  if(!empty($editnum)) {
      $sql = 'UPDATE tb_2 SET name=:name,comment=:comment,time=:time WHERE id=:id';
      $stmt = $pdo->prepare($sql);
      $stmt->bindParam(':name', $name, PDO::PARAM_STR);
      $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
      $stmt->bindParam(':id', $edit, PDO::PARAM_INT);
      $stmt->execute();

  //編集番号が送信されてないなら追記モード
  }else{    
      $sql = $pdo -> prepare("INSERT INTO tb_2 (name, comment) VALUES (:name,:comment)");
      $sql -> bindParam(':name', $name, PDO::PARAM_STR);
      $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
      $sql -> execute();
  }
}




  
    $sql = 'SELECT * FROM tb_2';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
        echo $row['id'].', ';
        echo $row['name'].', ';
        echo $row['comment'].', ';
        echo "<hr>";
    }
    
   
    
    
    ?>
</body>
</html>