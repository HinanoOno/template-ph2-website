<header>
  <div>
    <img src="../../assests_sample/img/logo.svg" alt="">
    <button onclick="signout()">ログアウト</button>
  </div>
</header>
<script>
  const signout=async()=>{
    const res=await fetch(`/../services/signout.php`,{
      method:"DELETE",
      headers:{
        'Accept': 'application/json, */*',
        "Content-Type": "application/x-www-form-urlencoded"
      },
    });
    if(res.status===204){
      alert('ログアウトしました')
      location.href='/../../quiz3.php'
    }
    else{
      alert('ログアウトできませんでした')
    }
  }
</script>