<?php
session_start();
$connect = false;
if (isset($_SESSION['users'])) {
    $connect = true;
}

?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Food Shop</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                </li>
                <?php
                if ($connect) {
                ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/TastyCart/page/product/addProduct.php">Add Product</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/TastyCart/page/category/addCategory.php">Add Category</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/TastyCart/page/product/listProduct.php">list Product</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/TastyCart/page/auth/logout.php">Logout</a>
                    </li>

                <?php

                } else {
                ?>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Sign up</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Login.php">Login</a>
                    </li>
                <?php
                }
                ?>




            </ul>
        </div>
    </div>
</nav>