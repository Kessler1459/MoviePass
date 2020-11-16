<?php 
    namespace DAO;

    use Models\Purchase as Purchase;
    use \Exception as Exception;

    class PurchaseDAO
    {
        private $connection;
        private $tableName;

        public function __construct() {
            $this->tableName = "purchases";
        }

        public function add($quantity_tikets,$discount,$date,$total){
            
            $query = "INSERT INTO $this->tableName (quantity_tikets,discount,purchase_date,total) 
                        VALUES (:quantity_tikets,:discount,:purchase_date,:total)";
            $parameters["quantity_tikets"] = $quantity_tikets;
            $parameters["discount"] = $discount;
            $parameters["purchase_date"] = $date;
            $parameters["total"] = $total;

            try
            {
                $this->connection = Connection::getInstance();
                $this->connection->executeNonQuery($query, $parameters);
            }
            catch(Exception $ex)
            {
                throw $ex;
            }
        }
        

        public function getById($id_purchase){
            
            $query="SELECT * from $this->tableName where id_purchase=$id_purchase";
            
            try
            {    
                $this->connection=Connection::getInstance();
                $results=$this->connection->execute($query);

            }catch(Exception $ex){
                throw $ex;
            }
            
                if(!empty($results)){
                    $row=$results[0];

                    $purchase = new Purchase($row["id_purchase"],$row["quantity_tickets"],$row["discount"],$row["purchase_date"],$row["total"]);
                    
                    return $purchase;
                }
                else{
                    return null;
                }
                
        }

    
?>

