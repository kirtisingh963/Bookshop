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
    <title>My Order - Bookshop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>
    <!-- header  -->
    <?php include_once "header.php"; ?>


    <div class="container absolute top-16">

        <div class="w-9/12 mx-auto mt-4 px-2">
            <div class="w-full mx-4">
                <?php
                    // calling orders and items here
                    $user_id = $getUser['user_id'];
                    $order = mysqli_query($connect, "select * from orders LEFT JOIN coupons ON orders.coupon_id = coupons.cp_id where user_id='$user_id' and is_ordered = '1'");
                    $count_myOrder = mysqli_num_rows($order);
                ?>

                <h1 class="text-2xl font-semibold ">My Order(<?= $count_myOrder; ?>)</h1>
                <div class="card mt-2">
                    <?php

                    while ($myOrder = mysqli_fetch_array($order)) :
                    ?>
                        <div class="card-header flex justify-between border p-2 mt-4">
                            <span>Order id: <?= $myOrder['order_id']; ?></span>
                            <?= ($myOrder['coupon_id'])? "<span>Coupon id : " . $myOrder['coupon_code'] . "</span>" : NULL ?>
                        </div>
                        <div class="card-body">
                            <?php
                            if ($count_myOrder > 0) :

                                $myOrderid = $myOrder['order_id'];
                                // getting order items
                                $myOrderitems = mysqli_query($connect, "select * from order_items JOIN books ON order_items.book_id = books.id where order_id = '$myOrderid'");
                                $count_order_item = mysqli_num_rows($myOrderitems);

                                $total_amount = $total_discount_amount = 0;

                                while ($order_item = mysqli_fetch_array($myOrderitems)) :
                                    $price = $order_item['qty'] * $order_item['price'];
                                    $discount_price = $order_item['qty'] * $order_item['discount_price'];
                            ?>
                                    <!-- items -->
                                    <div class="flex items-center gap-4 border p-2">
                                        <div class="w-1/12">
                                            <img src="images/<?= $order_item['cover_image']; ?>" alt="" class="w-full h-28">
                                        </div>
                                        <div class="w-10/12">
                                            <h2 class="text-md font-semibold truncate"><?= $order_item['title']; ?></h2>
                                            <h3><span class="font-semibold">Price:</span> ₹<?= $order_item['discount_price']; ?> <del class="text-sm text-gray-500 ml-1">₹<?= $order_item['price']; ?></del></h3>

                                            <div class="flex mt-2">
                                                <span class="font-semibold">Qty: <?= $order_item['qty']; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end items -->

                            <?php
                                    $total_amount += $price;
                                    $total_discount_amount += $discount_price;
                                endwhile;

                                $before_tax = $total_amount - $total_discount_amount;
                                $tax = $total_discount_amount * 0.18;
                                $coupon_amount = $myOrder['coupon_amount'];
                                $total_payable_amount = $total_discount_amount  + $tax;

                                if ($myOrder['coupon_id']) {
                                    $total_payable_amount = $total_payable_amount - $coupon_amount;
                                } else {
                                    $total_payable_amount;
                                }
                            endif; ?>
                        </div>
                        <div class="card-footer p-2 border">
                            <h1 class="font-semibold">Total Amount: <?= $total_payable_amount; ?></h1>
                        </div>
                </div>
            <?php endwhile; ?>

            </div>
        </div>

    </div>
</body>

</html>