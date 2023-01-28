<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>POSSE ログイン</title>
  <!-- スタイルシート読み込み -->
  <link rel="stylesheet" href="../../assets/styles/common.css">
  <link rel="stylesheet" href="../../admin.css">
  <!-- Google Fonts読み込み -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&family=Plus+Jakarta+Sans:wght@400;700&display=swap"
    rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
  <div class="wrapper">
    <main>
      <div class="container">
        <h1 class="page-theme mb-4">ログイン</h1>
        <div class="mb-3">
          <label for="email" class="form-label">Email:</label>
          <input type="text" name="email" class="email form-control" id="email">
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">パスワード:</label>
          <input type="password" name="password" class="password form-control" id="password">
        </div>
        <button type="submit" class="submit-btn" onclick="signin()">サインイン</button>

      </div>
    </main>
  </div>
  <script>
    const signin=async() => {
      const res=await fetch(`/services/signin.php`,{
        method:"POST",
        body:JSON.stringify({
          email:document.querySelector('#email').value,
          password:document.querySelector('#password').value,

        }),
        headers:{
          'Accept': 'application/json, */*',
          "Content-Type": "application/x-www-form-urlencoded"
        },
      });
      const json=await res.json()
      console.log(json)
      if(res.status === 200){
        alert(json["message"])
        location.href='/../../admin/index.php'
      }else{
        alert(json["error"]["message"])
      }

    }
  </script>
</body>