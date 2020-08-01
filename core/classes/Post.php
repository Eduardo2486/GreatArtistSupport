<?php
class Post{
    protected $pdo;

	function __construct($pdo){
		$this->pdo = $pdo;
    }

    public function getUserPostsById($id){
        $stmt = $this->pdo->prepare("SELECT * FROM post WHERE user_id = :user_id ORDER BY id DESC");
        $stmt->bindParam(':user_id',$id,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getUserPosts(){
        $stmt = $this->pdo->prepare("SELECT * FROM post ORDER BY id DESC");
        $stmt->bindParam(':user_id',$id,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function newPost($table,$fields=array()){
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

    public function searchPosts($search){
        $stmt = $this->pdo->prepare("SELECT * FROM post WHERE title LIKE '%$search%' OR content LIKE '%$search%' OR type LIKE '%$search%' ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPostById($post_id){
        $stmt = $this->pdo->prepare("SELECT * FROM post WHERE id = :post_id");
        $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function getAllUserFromPosts($user_id){
        $stmt = $this->pdo->prepare("SELECT * FROM post WHERE user_id = :user_id ORDER BY id DESC");
        $stmt->bindParam(':user_id',$user_id,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
?>