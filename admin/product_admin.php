<?php

include '../admin_and_user/connection.php';

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    $query = "SELECT * FROM product WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $product_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $productImage = htmlspecialchars($row['image']);
        $imagePath = $productImage;
        $productName = htmlspecialchars($row['name']);
        $productPrice = htmlspecialchars($row['price']);
        $productDescription = htmlspecialchars($row['description']);

        // Generate a random star rating (between 1 and 5)
        $randomStars = rand(1, 5);
    } else {
        echo 'Product not found.';
        exit;
    }

    // Fetch random related products
    $relatedQuery = "SELECT * FROM product WHERE id != ? ORDER BY RAND() LIMIT 3";
    $relatedStmt = mysqli_prepare($conn, $relatedQuery);
    mysqli_stmt_bind_param($relatedStmt, 'i', $product_id);
    mysqli_stmt_execute($relatedStmt);
    $relatedResult = mysqli_stmt_get_result($relatedStmt);
    $relatedProducts = [];
    while ($relatedRow = mysqli_fetch_assoc($relatedResult)) {
        $relatedProducts[] = $relatedRow;
    }

} else {
    echo 'No product ID provided.';
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Detail</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
          crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/product_details.css">
</head>
<style>
        body {
            background-color: #D7E5CA;
        }
       

    </style>
<body>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-7">
            <div class="product__detail-image">
                <div class="product__images">
                    <?php
                    echo "<img src='$imagePath' alt='Product'>";
                    echo "<img src='$imagePath' alt='Product'>";
                    echo "<img src='$imagePath' alt='Product'>";
                    ?>
                </div>
                <div class="product__image">
                    <img src="<?= $imagePath ?>" alt="Product">
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <h1 class="product__detail-title"><?= $productName ?></h1>
            <div class="product__price">
                NRs. <?= $productPrice ?> <span class="text-muted">/per item</span>
            </div>
            <div class="product__rating">
                <div class="">
                    <?php
                    // Display random star rating dynamically
                    for ($i = 1; $i <= 5; $i++) {
                        if ($i <= $randomStars) {
                            echo "<i class='fa fa-star'></i>";
                        } else {
                            echo "<i class='fa-regular fa-star'></i>";
                        }
                    }
                    ?>
                </div>
                <span>|</span>
                <div class="product__rating-subtitle">
                    <div class="">
                        <?= $randomStars ?> Ratings
                    </div>
                    <div class="text-muted">In Stock</div>
                </div>
            </div>
            <div class="product__description">
                <?= $productDescription ?>
            </div>
            
            <div class="product__button">
                <div class="product__button-common">
                    <button type="button" name="button" onclick="buyNowAlert()">Buy Now</button>
                </div>

                <script>
                function buyNowAlert() {
                    alert('You are not a user.Please register first.');
                }
                </script>

                <div class="product__button-common">
                    <button type="button" name="button" onclick="buyNowAlert()">Cart</button>
                </div>

                <script>
                function buyNowAlert() {
                    alert('You are not a user.Please register first.');
                }
                </script>

            </div>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-md-12">
            <h2>Customer Reviews</h2>
            <div class="customer__reviews">
                <?php
                // Sample reviews with ratings
                $reviews = [
                    ['name' => 'Shreeja Neupane', 'review' => 'Great product, highly recommend!', 'stars' => 5],
                    ['name' => 'Rojan Shrestha', 'review' => 'Good value for the price.', 'stars' => 4],
                    ['name' => 'Arohi Sah', 'review' => 'Perfect for my farm and good quality.', 'stars' => 4],
                    ['name' => 'Pritam Shrestha', 'review' => 'Good quality and good packaging.', 'stars' => 5],
                    ['name' => 'Ramesh Upadhyay', 'review' => 'Nice design, easy to setup.', 'stars' => 3],
                    ['name' => 'Bishnu Deshar', 'review' => 'Excellent service and product.', 'stars' => 5],
                    ['name' => 'Shreejan Maharjan', 'review' => 'Could be better quality.', 'stars' => 2],
                    ['name' => 'Davis Kunwar', 'review' => 'Great purchase, satisfied with it.', 'stars' => 4],
                ];

                // Shuffle reviews and display a random subset
                shuffle($reviews);
                $selectedReviews = array_slice($reviews, 0, 4); // Displaying 2 random reviews

                foreach ($selectedReviews as $review) {
                    echo "<div class='review'>";
                    echo "<h4>" . $review['name'] . "</h4>";
                    echo "<div class='review__stars'>";
                    for ($i = 1; $i <= 5; $i++) {
                        if ($i <= $review['stars']) {
                            echo "<i class='fa fa-star'></i>";
                        } else {
                            echo "<i class='fa-regular fa-star'></i>";
                        }
                    }
                    echo "</div>";
                    echo "<p>" . $review['review'] . "</p>";
                    echo "</div>";
                }
                ?>
            </div>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-md-12">
            <h2>Related Products</h2>
            <div class="related__products">
                <?php
                foreach ($relatedProducts as $relatedProduct) {
                    $relatedImage = htmlspecialchars($relatedProduct['image']);
                    $relatedName = htmlspecialchars($relatedProduct['name']);
                    $relatedId = htmlspecialchars($relatedProduct['id']);
                    echo "<div class='related__product'>";
                    echo "<a href='product_admin.php?product_id=$relatedId'>";
                    echo "<img src='$relatedImage' alt='$relatedName'>";
                    echo "<p>$relatedName</p>";
                    echo "</a>";
                    echo "</div>";
                }
                ?>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="back__button">
                <a href="admin_product.php" class="btn btn-secondary">Back to Products</a>
            </div>
        </div>
    </div>
</div>
<?php
include("../user/footer.php");
?>
</body>
</html>

<style>
    .customer__reviews {
    display: flex;
    flex-direction: column;
    gap: 20px;
    margin-top: 20px;
}

.review {
    background-color: #EEEDEB;
    padding: 15px;
    border-radius: 5px;
}

.review h4 {
    margin-bottom: 10px;
}

.review__stars {
    color: #ffc107; /* Color for filled stars */
}

.related__products {
    display: flex;
    gap: 150px;
    margin-top: 20px;
}

.related__product {
    text-align: center;
}

.related__product img {
    width: 300px;
    height: 300px;
    object-fit: cover;
    cursor: pointer;
}

.related__product p {
    margin-top: 10px;
}
    </style>