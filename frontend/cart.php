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
    <title>Cart </title>

</head>

<body>

    <?php include '../include/nav_front.php' ?>
    <?php
    require_once '../connectData.php';
    $userId = $_SESSION['users']['id'] ?? 0;
    $cartCount = count($_SESSION['cart'][$userId]);
    $cart = $_SESSION['cart'][$userId] ?? [];
    //create cart

    $products = [];

    if (!empty($cart)) {
        $idProducts = array_keys($cart);
        $idProductsString = implode(',', $idProducts);

        if (!empty($idProductsString)) {
            $stmt = $pdo->query("SELECT * FROM products WHERE id IN ($idProductsString)");
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    //create command

    if (isset($_POST['valid']) && !empty($products)) {
        $grandTotal = 0;
        $productPrix = [];

        foreach ($products as $product) {
            $productId = $product['id'];
            $qte = $cart[$productId];

            // Calculate discounted price if applicable
            if (!empty($product['discount'])) {
                $prix = $product['prix'] - ($product['prix'] * $product['discount'] / 100);
            } else {
                $prix = $product['prix'];
            }

            // total for this product
            $total = $prix * $qte;

            // add to overall total
            $grandTotal += $total;

            $productPrix[$productId] = [
                'product_id' => $productId,
                'prix' => $prix,
                'total' => $prix * $qte,
                'qte' => $qte
            ];
        }

        $sql = $pdo->prepare('insert into command (user_id,total) value(?,?)');
        $sql->execute([$userId, $grandTotal]);
        $commandId = $pdo->lastInsertId();

        //create command line
        $sqlCom = 'INSERT INTO command_line (product_id, command_id, prix, quantity, total) VALUES ';
        $params = [];

        foreach ($productPrix as $product) {
            $id = $product['product_id'];

            $sqlCom .= "(:product_id$id, :command_id$id, :prix$id, :quantity$id, :total$id),";

            $params[":product_id$id"] = $product['product_id'];
            $params[":command_id$id"] = $commandId;
            $params[":prix$id"] = $product['prix'];
            $params[":quantity$id"] = $product['qte'];
            $params[":total$id"] = $product['total'];
        }


        $sqlCom = rtrim($sqlCom, ',');


        $sqlState = $pdo->prepare($sqlCom);
        $insert = $sqlState->execute($params);

        if ($insert) {
            $_SESSION['cart'][$userId] = [];


    ?>
            <div class="alert alert-primary my-3 fade-out" role="alert" id="successAlert">
                Command created successfully
            </div>
    <?php
        }
        // header("location:" . $_SERVER['HTTP_REFERER']);
    }


    ?>
    <?php

    if (empty($cart)) {
    ?>

        <div class="container mt-5">

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
                            <?php

                            $orderSubTotal = 0;
                            $orderDisc = 0;
                            $orderTotal = 0;
                            foreach ($products as $product) {
                                $productId = $product['id'];
                                $qte = isset($cart[$productId]) ? $cart[$productId] : 0;

                                //subTotal
                                $order = $product['prix'] * $qte;
                                $orderSubTotal += $order;

                                //discount
                                $discount = $product['discount'] ?? 0;
                                $priceAfterDiscount = $product['prix'] - ($product['prix'] * $discount / 100);
                                $orderAfterDiscount = $priceAfterDiscount * $qte;
                                $orderTotal += $orderAfterDiscount;
                                //orderTotal
                                $orderDisc = $orderSubTotal - $orderTotal;

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
                                                <?php
                                                $idProduct = $product['id'];
                                                include '../include/qte.php'
                                                ?>
                                            </div>
                                            <div class="col-md-2">
                                                <?php

                                                if (isset($product['discount'])) {
                                                    $prix = $product['prix'];
                                                    $discount = $product['discount'];
                                                    $total_disc = $prix - (($prix * $discount) / 100);
                                                    $qte = $cart[$product['id']];
                                                    $total = $total_disc * $qte;
                                                    //--------

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
                                                <form action="delete_cart.php" method="post">
                                                    <?php
                                                    $currentProductId = $idProduct;
                                                    //
                                                    ?>
                                                    <input type="hidden" name="id" value="<?php echo $currentProductId ?>">
                                                    <button type="submit" name="delete" class="btn btn-link p-0 border-0">
                                                        <i class="bi bi-trash text-danger fs-5"></i>
                                                    </button>
                                                </form>
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
                                    <span>$<?php echo  $orderSubTotal; ?></span>
                                </div>
                                <div class="d-flex justify-content-between mb-3">
                                    <span class="text-muted">Discount</span>
                                    <span class="text-success">-$<?php echo $orderDisc ?></span>
                                </div>

                                <hr>
                                <div class="d-flex justify-content-between mb-4">
                                    <span class="fw-bold">Total</span>
                                    <span class="fw-bold">$<?php echo $orderTotal  ?></span>
                                </div>

                                <form method="post">
                                    <button name="valid" value="valid command" class="btn btn-primary checkout-btn w-100 mb-3">
                                        Proceed to Checkout
                                    </button>
                                </form>

                                <div class="d-flex justify-content-center gap-2">
                                    <i class="bi bi-shield-check text-success"></i>
                                    <small class="text-muted">Secure checkout</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    <?php
    }
    ?>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function updateQuantity(productId, change) {
            const input = event.target.parentElement.querySelector('.quantity-input');
            let value = parseInt(input.value) + change;
            if (value >= 0) {
                input.value = value;
            }
        }
        // alert
        setTimeout(() => {
            const alert = document.getElementById('successAlert');
            if (alert) {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(() => {
                    alert.remove();

                    // clear the cart visually
                    const cartWrapper = document.querySelector('.cart-wrapper');
                    if (cartWrapper) {
                        cartWrapper.innerHTML = `
                    <div class="container mt-5">
                        <div class="alert alert-danger my-3" role="alert">
                            Cart is empty!
                        </div>
                    </div>`;
                    }
                }, 100);
            }
        }, 1000);
    </script>



</body>

</html>