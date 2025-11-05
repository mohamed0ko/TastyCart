<?php


$connect = isset($_SESSION['users']);
$user = $_SESSION['users'] ?? null;
$userId = $user['id'] ?? 0;
$pageActive = $_SERVER['PHP_SELF'];
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container">
        <!-- Brand -->
        <a class="navbar-brand fw-bold text-primary" href="#">TastyCart</a>

        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu -->
        <div class="collapse navbar-collapse" id="navbarNav">

            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link <?= ($pageActive == '/TastyCart/home.php') ? 'active' : '' ?>" href="/TastyCart/frontend/home.php">Home</a>
                </li>

                <?php if ($user['role'] === 'admin'): ?>

                    <!-- Common Logout -->
                    <li class="nav-item">
                        <a class="nav-link text-success <?= ($pageActive == '/TastyCart/page/admin.php') ? 'active' : '' ?>" href="/TastyCart/page/admin.php">Switch to admin</a>
                    </li>
                <?php endif; ?>

            </ul>

            <!-- Cart -->
            <?php

            $userId = $_SESSION['users']['id'] ?? 0;
            $cartCount = isset($_SESSION['cart'][$userId]) ? count($_SESSION['cart'][$userId]) : 0;
            ?>
            <a href="cart.php" class="btn btn-outline-primary position-relative">
                <i class="fa-solid fa-cart-shopping"></i>
                <?php if ($cartCount > 0): ?>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        <?= $cartCount ?>
                    </span>
                <?php endif; ?>
            </a>


        </div>

    </div>
    <ul class="navbar-nav me-auto">

        <?php if ($connect): ?>

            <!-- Common Logout -->
            <li class="nav-item">
                <a class="nav-link text-danger <?= ($pageActive == '/TastyCart/page/auth/logout.php') ? 'active' : '' ?>" href="/TastyCart/page/auth/logout.php">Logout</a>
            </li>
        <?php endif; ?>


    </ul>
</nav>