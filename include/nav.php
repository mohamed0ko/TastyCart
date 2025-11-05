<?php

$connect = isset($_SESSION['users']);
$user = $_SESSION['users'] ?? null;
$pageActive = $_SERVER['PHP_SELF'];
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" />
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary" href="#">TastyCart</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">

                <?php if ($connect && $user['role'] === 'admin'): ?>
                    <!-- Admin Links -->
                    <li class="nav-item">
                        <a class="nav-link <?= ($pageActive == '/TastyCart/page/product/addProduct.php') ? 'active' : '' ?>" href="/TastyCart/page/product/addProduct.php">Add Product</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($pageActive == '/TastyCart/page/category/addCategory.php') ? 'active' : '' ?>" href="/TastyCart/page/category/addCategory.php">Add Category</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($pageActive == '/TastyCart/page/category/listCategory.php') ? 'active' : '' ?>" href="/TastyCart/page/category/listCategory.php">List Category</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($pageActive == '/TastyCart/page/product/listProduct.php') ? 'active' : '' ?>" href="/TastyCart/page/product/listProduct.php">List Product</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($pageActive == '/TastyCart/page/command/listCommand.php') ? 'active' : '' ?>" href="/TastyCart/page/command/listCommand.php">List Command</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-success <?= ($pageActive == '/TastyCart/frontend/home.php') ? 'active' : '' ?>" href="/TastyCart/frontend/home.php">Switch to Home</a>
                    </li>
                <?php endif; ?>





                <?php if ($connect): ?>

                    <!-- Common Logout -->
                    <li class="nav-item">
                        <a class="nav-link text-danger <?= ($pageActive == '/TastyCart/page/auth/logout.php') ? 'active' : '' ?>" href="/TastyCart/page/auth/logout.php">Logout</a>
                    </li>
                <?php else: ?>
                    <!-- Guest Links -->
                    <li class="nav-item">
                        <a class="nav-link <?= ($pageActive == '/TastyCart/page/auth/index.php') ? 'active' : '' ?>" href="/TastyCart/page/auth/index.php">Sign Up</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($pageActive == '/TastyCart/page/auth/Login.php') ? 'active' : '' ?>" href="/TastyCart/page/auth/Login.php">Login</a>
                    </li>
                <?php endif; ?>

            </ul>

            <!-- Cart Icon (for logged-in users) -->
            <?php if ($connect && isset($_SESSION['cart'][$user['id']])): ?>
                <?php $cartCount = count($_SESSION['cart'][$user['id']]); ?>
                <a href="/TastyCart/frontend/cart.php" class="btn btn-outline-primary position-relative">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <?php if ($cartCount > 0): ?>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            <?= $cartCount ?>
                        </span>
                    <?php endif; ?>
                </a>
            <?php endif; ?>
        </div>
    </div>
</nav>