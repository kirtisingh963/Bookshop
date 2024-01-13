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
    <link rel="stylesheet" href="style.css">
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
        <div class="w-10/12 flex gap-12 mx-auto mt-8 px-2">
            <div class="w-8/12 mx-4">
                <h1 class="text-2xl font-semibold ">Checkout</h1>
                <div class="form-card mt-2">
                    <div class="card-header bg-slate-200 border p-1">
                        <h1 class="text-xl text-center">Add Address</h1>
                    </div>
                    <div class="card-body">
                        <form action="" method="post" class="p-3 border">
                            <div class="mt-2 flex flex-col">
                                <label for="alt_name" class="font-semibold">Name</label>
                                <input type="text" name="alt_name" id="alt_name" value="<?= $getUser['name']; ?>" class="p-2 border rounded">
                            </div>
                            <div class="flex gap-4">
                                <div class="w-1/2 mt-2 flex flex-col">
                                    <label for="alt_contact" class="font-semibold">Contact</label>
                                    <input type="tel" name="alt_contact" id="alt_contact" placeholder="e.g 9999999999" class="p-2 border rounded">
                                </div>
                                <div class="w-1/2 mt-2 flex flex-col">
                                    <label for="type" class="font-semibold">Type</label>
                                    <select type="text" name="type" id="type" class="p-2 border rounded">
                                        <option value="">Select address type</option>
                                        <option value="0">Office</option>
                                        <option value="1">Home</option>
                                        <option value="2">Other</option>
                                    </select>
                                </div>
                            </div>
                            <div class="flex gap-4">
                                <div class="w-1/2 mt-2 flex flex-col">
                                    <label for="street" class="font-semibold">Street</label>
                                    <input type="text" name="street" id="street" placeholder="e.g MG Road" class="p-2 border rounded">
                                </div>
                                <div class="w-1/2 mt-2 flex flex-col">
                                    <label for="area" class="font-semibold">Area</label>
                                    <input type="text" name="area" id="area" placeholder="e.g College Chowk" class="p-2 border rounded">
                                </div>
                            </div>
                            <div class="flex gap-4">
                                <div class="w-1/2 mt-2 flex flex-col">
                                    <label for="house_no" class="font-semibold">House Holding No.</label>
                                    <input type="text" name="house_no" id="house_no" placeholder="e.g 22B" class="p-2 border rounded">
                                </div>
                                <div class="w-1/2 mt-2 flex flex-col">
                                    <label for="landmark" class="font-semibold">Landmark</label>
                                    <input type="text" name="landmark" id="landmark" placeholder="e.g Near KFC" class="p-2 border rounded">
                                </div>
                            </div>
                            <div class="flex gap-4">
                                <div class="w-1/3 mt-2 flex flex-col">
                                    <label for="city" class="font-semibold">City</label>
                                    <input type="text" name="city" id="city" placeholder="e.g Purnea" class="p-2 border rounded">
                                </div>
                                <div class="w-1/3 mt-2 flex flex-col">
                                    <label for="state" class="font-semibold">State</label>
                                    <input type="text" name="state" id="state" placeholder="e.g Bihar" class="p-2 border rounded">
                                </div>
                                <div class="w-1/3 mt-2 flex flex-col">
                                    <label for="pincode" class="font-semibold">Pincode</label>
                                    <input type="text" name="pincode" id="pincode" placeholder="e.g 000000" class="p-2 border rounded">
                                </div>
                            </div>
                            <div class="mt-3">
                                <input type="submit" name="save_Address" value="Save Address" class="p-2 bg-blue-600 text-white w-full font-semibold cursor-pointer rounded ">
                            </div>
                        </form>
                    </div>
                </div>

            </div>

            <div class="w-4/12">
                <h2 class="text-2xl font-semibold mb-3">Saved Address</h2>
                <form action="" method="post">
                    <div class="grid">
                        <?php
                        $callingSavedAddress = mysqli_query($connect, "select * from addresses where user_id='$user_id'");
                        $count_address = mysqli_num_rows($callingSavedAddress);

                        if($count_address > 0):
                        while ($add = mysqli_fetch_array($callingSavedAddress)) :
                        ?>
                            <label class="card">
                                <input name="address_id" class="radio" type="radio" value="<?= $add['address_id'];?>">

                                <div class="address-details">
                                    <span class="font-semibold text-green-700 leading-tight uppercase mb-2"><?= ($add['type'] == 0) ? "Office" : (($add['type'] == 1) ? "Home" : "Other"); ?></span>
                                    <span class="font-semibold text-gray-900">
                                        <span class="text-lg capitalize"><?= $add['alt_name'] ?></span>
                                    </span>
                                    <span>
                                        <span class="text-md text-gray-700"><?= $add['house_no'] . ", " . $add['area'] . ", " . $add['street'] . ","; ?></span><br>
                                        <span class="text-md text-gray-700"><?= $add['landmark'] . ", " . $add['city'] . " (" . $add['state'] . ")"; ?></span>
                                        <br>
                                        <span class="text-gray-700"><?= $add['pincode']; ?></span>
                                        <br>
                                        <span class="text-md">
                                            <span class="font-semibold">Mob no. </span> <?= $add['alt_contact']; ?>
                                        </span>
                                    </span>
                                    <div class="flex justify-end">
                                        <a href="checkout.php?address_id=<?= $add['address_id']; ?>" class="py-1  px-2 font-semibold bg-red-700 text-white rounded text-center decoration-none ">Delete</a>
                                    </div>
                                </div>

                            </label>
                        <?php endwhile; ?>
                    </div>


                    <div class="flex justify-between mt-5">
                        <a href="cart.php" class="px-3 py-2 text-white bg-blue-500 rounded">Go Back</a>
                        <input type="submit" name="make_payment" value="Make Payment" class="px-3 py-2 text-white bg-teal-800 rounded cursor-pointer">
                    </div>
                </form>
                <?php else: ?>
                    <h2 class="text-lg">Empty saved address</h2>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>

<?php
if (isset($_POST['save_Address'])) {
    $alt_name = $_POST['alt_name'];
    $alt_contact = $_POST['alt_contact'];
    $type = $_POST['type'];
    $street = $_POST['street'];
    $area = $_POST['area'];
    $house_no = $_POST['house_no'];
    $landmark = $_POST['landmark'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $pincode = $_POST['pincode'];

    $user_id = $getUser['user_id'];

    $queryForInsertAddress = mysqli_query($connect, "insert into addresses (alt_name, alt_contact, type, street, area, house_no, landmark, city, state, pincode, user_id) value ('$alt_name', '$alt_contact', '$type', '$street', '$area', '$house_no', '$landmark', '$city', '$state', '$pincode', '$user_id')");

    if ($queryForInsertAddress) {
        echo "<script>window.open('checkout.php', '_self')</script>";
    } else {
        echo "<script>alert('Failed')</script>";
    }
}

if (isset($_GET['address_id'])) {
    $address_id = $_GET['address_id'];
    $queryForRemoveAddress = mysqli_query($connect, "delete from addresses where address_id='$address_id' and user_id='$user_id'");

    if ($queryForRemoveAddress) {
        echo "<script>window.open('checkout.php', '_self')</script>";
    } else {
        echo "<script>alert('Failed to delete address')</script>";
    }
}

if(isset($_POST['make_payment'])){
    $address_id = $_POST['address_id'];
    $order_id = $myOrder['order_id']; 

    // update this address in order record
    $queryForAddressUpdate = mysqli_query($connect, "update orders SET address_id='$address_id' where user_id='$user_id' and order_id='$order_id'");

    if ($queryForAddressUpdate) {
        echo "<script>window.open('make_payment.php', '_self')</script>";
    } else {
        echo "<script>alert('Failed to Proceed address')</script>";
    }
}
