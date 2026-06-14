<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<title>PawLib</title>

<style>
body{
margin:0;
font-family:Arial;
background:#FFF8EE;
display:flex;
}

.sidebar{
width:250px;
height:100vh;
background:#FFFDF9;
box-shadow:4px 0 15px rgba(0,0,0,0.05);
padding:20px;
position:fixed;
box-sizing: border-box;
z-index: 999; /* Biar sidebar gak tertutup banner */
}

.sidebar h2{
color:#E69C62;
}

.sidebar a{
display:flex;
align-items:center;
gap:12px;
padding:14px;
text-decoration:none;
color:#444;
border-radius:14px;
margin-bottom:10px;
font-weight:bold;
}

.sidebar a i{
width:20px;
}

.sidebar a:hover{
background:#FBE7D4;
}

.main{
margin-left:250px;
width:calc(100% - 250px);
display:flex;
flex-direction:column;
min-height:100vh;
}

.topbar{
background:white;
padding:20px;
box-shadow:0 4px 10px rgba(0,0,0,0.05);
font-weight:bold;
display: flex;
justify-content: space-between;
align-items: center;
box-sizing: border-box;
width: 100%;
}

.topbar-left {
display: flex;
align-items: center;
}

.content{
padding:40px;
flex:1;
box-sizing:border-box;
}


.footer{
background:white;
padding:20px;
text-align:center;
}

#toggle-btn{
background:none;
border:none;
font-size:24px;
cursor:pointer;
margin-right:15px;
}

body.hide-sidebar .sidebar{
transform:translateX(-100%);
}

body.hide-sidebar .main{
margin-left:0;
width:100%;
}

.sidebar{
transition:.3s;
}

.main{
transition:.3s;
}
</style>

</head>
<body id="body">

<div class="main">
    
    <div class="topbar">
        <div class="topbar-left">
            <button id="toggle-btn"><i class="fa fa-bars"></i></button>
            <span>PawLib Dashboard</span>
            
            <?php if (session()->get('logged_in')) : ?>
                <a href="/auth/logout" onclick="return confirm('Yakin ingin keluar dari PawLib?')" style="color: #EF4444; text-decoration: none; font-weight: bold; margin-left: 20px; display: inline-flex; align-items: center; gap: 5px;">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            <?php else : ?>
                <a href="/auth" style="color: #E69C62; text-decoration: none; font-weight: bold; margin-left: 20px; display: inline-flex; align-items: center; gap: 5px;">
                    <i class="fas fa-sign-in-alt"></i> Login
                </a>
            <?php endif; ?>
        </div>
    </div>

    <div class="content">