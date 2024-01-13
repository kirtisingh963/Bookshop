<?php
include_once "connect.php";
if (!isset($_GET['book_id']) && $_GET['atc']) {
    echo "<script>window.open('index.php', '_self')</script>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Details - Bookshop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <?php include_once "header.php"; ?>

    <div class="container flex h-96 absolute top-14">
        <!-- sidebar  -->
        <div class="w-[20%] categories flex flex-col mx-4 mt-2 fixed left-4">
            <h2 class="text-2xl text-center text-white font-semibold p-2 bg-orange-500">Categories</h2>
            <?php
            $query = mysqli_query($connect, "select * from category");
            while ($row = mysqli_fetch_array($query)) :
            ?>
                <a href="index.php?cat_id=<?= $row['cat_id']; ?>" class="text-lg font-bolder p-2 border border-gray-200">
                    <?= $row['cat_title']; ?>
                </a>
            <?php endwhile; ?>
        </div>
        <!-- book details  -->
        <div class="flex flex-col w-[75%] mt-2 absolute right-8">

            <?php
            $book_id = $_GET['book_id'];
            $query = mysqli_query($connect, "select * from books JOIN category ON books.category=category.cat_id where id = '$book_id'");
            $data = mysqli_fetch_array($query);

            $count = mysqli_num_rows($query);
            if ($count > 0) : ?>
                <div class="w-full flex gap-6 p-4">

                    <div class="w-1/4 p-2">
                        <div class="card-img border">
                            <img src="<?= 'images/' . $data['cover_image']; ?>" class="w-full h-80 object-fill">
                        </div>
                    </div>

                    <div class="w-3/4 p-2">
                        <table class="w-11/12 border text-left">
                            <tr class="border">
                                <th>Title</th>
                                <td><?= $data['title']; ?></td>
                            </tr>
                            <tr class="border">
                                <th>Category</th>
                                <td><?= $data['cat_title']; ?></td>
                            </tr>
                            <tr class="border">
                                <th>No of Page</th>
                                <td><?= $data['no_of_page']; ?></td>
                            </tr>
                            <tr class="border">
                                <th>Author</th>
                                <td><?= $data['author']; ?></td>
                            </tr>
                            <tr class="border">
                                <th>ISBN</th>
                                <td><?= $data['isbn']; ?></td>
                            </tr>
                            <tr class="border">
                                <th>Price</th>
                                <td class="flex items-center gap-4">
                                    <h2 class="text-red-400 text-lg">₹<?= $data['discount_price']; ?></h2>
                                    <del>₹<?= $data['price']; ?></del>
                                </td>
                            </tr>
                        </table>
                        <!-- buy or add to cart button  -->
                        <div class="flex gap-6 mt-4">
                            <a href="" class="py-1 px-3 bg-green-500 text-white text-lg rounded">Buy</a>
                            <a href="cart.php?book_id=<?= $data['id']; ?>&atc=true" class="py-1 px-3 bg-orange-500 text-white text-lg rounded">Add to cart</a>
                        </div>
                    </div>
                </div>
                <div class="w-full mt-5">
                    <div class="card p-2 mb-2">
                        <div class="card-header">
                            <h2 class="font-semibold text-lg">Description</h2>
                        </div>
                        <div class="card-body mt-2">
                            <?= $data['description']; ?>
                        </div>
                    </div>
                    <hr>
                    <!-- related books work  -->
                    <div class="w-full mt-3 ml-3">
                        <h2 class="font-semibold text-lg">Related Books</h2>
                    </div>
                    <div class="flex p-5 gap-4 overflow-x-auto">
                        <?php
                        $query = mysqli_query($connect, "select * from books JOIN category ON books.category=category.cat_id where id <> '$book_id'");

                        $count = mysqli_num_rows($query);
                        if ($count < 1) {
                            echo "<h1 class='text-2xl'>Not Found any Books</h1>";
                        }
                        while ($data = mysqli_fetch_array($query)) :
                        ?>
                            <div class="flex flex-col p-2 border-2 bg-white">
                                <div class="card-header">
                                    <img src="<?= 'images/' . $data['cover_image']; ?>" class="w-36 h-40">
                                </div>
                                <div class="card-body mt-2">
                                    <h2 class="font-bold truncate w-32"><?= $data['title']; ?></h2>
                                    <h5><span class="font-semibold">Rs. <?= $data['discount_price']; ?>/-</span> <del><?= $data['price']; ?>/-</del></h5>
                                    <div class="flex justify-end mt-2">
                                        <a href="view_book.php?book_id=<?= $data['id']; ?>" class="text-blue-600 p-1">View</a>
                                    </div>
                                </div>
                            </div>

                        <?php endwhile; ?>
                    </div>
                </div>
            <?php else :
                echo "<h1>Book Not Found</h1>";
            endif;
            ?>
        </div>
    </div>
    </div>
</body>

</html>