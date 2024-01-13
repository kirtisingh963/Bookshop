<?php
include_once "connect.php";
if (!isset($_SESSION['account'])) {
    echo "<script>window.open('login.php','_self')</script>";
}
if (!isset($_SESSION['payment'])) {
    echo "<script>window.open('cart.php','_self')</script>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Cart - Bookshop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>
    <!-- header  -->
    <?php include_once "header.php";

    // calling orders and items here
    $user_id = $getUser['user_id'];
    $order = mysqli_query($connect, "select * from orders LEFT JOIN coupons ON orders.coupon_id = coupons.cp_id where user_id='$user_id' and is_ordered = '0'");
    $myOrder = mysqli_fetch_array($order);
    $count_myOrder = mysqli_num_rows($order);
    ?>


    <div class="container absolute top-16">
        <div class="w-3/12 mx-auto mt-8 px-2">
            <div class="card p-4 bg-gray-100 border rounded-lg shadow-md">
                <span class="flex justify-center"><img width="94" height="94" src="https://img.icons8.com/3d-fluency/94/ok.png" alt="ok"/></span>
                <h1 class="text-2xl text-center font-bold text-green-600">Order Placed Successfully.</h1>
                <p class="text-lg font-normal mt-5">Click here to See <a href="my_order.php" class="underline">My Order</a>  Page to know more details</p>
            </div>
        </div>
    </div>
</body>

</html>