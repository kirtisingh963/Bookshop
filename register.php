<?php include_once "connect.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Register</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <?php include_once "header.php"; ?>

    <div class="container bg-slate-300 w-full h-[100vh] top-18 absolute">
        <div class="card w-96 h-auto mx-auto bg-gray-50 mt-24 p-4 rounded opacity-80">
            <div class="card-header">
                <h2 class="text-center font-bold text-lg text-stone-800">Create an Account</h2>
            </div>
            <div class="card-body mt-6">
                <form action="" method="post">
                    <div class="mb-3 flex flex-col">
                        <label for="name" class="font-semibold mb-2">Name</label>
                        <input type="text" name="name" id="name" placeholder="Enter your name" class="p-1 border outline-none rounded">
                    </div>
                    <div class="mb-3 flex flex-col">
                        <label for="email" class="font-semibold mb-2">Email</label>
                        <input type="email" name="email" id="email" placeholder="Enter your email" class="p-1 border outline-none rounded">
                    </div>
                    <div class="mb-3 flex flex-col">
                        <label for="password" class="font-semibold mb-2">Password</label>
                        <input type="password" name="password" id="password" placeholder="Create password" class="p-1 border outline-none rounded">
                    </div>
                    <div class="mt-5">
                        <input type="submit" name="create" value="Sign Up" class="bg-blue-700 text-white p-2 w-full rounded font-semibold cursor-pointer">
                    </div>
                    <h5 class="text-sm mt-3">Already have an account? <a href="login.php" class="text-blue-700 hover:underline font-semibold">Sign In</a></h5>
                </form>

                <?php

                if (isset($_POST['create'])) {
                    $name = $_POST['name'];
                    $email = $_POST['email'];
                    $password = md5($_POST['password']);

                    $query = mysqli_query($connect, "insert into accounts (name, email, password) value ('$name', '$email', '$password')");

                    if ($query) {
                        echo "<script>window.open('login.php', '_self')</script>";
                    } else {
                        echo "<script>alert('Failed')</script>";
                    }
                }

                ?>
            </div>
        </div>
    </div>
</body>

</html>