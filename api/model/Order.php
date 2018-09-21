<?php
namespace App\model;

class Order extends Model
{

    public function __construct(){
        parent::__construct();
    }

    public function create($distance){
        $status = 0;
        $stmt = parent::get_conn()->prepare('INSERT INTO order_details (id,distance,status) VALUES (null,:distance,'.$status.')');
        $stmt->bindParam(':distance', $distance, \PDO::PARAM_STR);
        if($stmt->execute()){
            return ['id'=>parent::get_conn()->lastInsertId(),'distance' => $distance, 'status' => 'UNASSIGN'];
        }
        return ['error'=>'ERROR_WHILE_CREATING_ORDER'];
        
    }

    public function update($id){
        if(!is_numeric($id)){
            return ['error'=>'ERROR_WHILE_TAKING_ORDER'];
        }
        $stmt = parent::get_conn()->prepare('SELECT * FROM order_details WHERE id=?');
        $stmt->execute([$id]);
        $record = $stmt->fetch(\PDO::FETCH_ASSOC);
        if(empty($record)){
            return ['error'=>'ORDER_DOES_NOT_EXIST'];
        }
        if($record['status'] == 1){
            return ['error'=>'ORDER_ALREADY_BEEN_TAKEN'];
        }
        
        $stmt = parent::get_conn()->prepare('UPDATE order_details SET status = 1 WHERE id=:id');
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        if($stmt->execute()){
            return ['status'=>'SUCCESS'];
        }
        return ['error'=>'ERROR_WHILE_TAKING_ORDER'];
    }

    public function count(){
        $stmt = parent::get_conn()->prepare('SELECT COUNT(id) FROM order_details');
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function get($offset,$limit){
        $stmt = parent::get_conn()->prepare('SELECT id,distance,CASE WHEN status = 0 THEN "UNASSIGN" WHEN status=1 THEN "TAKEN" END status FROM order_details LIMIT :offset,:limit');
        $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
        if($stmt->execute()){
            $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $data;
        }
        else{
            return ['error'=>'ERROR_WHILE_FETCHING_ORDER'];
        }
        
    }
    
}
