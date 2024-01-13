<?php include_once "connect.php";?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book shop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <!-- header  -->
    <?php include_once "header.php"; ?>

    <!-- body part  -->
    <div class="container flex h-90 mt-14">

        <!-- category  -->
        <div class="md:w-2/12 flex flex-col mt-2 fixed left-8 md:left-5 sm:left-3 bg-white">
            <h2 class="lg:text-2xl md:text-lg text-center text-white font-semibold lg:p-2 md:p-2 bg-orange-500">Categories</h2>
            <?php
            $query = mysqli_query($connect, "select * from category");
            while ($row = mysqli_fetch_array($query)) :
            ?>
                <a href="index.php?cat_id=<?= $row['cat_id']; ?>" class="lg:text-lg md:text-lg sm:text-sm font-bolder px-2 py-1 border hover:bg-stone-100 border-gray-100">
                    <?= $row['cat_title']; ?>
                </a>
            <?php endwhile; ?>
        </div>

        <!-- Product Card Work  -->
        <div class="w-9/12 absolute right-8 md:right-5 bg-gray-50">
            <div class="grid xl:grid-cols-5 lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-2 lg:gap-4 sm:gap-2 md:gap-3 p-4">
                <?php
                if (isset($_GET['find'])) {
                    $search = $_GET['search'];
                    $query = mysqli_query($connect, "select * from books JOIN category ON books.category=category.cat_id WHERE title LIKE '%$search%'");
                } else {
                    if (isset($_GET['cat_id'])) {
                        $cat_id = $_GET['cat_id'];
                        $query = mysqli_query($connect, "select * from books JOIN category ON books.category=category.cat_id where cat_id = '$cat_id'");
                    } else {
                        $query = mysqli_query($connect, "select * from books JOIN category ON books.category=category.cat_id");
                    }
                }

                $count = mysqli_num_rows($query);
                if ($count < 1) {
                    echo "<h1 class='text-2xl'>Not Found any Books</h1>";
                }

                while ($data = mysqli_fetch_array($query)) :
                ?>
                    <div class="flex flex-col p-2 border-2 shadow-lg shadow-white bg-white">
                        <div class="card">
                            <img src="<?= 'images/' . $data['cover_image']; ?>" class="w-full h-60">
                        </div>
                        <div class="card-body border-t mt-2">
                            <h2 class="font-bold truncate"><?= $data['title']; ?></h2>
                            <h5><b>Rs. <?= $data['discount_price']; ?>/-</b> <del><?= $data['price']; ?>/-</del></h5>
                            <div class="flex justify-between items-center mt-2">
                                <h5 class="text-sm font-semibold truncate w-32">Type: <span class="font-normal text-sm"><?= $data['cat_title']; ?></span></h5>
                                <a href="view_book.php?book_id=<?= $data['id']; ?>" class="text-blue-600 font-semibold">View-></a>
                            </div>
                        </div>
                    </div>

                <?php endwhile; ?>
            </div>
        </div>
    </div>
</body>

</html>