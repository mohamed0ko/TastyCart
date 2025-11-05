<?php
require_once '../auth/authCheck.php';

if (!isAdmin()) {
    header('Location: /TastyCart/page/403.php');
    exit;
}
?>
<?php
$connect = isset($_SESSION['users']);
$user = $_SESSION['users'] ?? null;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Add Product</title>
</head>

<body>
    <?php include '../../include/nav.php'; ?>



    <div class="container my-3 ">


        <?php
        //create product
        if (isset($_POST['addProduct'])) {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $prix = $_POST['prix'];
            $discount = $_POST['discount'];
            $category_id = (int) $_POST['category_id'];
            $data = date('Y-m-d');
            //upload image 
            $filename = 'product.png';
            if (!empty($_FILES['image'])) {
                $image = $_FILES['image']['name'];
                $filename =  uniqid() . $image;
                $destination = __DIR__ . '/../../upload/product/' . $filename;
                //move_uploaded_file($_FILES['image']['tmp_name'],   $destination);
                if (move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
                    // Successfully uploaded
                } else {
                    // Upload failed — keep default image
                    $filename = 'product.png';
                }
            }
            if (
                !empty($name) &&
                is_numeric($prix) &&
                is_numeric($discount) &&
                !empty($category_id)
            ) {
                require_once '../../connectData.php';

                $sql = $pdo->prepare('INSERT INTO products (name,description, prix, discount,image, category_id, date_creation) VALUES (?, ?, ?, ?, ?,?,?)');
                $sql->execute([$name, $description, $prix, $discount, $filename, $category_id, $data]);

                header("Location: " . $_SERVER['PHP_SELF'] . "?success=" . urlencode($name));
                exit;
            } else {
                header("Location: " . $_SERVER['PHP_SELF'] . "?error=1");
                exit;
            }
        }


        // fetch categories
        require_once '../../connectData.php';
        $sql = $pdo->prepare('SELECT id, name FROM categories');
        $sql->execute();
        $categories = $sql->fetchAll(PDO::FETCH_ASSOC);

        ?>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success my-3 fade-out" role="alert">
                Create category <?php echo htmlspecialchars($_GET['success']); ?> successfully!
            </div>
        <?php elseif (isset($_GET['error'])):  ?>
            <div class="alert alert-danger my-3 fade-out" role="alert">
                Data invalid !
            </div>
        <?php endif; ?>

        <form method="post" enctype="multipart/form-data">
            <h3>Add Product</h3>

            <div class="mb-3 my-3">
                <label for="login" class="form-label">name</label>
                <input type="text" class="form-control" id="name" name="name">
            </div>

            <div class="form-floating mb-3">
                <textarea class="form-control" placeholder="Leave a comment here" name="description" id="description"></textarea>
                <label for="description">Description</label>
            </div>

            <div class="mb-3 my-3">
                <label for="prix" class="form-label">Prix</label>
                <input type="text" class="form-control" id="prix" name="prix">
            </div>
            <div class="mb-3 my-3">
                <label for="discount" class="form-label">
                    Discount: <span id="discountValue">0%</span>
                </label>

                <input
                    type="range"
                    class="form-range"
                    name="discount"
                    id="discount"
                    min="0"
                    max="90"
                    value="0"
                    oninput="document.getElementById('discountValue').textContent = this.value + '%';">
            </div>


            <div class="mb-3 my-3">
                <label for="image" class="form-label">Image</label>
                <input class="form-control" type="file" id="image" name="image">
            </div>
            <select class="form-select mb-3" name="category_id" aria-label="Default select example">
                <option selected> select Category</option>
                <?php if (count($categories) > 0) : ?>
                    <?php foreach ($categories as $category) : ?>

                        <option value="<?= htmlspecialchars($category['id'] ?? '') ?>"><?= htmlspecialchars($category['name'] ?? '') ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>

            </select>



            <button type="submit" class="btn btn-primary" name="addProduct">Add Product</button>

        </form>
    </div>

</body>

</html>