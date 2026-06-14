<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Login | PawLib</title>


<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
}

html,
body{
width:100%;
height:100%;
overflow:hidden;
}

body{
background:white;
}

.container{
display:flex;
width:100vw;
height:100vh;
}

.left{
width:52%;
padding:40px;
display:flex;
justify-content:center;
align-items:center;
flex-direction:column;
background:#F8E8D8;
position:relative;
}

.left h1{
font-size:56px;
margin-bottom:15px;
color:#E69C62;
}

.left p{
font-size:18px;
max-width:380px;
text-align:center;
line-height:1.6;
color:#666;
}

.left::before{
content:"🐾";
font-size:180px;
opacity:.05;
position:absolute;
}

.right{
width:48%;
display:flex;
justify-content:center;
align-items:center;
background:white;
}

.login-box{
width:380px;
}

.logo{
width:80px;
height:80px;
border-radius:50%;
background:#F8E8D8;
display:flex;
justify-content:center;
align-items:center;
font-size:38px;
margin:0 auto 15px;
}

.title{
font-size:46px;
font-weight:bold;
text-align:center;
color:#E69C62;
margin-bottom:5px;
}

.subtitle{
text-align:center;
font-size:17px;
color:#777;
margin-bottom:25px;
}

label{
font-size:17px;
font-weight:600;
margin-bottom:6px;
display:block;
}

input{
width:100%;
padding:13px;
font-size:16px;
border-radius:12px;
border:1px solid #ddd;
margin-bottom:18px;
}

button{
width:100%;
padding:14px;
border:none;
border-radius:12px;
background:#E69C62;
font-size:18px;
font-weight:bold;
color:white;
margin-top:8px;
cursor:pointer;
}

.footer{
margin-top:20px;
text-align:center;
font-size:14px;
color:#999;
}

</style>

</head>

<body>

<div class="container">

<div class="left">

<h1>PawLib</h1>

<p>
Kelola perpustakaan digital dengan mudah,
cepat, dan efisien.
</p>

</div>

<div class="right">

<div class="login-box">

<div class="logo">

<!-- nanti tinggal ganti -->
🐾

<!-- atau -->
<!--
<img src="<?= base_url('assets/logo.png') ?>">
-->

</div>

<div class="title">
PawLib
</div>

<div class="subtitle">
Perpustakaan Digital
</div>

<form action="<?= base_url('auth/login') ?>" method="post">

<label>Username</label>

<input
type="text"
name="username"
placeholder="Masukkan username"
required
>

<label>Password</label>

<input
type="password"
name="password"
placeholder="Masukkan password"
required
>

<button type="submit">

Masuk

</button>

</form>

<div class="footer">

© 2026 PawLib

</div>

</div>

</div>

</div>

</body>
</html>
