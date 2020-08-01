<?php
require_once 'core/init.php';

if(!isset($_SESSION["user_id"])){
    header('location: index.php');
}

$posts = $getFromP->getUserPosts();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>
    <link rel="stylesheet" href="./assets/css/reset.css">
    <link rel="stylesheet" href="./assets/css/header.css">
    
    <link rel="stylesheet" href="./assets/css/home.css">
    
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
    

    <main class="main-container">
        <div style="display:none">
            <audio id="global-music-player" src=""></audio>
        </div>
        <div class="main-container-centered">
                <?php 

                if(isset($posts)){
                    foreach($posts as $post){
                        
                        $userData = $getFromU->userData($post["user_id"]);
                        if($post["type"] === "audio"){
                            
                            $imageUrl = "";
                            if($post["image"] == " "){
                                $imageUrl = $post["image"];
                            }else{
                                $imageUrl = "assets/public/defaultMusicImage.png" ;
                            }
                            $file_name = explode('/',$post["audio"]);
                            $tip_button = "";
                            if( $userData->id != $_SESSION["user_id"] ) {
                                $tip_button = '<div class="send-tip-button"  data-id-post="'.$post["id"].'" data-id-user="'.$userData->id.'">
                                    <span class="send-tip-button-link"><i class="far fa-money-bill-alt"></i></span>
                                </div>'; 
                            }else{
                                $tip_button = '<div class="info-post-button"  data-id-post="'.$post["id"].'" data-id-user="'.$userData->id.'">
                                    <span class="info-post-button-link"><i class="fas fa-info"></i></span>
                                </div>'; 
                            }
                            echo '<div class="element">
                            <figure class="image-element-container">
                                <div class="image-element">
                                    <img src="'.$imageUrl .'" alt="">
                                   
                                </div>
                                <div class="music-player-container">
                                    <span class="song-icon-play" data-actual-state="stop" data-song-src="'.$post["audio"].'"><i class="fas fa-play"></i></span>
                                    <div class="song-play-back-container">
                                        <div class="song-duration-bar">
                                        </div>
                                        <span class="song-position-icon"></span>
                                    </div>
                                </div>
                                <div class="author-container">
                                   
                                    <div class="image-author-container">
                                        <div class="image-author-size">
                                            <a href="'.BASE_URL."user.php?user=".$userData->username.'"> 
                                                <img src="'.$userData->profile.'" class="author-image" alt="">
                                            </a> 
                                        </div>
                                    </div>
                                    <div class="author-name-container">
                                        <a href="'.BASE_URL."user.php?user=".$userData->username.'" class="author-name">'.$userData->username.'</a>
                                    </div>
                                    <div class="download-button">
                                        <a href="'.BASE_URL.'download.php?file='.$file_name[2].'" class="download-button-link"><i class="fas fa-arrow-down"></i></a>
                                    </div>
                                    '.$tip_button.'
                                </div>
                                
                            </figure>
                        </div>';
                        }else if($post["type"] === "video"){
                            $file_name = explode('/',$post["video"]);
                            $tip_button = "";
                            if( $userData->id != $_SESSION["user_id"] ) {
                                $tip_button = '<div class="send-tip-button"  data-id-post="'.$post["id"].'" data-id-user="'.$userData->id.'">
                                    <span class="send-tip-button-link"><i class="far fa-money-bill-alt"></i></span>
                                </div>'; 
                            }else{
                                $tip_button = '<div class="info-post-button"  data-id-post="'.$post["id"].'" data-id-user="'.$userData->id.'">
                                    <span class="info-post-button-link"><i class="fas fa-info"></i></span>
                                </div>'; 
                            }
                            echo '<div class="element">
                            <figure class="image-element-container">
                                <div class="image-element">
                                    <video class="video-element" controls src="'.$post["video"].'"></video>
                                   
                                </div>
                                
                                <div class="author-container video">
                                   
                                    <div class="image-author-container">
                                        <div class="image-author-size">
                                            <a href="'.BASE_URL."user.php?user=".$userData->username.'"> 
                                                <img src="'.$userData->profile.'" class="author-image" alt="">
                                            </a> 
                                        </div>
                                    </div>
                                    <div class="author-name-container">
                                        <a href="'.BASE_URL."user.php?user=".$userData->username.'" class="author-name">'.$userData->username.'</a>
                                    </div>
                                    <div class="download-button">
                                        <a href="'.BASE_URL.'download.php?file='.$file_name[2].'" class="download-button-link"><i class="fas fa-arrow-down"></i></a>
                                    </div>
                                    '.$tip_button.'
                                </div>
                                
                            </figure>
                        </div>';
                        }else if($post["type"] === "image"){
                            $file_name = explode('/',$post["image"]);
                            $tip_button = "";
                            if( $userData->id != $_SESSION["user_id"] ) {
                                $tip_button = '<div class="send-tip-button"  data-id-post="'.$post["id"].'" data-id-user="'.$userData->id.'">
                                    <span class="send-tip-button-link"><i class="far fa-money-bill-alt"></i></span>
                                </div>'; 
                            }else{
                                $tip_button = '<div class="info-post-button"  data-id-post="'.$post["id"].'" data-id-user="'.$userData->id.'">
                                    <span class="info-post-button-link"><i class="fas fa-info"></i></span>
                                </div>'; 
                            }
                            echo '<div class="element">
                            <figure class="image-element-container">
                                <div class="image-element">
                                    <img src="'.$post["image"].'" alt="">
                                </div>
                                <div class="author-container">
                                    <div class="image-author-container">
                                        <div class="image-author-size">
                                            <a href="'.BASE_URL."user.php?user=".$userData->username.'"> 
                                                <img src="'.$userData->profile.'" class="author-image" alt="">
                                            </a> 
                                        </div>
                                    </div>
                                    <div class="author-name-container">
                                        <a href="'.BASE_URL."user.php?user=".$userData->username.'" class="author-name">'.$userData->username.'</a>
                                    </div>
                                    <div class="download-button">
                                        <a href="'.BASE_URL.'download.php?file='.$file_name[2].'" class="download-button-link"><i class="fas fa-arrow-down"></i></a>
                                    </div>
                                    '.$tip_button.'
                                </div>
                            </figure>
                        </div>';
                        }else if($post["type"] === "text"){
                            $tip_button = "";
                            if( $userData->id != $_SESSION["user_id"] ) {
                                $tip_button = '<div class="send-tip-button"  data-id-post="'.$post["id"].'" data-id-user="'.$userData->id.'">
                                    <span class="send-tip-button-link"><i class="far fa-money-bill-alt"></i></span>
                                </div>'; 
                            }else{
                                $tip_button = '<div class="info-post-button"  data-id-post="'.$post["id"].'" data-id-user="'.$userData->id.'">
                                    <span class="info-post-button-link"><i class="fas fa-info"></i></span>
                                </div>'; 
                            }
                            echo '<div class="element">
                            <figure class="image-element-container">
                                <div class="image-element">
                                    <span class="text-element">'.$post["content"].'</span>
                                </div>
                                
                                <div class="author-container">
                                   
                                    <div class="image-author-container">
                                        <div class="image-author-size">
                                            <a href="'.BASE_URL."user.php?user=".$userData->username.'"> 
                                                <img src="'.$userData->profile.'" class="author-image" alt="">
                                            </a> 
                                        </div>
                                    </div>
                                    <div class="author-name-container">
                                        <a href="'.BASE_URL."user.php?user=".$userData->username.'" class="author-name">'.$userData->username.'</a>
                                    </div>
                                    '.$tip_button.'
                                </div>
                            </figure>
                        </div>';
                        }
                        
                    }
                }
                ?>
        </div>
    </main>
    <footer>

    </footer>
    <script src="./assets/js/jquery.js"></script>
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
                let thisTag =  $(this);
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


           
            
            let postIdDonate = null;
            let userIdDonate = null;

            $(".send-tip-button-link").click(function(e){
                $("#send-tip-container").css("display","block");
                let thisTag = $(this).parent()[0];
                postIdDonate = thisTag.getAttribute('data-id-post');
                userIdDonate = thisTag.getAttribute('data-id-user');
            });

            $(".info-post-button-link").click(function(e){
                $("#info-post-container").css("display","block");
                let thisTag = $(this).parent()[0];
                postIdDonate = thisTag.getAttribute('data-id-post');
                userIdDonate = thisTag.getAttribute('data-id-user');
                let dataString = 'id_post='+postIdDonate+'&id_username='+userIdDonate;
                console.log(dataString);
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
                
            $("#send-tip-container").click(function(e){
                if (e.target == $("#send-tip-container")[0]) {
                    $(this).css("display","none");
                }
            });

            $("#info-post-container").click(function(e){
                if (e.target == $("#info-post-container")[0]) {
                    $(this).css("display","none");
                }
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
                            if(data != "error"){
                                $("#current-money").text(data);
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

            $("#info-post-button-modal").click(function(e){
                $("#info-post-container").css("display","none");               
            });


            
        });

       
    </script>
</body>
</html>