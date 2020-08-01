<?php
class Card{
    protected $pdo;

    function __construct($pdo){
		$this->pdo = $pdo;
    }

    public function newCard($table,$fields=array()){
        $columns = implode(',',array_keys($fields));
		$values=':'.implode(', :',array_keys($fields));
		$sql = "INSERT INTO {$table} ({$columns}) VALUES ({$values})";
		if($stmt = $this->pdo->prepare($sql)){
			foreach ($fields as $key => $data) {
				$stmt->bindValue(':'.$key,$data);
			}
			$stmt->execute();
			return $this->pdo->lastInsertId();
		}
    }

    public function checkInput($var){
		$var = htmlspecialchars($var);
		$var = trim($var);
		$var = stripcslashes($var);
		return $var;
    }
    public function checkNumberCard($card){
        $stmt= $this->pdo->prepare("SELECT card_number FROM card WHERE card_number = :card");
		$stmt->bindParam(":card",$card,PDO::PARAM_STR);
		$stmt->execute();
		$count=$stmt->rowCount();

		if($count > 0){
			return false;
		}else{
			return true;
		}
    }

    public function getAvailableCards($user_id){
        $stmt= $this->pdo->prepare("SELECT card_number, id, user_id FROM card WHERE user_id = :user_id");
		$stmt->bindParam(":user_id",$user_id,PDO::PARAM_INT);
		$stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function deleteCard($id_card){
        $stmt= $this->pdo->prepare("DELETE FROM card WHERE id = :id_card ");
		$stmt->bindParam(":id_card",$id_card,PDO::PARAM_INT);
		$stmt->execute();
	}
	
	public function depositMoney($idCard, $quantity, $user_id){
		$stmt= $this->pdo->prepare("INSERT INTO deposit (user_id, id, balance) VALUES (:user_id, :card_id, :balance)");
		$stmt->bindParam(":user_id",$user_id,PDO::PARAM_INT);
		$stmt->bindParam(":card_id",$idCard,PDO::PARAM_INT);
		$stmt->bindParam(":balance",$quantity,PDO::PARAM_STR);
		$stmt->execute();

		$stmt= $this->pdo->prepare("UPDATE user SET balance= balance + :balance WHERE id = :user_id");
		$stmt->bindParam(":user_id",$user_id,PDO::PARAM_INT);
		$stmt->bindParam(":balance",$quantity,PDO::PARAM_STR);
		$stmt->execute();
	}

	public function donateMoney($post_id, $user_id_to, $quantity, $user_id_from){
		$stmt= $this->pdo->prepare("INSERT INTO donation (user_id_from, user_id_to, post_id, deposit, donation_date) VALUES (:user_id_from, :user_id_to, :post_id, :deposit, :donation_date)");
		$stmt->bindParam(":user_id_from",$user_id_from,PDO::PARAM_INT);
		$stmt->bindParam(":user_id_to",$user_id_to,PDO::PARAM_INT);
		$stmt->bindParam(":post_id",$post_id,PDO::PARAM_INT);
		$stmt->bindParam(":deposit",$quantity,PDO::PARAM_STR);
		$newDateTime  =  new DateTime();
		$date =$newDateTime->format('Y-m-d H:i:s');
		$stmt->bindParam(":donation_date",$date,PDO::PARAM_STR);
		$stmt->execute();

		$stmt= $this->pdo->prepare("UPDATE user SET balance= balance - :balance WHERE id = :user_id");
		$stmt->bindParam(":user_id",$user_id_from,PDO::PARAM_INT);
		$stmt->bindParam(":balance",$quantity,PDO::PARAM_STR);
		$stmt->execute();

		$stmt= $this->pdo->prepare("UPDATE user SET balance= balance + :balance WHERE id = :user_id");
		$stmt->bindParam(":user_id",$user_id_to,PDO::PARAM_INT);
		$stmt->bindParam(":balance",$quantity,PDO::PARAM_STR);
		$stmt->execute();

		$stmt= $this->pdo->prepare("UPDATE post SET balance= balance + :balance WHERE id = :post_id");
		$stmt->bindParam(":post_id",$post_id,PDO::PARAM_INT);
		$stmt->bindParam(":balance",$quantity,PDO::PARAM_STR);
		$stmt->execute();
	}

	public function getBalance($user_id){
		$stmt= $this->pdo->prepare("SELECT balance FROM user WHERE id = :user_id");
		$stmt->bindParam(":user_id",$user_id,PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_OBJ);
	}

	public function getRecieveDonations($user_id){
		$stmt= $this->pdo->prepare("SELECT * FROM donation WHERE user_id_to = :user_id");
		$stmt->bindParam(":user_id",$user_id,PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
	public function getDonationsByPostId($post_id){
        $stmt = $this->pdo->prepare("SELECT * FROM donation WHERE post_id = :post_id ORDER BY id DESC");
        $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>