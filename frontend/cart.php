<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- font-awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <title>Cart | </title>

</head>

<body>
    <?php include '../include/nav_front.php' ?>
    <?php
    require_once '../connectData.php';
    $userId = $_SESSION['users']['id'];
    $cartCount = count($_SESSION['cart'][$userId]);
    $cart = $_SESSION['cart'][$userId];
    $idProducts = array_keys($_SESSION['cart'][$userId]);
    // change array [2,3,4] to 2,3,4
    $idProducts = implode(',',  $idProducts);

    $products = $sql = $pdo->query("select * from products where id in ($idProducts)")->fetchAll(PDO::FETCH_ASSOC);



    ?>

    <div class="container mt-5">



        <?php

        if (empty($cart)) {
        ?>
            <div class="alert alert-danger my-3 fade-out" role="alert">
                cart is empty!
            </div>
        <?php
        } else {
        ?>
            <div class="cart-wrapper">
                <div class="container">
                    <div class="row g-4">
                        <!-- Cart Items Section -->
                        <div class="col-lg-8">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="mb-0">Shopping Cart</h4>
                                <span class="text-muted"><?php echo $cartCount ?> items</span>
                            </div>


                            <!-- Product Cards -->
                            <?php foreach ($products as $product) {
                            ?>
                                <div class="d-flex flex-column gap-3">
                                    <!-- Product 1 -->
                                    <div class="product-card p-3 shadow-sm">
                                        <div class="row align-items-center">
                                            <div class="col-md-2">
                                                <img src=" ../upload/product/<?php echo $product['image'] ?>" alt="Product" class="product-image-cart">
                                            </div>
                                            <div class="col-md-4">
                                                <h6 class="mb-1"><?= $product['name'] ?></h6>
                                                <p class="text-muted mb-0">Black | Premium Series</p>
                                                <?php
                                                if (!empty($product['discount'])) {
                                                ?>
                                                    <span class="discount-off mt-2"><?php echo $product['discount'] ?>% OFF</span>
                                                <?php
                                                }
                                                ?>

                                            </div>
                                            <div class="col-md-3">
                                                <div class="d-flex align-items-center gap-2">
                                                    <button class="quantity-btn" onclick="updateQuantity(1, -1)">-</button>
                                                    <input type="number" class="quantity-input" value="<?php echo $cart[$product['id']] ?>" min="1">
                                                    <button class="quantity-btn" onclick="updateQuantity(1, 1)">+</button>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <?php
                                                if (!empty($product['discount'])) {
                                                    $prix = $product['prix'];
                                                    $discount = $product['discount'];
                                                    $total_disc = $prix - (($prix * $discount) / 100);
                                                    $qte = $cart[$product['id']];
                                                    $total = $total_disc * $qte;
                                                ?>
                                                    <span class="fw-bold">$<?php echo $total ?></span>
                                                <?php
                                                } else {
                                                    $total = $prix * $qte;
                                                ?>
                                                    <span class="fw-bold">$<?php echo $total ?></span>
                                                <?php
                                                }




                                                ?>

                                            </div>
                                            <div class="col-md-1">
                                                <i class="bi bi-trash remove-btn"></i>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            <?php

                            } ?>

                        </div>

                        <!-- Summary Section -->
                        <div class="col-lg-4">
                            <div class="summary-card p-4 shadow-sm">
                                <h5 class="mb-4">Order Summary</h5>

                                <div class="d-flex justify-content-between mb-3">
                                    <span class="text-muted">Subtotal</span>
                                    <span>$479.97</span>
                                </div>
                                <div class="d-flex justify-content-between mb-3">
                                    <span class="text-muted">Discount</span>
                                    <span class="text-success">-$26.00</span>
                                </div>
                                <div class="d-flex justify-content-between mb-3">
                                    <span class="text-muted">Shipping</span>
                                    <span>$5.00</span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between mb-4">
                                    <span class="fw-bold">Total</span>
                                    <span class="fw-bold">$458.97</span>
                                </div>

                                <!-- Promo Code -->
                                <div class="mb-4">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Promo code">
                                        <button class="btn btn-outline-secondary" type="button">Apply</button>
                                    </div>
                                </div>

                                <button class="btn btn-primary checkout-btn w-100 mb-3">
                                    Proceed to Checkout
                                </button>

                                <div class="d-flex justify-content-center gap-2">
                                    <i class="bi bi-shield-check text-success"></i>
                                    <small class="text-muted">Secure checkout</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php
        }
        ?>



    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function updateQuantity(productId, change) {
            const input = event.target.parentElement.querySelector('.quantity-input');
            let value = parseInt(input.value) + change;
            if (value >= 1) {
                input.value = value;
            }
        }
    </script>



</body>

</html>