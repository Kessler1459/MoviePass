<?php 
    namespace DAO;

    use Models\User as User;
    use Models\UserProfile as UserProfile;
    use Models\UserRole as UserRole;

    class UserDAO
    {
        private $connection;
        private $tableName = "users";

        public function __construct() {
            
        }

        public function add($user){
            try
            {
                $query = "INSERT INTO $this->tableName (id_user,email,pass,first_name,last_name,dni,user_type,role_description,id_cinema) 
                            VALUES (:id_user,:email,:pass,:first_name,:last_name,:dni,:user_type,:role_description,:id_cinema)";
                $parameters["id_user"] = $user->getId();
                $parameters["email"] = $user->getEmail();
                $parameters["pass"] = $user->getPassword();
                $parameters["first_name"] = $user->userProfile->getFirstName();
                $parameters["last_name"] = $user->userProfile->getLastName();
                $parameters["dni"] = $user->userProfile->getDni();
                $parameters["user_type"] = $user->userRole->getUserType();
                $parameters["role_description"] = $user->userRole->getDescription();
                $parameters["id_cinema"] = $user->getCinemaId();
                $this->connection = Connection::getInstance();
                $this->connection->executeNonQuery($query, $parameters);
            }
            catch(Exception $ex)
            {
                throw $ex;
            }
        }


        public function getById($id_user){
            try{
                $query="SELECT * from $this->tableName where id_user=$id_user";
                $this->connection=Connection::getInstance();
                $results=$this->connection->execute($query);
                if(!empty($results)){
                    $row=$results[0];

                    $userRole = new UserRole($row["user_type"],$row["role_description"]);
                    $userProfile = new UserProfile($row["first_name"],$row["last_name"],$row["dni"]);
                    $user = new User($row["id_user"],$row["email"],$row["pass"],$userProfile,$userRole,$row["id_cinema"]);
                    
                    return $user;
                }
                else{
                    return false;
                }
                
            }catch(Exception $ex){
                throw $ex;
            }
        }


        public function findUser($email,$password){
            try{
                $query="SELECT * from $this->tableName where email=$email AND pass=$password";
                $this->connection=Connection::getInstance();
                $results=$this->connection->execute($query);
                if(!empty($results)){
                    $row=$results[0];

                    $userRole = new UserRole($row["user_type"],$row["role_description"]);
                    $userProfile = new UserProfile($row["first_name"],$row["last_name"],$row["dni"]);
                    $user = new User($row["id_user"],$row["email"],$row["pass"],$userProfile,$userRole,$row["id_cinema"]);
                    
                    return $user;
                }
                else{
                    return false;
                }
                
            }catch(Exception $ex){
                throw $ex;
            }
        }


        public function findEmail($email){
            try{
                $query="SELECT * from $this->tableName where email=$email";
                $this->connection=Connection::getInstance();
                $results=$this->connection->execute($query);
                if(!empty($results)){
                    
                    return true;
                }
                else{
                    return false;
                }
                
            }catch(Exception $ex){
                throw $ex;
            }
        }
    
    }
    
?>