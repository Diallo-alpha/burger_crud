<?php
require_once(__DIR__ .'/database.php');

$donne_Get =  $_GET['id'];

if(!isset($donne_Get) || !empty($donne) || trim($donne_Get)=== '')
    {
        echo 'id not find ';
    }    

    $db = Database::connect();
    $statement = $db->prepare('SELECT items.id, items.name,items.description,items.price,items.image,categories.name AS category
                               FROM items
                               LEFT JOIN categories 
                               ON items.category = categories.id
                               WHERE items.id = ?');

    $statement->bindParam(':id', $donne_Get);
    $statement->execute([$donne_Get]);

    $items = $statement->fetch();
    Database::disconnect();
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
        <link rel="stylesheet" href="../styles.css">
    </head>
    
    <body>
        <h1 class="text-logo">Burger PHP</h1>
        <div class="container admin">
            <div class="row">
                <div class="col-sm-6">
                <h1><strong>Voir un item</strong></h1>
                <br>

            <form>
                <div class="form-group">
                    <label for="nom">Nom:</label><?php echo ' '.$items['name']; ?>
                </div>
                <div class="form-group">
                    <label for="description">Description:</label><?php echo ' '.$items['description']; ?>
                </div>
                <div class="form-group">
                    <label for="price">Prix:</label><?php echo ' '.$items['price']; ?></label>
                </div>
                <div class="form-group">
                    <label for="category">Categories :</label><?php echo ' '.$items['category']; ?></label>
                </div>
                <div class="form-group">
                    <label for="image">image :</label><?php echo ' '.$items['image']; ?></label>
                </div>
            </form>
            <br>
            <div class="form-actions">
            <a class="btn btn-primary" href="admin.php"><span class="bi-arrow-left"></span> Retour</a>
            </div>
                </div>
                <div class="col-sm-6 site">
                <div class="img-thumbnail">
                        <img src="<?php echo '../images/' .$items['image'];?>" class="img-fluid" alt="...">
                        <div class="price"><p><?php echo $items['price']; ?></p></div>
                        <div class="caption">
                        <h4><?php echo $items['name']; ?></h4>
                        <p><?php echo ' '.$items['description'];?></p>
                        <a href="#" class="btn btn-order" role="button"><span class="bi-cart-fill"></span></a>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>