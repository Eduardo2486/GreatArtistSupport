<?php
require_once 'core/init.php';
if(!isset($_SESSION["user_id"])){
    header('location: index.php');
}

$user=$getFromU->userData($_SESSION['user_id']);

$donations= $getFromC->getRecieveDonations( $_SESSION['user_id']);

?>
<header class="header">
        <nav class="nav">
            
            <div class="icon-image-container"><div class="icon-image"><img height="70" src="./assets/images/icon.png"></div></div>

            <form method="GET" action="search.php" class="form-search" >
                <input type="text" placeholder="Search" name="search" class="input-search">
            </form>
            <ul class="menu">
                <li class="menu-list-element"><a href="http://localhost/montoya/home.php" class="menu-list-link">Explore</a></li>
            </ul>
            <ul class="user-menu">
                <li class="menu-list-element"><a href="http://localhost/montoya/new_post.php" class="menu-list-link">
                    <div style="position: absolute;font-size: 33px;top: -12px;left: 10px;">
                        <i class="far fa-file" ></i>
                    </div>
                    <i class="fas fa-plus" style="font-size: 10px;"></i>
                </a></li>
                <li class="menu-list-element" id="user-notification-button"><a href="#" class="menu-list-link"><i class="fas fa-bell"></i></a>
                    <ul class="user-submenu-notifications" style="display:none" id="user-notifications-div">
                        <?php
                        if(isset($donations)){
                            foreach($donations as $donation){
                                $userSender = $getFromU->userData($donation["user_id_from"]);
                                $postInfo = $getFromP->getPostById($donation["post_id"]);
                                echo '<li class="submenu-list-element">
                                <a class="submenu-list-link" href="'.BASE_URL.'"user.php?user='.$userSender->username.'">
                                    <div class="image-notification-container">
                                        <img src="'.BASE_URL.$userSender->profile.'" class="image-notification" alt="">
                                    </div>
                                    <strong>'.$userSender->username.'</strong> Te dono <span style="color:#00e713;"> $'.$donation["deposit"].'</span>
                                     a el post "'.$postInfo->title.'"
                                </a>
                            </li>';
                            }
                        }
                        ?>
                        
                        <!-- <li class="submenu-list-element">
                            <a class="submenu-list-link" href="#">
                                <div class="image-notification-container">
                                    <img src="./images/1.jpg" class="image-notification" alt="">
                                </div>
                                <strong>@JuanJose</strong> gave you $5 dollars
                            </a>
                        </li> -->
                    </ul>
                </li>
                <li class="menu-list-element"><a href="http://localhost/montoya/user.php" class="menu-list-link"><?php echo $user->username;?></a>
                    <ul class="user-submenu">
                        <li class="submenu-list-element"><a class="submenu-list-link" href="http://localhost/montoya/setting.php">Settings</a></li>
                        <li class="submenu-list-element"><a class="submenu-list-link" href="http://localhost/montoya/card.php">Cards</a></li>
                        <li class="submenu-list-element"><a class="submenu-list-link" href="http://localhost/montoya/logout.php">Exit</a></li>
                    </ul>
                </li>
                <li class="menu-list-element money-icon" id="current-money" style="font-family: 'OpenSans'; color:#00e713;padding-left: 15px;"><?php echo $user->balance;?></li>
            </ul>
        </nav>
    </header>
    <style>
        .menu-list-element.money-icon:before{
            content:'$';
        }
    </style>
    
    <script src="./assets/js/jquery.js"></script>
    <script>
        $(document).ready(function(e){
            $("#user-notification-button").click(function(e){
                if($("#user-notifications-div").css("display") == "none"){
                    $("#user-notifications-div").css("display","block");
                }else{
                    $("#user-notifications-div").css("display","none");
                }
            });
        });
            
    </script>