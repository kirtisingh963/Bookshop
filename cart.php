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


    <div class="container mt-16">
        <?php
        if ($count_myOrder > 0) :

            $myOrderid = $myOrder['order_id'];
            // getting order items
            $myOrderitems = mysqli_query($connect, "select * from order_items JOIN books ON order_items.book_id = books.id where order_id = '$myOrderid'");
            $count_order_item = mysqli_num_rows($myOrderitems);

            if ($count_order_item) :
        ?>
                <div class="w-10/12 flex gap-12 mx-auto mt-8 px-2">
                    <div class="w-9/12 mx-4">

                        <h1 class="text-2xl font-semibold ">My Cart(<?= $count_order_item; ?>)</h1>
                        <div class="card mt-2">

                            <?php

                            $total_amount = $total_discount_amount = 0;

                            while ($order_item = mysqli_fetch_array($myOrderitems)) :

                                $price = $order_item['qty'] * $order_item['price'];
                                $discount_price = $order_item['qty'] * $order_item['discount_price'];

                            ?>

                                <div class="flex items-center gap-2 border rounded mb-3 p-2">
                                    <div class="w-2/12">
                                        <img src="images/<?= $order_item['cover_image']; ?>" alt="" class="w-8/12 h-28">
                                    </div>
                                    <div class="w-10/12">
                                        <h2 class="text-lg font-semibold truncate"><?= $order_item['title']; ?></h2>
                                        <h3><span class="font-semibold">Price:</span> ₹<?= $order_item['discount_price']; ?> <del class="text-sm text-gray-500 ml-1">₹<?= $order_item['price']; ?></del></h3>

                                        <div class="flex justify-between items-center mt-2">
                                            <div class="flex">
                                                <a href="cart.php?book_id=<?= $order_item['id']; ?>&dfc=true" class="px-2 py-1 text-white bg-red-600 rounded"><i class="fa-solid fa-minus"></i></a>
                                                <span class="px-3 py-1 border"><?= $order_item['qty']; ?></span>
                                                <a href="cart.php?book_id=<?= $order_item['id']; ?>&atc=true" class="px-2 py-1 text-white bg-green-600 rounded"><i class="fa-solid fa-plus"></i></a>
                                            </div>
                                            <a href="cart.php?delete_item=<?= $order_item['oi_id']; ?>" class="bg-gray-200 px-2 py-1 rounded"><i class="fa-solid fa-trash"></i>Remove</a>
                                        </div>

                                    </div>
                                </div>
                            <?php
                                $total_amount += $price;
                                $total_discount_amount += $discount_price;
                            endwhile;
                            ?>
                        </div>
                    </div>
                    <div class="w-3/12">
                        <h2 class="text-2xl font-semibold">Price Break</h2>
                        <div class="flex flex-col mt-2 border rounded-md">
                            <div class="flex justify-between p-2">
                                <span class="font-semibold">Total Amount</span>
                                <span><?= $total_amount; ?>/-</span>
                            </div>
                            <div class="flex justify-between p-2">
                                <span class="font-semibold">Total Discount</span>
                                <span><?= $before_tax = $total_amount - $total_discount_amount; ?>/-</span>
                            </div>
                            <div class="flex justify-between p-2">
                                <span class="font-semibold">Tax (GST)</span>
                                <span><?= $tax = $total_discount_amount * 0.18; ?>/-</span>
                            </div>
                            <?php
                            if ($myOrder['coupon_id']) :
                            ?>

                                <div class="p-2">
                                    <div class="flex justify-between">
                                        <span class="font-semibold">Coupon Discount</span>
                                        <span><?= $coupon_amount = $myOrder['coupon_amount']; ?>/-</span>
                                    </div>
                                    <div class="flex justify-between bg-gray-100 py-1 px-2 rounded border border-dashed">
                                        <span>Coupon Applied - <small><?= $myOrder['coupon_code']; ?></small></span>
                                        <a href="cart.php?remove_coupon=<?= $myOrder['order_id']; ?>" class="decoration-none text-red-600"><i class="fa-solid fa-xmark"></i></a>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="flex justify-between p-2 bg-slate-200 rounded-b-md">
                                <span class="text-lg font-semibold">Payable Amount</span>
                                <span class="text-lg font-semibold">
                                    <?php
                                    $total_payable_amount = $total_discount_amount  + $tax;

                                    if ($myOrder['coupon_id']) {
                                        echo $total_payable_amount - $coupon_amount;
                                    } else {
                                        echo $total_payable_amount;
                                    }
                                    ?>/-</span>
                            </div>
                        </div>
                        <div class="flex justify-between mt-5">
                            <a href="index.php" class="px-3 py-2 text-white bg-blue-500 rounded">Go Back</a>
                            <a href="checkout.php" class="px-3 py-2 text-white bg-teal-800 rounded">Checkout</a>
                        </div>

                        <?php
                        if (!$myOrder['coupon_id']) :
                        ?>

                            <div class="mt-8 w-full">
                                <form action="" method="post" class="flex">
                                    <input type="text" name="coupon_code" placeholder="Enter Coupon Code" class="w-full p-2 border border-gray-300 outline-0 rounded-l">
                                    <input type="submit" value="Apply" name="apply" class="px-3 py-2 bg-black text-white rounded-r cursor-pointer">
                                </form>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

            <?php else : ?>
                <div class="mt-10 ml-20">
                    <h1 class="text-2xl font-semibold mb-5">Sorry...! Your cart is Empty</h1>
                    <a href="index.php" class="p-2 bg-blue-500 hover:bg-blue-600 shadow text-white rounded-md mt">Shop now</a>
                </div>
        <?php endif;
        endif; ?>
    </div>
</body>
</html>

<?php
if (isset($_GET['book_id']) && isset($_GET['atc'])) {

    // check user login or not 
    if (!isset($_SESSION['account'])) {
        echo "<script>window.open('login.php', '_self')</script>";
    }

    // if login 

    $book_id = $_GET['book_id'];
    $user_id = $getUser['user_id'];
    // checking order already exist or not 
    $check_order = mysqli_query($connect, "select * from orders where user_id = '$user_id' and is_ordered = '0'");

    $count_check_order = mysqli_num_rows($check_order);

    if ($count_check_order < 1) {
        // not exist prev that why we need to create new order in order table
        $create_order = mysqli_query($connect, "insert into orders (user_id) value ('$user_id')");
        $created_order_id = mysqli_insert_id($connect);

        // inserting new order items 
        $create_order_items = mysqli_query($connect, "insert into order_items (order_id, book_id) value ('$created_order_id', '$book_id')");
    } else {
        // already exist order work
        $current_order = mysqli_fetch_array($check_order);
        $current_order_id = $current_order['order_id'];

        // checking if order_items already exist or not
        $check_order_items = mysqli_query($connect, "select * from order_items where order_id = '$current_order_id' and book_id = '$book_id'");

        $current_order_item = mysqli_fetch_array($check_order_items);
        $count_current_order_item = mysqli_num_rows($check_order_items);

        if ($count_current_order_item > 0) {
            // only need to update qty of items in order_items table
            $current_order_item_id = $current_order_item['oi_id'];
            $query_for_qty_update = mysqli_query($connect, "update order_items set qty=qty + 1 where oi_id = '$current_order_item_id'");
        } else {
            $create_order_items = mysqli_query($connect, "insert into order_items (order_id, book_id) value ('$current_order_id', '$book_id')");
        }
    }
    // refresh page
    echo "<script>window.open('cart.php', '_self')</script>";
}
?>

<!-- delete from cart  -->

<?php
if (isset($_GET['book_id']) && isset($_GET['dfc'])) {

    // check user login or not 
    if (!isset($_SESSION['account'])) {
        echo "<script>window.open('login.php', '_self')</script>";
    }

    // if login 

    $book_id = $_GET['book_id'];
    $user_id = $getUser['user_id'];
    // checking order already exist or not 
    $check_order = mysqli_query($connect, "select * from orders where user_id = '$user_id' and is_ordered = '0'");

    $count_check_order = mysqli_num_rows($check_order);

    // already exist order work
    $current_order = mysqli_fetch_array($check_order);
    $current_order_id = $current_order['order_id'];

    // checking if order_items already exist or not
    $check_order_items = mysqli_query($connect, "select * from order_items where order_id = '$current_order_id' and book_id = '$book_id'");

    $current_order_item = mysqli_fetch_array($check_order_items);
    $count_current_order_item = mysqli_num_rows($check_order_items);

    if ($count_current_order_item > 0) {
        // only need to update qty of items in order_items table
        $current_order_item_id = $current_order_item['oi_id'];

        $qty = $current_order_item['qty'];
        if ($qty == 1) {
            $delete_query_for_order_item = mysqli_query($connect, "delete from order_items where oi_id = '$current_order_item_id'");
        } else {
            $query_for_qty_update = mysqli_query($connect, "update order_items set qty=qty - 1 where oi_id = '$current_order_item_id'");
        }
    }
    // refresh page
    echo "<script>window.open('cart.php', '_self')</script>";
}

// Apply coupon code
if (isset($_POST['apply'])) {
    $code = $_POST['coupon_code'];

    $callingCoupon = mysqli_query($connect, "select * from coupons where coupon_code = '$code'");

    $getCoupon = mysqli_fetch_array($callingCoupon);

    $countCoupon = mysqli_num_rows($callingCoupon);
    if ($countCoupon > 0) {
        // updating coupon id in order record
        $coupon_id = $getCoupon['cp_id'];
        $updateOrder = mysqli_query($connect, "update orders SET coupon_id = '$coupon_id' where order_id = '$myOrderid'");
        echo "<script>window.open('cart.php', '_self')</script>";
    } else {
        echo "<script>alert('Invalid coupon code')</script>";
    }
}

if (isset($_GET['delete_item'])) {
    $item_id = $_GET['delete_item'];

    $queryForDeleteItem = mysqli_query($connect, "delete from order_items where oi_id = '$item_id'");

    if ($queryForDeleteItem) {
        echo "<script>window.open('cart.php','_self')</script>";
    } else {
        echo "<script>alert('Failed to delete item')</script>";
    }
}

if (isset($_GET['remove_coupon'])) {
    $id = $_GET['remove_coupon'];

    $queryForRemoveCoupon = mysqli_query($connect, "update orders SET coupon_id='NULL' where order_id='$id'");

    if ($queryForRemoveCoupon) {
        echo "<script>window.open('cart.php', '_self')</script>";
    } else {
        echo "<script>alert('Failed to remove coupon')</script>";
    }
}
?>