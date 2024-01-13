<?php
include_once "connect.php";
if (!isset($_SESSION['account'])) {
    echo "<script>window.open('login.php','_self')</script>";
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
            <div class="card">
                <div class="card-header border p-2">
                    <h2 class="text-2xl font-bold text-center">Choose Payment method</h2>
                </div>
                <div class="card-body p-2 flex flex-col border">
                    <a href="" class="text-lg border py-1 px-2 hover:bg-gray-200 cursor-not-allowed">Wallets</a>
                    <a href="" class="text-lg border py-1 px-2 hover:bg-gray-200 cursor-not-allowed">UPI</a>
                    <a href="" class="text-lg border py-1 px-2 hover:bg-gray-200 cursor-not-allowed">Debit/Credit Card</a>
                    <a href="make_payment.php?type=cod" class="text-lg border py-1 px-2 hover:bg-gray-200">Cash on delivery (COD)</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

<?php
if(isset($_GET['type'])){
    $type = $_GET['type'];
    if($type == "cod"){
        // update order record
        if($myOrder['address_id'] != NULL){
            $order_id = $myOrder['order_id'];
            $query = mysqli_query($connect, "UPDATE orders SET is_ordered='1' where user_id='$user_id' and order_id='$order_id'");
            $_SESSION['payment'] = ['success'];
            echo "<script>window.open('order_done.php', '_self')</script>";
        }
        else{
            echo "<script>alert('Please select address first.')</script>";
            echo "<script>window.open('checkout.php', '_self')</script>";
        }
    }
}