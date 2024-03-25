<?php
    require 'database.php';
    $id = $_GET['id'];
    $donne_post = $_POST['id'];
    if(!empty($donne_post))
    {
        $id = checkInput($donne_post);
        $db = Database::connect();
        $stmt = $db->prepare("DELETE FROM items WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute([
            'id' => $id,
        ]);
        Database::disconnect();
        header("location: admin.php");
    }

    if(!empty($donne_post))
        {
            $donne_post = checkInput($donne_post);
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
        
    <body style="text-align: center;">
    <br>
    <br>
        <h1 class="text-logo">BURGER PHP</h1>
        <br>
        <br>
        <div class="container admin">
            <div class="row">
                <h1><strong>Supprimer un menu</strong></h1>
        <form action="delete.php" method="POST" class="form" role="form">
            <input type="hidden" name="id" value="<?php echo $id;?>">
            <p class="alert alert-warning">Êtes vous sur de vouloir supprimer</p>
            <div class="form-actions">
                <button type="submit" class="btn btn-warning">Oui</button>
                <a class="btn btn-primary" href="admin.php">Non</a>
                </div>
            </form> 
            </div>
        </div>
    </body>
</html>