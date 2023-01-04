<?php
require_once "../../dbconnect.php";
$db=getDb();
$sql = "SELECT * FROM questions WHERE id = :id";
$stmt = $db->prepare($sql);

$stmt->bindValue(":id",$_GET["id"]);
$stmt->execute();
$question= $stmt->fetch();

$sql = "SELECT * FROM choices WHERE question_id = :question_id";
$stmt = $db->prepare($sql);
$stmt->bindValue(":question_id", $_GET["id"]);
$stmt->execute();
$choices=$stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>POSSE 管理画面ダッシュボード</title>
  <!-- スタイルシート読み込み -->
  <link rel="stylesheet" href="./assets/styles/common.css">
  <link rel="stylesheet" href="./admin.css">
  <!-- Google Fonts読み込み -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&family=Plus+Jakarta+Sans:wght@400;700&display=swap"
    rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="../assets/scripts/common.js" defer></script>
</head>
<body>
  <div class="wrapper">
    <main>
      <div class="container">
        <h1 class="page-theme mb-4">問題編集</h1>
        <form action="../../services/update_question.php" method="post" enctype="multipart/form-data">
          <div class="form-item mb-4">
            <label for="question" class="form-label">問題文:</label>
            <input type="text" name="content" id="question" class="form-control required" value="<?=$question["content"]?>" placeholder="問題文を入力してください">
          </div>
          <div class="form-item mb-4">
            <label class="form-label">選択肢:</label>
            <?php foreach($choices as $key => $choice){?>
              <input type="text" name="choices[]" class="form-control required" value="<?=$choice["name"] ?>" placeholder="選択肢1を入力してください">
            <?php } ?>
          </div>
          <div class="form-item mb-4"> 
            <label class="form-label">正解の選択肢:</label>
            <?php foreach($choices as $key => $choice){ ?>
              <div class="form-check">
                <input type="radio" name="correctChoice" id="correctChoice<?=$key + 1 ?>" value="<?=$key + 1 ?>" <?=$choice["valid"] === 1?'checked':'' ?>>
                <label for="correctChoice<?=$key?>">選択肢<?=$key + 1?></label>
              </div>

            <?php }?>

          </div>
          <div class="form-item mb-4">
            <label for="upload_image" class="form-label">問題の画像</label>
            <input type="file" name="upload_image" id="upload_image" class="form-control required" placeholder="画像を追加してください">

          </div>
          

          <div class="form-item mb-4">
            <label for="supplement" class="form-label">補足:</label>
            <input type="text" name="supplement" id="supplement" class="form-control"value=<?=$question["content"]?> placeholder="補足を入力してください">

          </div>
          <input type="hidden" name="id" value="<?=$question["id"]?>">
          <?php foreach($choices as $key => $choice){?>
            <input type="hidden" name="question_id[]" value="<?=$choice["id"] ?>" >
          <?php } ?>

          <button type="submit" class="submit-btn" >更新</button>
        </form>
      </div>
    </main>
  </div>
</body>
