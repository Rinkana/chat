<?php
/**
 * User: Max Berends
 * Date: 15-11-2014
 * Time: 12:03
 * For:  chat
 */

class Post {
    private $id;
    private $poster;
    private $text;
    private $date;

    public function __construct($id = null){

        if(!is_null($id) && is_numeric($id)){
            //Load post
            $this->id = $id;
            return $this->load();
        }
        return false;

    }

    private function load(){
        if(!is_null($this->id) && $this->id > 0){
            $db = Database::GetInstance();

            if($db instanceof Database){

                $SQL = "SELECT * FROM tblPosts WHERE ID = :ID";
                $aValues = array($this->id);

                $postData = $db->FetchArray($SQL,$aValues);
                if($postData && is_array($postData) && count($postData) > 0){
                    $this->poster = $postData[0]["poster"];
                    $this->text = $postData[0]["text"];
                    $this->date = $postData[0]["date"];
                }else{
                    return false;
                }
            }
        }
    }

    public function getID(){
        return $this->id;
    }

    public function getPoster(){
        return $this->poster;
    }

    public function setPoster($value){
    $this->poster = $value;
}

    public function getText(){
        return $this->text;
    }

    public function setText($value){
        $this->text = $value;
    }

    public function getDate(){
        return $this->date;
    }

    public function setDate($value){
        $this->date = $value;
    }

    public function insert(){
        if(is_null($this->id)){
            $db = Database::GetInstance();
            if($db instanceof Database){
                $SQL = "
                INSERT INTO
                  tblPosts
                VALUES(
                  null,
                  :poster,
                  :text,
                  :date
                )";

                $values = array(
                    $this->getPoster(),
                    $this->getText(),
                    $this->getDate()
                );

                return $db->Insert($SQL,$values);
            }
        }
        return false;
    }

    public static function loadFromID($id = 0, $limit = null){
        $db = Database::GetInstance();

        if($db instanceof Database){

            //Database connection set
            $SQL = "SELECT ID FROM tblPosts";
            $aValues = array();
            if(is_numeric($id) && $id > 0){
                $SQL .= " WHERE ID > :ID";
                $aValues[] = $id;
            }

            if(!is_null($limit) && is_numeric($limit)){
                $SQL .= " LIMIT ".$limit;
            }

            $posts = $db->FetchArray($SQL,$aValues);

            $result = array();

            if($posts && is_array($posts)){
                foreach($posts as $post){
                    $result[] = new Post($post["ID"]);
                }
            }

            return $result;

        }

        return false;
    }
} 