<?php

require_once 'core/init.php';

$actualInfo = $getFromU->userData($_SESSION["user_id"]);


if(isset($_POST["submit"])){

    $location = $_POST["location"];
    $email = $_POST["email"];
    $about = $_POST["about"];

    $imageProfile ='';
    $imageCover = '';

    if(isset($_FILES["cover"])){
        $extension = explode(".",$_FILES["cover"]["name"]);
        $extension_position = count($extension)-1;
        $extension = $extension[$extension_position];
        if($extension == "jpg" || $extension == "png" || $extension == "jpeg" || $extension == "gif" ){
            $target = "assets/public/".$_SESSION["user_id"]."cover.".$extension;
            if(move_uploaded_file($_FILES["cover"]["tmp_name"],$target )){
                $imageCover = $target;
            }
        }
    }
    if(isset($_FILES["profile"])){
        $extension = explode(".",$_FILES["profile"]["name"]);
        $extension_position = count($extension)-1;
        $extension = $extension[$extension_position];
        if($extension == "jpg" || $extension == "png" || $extension == "jpeg" || $extension == "gif" ){
            $target = "assets/public/".$_SESSION["user_id"]."profile.".$extension;
            if(move_uploaded_file($_FILES["profile"]["tmp_name"],$target )){
                $imageProfile = $target;
            }
        }
    }

    
    if($imageProfile == ""){
        $imageProfile = 'assets/public/defaultProfile.jpg';
    }
    if($imageCover == ""){
        $imageCover = 'assets/public/defaultCover.jpg';
    }
    

    $getFromU->updateUserInfo($_SESSION["user_id"],$email, $about, $location, $imageProfile, $imageCover );

}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Settings</title>
    <link rel="stylesheet" href="./assets/css/reset.css">
    <link rel="stylesheet" href="./assets/css/header.css">
    
    <link rel="stylesheet" href="./assets/css/settings.css">
    
    <link rel="stylesheet" href="./assets/css/all.min.css">
</head>
<body>
    <?php
    require_once 'header.php';
    ?>

    <main class="main-container">

        <div class="main-user-content">
            <div class="container-user-edit">
               
                <form class="form-edit-user" action="setting.php" method="POST"  enctype="multipart/form-data">
                    <h2 class="heading-2">Settings</h2>
                    <div class="element-action-container">
                        <span class="element-action">
                                <i class="fas fa-image"></i>
                        </span>
                        <span class="element-action-name">
                            Cover:
                        </span>
                        <input type="file" class="input-file" name="cover" id="">
                    </div>

                    <div class="element-action-container">
                        <span class="element-action">
                            <i class="fas fa-file-image"></i>
                        </span>
                        <span class="element-action-name">
                            Profile:
                        </span>
                        <input type="file" class="input-file" name="profile" id="">
                    </div>
                    <div class="element-action-container">
                        <span class="element-action">
                            <i class="fas fa-map-pin"></i>
                        </span>
                        <span class="element-action-name">
                            Country:
                        </span>
                        <input placeholder="Location" type="text" value="<?php echo $actualInfo->location; ?>" class="input-file" name="location" id="">
                    </div>
                    <div class="element-action-container">
                        <span class="element-action">
                            <i class="fas fa-at"></i>
                        </span>
                        <span class="element-action-name">
                            Email:
                        </span>
                        <input type="text" class="input-file" value="<?php echo $actualInfo->email; ?>" placeholder="Email" name="email" id="">
                    </div>
                    <div class="element-action-container">
                        <span class="element-action">
                            <i class="fas fa-newspaper"></i>
                        </span>
                        <span class="element-action-name">
                            About you:
                        </span>
                        <textarea placeholder="About you" value="<?php echo $actualInfo->about; ?>" class="textarea-about" name="about"></textarea>
                    </div>
                    <input type="submit" value="Save" name="submit" class="save-button">
                </form>
            </div>
        </div>
    </main>
    <footer>

    </footer>
   
</body>
</html>