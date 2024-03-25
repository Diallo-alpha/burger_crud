<?php 
    require_once(__DIR__. '/admin/database.php');
?>
<!DOCTYPE html>
<html>  
    <head>
        <title>Burger PHP</title>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
        <link href='http://fonts.googleapis.com/css?family=Holtwood+One+SC' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <div class="container site">
            <h1 class="text-logo">Burger PHP</h1>
            <nav>
                <ul class="nav nav-pills" role="tablist">
                    <?php
                        $db = Database::connect();
                        $statement = $db->query('SELECT * FROM categories');
                        $categories = $statement->fetchAll();
                        foreach ($categories as $category) {
                            if($category['id'] == '1') {
                                echo '<li class="nav-item" role="presentation"><a class="nav-link active" data-bs-toggle="pill" data-bs-target="#tab'. $category['id'] . '" role="tab">' . $category['name'] . '</a></li>';
                            } else {
                                echo '<li class="nav-item" role="presentation"><a class="nav-link" data-bs-toggle="pill" data-bs-target="#tab'. $category['id'] . '" role="tab">' . $category['name'] . '</a></li>';
                            }
                        }
                    ?>
                </ul>
            </nav>

            <div class="tab-content">
                <?php
                    foreach($categories as $category) {
                        if($category['id'] == '1') {
                            echo '<div class="tab-pane active" id="tab'.$category['id'] . '" role="tabpanel">';
                        } else {
                            echo '<div class="tab-pane" id="tab'.$category['id'] . '" role="tabpanel">';
                        }

                        echo '<div class="row">';
                        
                        $stmt = $db->prepare("SELECT * FROM items WHERE items.category = ?");
                        $stmt->execute(array($category['id']));

                        while($item = $stmt->fetch()) {
                            echo '<div class="col-md-6 col-lg-4">
                                    <div class="img-thumbnail">
                                        <img src="images/'.$item['image'].'" class="img-fluid" alt="...">
                                        <div class="price"> '.$item['price'].'</div>
                                        <div class="caption">
                                            <h4> '.$item['name'] .'</h4>
                                            <p>' . $item['description']. '</p>
                                            <a href="#" class="btn btn-order" role="button"><span class="bi-cart-fill"></span> Commander</a>
                                        </div>
                                    </div>
                                </div>';
                        }

                        echo '</div></div>';
                    }
                    Database::disconnect();
                ?>
            </div>
        </div>
    </body>
</html>
