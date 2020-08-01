<?php
    include '../init.php';
    
    if(isset($_POST["idCard"])){
        $int = (int)$_POST["idCard"];
        $result = $getFromC->deleteCard($int);
    }

    if(isset($_POST["id_card"]) && isset($_POST["quantity"])){
        $idCard = $_POST["id_card"];
        $quantity = $_POST["quantity"];
        $user_id = $_SESSION["user_id"];
        $getFromC->depositMoney($idCard, $quantity, $user_id);
    }

    if(isset($_POST["id_post"]) && isset($_POST["id_user"]) && isset($_POST["donate_quantity"])){
        $post_id = $_POST["id_post"];
        $user_id_to = $_POST["id_user"];
        $quantity = $_POST["donate_quantity"];
        $user_id_from = $_SESSION["user_id"];
        echo $user_id_to;
        $userBalance = $getFromC->getBalance($_SESSION["user_id"]);
        
        if($quantity <=  $userBalance->balance){
            $getFromC->donateMoney($post_id, $user_id_to, $quantity, $user_id_from);
            $userNewBalance = $getFromC->getBalance($_SESSION["user_id"]);
        
            echo json_encode($userNewBalance);
        }else{
            echo 'error';
        }       
    }

    if(isset($_POST["id_post"]) && isset($_POST["id_username"])){
        $post_id = $_POST["id_post"];
        $user_id_to = $_POST["id_username"];

        $post = $getFromP->getPostById($post_id);
        $donations = $getFromC->getDonationsByPostId($post_id);
        $datePost = new DateTime($post->posted_date);
        $donationRows = "<span class='info-post-span'>Titulo del post: ".$post->title."</span><span class='info-post-span'>Dinero generado: $".$post->balance."</span><span class='info-post-span'>Fecha de posteo: ".$datePost->format('d-m-Y')."</span><span>Donaciones:</span>";
        $donationRows.="<table id='table-info-content'><tr><th>Nombre de usuario</th><th>Donacion</th><th>Fecha de donacion</th></tr>";
        foreach($donations as $donation){
            $userSender = $getFromU->userData($donation["user_id_from"]);
            $dateDonation = new DateTime($donation["donation_date"]);
            $donationRows .="<tr><td><a href=".BASE_URL."user.php?user=".$userSender->username.">".$userSender->username."</td> </a>"."<td>".$donation["deposit"]."</td>"."<td>".$dateDonation->format('d-m-Y')."</td></tr>";
        }
        $donationRows.="</table>";
        echo $donationRows;
    }

    if(isset($_POST["report"])){

        $posts = $getFromP->getAllUserFromPosts($_SESSION["user_id"]);

        $postRows = "<table id='table-info-content'><tr><th>Post</th><th>tipo</th><th>Donacion</th><th>Fecha de donacion</th></tr>";
        foreach($posts as $post){
            $datePost = new DateTime($post["posted_date"]);
            $postRows .= "<tr><td>".$post["title"]."</td> </a>"."<td>".$post["type"]."</td><td>".$post["balance"]."</td><td>".$datePost->format('d-m-Y')."</td></tr>";
        }

        echo $postRows;
    }

?>