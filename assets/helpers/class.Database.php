<?php
/**
 * User: Rinkana
 * Date: 31-8-13
 * Time: 13:05
 * @Author: Max Berends
 */
class Database {
    private static $instance;

    private $oConnection; //Private connection string, will be used for PDO

    public function __construct($connection) {
        //When the class is loaded we check if the config is already loaded.
        //We check again

        if($connection && $connection instanceof PDO){
            $this->oConnection = $connection;
        }else{

            throw new Exception("Not all database connection settings are set");
        }
    }
    final protected function RunQuery($sQuery, $aValues = array()){
        //NOTE:PDO escapes everything. This means you can not use it to replace table names and select columns

        //Default way to run a query
        $oPreparedQuery = $this->oConnection->prepare($sQuery); //Prepare the query
        $oPreparedQuery->execute($aValues);//Run the query
        if($oPreparedQuery->errorCode() == 0){ //Was there an error while doing the query
            return ($oPreparedQuery); //No? Return the requested data
        }else{
            $aPDOError = $oPreparedQuery->errorInfo();
            throw new Exception($aPDOError[2],$aPDOError[1]); //Yes? Throw exception
        }

    }
    public function FetchArray($sQuery, $aValues = array()){
        $oFinishedQuery = $this->RunQuery($sQuery,$aValues); //Run the query
        $aResult = $oFinishedQuery->fetchAll(PDO::FETCH_ASSOC); //Get all results. Default PDO returns the data twice, one with the col names and one with a numeric index. We only want the colnames
        return $aResult; //Return result
    }
    public function FetchSingleArray($sQuery, $aValues = array()){
        $oFinishedQuery = $this->RunQuery($sQuery,$aValues);//Run the query
        $aResult = $oFinishedQuery->fetch(PDO::FETCH_ASSOC);//Get single row. Default PDO returns the data twice, one with the col names and one with a numeric index. We only want the colnames
        return $aResult;//Return result
    }
    public function FetchSingle($sQuery, $aValues = array(), $iColumn = 0){
        $oFinishedQuery = $this->RunQuery($sQuery,$aValues); //Run the query
        $sResult = $oFinishedQuery->fetchColumn($iColumn); //Get the single column. $iColumn can be used to select another column
        return $sResult;//Return result
    }
    public function Insert($sQuery, $aValues = array()){
        //PDO uses a more safer method of inserting rows.
        //First we need an query like: "INSERT INTO tblPages VALUES(NULL,:Title,:Text,:Active)";
        //Then we need an array where all data is defined like: array(":Title" => "Title", ":Text" => "Some random text",":Active" => 1)
        $oPreparedQuery = $this->oConnection->prepare($sQuery);//Prepare the query
        $oPreparedQuery->execute($aValues);//Run the query and send the data with it
        if($oPreparedQuery->errorCode() == 0){ //Was there an error?
            return $this->oConnection->lastInsertId(); //No? return te inserted id
        }else{
            $aPDOError = $oPreparedQuery->errorInfo();
            throw new Exception($aPDOError[2],$aPDOError[1]); //Yes? Throw exception
        }
    }
    public function Delete($sQuery, $aValues = array()){
        //Delete query
        $oPreparedQuery = $this->oConnection->prepare($sQuery);
        $oPreparedQuery->execute($aValues);
        if(is_numeric($oPreparedQuery->rowCount())){//is the data numeric?
            return $oPreparedQuery->rowCount(); //return the deleted row count
        }else{
            $aPDOError = $oPreparedQuery->errorInfo();
            throw new Exception($aPDOError[2],$aPDOError[1]); //Yes? Throw exception
        }

    }
    public function Update($sQuery,$aValues = array()){
        //PDO uses a more safer method of updating rows.
        //First we need an query like: "INSERT INTO tblPages VALUES(NULL,:Title,:Text,:Active)";
        //Then we need an array where all data is defined like: array(":Title" => "Title", ":Text" => "Some random text",":Active" => 1)
        $oPreparedQuery = $this->oConnection->prepare($sQuery);//Prepare the query
        $oPreparedQuery->execute($aValues);//Run the query and send the data with it
        if($oPreparedQuery->errorCode() == 0){ //Was there an error?
            return true; //No? return te inserted id
        }else{
            $aPDOError = $oPreparedQuery->errorInfo();
            throw new Exception($aPDOError[2],$aPDOError[1]); //Yes? Throw exception
        }
    }

    public static function GetInstance($connection = null){
        //get connection
        if(empty(self::$instance) && !is_null($connection)){
            //connection is not set but we can try to connect
            self::$instance = new Database($connection);
            return self::$instance;
        }elseif(!empty(self::$instance) && is_null($connection)){
            //We already have an instance so set that
            return self::$instance;
        }else{
            throw new Exception("Unable to connect");
        }


    }

}
?>