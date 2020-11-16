<?php
    namespace DAO;
    use Models\CreditAccount as CreditAccount;

    class CreditAccountDAO 
    {
        private $connection;
        private $tableName = "creditAccounts";

        public function getById($id)
        {
            $query = "SELECT * FROM " . $this->tableName . " where id=$id";
            try {
                $this->connection = Connection::GetInstance();
                $resultSet = $this->connection->Execute($query);
            } catch (Exception $ex) {
                throw $ex;
            }
            $creditAccount = new CreditAccount($id, $row["company"]);
            return $creditAccount;
        }


        public function getAll()
        {
            $query = "SELECT * FROM " . $this->tableName;
            try {
                $this->connection = Connection::GetInstance();
                $resultSet = $this->connection->Execute($query);
            } catch (Exception $ex) {
                throw $ex;
            }
            $creditAccounts = array();
            foreach ($resultSet as $row) {
                $account = new CreditAccount($row["id"], $row["company"]);
                array_push($creditAccounts, $account);
            }
            return $creditAccounts;
        }
    }
    
?>

