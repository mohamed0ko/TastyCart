<?php
$userId = $_SESSION['users']['id'];
$qte = $_SESSION['cart'][$userId][$idProduct] ?? 0;
?>

<form action="add_cart.php" method="post">
    <div class="d-flex align-items-center gap-2">
        <?php $currentProductId = $idProduct;
        ?>
        <input type="hidden" name="id" value="<?php echo $currentProductId ?>">

        <button type="button" class="quantity-btn" onclick="updateQuantity(<?php echo $currentProductId; ?>, -1)">-</button>

        <input type="number" name="qte" id="qte_<?php echo $currentProductId; ?>" class="quantity-input" value="<?php echo $qte ?>" min="0" max="99">

        <button type="button" class="quantity-btn" onclick="updateQuantity(<?php echo $currentProductId; ?>, 1)">+</button>

        <button type="submit" value="add" name="add" class="btn cart-btn text-black">
            <i class="fa-solid fa-cart-plus"></i>
        </button>
    </div>
</form>