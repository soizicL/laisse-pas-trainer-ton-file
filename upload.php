<?php

//SUPPRIMER LE FICHIER
if(!empty($_POST['delete'])) {
    unlink('upload/'.$_POST['delete']);
}

//VERIFICATION DE L'ENVOI

if(!empty($_FILES['upload_file'])) {
    if(count($_FILES['upload_file']['name']) >0)
    {
        for ($i = 0; $i < count($_FILES['upload_file']['name']); $i++)
        {

            //VERIFICATION EXTENSION
            $validExtension = array('jpeg', 'jpg', 'png', 'gif');
            $fileExtension = strtolower(substr(strrchr($_FILES['upload_file']['name'][$i], '.'),1));
            if(in_array($fileExtension, $validExtension)) {

                //Nom
                $key = "image";
                $keys = array_merge(range(0,9), range('a', 'z'));

                for($y =0; $y <10; $y++) {
                    $key.= $keys[array_rand($keys)];
                }

                //VERIFICATION ADDRESSE FICHIER
                $upload = "upload/" .$key ."." .$fileExtension;

                if($_FILES['upload_file']['tmp_name'] != "") {
                    if(move_uploaded_file($_FILES['upload_file']['tmp_name'][$i], $upload)) {
                        //OK
                        move_uploaded_file($_FILES['upload_file']['tmp_name'][$i], $upload);
                        echo " it's good";
                    } else {
                        echo "problem with : " .$_FILES['upload_file']['error'][$i];
                    }
                }else {
                    echo "file doesn't exist";
                }
            }else {
                echo " extension doesn't authorized";
            }
        }
} else {
        echo "<p> No new file</p>";
}
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>UPLOAD DE FICHIER</title>
    <!----------------------import bootstrap--------------------------->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>

<body>

    <div class="container">
        <form action="#" method="post" enctype="multipart/form-data">
            <p><input type="hidden" name="SizeMax" value="999999"/></p>
            <p><label for="upload"> ADD FILES : </label></p>
            <p> <input type="file" name="upload_file[]" multiple="multiple"/></p>
            <p><input type="submit" name="submit" value ="Submit"></p>
        </form>
    </div>


<br/><br/> IMAGE <br/><br/>

<section>
    <div class="container">

            <div class="col-xs-10">
                <?php
                $files = scandir('upload/');
                $i = 0;
                foreach ($files as $file) {
                    if($file == "." OR $file == "..") {

                    } else {
                        $i++;
                        ?>
                <div class="thumbnails">
                    <img src="upload/<?= $file ?>" alt="image"/>
                    Nom : <?= $file ?>
                    <form id="<?= $i ?>" action="#" method="post">
                        <input type="text" style="display:none" name="delete" value="<?=$file ?>" />
                        <input type="submit" name="submit" value="Delete"/>
                    </form>
                </div>
                <br/><br/>
                <?php
                    }
                }
                ?>
            </div>

    </div>
</section>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>

