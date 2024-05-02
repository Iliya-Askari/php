# توضیحات فایل `server.php`

1. **Session Start**:
   ```php
   session_start();
   ```
   این خط کد نشان می‌دهد که جلسه‌ی کاربر را آغاز کنید. جلسه‌ها اطلاعاتی را بین صفحات و وب سرور ذخیره می‌کنند.

2. **تعریف متغیرها**:
   ```php
   $username = "";
   $email    = "";
   $errors = array(); 
   ```
   در اینجا متغیرهای مختلفی برای نام کاربری، ایمیل و خطاها تعریف شده‌اند. متغیر `$errors` برای ذخیره‌ی خطاهایی است که ممکن است در فرآیند ثبت نام یا ورود کاربر رخ دهد.

3. **اتصال به پایگاه داده**:
   ```php
   $db = mysqli_connect('localhost', 'root', '', 'registration');
   ```
   این کد به پایگاه داده‌ی MySQL متصل می‌شود. اطلاعات اتصال شامل میزبان (localhost)، نام کاربری (root)، رمز عبور (خالی) و نام پایگاه داده (registration) است.

4. **ثبت نام کاربر**:
   ```php
   if (isset($_POST['reg_user'])) {
   ```
   این بخش از کد بررسی می‌کند که آیا فرم ثبت نام توسط کاربر ارسال شده است یا خیر.

5. **استخراج و اعتبارسنجی اطلاعات از فرم**:
   ```php
   $username = mysqli_real_escape_string($db, $_POST['username']);
   $email = mysqli_real_escape_string($db, $_POST['email']);
   $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
   $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);
   ```
   این بخش اطلاعاتی که کاربر در فرم ثبت نام وارد کرده است را استخراج و اعتبارسنجی می‌کند. متغیرهای `username`، `email`، `password_1` و `password_2` اطلاعاتی هستند که کاربر در فرم وارد کرده است.

6. **بررسی وجود خطاها**:
   ```php
   if (empty($username)) { array_push($errors, "Username is required"); }
   if (empty($email)) { array_push($errors, "Email is required"); }
   if (empty($password_1)) { array_push($errors, "Password is required"); }
   if ($password_1 != $password_2) {
       array_push($errors, "The two passwords do not match");
   }
   ```
   در این بخش، بررسی می‌شود که آیا هر یک از فیلدها پر شده‌اند یا خیر، و همچنین اعتبارسنجی رمز عبور. اگر خطا وجود داشته باشد، آنها به آرایه خطاها اضافه می‌شوند.

7. **بررسی وجود کاربر در پایگاه داده**:
   ```php
   $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
   $result = mysqli_query($db, $user_check_query);
   $user = mysqli_fetch_assoc($result);
   ```
   در اینجا، بررسی می‌شود که آیا نام کاربری یا ایمیل وارد شده توسط کاربر قبلاً در پایگاه داده ثبت شده است یا خیر.

8. **ذخیره‌ی کاربر جدید در پایگاه داده**:
   ```php
   if (count($errors) == 0) {
       $password = md5($password_1);
       $query = "INSERT INTO users (username, email, password) VALUES('$username', '$email', '$password')";
       mysqli_query($db, $query);
       $_SESSION['username'] = $username;
       $_SESSION['success'] = "You are now logged in";
       header('location: index.php');
   }
   ```
   در اینجا، اگر هیچ خطایی وجود نداشته باشد، اطلاعات کاربر جدید به پایگاه داده اضافه می‌شود و کاربر به صفحه‌ی اصلی هدایت می‌شود.

9. **ورود کاربر**:
   ```php
   if (isset($_POST['login_user'])) {
   ```
   این بخش از کد بررسی می‌کند که آیا فرم ورود توسط کاربر ارسال شده است یا خیر.

10. **اعتبارسنجی اطلاعات ورود کاربر**:
    ```php
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
    ```
    در اینجا، اطلاعات ورودی کاربر (نام کاربری و رمز عبور) از فرم استخراج و اعتبارسنجی می‌شود.

11. **بررسی ورودی‌ها و ورود کاربر به سیستم**:


    ```php
    if (count($errors) == 0) {
        $password = md5($password);
        $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
        $results = mysqli_query($db, $query);
        if (mysqli_num_rows($results) == 1) {
            $_SESSION['username'] = $username;
            $_SESSION['success'] = "You are now logged in";
            header('location: index.php');
        } else {
            array_push($errors, "Wrong username/password combination");
        }
    }
    ```
    اگر هیچ خطایی وجود نداشته باشد، اعتبارسنجی اطلاعات ورودی کاربر با اطلاعات موجود در پایگاه داده انجام می‌شود. اگر اطلاعات مطابقت داشته باشند، کاربر به صفحه‌ی اصلی هدایت می‌شود. در غیر این صورت، یک پیغام خطا نمایش داده می‌شود که اطلاعات ورودی اشتباه است.

___

# توضیحاتی در مورد کدها در PHP

## session_start():
این تابع برای شروع یک نشست (session) در PHP استفاده می‌شود. نشست‌ها برای نگهداری وضعیت کاربر (مانند ورود یا خروج) و داده‌هایی که بین صفحات وبسایت به اشتراک گذاشته می‌شود، استفاده می‌شوند.

## array():
در PHP، یک آرایه یک مجموعه از داده‌ها است که می‌تواند شامل رشته‌ها، اعداد و سایر نوع داده‌ها باشد. به عنوان مثال، `$errors` یک آرایه است که برای ذخیره پیام‌های خطا استفاده می‌شود.

## mysqli_connect():
این تابع برای برقراری ارتباط با یک پایگاه داده MySQL استفاده می‌شود. برای استفاده از این تابع، نیاز است به مشخص کردن نام کاربری و رمز عبور پایگاه داده، هاست، و نام پایگاه داده.

## mysqli_real_escape_string():
این تابع برای تمیزکاری داده‌های ورودی استفاده می‌شود تا جلوی حملاتی مانند حمله SQL Injection را بگیرد. به عبارت دیگر، این تابع کاراکترهای ویژه مانند `'` یا `"` را به شکلی جلوی آنها را می‌گیرد تا باعث ایجاد مشکل در پرس و جوی SQL نشود.

## empty():
این تابع بررسی می‌کند که آیا یک متغیر خالی است یا نه. اگر متغیر خالی باشد یا وجود نداشته باشد، مقدار `true` برگردانده می‌شود؛ در غیر این صورت، مقدار `false`.

## array_push():
این تابع یک یا چند عنصر را به آخر آرایه اضافه می‌کند.

## mysqli_query():
این تابع یک پرس و جو را در پایگاه داده اجرا می‌کند و نتایج آن را برمی‌گرداند.

## mysqli_fetch_assoc():
این تابع یک ردیف از نتایج یک پرس و جو را به صورت یک آرایه انجمنی (Associative Array) بازمی‌گرداند.

## count():
این تابع تعداد عناصر یک آرایه را برمی‌گرداند.

## isset():
این تابع بررسی می‌کند که آیا یک متغیر تعیین شده است یا نه. اگر متغیر تعیین شده باشد و مقدار آن null نباشد، `true` برمی‌گرداند؛ در غیر این صورت، `false`.

## md5():
این تابع یک رشته را به شکل رمزنگاری شده MD5 تبدیل می‌کند.

## mysqli_num_rows():
این تابع تعداد ردیف‌های بازگشتی از یک پرس و جو را برمی‌گرداند.

## header():
این تابع به مرورگر می‌گوید که به یک صفحه مشخص هدایت شود.

___

# توضیحات فایل `index.php`

### بخش 1: شروع جلسه (Session Start)
```php
<?php 
  session_start(); 
?>
```
این خط کد به PHP می‌گوید که جلسه (session) را شروع کند یا اگر قبلاً شروع شده است، آن را ادامه دهد.

### بخش 2: بررسی ورود کاربر
```php
<?php 
  if (!isset($_SESSION['username'])) {
  	$_SESSION['msg'] = "You must log in first";
  	header('location: login.php');
  }
?>
```
در این بخش، ابتدا چک می‌شود که آیا نام کاربری در جلسه تعیین شده است یا خیر. اگر نه، پیام "You must log in first" به کاربر نمایش داده می‌شود و او به صفحه ورود (login.php) هدایت می‌شود.

### بخش 3: خروج از حساب کاربری
```php
<?php 
  if (isset($_GET['logout'])) {
  	session_destroy();
  	unset($_SESSION['username']);
  	header("location: login.php");
  }
?>
```
در این بخش، بررسی می‌شود که آیا درخواست خروج از حساب کاربری صورت گرفته است یا خیر. اگر بله، جلسه حذف می‌شود و کاربر به صفحه ورود (login.php) هدایت می‌شود.

### بخش 4: بخش HTML
```html
<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
```
این بخش شامل تگ‌های ابتدایی HTML صفحه است، شامل عنوان صفحه و لینک به CSS برای استایل‌دهی.

### بخش 5: عنوان صفحه
```html
<div>
	<h2 align="center">Welcome Page</h2>
</div>
```
این بخش شامل یک دیو (div) است که شامل یک عنوان `<h2>` به نام "Welcome Page" است.

### بخش 6: نمایش پیام‌ها و اطلاعات کاربر
```html
<div class="#" align="center">
  	<!-- notification message -->
  	<?php if (isset($_SESSION['success'])) : ?>
      <div class="error success" >
      	<h3>
          <?php 
          	echo $_SESSION['success']; 
          	unset($_SESSION['success']);
          ?>
      	</h3>
      </div>
  	<?php endif ?>

    <!-- logged in user information -->
    <?php  if (isset($_SESSION['username'])) : ?>
    	Welcome <strong><?php echo $_SESSION['username']; ?></strong>
    	<a href="index.php?logout='1'">logout</a> 
    <?php endif ?>
</div>
```
در این بخش، اطلاعیه‌ها و اطلاعات کاربر نمایش داده می‌شود. اگر یک اطلاعیه موفقیت‌آمیز وجود داشته باشد، آن نمایش داده می‌شود و از جلسه حذف می‌شود. همچنین اگر کاربر وارد شده باشد، نام کاربری نمایش داده می‌شود و یک لینک برای خروج (logout) نمایش داده می‌شود.

### بخش 7: بستن تگ‌های HTML
```html
</body>
</html>
```
این بخش شامل بستن تگ‌های HTML است.

___

# توضیخات فایل `eror.php`
این قطعه کد PHP یک بررسی انجام می‌دهد که آیا آرایه `$errors` حاوی خطاهایی است یا خیر. اگر تعداد خطاها بیشتر از صفر باشد، آنها را به کاربر نمایش می‌دهد. در غیر این صورت، هیچ خطایی نمایش داده نمی‌شود. حالا بیایید این کد را به صورت بخش‌های کوچکتر تجزیه کنیم و توضیح دهیم:

### بخش 1: بررسی تعداد خطاها
```php
<?php if (count($errors) > 0) : ?>
```
در این بخش، چک می‌شود که آیا تعداد خطاها در آرایه `$errors` بیشتر از صفر است یا خیر.

### بخش 2: نمایش خطاها
```php
  <div class="error">
  	<?php foreach ($errors as $error) : ?>
  	  <p><?php echo $error ?></p>
  	<?php endforeach ?>
  </div>
```
در این بخش، اگر تعداد خطاها بیشتر از صفر باشد، هر خطا به عنوان یک پاراگراف (`<p>`) درون یک دیو (div) با کلاس "error" قرار می‌گیرد.

### بخش 3: بستن شرط
```php
<?php endif ?>
```
این بخش پایانی شرط است و نشان می‌دهد که بررسی تعداد خطاها به اتمام رسیده است.