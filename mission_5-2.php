<!DOCTYPE html>
<html lang = "ja">
    <head>
        <meta charset = "UTF-8">
        <title>mission_5_2</title>
    </head>
    <body>
        <p><strong>好きな音楽は？</strong> アーティストでも曲名でも何でもOK！</p>
        
        <?php
            // DB接続設定
            $dsn = 'mysql:dbname=データベース名;host=localhost';
            $user = 'ユーザー名';
            $password = 'パスワード';
            $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
            $sql = "CREATE TABLE IF NOT EXISTS table_5_2"   // テーブルの作成
            ." ("
            . "id INT AUTO_INCREMENT PRIMARY KEY,"
            . "name char(32),"
            . "comment TEXT,"
            . "date TEXT,"
            . "password TEXT"
            .");";
            $stmt = $pdo->query($sql);
            $sql = 'SHOW TABLES';   // テーブルの表示
            $result = $pdo -> query($sql);
            foreach($result as $row){
                //echo $row[0];
                //echo '<br>';
            }
            echo "<hr>";
            
            if(isset($_POST['edit'])){   // 編集の時
                $id =$_POST["edi"];  // 変更する投稿番号
                $pass3 = $_POST["pass3"];
                
                if($id != '' && $pass3 !=''){
                    $sql = 'SELECT * FROM table_5_2 WHERE id=:id';   // 抽出表示
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                    $stmt->execute();
                    $results = $stmt->fetchAll();
                    foreach($results as $row){
                        // $rowの中にはテーブルのカラム名が入る
                        $edi_name = $row['name'];
                        $edi_com =  $row['comment'];
                        $edi_pass = $row['password'];
                    }
                }
                if($edi_pass == $pass3 && $edi_name !='' && $edi_com !=''){   // 編集でパスワードが正しかったら
        ?>
            <form action ="" method = "post">
                <input type = "text" name = "name" value = <?php echo $edi_name ?> ><br>
                <input type = "text" name = "com" value = <?php echo $edi_com ?> ><br>
                <input type = "hidden" name = "pre" value = <?php echo $id ?> >
                <input type = "password" name = "pass1" placeholder="パスワード" ><br>
                <input type = "submit" name = submit><br><br>
            
                <input type = "number" name = "del" placeholder="削除対象番号"><br>
                <input type = "password" name = "pass2" placeholder="パスワード" ><br>
                <input type = "submit" name = delete value="削除"><br><br>
            
                <input type = "number" name = "edi" placeholder="編集対象番号"><br>
                <input type = "password" name = "pass3" placeholder="パスワード" ><br>
                <input type = "submit" name = edit value="編集"><br><br>
            </form>
        <?php
                }else{   // 編集でパスワードが違ったら
        ?>
            <form action ="" method = "post">
                <input type = "text" name = "name" placeholder="名前"><br>
                <input type = "text" name = "com" placeholder="コメント"><br>
                <input type = "password" name = "pass1" placeholder="パスワード" ><br>
                <input type = "submit" name = submit><br><br>
            
                <input type = "number" name = "del" placeholder="削除対象番号"><br>
                <input type = "password" name = "pass2" placeholder="パスワード" ><br>
                <input type = "submit" name = delete value="削除"><br><br>
            
                <input type = "number" name = "edi" placeholder="編集対象番号"><br>
                <input type = "password" name = "pass3" placeholder="パスワード" ><br>
                <input type = "submit" name = edit value="編集"><br><br>
            </form>
        <?php     
                }
                if($id == ''){
                    echo 'Error: Edit-Number is Empty.<br><br>';
                }elseif($pass3 == ''){
                    echo 'Error: Password is Empty.<br><br>';
                }
            
           }elseif(isset($_POST['delete'])){   // 削除の時
        ?>
            <form action ="" method = "post">
                <input type = "text" name = "name" placeholder="名前"><br>
                <input type = "text" name = "com" placeholder="コメント"><br>
                <input type = "password" name = "pass1" placeholder="パスワード" ><br>
                <input type = "submit" name = submit><br><br>
            
                <input type = "number" name = "del" placeholder="削除対象番号"><br>
                <input type = "password" name = "pass2" placeholder="パスワード" ><br>
                <input type = "submit" name = delete value="削除"><br><br>
            
                <input type = "number" name = "edi" placeholder="編集対象番号"><br>
                <input type = "password" name = "pass3" placeholder="パスワード" ><br>
                <input type = "submit" name = edit value="編集"><br><br>
            </form>
        <?php 
                $id = $_POST["del"];
                $pass2 = $_POST["pass2"];
                if($id == ''){
                    echo 'Error: Delete-Number is Empty.<br><br>';
                }elseif($pass2 == ''){
                    echo 'Error: Password is Empty.<br><br>';
                }elseif($id != '' && $pass2 != ''){
                    
                    $sql = 'SELECT * FROM table_5_2 WHERE id=:id';   // パスワード抽出
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                    $stmt->execute();
                    //$stmt = $pdo->query($sql);
                    $results = $stmt->fetchAll();
                    foreach($results as $row){
                        // $rowの中にはテーブルのカラム名が入る
                        $del_pass = $row['password'];
                    }
                    
                    if($del_pass == $pass2){  // パスワードが等しかったら
                        $sql = 'delete from table_5_2 where id=:id';   // データの削除
                        $stmt = $pdo->prepare($sql);
                        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                        $stmt->execute();
                    }
                }
        
            }elseif(isset($_POST['submit'])){   // 送信の時
        ?>   
            <form action ="" method = "post">
                <input type = "text" name = "name" placeholder="名前"><br>
                <input type = "text" name = "com" placeholder="コメント"><br>
                <input type = "hidden" name = "pre" >
                <input type = "password" name = "pass1" placeholder="パスワード" ><br>
                <input type = "submit" name = submit><br><br>
            
                <input type = "number" name = "del" placeholder="削除対象番号"><br>
                <input type = "password" name = "pass2" placeholder="パスワード" ><br>
                <input type = "submit" name = delete value="削除"><br><br>
            
                <input type = "number" name = "edi" placeholder="編集対象番号"><br>
                <input type = "password" name = "pass3" placeholder="パスワード" ><br>
                <input type = "submit" name = edit value="編集"><br><br>
            </form>
        <?php
                $name = $_POST["name"];
                $comment = $_POST["com"];
                $id = $_POST["pre"];  // 編集する投稿番号
                $pass1 = $_POST["pass1"];
                
                if($name == ''){
                    echo 'Error: Name is Empty.<br><br>';
                }elseif($comment == ''){
                    echo 'Error: Comment is Empty.<br><br>';
                }elseif($pass1 == ''){
                    echo 'Error: Password is Empty.<br><br>';
                }else{
                
                    if( $id == '' ){// 書き込み
                        $sql = $pdo -> prepare("INSERT INTO table_5_2 (name, comment, date, password) VALUES (:name,:comment,:date,:password)");    // データの入力
                        $sql -> bindParam(':name', $name, PDO::PARAM_STR);
                        $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
                        $sql -> bindParam(':date', $date, PDO::PARAM_STR);
                        $sql -> bindParam(':password', $password, PDO::PARAM_STR);
                        $name = $_POST["name"];
                        $comment = $_POST["com"];
                        $date = date("Y/m/d H:i:s");
                        $password = $_POST["pass1"];
                        $sql -> execute();
                 
                    }elseif( $id != '' ){  //編集の送信
                        $sql = 'SELECT * FROM table_5_2 WHERE id=:id';   // パスワード抽出
                        $stmt = $pdo->prepare($sql);
                        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                        $stmt->execute();
                        $results = $stmt->fetchAll();
                        foreach($results as $row){
                            // $rowの中にはテーブルのカラム名が入る
                            $edi_pass = $row['password'];
                        }
                    
                        if($edi_pass == $pass1){
                            $name = $_POST["name"];
                            $comment = $_POST["com"];
                            $date = date("Y/m/d H:i:s");
                            $password = $_POST["pass1"];
                            $sql = 'UPDATE table_5_2 SET name=:name,comment=:comment,date=:date,password=:password WHERE id=:id';
                            $stmt = $pdo->prepare($sql);
                            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                            $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
                            $stmt->bindParam(':date', $date, PDO::PARAM_STR);
                            $stmt->bindParam(':password', $password, PDO::PARAM_STR);
                            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                            $stmt->execute();
                        }
                    }
                }
            }else{
        ?>
            <form action ="" method = "post">
                <input type = "text" name = "name" placeholder="名前"><br>
                <input type = "text" name = "com" placeholder="コメント"><br>
                <input type = "hidden" name = "pre" >
                <input type = "password" name = "pass1" placeholder="パスワード" ><br>
                <input type = "submit" name = submit><br><br>
            
                <input type = "number" name = "del" placeholder="削除対象番号"><br>
                <input type = "password" name = "pass2" placeholder="パスワード" ><br>
                <input type = "submit" name = delete value="削除"><br><br>
            
                <input type = "number" name = "edi" placeholder="編集対象番号"><br>
                <input type = "password" name = "pass3" placeholder="パスワード" ><br>
                <input type = "submit" name = edit value="編集"><br><br>
            </form>
        <?php 
            }
        
        $sql = 'SELECT * FROM table_5_2';  // テーブルの中身表示
        $stmt = $pdo->query($sql);
        $results = $stmt->fetchAll();
        foreach($results as $row){
            // $rowの中にはテーブルのカラム名が入る
            echo $row['id'].'<>';
            echo $row['name'].'<>';
            echo $row['comment'].'<>';
            echo $row['date'].'<br>';
        echo "<hr>";
        }  
        ?>
    </body>
</html>
