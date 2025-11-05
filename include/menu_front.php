 <div class="col-lg-3">
     <div class="filter-sidebar p-4 shadow-sm">
         <?php
            require_once '../connectData.php';
            $sql = $pdo->prepare('select * from categories');
            $sql->execute();
            $categories = $sql->fetchAll(PDO::FETCH_ASSOC);
            ?>
         <div class="filter-group">
             <h6 class="mb-3">Categories</h6>
             <?php
                foreach ($categories as $category) {

                ?>
                 <a href="categories.php?id=<?= htmlspecialchars($category['id'] ?? '') ?>" class="list-group-item list-group-item-action"> <i class="<?= htmlspecialchars($category['icon'] ?? '') ?>"></i>&nbsp;&nbsp;<?= htmlspecialchars($category['name'] ?? '') ?></a>
             <?php
                }
                ?>
         </div>

     </div>
 </div>