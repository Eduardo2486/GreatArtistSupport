<?php
class User{
    protected $pdo;

	function __construct($pdo){
		$this->pdo = $pdo;
    }
    
    public function login($email, $password){
			$hash = hash('sha512', $password);
        $stmt = $this->pdo->prepare("SELECT id FROM user WHERE email = :email AND password = :password");
			$stmt->bindParam(":email",$email,PDO::PARAM_STR);
			$stmt->bindParam(":password",$hash,PDO::PARAM_STR);
			$stmt->execute();

			$user = $stmt->fetch(PDO::FETCH_OBJ);

			$count = $stmt->rowCount();

			if($count > 0){
				$_SESSION['user_id'] = $user->user_id;
				header("Location: home.php");
			}else{
				return false;
			}
    }

	public function userData($user_id){
	
		$stmt = $this->pdo->prepare("SELECT * FROM user WHERE id = :user_id");
		$stmt->bindParam(':user_id',$user_id,PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_OBJ);
	}

	public function getUserNumberPost($user_id){
		$stmt = $this->pdo->prepare("SELECT * FROM post WHERE id = :user_id");
		$stmt->bindParam(':user_id',$user_id,PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->rowCount();
	}

	public function userDatabyUsername($username){
		$stmt = $this->pdo->prepare("SELECT * FROM user WHERE username = :username");
		$stmt->bindParam(':username',$username,PDO::PARAM_STR);
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_OBJ);
	}

    
    public function checkEmail($email){
			$stmt= $this->pdo->prepare("SELECT email FROM user WHERE email = :email");
			$stmt->bindParam(":email",$email,PDO::PARAM_STR);
			$stmt->execute();
			$count=$stmt->rowCount();

			if($count > 0){
				return true;
			}else{
				return false;
			}
    }
    
    public function checkUsername($username){
		$stmt= $this->pdo->prepare("SELECT username FROM user WHERE username = :username");
		$stmt->bindParam(":username",$username,PDO::PARAM_STR);
		$stmt->execute();
		$count=$stmt->rowCount();

		if($count > 0){
			return true;
		}else{
			return false;
		}
    }
    
    public function create($table,$fields=array()){
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

    public function logout(){
		$_SESSION = array();
		session_destroy();
		header('Location: '.BASE_URL.'./index.php');
    }
    
    public function loggedin(){
		return (isset($_SESSION['user_id'])) ? true : false;
	}

    public function checkInput($var){
		$var = htmlspecialchars($var);
		$var = trim($var);
		$var = stripcslashes($var);
		return $var;
	}

	public function updateUserInfo($user_id,$email, $about, $location, $imageProfile, $imageCover){
		$stmt= $this->pdo->prepare("UPDATE user 
		SET email= :email, 
			about= :about, 
			location= :location, 
			cover= :cover, 
			profile= :profile 
		WHERE id = :user_id");
		
		$stmt->bindParam(":email",$email,PDO::PARAM_STR);
		$stmt->bindParam(":about",$about,PDO::PARAM_STR);
		$stmt->bindParam(":location",$location,PDO::PARAM_STR);
		$stmt->bindParam(":cover",$imageCover,PDO::PARAM_STR);
		$stmt->bindParam(":profile",$imageProfile,PDO::PARAM_STR);
		$stmt->bindParam(":user_id",$user_id,PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->rowCount();
	}
}
?>