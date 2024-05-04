<?php
session_start();

// initializing variables
$username = "";
$email    = "";
$errors = array(); 

// وصل شدن به دیتا بیس 
$db = mysqli_connect('localhost', 'root', '', 'registration');

// ثبت نام کابر
if (isset($_POST['reg_user'])) {
  // ابن کد مقادیر مورد نیلز رو از فمری که ساختی مثلا فرم ورود و خروج میگیره 
 //از تابع مای اسکیوال اسپیس استرینگ  برای جایگذار مقدار در اس کیو ال  برای روش امن  و با همین تابع در دیتا بیس ذخیره میشه
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

  // به اخر هر تابع اضافه میکند (array_push()) 
  if (empty($username)) { array_push($errors, "Username is required"); }//اگر نام کاربری خالی باشد یک پیغام نشون بده و به تابع ارور ها یکی اضافه بکن
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if ($password_1 != $password_2) { //اگر دوتا رمز عبور باهم تطایق نداشت مجدد به ارور اضافه بکن و پیام بده
	array_push($errors, "The two passwords do not match");
  }

//این تکه کد برای بررسی این است که آیا یک کاربر با نام کاربری یا ایمیلی که کاربر جدید در فرم ثبت نام وارد کرده است، در دیتابیس وجود دارد یا خیر.
//به دنبال ورودی هاش مشابه می گردد
//با استفاده از این کد، می‌توان اطمینان حاصل کرد که نام کاربری یا ایمیلی که کاربر جدید می‌خواهد استفاده کند، تکراری نیست و از قبل در دیتابیس وجود ندارد. این کار از جلوگیری از ثبت نام تکراری کاربران جدید جلوگیری می‌کند.
  $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";// ازجدول کاربران  اطلاعات اشتخراج میکند  و لیمیت یک به معنای  اگر یک رکورد یا بیشتر  پیدا مرد فقط یک رکورد رو یرکرداند 
  $result = mysqli_query($db, $user_check_query);//نتیجه کوئری هست
  $user = mysqli_fetch_assoc($result);//ریسالت رو به صورت یک کلید در هر ستون بارگذاری میکند
  
  if ($user) { // این شرط بررسی میکنه که متغیر یوزر درونش مقداری هست یا نه اکر مقدار نداشته باشه  یعنی کاربر میتونه با ایمیل و نام کاربری که در فرم زده زده ثبت نام بکنه
    if ($user['username'] === $username) {//بررسی میکند  که ایا قبلا نام کاربری کاربر جدید که در حال ثبت نام هست قبلا در دیتابیس ذخیره شده است یا نه  اگ یکسان باشه اخطار میده و تابع ارور یکی اضافه میکنه  و پیام میده
      array_push($errors, "Username already exists");
    }

    if ($user['email'] === $email) {//برای ایمیل هم شرایط بالا رو استفاده میشه فقط به جای نام کاربری شزط بر اسا نام کاربری هست
      array_push($errors, "email already exists");
    }
  }

  // اخرین مرخله از ثبت نام کاربر
  if (count($errors) == 0) {// بررسی میکند که ارایه ارور برابر صفر یاشد یعنی در فرم هیچ خطایی نداشته باشد و کاررب میتواند ثبت نام بکند 
  	$password = md5($password_1);//پسورد قبل از ذخیره شدن   با تابع ام دی 5 به صورت رمزگداری شده و امنیتی ذخیره میشود

  	$query = "INSERT INTO users (username, email, password) 
  			  VALUES('$username', '$email', '$password')";//اطلاعات کاربران رو در جدول ذخیره میکنه
  	mysqli_query($db, $query);//اجرا و دخیره میکنه در دیتا بیس
  	$_SESSION['username'] = $username;//نام کاربری جدید در سشن دخیره میشه تا لاگین پس از ثبت نام خودکار انجام بشه
  	$_SESSION['success'] = "You are now logged in";
  	header('location: index.php');//کاربر به صفحه اصلی منقل میشود
  }
}
// LOGIN USER
if (isset($_POST['login_user'])) {//ایا کاربر دکمه ثیت رو با این اسم زده یا نه
    $username = mysqli_real_escape_string($db, $_POST['username']);//نام کاربری که کاربر در فرم وارد کرئه توسط تابع از تزریق اس کسو ال محافظت میکند د متغیر مشخص شده ذخیره میکند
    $password = mysqli_real_escape_string($db, $_POST['password']);//برای پسورد هم طبق نام کاربری هست توضیخات
  
    if (empty($username)) {//بررسی میکند که فیلد نام کاربری خالی هست یا نه اگر خالی بود اخطار بده و به تابع ارور یکی اضافه بکن
        array_push($errors, "Username is required");
    }
    if (empty($password)) {//دقیقا مثل بخش نام کاربری
        array_push($errors, "Password is required");
    }
  
    if (count($errors) == 0) {//بررسی میکند که ایا تعداد تابع ارور برابر با صفر هست یا نه اگر برابر  با صفر بود امکان بررسی  بقیه موارد رو میدهد
        $password = md5($password);//پسورد قبل از ذخیره شدن   با تابع ام دی 5 به صورت رمزگداری شده و امنیتی ذخیره میشود
        $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";//جستجو کردن کاربران بر اساس نام کاربری و پسورد
        $results = mysqli_query($db, $query);//کوئری را اجرا کرده و نتیجه در متغیر ریزالت دخیره میکند 
        if (mysqli_num_rows($results) == 1) {//این شرط بررسی میکند که ایا تنها یک ردیف (یک کاربر)با اطلاعات وارد شده  یافت شود به این معناست که نام کاربری و رمز عبور درسته
          $_SESSION['username'] = $username;// نام کاربری کاربر وارد شده در سشن ذخیره می‌شود تا بتواند به عنوان کاربر وارد شده شناخته شود.
          $_SESSION['success'] = "You are now logged in";
          header('location: index.php');// کاربر پس از ورود موفق به صفحه اصلی هدایت می‌شود.
        }else {
            array_push($errors, "Wrong username/password combination");
        }
    }
  }
  
  ?>