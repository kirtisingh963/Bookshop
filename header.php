<header class="w-full lg:w-full md:w-full sm:w-full bg-blue-600 shadow-sm shadow-blue-300 fixed top-0 z-10">
    <div class="flex justify-between items-center p-2 mx-12">
        <!-- header logo  -->
        <div class="logo flex items-center">
            <img src="images/img.jpg" alt="" class="w-10 h-10 rounded-full lg:mr-3 md:mr-4 sm:mr-4 mr-3">
            <a href="index.php" class="logo w-1/3 text-white font-serif">
                <h2 class="font-bold text-2xl md:xl">BookShop</h2>
            </a>
        </div>

        <!-- header search work here  -->
        <div class="lg:inline-flex w-1/3 md:hidden sm:hidden hidden">
            <form action="index.php" method="GET" class="flex items-center w-full">
                <input type="search" name="search" placeholder="Search any book title" class="w-2/3 p-2 rounded-l outline-none">
                <button name="find" class="py-2 px-3 bg-red-600 text-white rounded-r"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
        </div>

        <!-- header links -->
        <div class="md:hidden lg:flex w-1/3 sm:hidden hidden lg:gap-6 justify-end">
            <!-- home -->
            <a href="index.php" class="text-white text-lg hover:underline hover:text-gray-100"><span class="mr-1"><i class="fa-solid fa-house"></i></span>Home</a>

            <?php
            if (isset($_SESSION['account'])) :
                $email = $_SESSION['account'];
                $getUser = mysqli_query($connect, "select * from accounts where email = '$email'");
                $getUser = mysqli_fetch_array($getUser);

            ?>
                <!-- when user is logined in  -->
                <a href="cart.php" class="text-white text-lg hover:underline hover:text-gray-100" title="My Cart"><span class="mr-1"><i class="fa-solid fa-cart-shopping"></i></span>Cart</a>
                <a href="my_order.php" class="text-white text-lg hover:underline hover:text-gray-100" title="click here to check my Order"><?= $getUser['name']; ?></a>
                <a href="logout.php" class="px-2 bg-red-500 text-white text-lg hover:underline rounded" title="Logout"><i class="fa-solid fa-right-from-bracket"></i></a>

            <?php else : ?>
                <!-- when user is logged out -->
                <a href="login.php" class="text-white text-lg hover:underline hover:text-gray-100" title="Login">Login</a>
                <a href="register.php" class="text-white text-lg hover:underline hover:text-gray-100" title="Create an account">Create account</a>
            <?php endif; ?>
        </div>


    </div>
</header>