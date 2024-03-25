<?php
    require 'database.php';


    $nameError = $descriptionError = $categoryError = $imageError = $priceError = $name = $description = $image = $category = "";


    if(!empty($_POST))
        {
            $name        = checkInput($_POST['name']);
            $description = checkInput($_POST['description']);
            $category    = checkInput($_POST['category']);
            $price       = checkInput($_POST['price']);
            $image       = checkInput($_FILES['image']['name']);
            $imagePath   =  '../images/' . basename($image);
            $imageExtension  = pathinfo($imagePath, PATHINFO_EXTENSION);
            $isSucces = true;
            $isUploadSucces = false;

            if(empty($name))
            {
                $nameError = "ce champ ne peut pas être vide donner votre nom : ";
                $isSucces = false;
            }
            if(empty($price) || !is_numeric($price))
            {
                $priceError = "ce champ ne peut pas être vide donner le peix : ";
                $isSucces = false;
            }
            if(empty($description))
            {
                $descriptionError = "ce champ ne peut pas être vide donner la descrition : ";
                $isSucces = false;
            }
            if(empty($category))
            {
                $categoryError= "ce champ ne peut pas être vide donner la caetegories: ";
                $isSucces = false;
            }
            if(empty($image))
            {
                $imageError= "ce champ ne peut pas être vide donner l'image: ";
                $isSucces = false;
            }else{
                $isUploadSucces = true;
                if($imageExtension != "jpg" && $imageExtension != "png" && $imageExtension != "jpeg" && $imageExtension != "gif")
                {
                    $imageError = "l'extension n'es pas autorisée";
                    $isUploadSucces = false;
                }

                if(file_exists($imagePath))
                {
                    $imageError = "Error le fichier exist déja";
                    $isUploadSucces = false;
                }

                if($_FILES["image"]["size"] > 500000)
                {
                    $imageError = "le fichier ne doit pas dépasser les 500kb";
                    $isUploadSucces = false;
                }
            }
            if($isUploadSucces)
            {
                if(move_uploaded_file($_FILES['image']['tmp_name'], $imagePath))
                {
                    $imageError = "Erreur sur upload";
                    $isUploadSucces = false;
                }
            }
            if($isSucces && $isUploadSucces)
            {
                $db = Database::connect();
                $stmt = $db->prepare("INSERT INTO items (name, description, price, category, image) VALUES (:name, :description, :price, :category,:image)");
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':description', $description);
                $stmt->bindParam(':price', $price);
                $stmt->bindParam(':category', $category);
                $stmt->bindParam(':image', $image);
                $stmt->execute([
                    'name' => $name,
                    'description' => $description,
                    'price' => $price,
                    'category' => $category,
                    'image' => $image,
                ]);
                Database::disconnect();
                header("location: ../index.php");
            }
            
        }
        
        function checkInput($data)
        {
            $date = trim($data);
            $data = htmlspecialchars($data);
            $data = stripcslashes($data);
            return $data;
        }

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
        <h1 class="text-logo">Burger PHP </h1>
        <div class="container admin">
            <div class="row">
                <h1><strong>Ajouter un menu</strong></h1>
                <br>
                <form class="form" action="insert.php" role="form" method="post" enctype="multipart/form-data">
                    <br>
                    <div>
                        <label class="form-label" for="name">Nom:</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nom" value="<?php echo $name;?>">
                        <span class="help-inline"><?php echo $nameError;?></span>
                    </div>
                    <br>
                    <div>
                        <label class="form-label" for="description">Description:</label>
                        <input type="text" class="form-control" id="description" name="description" placeholder="Description" value="<?php echo $description;?>">
                        <span class="help-inline"><?php echo $descriptionError;?></span>
                    </div>
                    <br>
                    <div>
                        <label class="form-label" for="price">Prix:</label>
                        <input type="number" step="5" class="form-control" id="price" name="price" placeholder="Prix" value="<?php echo $price;?>">
                        <span class="help-inline"><?php echo $priceError;?></span>
                    </div>
                    <br>
                    <div>
                        <label class="form-label" for="category">Catégorie:</label>
                        <select class="form-control" id="category" name="category">
                        <?php
                           $db = Database::connect();
                           foreach ($db->query('SELECT * FROM categories') as $row) 
                             {
                                echo '<option value="'. $row['id'] .'">'. $row['name'] . '</option>';;
                             }
                           Database::disconnect();
                        ?>
                        </select>
                        <span class="help-inline"><?php echo $categoryError;?></span>
                    </div>
                    <br>
                    <div>
                        <label class="form-label" for="image">Sélectionner une image:</label>
                        <input type="file" id="image" name="image"> 
                        <span class="help-inline"><?php echo $imageError;?></span>
                    </div>
                    <br>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success"><span class="bi-pencil"></span> Ajouter</button>
                        <a class="btn btn-primary" href="index.php"><span class="bi-arrow-left"></span> Retour</a>
                   </div>
                </form>
            </div>
        </div>   
    </body>
</html>