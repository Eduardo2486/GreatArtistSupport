<?php
require_once 'core/init.php';

if(isset($_POST["submit"])){
    $firstName = $_POST["user_first_name_card"];
    $lastName = $_POST["user_last_name_card"];
    $zipCode = $_POST["user_zip_code_card"];
    $cardNumber = $_POST["user_card_number_card"];
    $expYear = $_POST["user_exp_year_card"];
    $expMoth = $_POST["user_exp_month_card"];
    $secuCode = $_POST["user_secutiry_code_card"];

    $firstName = $getFromC->checkInput($firstName);
    $lastName = $getFromC->checkInput($lastName);
    $zipCode = $getFromC->checkInput($zipCode);
    $cardNumber = $getFromC->checkInput($cardNumber);
    $expYear = $getFromC->checkInput($expYear);
    $expMoth = $getFromC->checkInput($expMoth);
    $secuCode = $getFromC->checkInput($secuCode);


    if($getFromC->checkNumberCard($cardNumber)){
        if( isset($firstName) &&
        isset($lastName) &&
        isset($zipCode) &&
        isset($cardNumber) &&
        isset($expYear) &&
        isset($expMoth) &&
        isset($secuCode) ){
            $id = $getFromC->newCard('card', array('user_id' => $_SESSION["user_id"],
                                            'first_name' => $firstName,
                                            'last_name' => $lastName,
                                            'zip_code'=>$zipCode,
                                            'card_number'=>$cardNumber,
                                            'expiration_year'=>$expYear,
                                            'expiration_month'=>$expMoth,
                                            'security_code'=>$secuCode));

        }
       
    }
}

$cards = $getFromC->getAvailableCards($_SESSION["user_id"]);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Index</title>
    <link rel="stylesheet" href="./assets/css/reset.css">
    <link rel="stylesheet" href="./assets/css/header.css">
    <link rel="stylesheet" href="./assets/css/cards.css">
    <link rel="stylesheet" href="./assets/css/all.min.css">
</head>
<body>
    <?php
        require_once 'header.php';
    ?>

    <main class="main-container">

        <div class="main-user-content">
            <div class="container-user-cards">
                <div class="reload-money">
                    <h2 class="heading-2">Add mobey</h2>
                    <input type="text" id="quantity-deposit" class="deposit-money" placeholder="Deposit">
                    <select name="card-id" id="option-card-id" style="font-size: 1.9em;border: 1px solid #fff;border-radius: 3px"> 
                        <option value=""></option>
                        <?php
                            if(isset($cards)){
                                foreach($cards as $card){
                                    $card_digits = $card->card_number;
                                    $last_digits = substr($card_digits, -4);
                                    echo '<option value="'.$card->id.'">
                                    &middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;
                                    '.$last_digits.'</option>';
                                }
                            }
                        ?>
                    </select>
                    <input type="submit" id="deposit-money" class="save-card money" value="Depositar">
                </div>
                <div class="cards-added">
                    <h2 class="heading-2">Cards</h2>

                    <div class="cards-container">
                        <?php
                            if(isset($cards)){
                                foreach($cards as $card){
                                    $card_digits = $card->card_number;
                                    $last_digits = substr($card_digits, -4);
                                    echo '  
                                    <div class="card-container" data-card-id="'.$card->id.'">
                                        <span class="number-cards">
                                        &middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;
                                        '.$last_digits.'
                                        </span>
                                        <span class="thrash-card"><i class="fas fa-trash-alt"></i></span>
                                    </div>
                                    ';
                                }
                            }
                        ?>
                        

                    </div>

                </div>
                
                <form class="form-new-card" action="card.php" method="POST">
                    <h2 class="heading-2">Add a new card</h2>
                    <div style="font-size: 3em; color: #e4e4e4;    margin-bottom: 15px;">
                            <span><i class="fab fa-cc-mastercard"></i></span> 
                            <span><i class="fab fa-cc-visa"></i></span>
                            <span><i class="fab fa-cc-amex"></i></span> 
                    </div>
                    <div class="container-input-card">
                        
                        <span class="input-card-label">
                            First name:
                        </span>
                        <input type="text" name="user_first_name_card" class="input-card" placeholder="Nombre">
                    </div>
                    <div class="container-input-card">
                    
                        <span class="input-card-label">
                            Las name:
                        </span>
                        <input type="text" name="user_last_name_card" class="input-card" placeholder="Apellido">
                    </div>
                    <div class="container-input-card">
                
                        <span class="input-card-label">
                            CP:
                        </span>
                        <input type="text" name="user_zip_code_card" style="width:90px;" class="input-card" placeholder="Codigo Postal">
                    </div>
                    <div class="container-input-card">
                
                        <span class="input-card-label">
                            Card number:
                        </span>
                        <input type="text" name="user_card_number_card" class="input-card" placeholder="Numero de tarjeta">
                    </div>
                    <div class="container-input-card">
                
                        <span class="input-card-label">
                            expiration year:
                        </span>
                        <input type="text" name="user_exp_year_card" style="width: 100px;" class="input-card" placeholder="Año de expiracion">
                    </div>
                    <div class="container-input-card">
                
                        <span class="input-card-label">
                            expiration month:
                        </span>
                        <input type="text" name="user_exp_month_card" style="width: 50px;" class="input-card" placeholder="Mes de expiracion">
                    </div>
                    <div class="container-input-card">
            
                        <span class="input-card-label">
                            CVV:
                        </span>
                        <input type="text" name="user_secutiry_code_card" style="width: 80px;" class="input-card" placeholder="Codigo de seguridad">
                    </div>
                    <div class="container-input-card" style="display:block;">
                        <input type="submit" class="save-card" name="submit" value="Guardar">
                    </div>
                </form>
            </div>
        </div>
    </main>
    <script src="./assets/js/jquery.js"></script>
    <script src="./assets/js/sweetAlerts.js"></script>
    <script src="./assets/js/cards.js"></script>
    <footer>

    </footer>
   
</body>
</html>