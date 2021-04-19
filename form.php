
<?php

$errors = '';
$uploadDir = '';
$uploadFile = '';
$extension = '';
$extensions_ok = [];
$maxFileSize = 0;
$fileName = '';
$uniqueName = '';

if($_SERVER['REQUEST_METHOD'] === "POST"){ 

$uploadDir = 'public/uploads/';

$fileName = $_FILES['avatar']['tmp_name'];

$uploadFile = $uploadDir . basename($_FILES['avatar']['name']);

$extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);

$extensions_ok = ['jpg','gif','png','webp'];

$maxFileSize = 1000000;


if( (!in_array($extension, $extensions_ok ))){

    $errors = 'Veuillez sélectionner une image de type jpg/gif/png/webp !';
}

if(filesize($fileName) > $maxFileSize)
{
     $errors = "Votre fichier doit faire moins de 1M !";
}else{
    move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadFile);
}

/**
 * Delete uploaded image
 */
if(isset($_POST['delete'])){
    if(file_exists($fileName)){
        unlink($fileName);
    }else{
        $errors = "Ce fichier n'existe pas";
    }
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="public//assets/css/style.css">
    <title>File Upload Challenge - Amadou NDIAYE</title>
</head>
<body>
    <h1>Upload image</h1>
<!--Gestion des erreurs-->
<?php if(!empty($errors)) { ?>
        <div class="msg-errors">
            <p><?php echo $errors; ?></p>
        </div>
    <?php } ?>  

    <div class="file-form">
        <form method="post" enctype="multipart/form-data" action="#">

            <label for="imageUpload">Veuillez charger votre image</label>    
        
            <input type="file" name="avatar" id="imageUpload" />
        
            <button name="send">Envoyer</button>
        
        </form>
    </div>

    <?php if(isset($_POST['send'])) { ?>

        <div class="card">
        <div class="text-top border-top">
            <p>TAXICAB <br>LICENSE</p>
        </div>
        <img class="border" src="<?= $uploadFile ?>" alt="Uploaded image for avatar">
        <div class="text-bottom border-bottom">
            <p>HOMER J. SIMPSON</p>
            <p>742 EVERGREEN TERRACE</p>
            <p>SPRINGFIELD,USA.</p>
            <p>SEX:M</p>
            <p>HAIR:NONE</p>
        </div>
    </div>

    <div class="delete-btn">
        <button type="button" name="delete">Delete image</button>
    </div>
    <?php } ?>  
    
</body>
</html>