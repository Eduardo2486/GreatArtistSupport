<?php
require_once 'core/init.php';

if(isset($_POST["submit"])){
    $number_post = $getFromU->getUserNumberPost($_SESSION["user_id"]);
    $number_post++;

    $title = $_POST["title"];
    $content = $_POST["content"];
    $audio = '';
    $image = '';
    $video = '';
    $type = $_POST["type"];
    
    if(isset($_FILES["audio"])){
        $extension = explode(".",$_FILES["audio"]["name"]);
        $extension_position = count($extension)-1;
        $extension = $extension[$extension_position];
        if($extension == "mp3"){
            $target = "assets/public/".$_SESSION["user_id"]."-".$number_post.".".$extension;
            if(move_uploaded_file($_FILES["audio"]["tmp_name"],$target )){
                $audio = $target;
            }
        }
    }

    if(isset($_FILES["image"])){
        $extension = explode(".",$_FILES["image"]["name"]);
        $extension_position = count($extension)-1;
        $extension = $extension[$extension_position];
        if($extension == "jpg" || $extension == "png" || $extension == "jpeg" || $extension == "gif" ){
            $target = "assets/public/".$_SESSION["user_id"]."-".$number_post.".".$extension;
            if(move_uploaded_file($_FILES["image"]["tmp_name"],$target )){
                $image = $target;
            }
        }
    }

    if(isset($_FILES["video"])){
        $extension = explode(".",$_FILES["video"]["name"]);
        $extension_position = count($extension)-1;
        $extension = $extension[$extension_position];
        if($extension == "mp4"){
            $target = "assets/public/".$_SESSION["user_id"]."-".$number_post.".".$extension;
            if(move_uploaded_file($_FILES["video"]["tmp_name"],$target )){
                $video = $target;
            }
        }
    }
    $newDateTime  =  new DateTime();
    $getFromP->newPost('post', 
    array('user_id'=>$_SESSION['user_id'], 
        'title'=>$title, 'content'=>$content, 
        'image'=>$image, 'audio'=>$audio, 
        'video'=>$video, 'type' => $type, 
        'posted_date'=> $newDateTime->format('Y-m-d H:i:s')));
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>New Post</title>
    <link rel="stylesheet" href="./assets/css/reset.css">
    <link rel="stylesheet" href="./assets/css/header.css">
    <link rel="stylesheet" href="./assets/css/newpost.css">
    <link rel="stylesheet" href="./assets/css/all.min.css">
</head>
<body>
    <?php
        require './header.php';
    ?>
    <style>
    .icon-input-file{
        font-size: 1.5em;
color: #fff;
position: relative;
top: 3px;
    }
    </style>
    <main class="main-container">
        <div class="main-user-content">
            <div class="new-post-container">
                <form action="new_post.php" method="POST" enctype="multipart/form-data">
                    
                    <input type="text" class="input-content-post" name="title" placeholder="Title">
                    <textarea class="input-content-post" name="content" placeholder="Content"></textarea>  
                
                    <div class="input-file-container">
                        <span class="icon-input-file"><i class="fas fa-image"></i></span>
                        <input name="image" class="load-multiple-files" type="file"/>
                    </div>

                    <div class="input-file-container">
                        <span class="icon-input-file"><i class="fas fa-file-audio"></i></span>
                        <input name="audio" class="load-multiple-files" type="file"/>
                    </div>

                    <div class="input-file-container">
                        <span class="icon-input-file"><i class="fas fa-video"></i></span>
                        <input name="video" class="load-multiple-files" type="file"/>
                    </div>

                    <select name="type" id="">
                        <option value=""></option>
                        <option value="audio">Audio</option>
                        <option value="video">Video</option>
                        <option value="image">Image</option>
                        <option value="text">Text</option>
                    </select>

                    <input type="submit" name="submit" class="submit-post" value="Submit">
                </form>
            </div>
        </div>
    </main>
    <footer>

    </footer>
   
</body>
</html>