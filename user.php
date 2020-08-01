<?php
require_once 'core/init.php';
$userProfile = null;
if(isset($_GET["user"])){
    $userProfile=$getFromU->userDatabyUsername($_GET["user"]);
    if($userProfile->id == $_SESSION["user_id"]){
        header("Location: user.php");
    }
}else{
    $userProfile=$getFromU->userData($_SESSION['user_id']);
}

$posts = $getFromP->getUserPostsById($_SESSION['user_id']);



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $userProfile->username ?></title>
    <link rel="stylesheet" href="./assets/css/reset.css">
    <link rel="stylesheet" href="./assets/css/header.css">
    
    <link rel="stylesheet" href="./assets/css/user.css">
    
    <link rel="stylesheet" href="./assets/css/all.min.css">
</head>
<body>
    
<?php require "./header.php"; ?>

    <div class="send-tip-container" id="send-tip-container" style="display:none;">
        <div class="send-tip-box">
            <h3 class="heading-3">How much do you want to donate?</h3>
            <input type="text" value="0" placeholder="Insert the quantity here" id="send-tip-input-modal" class="input-donate">
            <div class="center-send-tip-button-box">
                <button class="send-tip-button-box" id="send-tip-button-modal">Donate</button>
            </div>
        </div>
    </div>
    <div class="send-tip-container" id="info-post-container" style="display:none;">
        <div class="send-tip-box">
            <h3 class="heading-3">Post status</h3>
            <div class="info-container" id="info-modal-container" style="font-size: 1.3em;font-family: 'OpenSans';">
                
            </div>
            <div class="center-send-tip-button-box">
                <button class="send-tip-button-box" id="info-post-button-modal">OK</button>
            </div>
        </div>
    </div>

    <div class="send-tip-container" id="report-container" style="display:none;">
        <div class="send-tip-box">
            <h3 class="heading-3">Report</h3>
            <div class="info-container" id="report-modal-container" style="font-size: 1.3em;font-family: 'OpenSans';">
                
            </div>
            <div class="center-send-tip-button-box">
                <button class="send-tip-button-box" id="report-button-modal">OK</button>
            </div>
        </div>
    </div>
    

    <main class="main-container">
        <div style="display:none">
            <audio id="global-music-player" src=""></audio>
        </div>
        <div class="background-image-user" style="background-image: url('<?php echo $userProfile->cover ?>')">

        </div>
        <div class="main-user-content">
            <div class="user-info-container">
                <div class="user-info-image-container">
                    <img src="<?php echo $userProfile->profile ?>" class="user-image-profile" alt="">
                </div>
                <div class="user-info-content">
                    <div class="user-info-detail user-name">
                        <strong class="username-page" class=""><?php echo $userProfile->username ?></strong>
                    </div>
                    <?php
                        if( $userProfile->about != "" ){
                        echo '<div class="user-info-detail user-description">
                            <span class="user-info-icon">
                                <i class="fas fa-newspaper"></i>
                            </span>
                            <span class="user-info-value">'. $userProfile->about.'a</span>
                        </div>';
                        }
                    ?>
                    <?php
                        if( $userProfile->location != "" ){
                        echo '<div class="user-info-detail user-location">
                                <span class="user-info-icon">
                                    <i class="fas fa-map-pin"></i>
                                </span>
                                <span class="user-info-value">'. $userProfile->location .'</span>
                            </div>';
                        }
                    ?>
                    <?php
                        if( $userProfile->profile != "" ){
                            echo '<div class="user-info-detail user-email">
                                <span class="user-info-icon">
                                    <i class="fas fa-at"></i>
                                </span>
                                <span class="user-info-value">'. $userProfile->email .'</span>
                            </div>';
                        }
                    ?>
                    <div class="user-info-detail user-email">
                            <span class="user-info-icon">
                            <i class="fas fa-chart-area"></i>
                            </span>
                            <span class="user-info-value" id="report-button" style="color: #239aff;cursor: pointer;">Report</span>
                        </div>
                    
                </div>
            </div>
            <div class="user-posts">
                    <?php 
                        if(isset($posts)){
                            foreach($posts as $post){
                                
                                if($post["type"] == "text"){
                                    $tip_button = "";
                                    if( $userProfile->user_id != $_SESSION["user_id"] ) {
                                        $tip_button = '<div class="send-tip-button"  data-id-post="'.$post["post_id"].'" data-id-user="'.$userProfile->user_id.'">
                                            <span class="send-tip-button-link"><i class="far fa-money-bill-alt"></i></span>
                                        </div>'; 
                                    }else{
                                        $tip_button = '<div class="info-post-button"  data-id-post="'.$post["post_id"].'" data-id-user="'.$userProfile->user_id.'">
                                            <span class="info-post-button-link"><i class="fas fa-info"></i></span>
                                        </div>'; 
                                    }
                                    echo '
                                    <div class="single-post">
                                    <div class="element-user-page">
                                            <figure class="image-element-container">
                                                <h2 class="heading-name-art">'.$post["title"].'</h2>
                                                <div class="content-element">
                                                    <span class="text-user-art">'.$post["content"].'</span>
                                                </div>
                                                <div class="download-art">
                                                    
                                                    '.$tip_button.'
                                                </div>                                        
                                            </figure>
                                        </div>
                                        </div>';
                                }else if($post["type"] == "video"){
                                    $file_name = explode('/',$post["video"]);
                                    $tip_button = "";
                                    if( $userProfile->user_id != $_SESSION["user_id"] ) {
                                        $tip_button = '<div class="send-tip-button"  data-id-post="'.$post["post_id"].'" data-id-user="'.$userProfile->user_id.'">
                                            <span class="send-tip-button-link"><i class="far fa-money-bill-alt"></i></span>
                                        </div>'; 
                                    }else{
                                        $tip_button = '<div class="info-post-button"  data-id-post="'.$post["post_id"].'" data-id-user="'.$userProfile->user_id.'">
                                            <span class="info-post-button-link"><i class="fas fa-info"></i></span>
                                        </div>'; 
                                    }
                                    echo ' <div class="single-post">
                                      <div class="element-user-page">
                                    <figure class="image-element-container">
                                        <h2 class="heading-name-art">'.$post["title"].'</h2>
                                        <div class="image-element">
                                                <video class="video-element" controls src="'.$post["video"].'"></video>
                                            <figcaption class="text-user-art">'.$post["content"].'</figcaption>
                                        </div>
                                      
                                        <div class="download-art">
                                            <div class="download-button">
                                                <a href="'.BASE_URL.'download.php?file='.$file_name[2].'" class="download-button-link"><i class="fas fa-arrow-down"></i></a>
                                            </div>
                                            '. $tip_button .'
                                        </div>
                                    </figure>
                                </div>
                                </div>';

                                }else if($post["type"] == "audio"){
                                    $imageUrl = "";
                                    if($post["image"] == " "){
                                        $imageUrl = $post["image"];
                                    }else{
                                        $imageUrl = "assets/public/defaultMusicImage.png" ;
                                    }
                                    $file_name = explode('/',$post["audio"]);
                                    $tip_button = "";
                                    if( $userProfile->user_id != $_SESSION["user_id"] ) {
                                        $tip_button = '<div class="send-tip-button"  data-id-post="'.$post["post_id"].'" data-id-user="'.$userProfile->user_id.'">
                                            <span class="send-tip-button-link"><i class="far fa-money-bill-alt"></i></span>
                                        </div>'; 
                                    }else{
                                        $tip_button = '<div class="info-post-button"  data-id-post="'.$post["post_id"].'" data-id-user="'.$userProfile->user_id.'">
                                            <span class="info-post-button-link"><i class="fas fa-info"></i></span>
                                        </div>'; 
                                    }
                                    echo '<div class="single-post">
                                            <div class="element-user-page">
                                            <figure class="image-element-container">
                                                <h2 class="heading-name-art">'.$post["title"].'</h2>
                                                <div class="image-element">
                                                    <img class="user-image-art" src="'. $imageUrl .'" alt="">
                                                    <figcaption class="text-user-art">'.$post["content"].'</figcaption>
                                                </div>
                                                <div class="music-player-container">
                                                    <span class="song-icon-play" data-actual-state="stop" data-song-src="'.$post["audio"].'"><i class="fas fa-play"></i></span>
                                                    <div class="song-play-back-container">
                                                        <div class="song-duration-bar">
                                                        </div>
                                                        <span class="song-position-icon"></span>
                                                    </div>
                                                </div>
                                                <div class="download-art">
                                                    <div class="download-button">
                                                        <a href="'.BASE_URL.'download.php?file='.$file_name[2].'" class="download-button-link"><i class="fas fa-arrow-down"></i></a>
                                                    </div>
                                                    '.$tip_button.'
                                                </div>
                                            </figure>
                                            </div>
                                        </div>';
                                }else if($post["type"] == "image"){
                                    $tip_button = "";
                                    if( $userProfile->user_id != $_SESSION["user_id"] ) {
                                        $tip_button = '<div class="send-tip-button"  data-id-post="'.$post["id"].'" data-id-user="'.$userProfile->id.'">
                                            <span class="send-tip-button-link"><i class="far fa-money-bill-alt"></i></span>
                                        </div>'; 
                                    }else{
                                        $tip_button = '<div class="info-post-button"  data-id-post="'.$post["id"].'" data-id-user="'.$userProfile->id.'">
                                            <span class="info-post-button-link"><i class="fas fa-info"></i></span>
                                        </div>'; 
                                    }
                                    $file_name = explode('/',$post["image"]);
                                    echo '<div class="single-post">
                                        <div class="element-user-page">
                                            <figure class="image-element-container">
                                                <h2 class="heading-name-art">'.$post["title"].'</h2>
                                                <div class="image-element">
                                                    <img class="user-image-art" src="'.$post["image"].'" alt="">
                                                    <figcaption class="text-user-art">'.$post["content"].'</figcaption>
                                                </div>
                                                <div class="download-art">
                                                    <div class="download-button">
                                                        <a href="'.BASE_URL.'download.php?file='.$file_name[2].'" class="download-button-link"><i class="fas fa-arrow-down"></i></a>
                                                    </div>
                                                    '.$tip_button.'
                                                </div>
                                                
                                            </figure>
                                        </div>
                                    </div> ';
                                }                  
                            }
                        }

                    ?>
                 
               
            </div>
        </div>
    </main>
    <footer>

    </footer>
    <script src="./assets/js/sweetAlerts.js"></script>
    <script>
        let playerAudio = document.getElementById('global-music-player');
        $(document).ready(function(){
            let currentElementPlaying = null;
            let timer;
            function transitionPositionPlayer(){
               
                let durationSong =  document.getElementById("global-music-player").duration;
                let currentTime = document.getElementById("global-music-player").currentTime;
                let barWidth = currentElementPlaying.next().children(".song-duration-bar").width();
                let positionIcon = currentElementPlaying.next().children(".song-position-icon");
                let newPositionIcon = barWidth * (currentTime / durationSong);
                timer = setTimeout(function(){ currentElementPlaying.next().children(".song-position-icon").css("width" , newPositionIcon); }, 100);
            }
            playerAudio.addEventListener("timeupdate", transitionPositionPlayer, false);

            $(".song-duration-bar").click(function(e){
                if(currentElementPlaying != null && currentElementPlaying.next().children(".song-duration-bar")[0] == this){    
                    var percent = (e.offsetX) / (this.offsetWidth);
                    playerAudio.currentTime = percent * playerAudio.duration;
                    currentElementPlaying.value = Math.floor((percent) / 100);
                }
            });

            $(".song-icon-play").click(function(e){
                let thisTag = $(this);
                let newSrc = $(this).attr("data-song-src");
                let currentSrc = $("#global-music-player").attr("src");

                let status = $(this).attr("data-actual-state");

                if(status == "stop"){
                    
                        $("#global-music-player").attr("src", newSrc);
                        if(timer > 0){
                            window.clearTimeout(timer);
                            
                        }
                        playerAudio.addEventListener('canplaythrough', function(e){
                            $("#global-music-player").get(0).play();
                            
                            $(".song-icon-play").attr("data-actual-state", "stop");
                            $(".song-icon-play").children().remove();
                            $(".song-icon-play").append('<i class="fas fa-play"></i>');

                            thisTag.children().remove();
                            thisTag.append('<i class="fas fa-pause"></i>');
                            thisTag.attr("data-actual-state", "play");
                            
                            currentElementPlaying = thisTag;
                            transitionPositionPlayer();
                        });
                        
                    
                        
                    
                }else if(status == "play"){
                    $("#global-music-player").get(0).pause();
                    $(this).children().remove();
                    $(this).append('<i class="fas fa-play"></i>');
                    $(this).attr("data-actual-state", "pause");

                }else if(status == "pause"){
                    $("#global-music-player").get(0).play();
                    $(this).children().remove();
                    $(this).append('<i class="fas fa-pause"></i>');
                    $(this).attr("data-actual-state", "play");

                }
                
            });


            
                

            $("#report-button").click(function(e){
                $("#report-container").css("display","block");
                let dataString = "report";
                $.ajax({
                    type:"POST",
                    url: "http://localhost/montoya/core/ajax/card.php",
                    data: dataString,
                    cache: false,
                    success: function (data){
                        $("#report-modal-container").html(data);
                    },
                    error: function(err){
                        console.log(err)
                    }
                });
            });

            $("#report-container").click(function(e){
                if (e.target == $("#report-container")[0]) {
                    $(this).css("display","none");
                }
            });

            $("#report-button-modal").click(function(e){
                $("#report-container").css("display","none");
            });


            $("#send-tip-container").click(function(e){
                if (e.target == $("#send-tip-container")[0]) {
                    $(this).css("display","none");
                }
            });

            let postIdDonate = null;
            let userIdDonate = null;

            $(".send-tip-button-link").click(function(e){
                $("#send-tip-container").css("display","block");
                let thisTag = $(this).parent()[0];
                postIdDonate = thisTag.getAttribute('data-id-post');
                userIdDonate = thisTag.getAttribute('data-id-user');
            });


            $("#send-tip-button-modal").click(function(e){
                let quantity = parseFloat($("#send-tip-input-modal").val());
                if(quantity){
                    let dataString = 'id_post='+postIdDonate+'&id_user='+userIdDonate+'&donate_quantity='+quantity;
                    $.ajax({
                        type:"POST",
                        url: "http://localhost/montoya/core/ajax/card.php",
                        data: dataString,
                        cache: false,
                        success: function (data){
                            data = data.slice(1,data.length);
                            data = JSON.parse(data);
                            if(data != "error"){
                                $("#current-money").text(data.balance);
                                $("#send-tip-container").css("display","none");
                                $("#send-tip-input-modal").val("0");
                                swal("Donado", "Thanks for your support to artists", "success");
                            }else{
                                swal("Error", "You cannot donate that quantity", "error");
                            }                      
                        },
                        error: function(err){
                            swal("Error", "Try again later", "error");
                        }
                    });
                }else{
                    $("#send-tip-container").css("display","none");
                    swal("Error", "You donation must be more than 0", "error"); 
                }
            });

            
            $(".info-post-button-link").click(function(e){
                $("#info-post-container").css("display","block");
                
                let dataString = 'id_post='+postIdDonate+'&id_username='+userIdDonate;
                $.ajax({
                    type:"POST",
                    url: "http://localhost/montoya/core/ajax/card.php",
                    data: dataString,
                    cache: false,
                    success: function (data){
                        $("#info-modal-container").html(data);
                        console.log(data);
                    },
                    error: function(err){
                    }
                });
            });
            $("#info-post-container").click(function(e){
                if (e.target == $("#info-post-container")[0]) {
                    $(this).css("display","none");
                }
            });
            $("#info-post-button-modal").click(function(e){
                $("#info-post-container").css("display","none");               
            });
            
        });

       
    </script>
</body>
</html>