<?php


var_dump($_POST['fileName']);
var_dump($_FILES);

// 1/ un fichier a t'il été envoyé ?
if(!empty($_FILES['fichier']['tmp_name'])) {
    //2/ le fichier a t'il été correctement uploadé ?
    if(is_uploaded_file($_FILES['fichier']['tmp_name'])) {
        //3/ le fichier a t'il un type autorisé .
        $typeMime = mime_content_type(($_FILES['fichier']['tmp_name']));

        if($typeMime == 'image/gif' || 'image/jpeg' || 'image/png' ) {
            //4/ le fichier respecte t'il la taille limite ?
            $size = filesize($_FILES['fichier']['tmp_name']);
            var_dump($size);
            if($size > 10000) {
                $message = "le fichier ne doit pas depasser 1Mo";
            }else {
                //5/ Nettoyage du nom de fichier propose
                $cleanBefore = $_POST['fileName'];
                //Remplacer les caractères qui ne sont pas des ;lettres ni des nombres
                $cleanName = preg_replace("-[^\\pl\d]*-u", 'image', $cleanBefore);
                
            }
        } else {
            $message = " ne sont acceptés que les fichiers .png, .jpeg et .gif";
        }
    }
}





//Emplacement temporaire du fichier uploadé
$tempFile = $_FILES['fichier']['tmp_name']; //on utilise le nom fichier car utilise comme attribut "name" dans le formulaire

//Construction du nom de fichier : recuperation de l'extension du fichier
$extension=substr(strchr($_FILES['fichier']['name'], "."),1);

//recuperation du nom de fichier proposé par l'utilisateur
$newName = $_POST['fileName'].".".$extension;


//on crée une variable pour le chemin definitif ici sans le nom avec l'extension
//$definitiveFile = 'upload/'.$_FILES['fichier']['name'];
//ICI avec l'extension
$definitiveFile = 'upload/'.$newName;

//on crée une fonction pour s'assurer que le fichier est bien uploadé, en cas d'erreur la fonction renvoie un message
$moveIsOk = move_uploaded_file($tempFile,$definitiveFile);

if($moveIsOk)
{
    $message = "le fichier a été uploadé dans " . $definitiveFile;
} else {
    $message = "Suite à une erreur, le fichier n'a pas été uploadé";
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!----------------------import bootstrap--------------------------->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!----------------------Link style CSS--------------------------->
    <link rel="stylesheet" href="style.css">

    <title>Traitement du fichier</title>
</head>
<body>

<h1>UPLOAD</h1>

<p><?= $message ?></p>


</body>
</html>

