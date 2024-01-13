<?php include_once "connect.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Login</title>
</head>

<body>
    <?php include_once "header.php"; ?>

    <div class="container bg-slate-300 w-full h-[100vh] top-18 absolute">
        <div class="card w-96 h-auto mx-auto bg-gray-50 mt-24 p-4 rounded opacity-80">
            <div class="card-header">
                <h2 class="text-center font-bold text-lg text-stone-800">Login Here</h2>
            </div>
            <div class="card-body mt-6">
                <form action="" method="post">
                    <div class="mb-3 flex flex-col">
                        <label for="email" class="font-semibold mb-2">Email</label>
                        <input type="email" name="email" id="email" placeholder="Enter your email" class="p-1 border outline-none rounded">
                    </div>
                    <div class="mb-3 flex flex-col">
                        <label for="password" class="font-semibold mb-2">Password</label>
                        <input type="password" name="password" id="password" placeholder="Enter password" class="p-1 border outline-none rounded">
                    </div>
                    <div class="mt-5">
                        <input type="submit" name="login" value="Sign In" class="bg-blue-700 text-white p-2 w-full rounded font-semibold cursor-pointer">
                    </div>
                    <h5 class="text-sm mt-3">Create an account? <a href="register.php" class="text-blue-700 hover:underline font-semibold">Sign Up</a></h5>
                </form>

                <?php

                if (isset($_POST['login'])) {
                    $email = $_POST['email'];
                    $password = md5($_POST['password']);

                    $query = mysqli_query($connect, "select * from accounts where email = '$email' AND password = '$password' ");

                    $count = mysqli_num_rows($query);

                    $checkAccessLevel = mysqli_fetch_array($query);

                    if ($count > 0) {
                        $_SESSION['account'] = $email;

                        if ($checkAccessLevel['isAdmin'] == 1) {
                            $_SESSION['admin'] = $email;
                            echo "<script>window.open('admin/index.php', '_self')</script>";
                        } else {
                            echo "<script>window.open('index.php', '_self')</script>";
                        }
                    } else {
                        echo "<script>alert('Email or Password is invalid try again')</script>";
                    }
                }

                ?>
            </div>
        </div>
    </div>
</body>

</html>