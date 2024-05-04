<?php 
  session_start(); 

  if (!isset($_SESSION['username'])) {//یعنی قبلا مقدار نام کاربری پر نشده و امکان لاگین دارد  
  	$_SESSION['msg'] = "You must log in first";//این بخش با وجود مقدار  تعریف تابع پیغام رو نششون میده 
  	header('location: login.php');
  }
  if (isset($_GET['logout'])) {//یعنی مقدار خروج کاربر  در خط 46 مشخص شده که مقدار برابر 1 هستی یعنی این تابع یکبار تعریف و مشخص شده 
  	session_destroy();// اینجا هم نشستی که فعال شده تا مقادیر رو در خودش ذخیره بکنه  پاک میشه و ورود مجدد فعال میشه با کد های پایین
  	unset($_SESSION['username']);//اینجا هم نام کاربری رو پاک میکنه  و این تکه کد رو به صفحه لاگین وصل میکنه  و امکان ورود مجدد رو فراهم میکنه
  	header("location: login.php");
  }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	
	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<link rel="stylesheet" href="css/style.css">
</head>
<body>

<div>
	<h2 align="center">Welcome Page</h2>
</div>
<div class="#" align="center">
  	<!-- notification message -->
  	<?php if (isset($_SESSION['success'])) : ?> <!-- این مقدار در فایل سرور معرفی شده یعنی بر طبقی از شرط ها این مقدار در حط 52 فایل سرور  موفقیت تعریف شده  --> 
      <div class="error success" >
      	<h3>
          <?php 
          	echo $_SESSION['success']; // یعنی مقدار ساکسز که یک پیامی برای ورود موفقیت امیز هست  رو چاپ بکن و اینجا نشون بده در خط 52 
          	unset($_SESSION['success']); // خب اینجا پیام رو  پاک میکنه 
          ?>
      	</h3>
      </div>
  	<?php endif ?>

    <!-- logged in user information -->
    <?php  if (isset($_SESSION['username'])) : ?><!-- در اینجا هم اگر مقدار نام کاربری تعریف شده باشد و  وجود داشتنه باشد گزینه خروج فعال بشه و پیام موفقیا بیاد -->
    	Welcome <strong><?php echo $_SESSION['username']; ?></strong> <!-- در اینجا چون شرط وجود کاربر هست  نام کابری رو چاپ بکن --> 
    	<a href="index.php?logout='1'">logout</a>  <!--  8 ک در اینجا خروج کاربر برابر یک معلوم شده یعنی درس به منظور اینکه سشن خروج کاربر هست و در  خط  -->
    <?php endif ?>
</div>
		
</body>
</html>
 