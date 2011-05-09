<?php
if(!defined('__nexus')){
    header("HTTP/1.0 404 not found");
    $redirect = new reroute();
    $redirect->route('error', '404');
}
class feed extends nexus_core{
    protected $feed = array(),
    $query = array(
        'level' => 10,
        'taxonomies' => array(),
        'fields' => array(),
        'types' => array(),
        'joins' => array(),
        'orderby' => array()
    );
    public function __construct(){
        try{ parent::__construct(); }catch(Exception $e){
            $redirect = new reroute();
            $redirect->route('error', 'database');
        }
    }
    public function level($level){
        //specify the permissions thats all post in the feed should be <=
        if($level >= 0 && $level <= 10){
            $this->query['level'] = $level;
        }
        return $this;
    }
    public function tax($name, $value){
        $this->query['taxonomies'][count($this->query['taxonomies'])] = $value;
        return $this;
    }
    public function has_value($table, $field, $value){
        /* require the post to have a value for a particular field in the database 
         * such a the author_id to match a particular author
         * this function takes three parameters $table, $field, $value
        */
        $this->query['fields'][count($this->query['fields'])] = array($table, $field, $value);
        return $this;
    }
    public function type($type){
        /* will get posts of only of the type specified this can be an array or individual values */
        $this->query['types'][count($this->query['types'])] = $type;
        return $this;
    }
    public function add_join($table, $condition){
        /* This function allows the user to add a table to the sql
         * via a JOIN where -> JOIN $table ON $condition
        */
        $this->query['joins'][count($this->query['joins'])] = array($table, $condition);
        return $this;
    }
    public function execute(){
        /* will build and execute the query */
    }
    public function each($function, $params = null){
        /* will iterate through the values one at a time */
        if(is_callable($function)){
            foreach($this->feed as $value){
                $function($value, $params);
            }
        }else{
            return false;
        }
    }
    public function get_feed_objects(){
        return $this->feed;
    }
    public function get_feed($name){
        @include_once "$name.feed.php";
        if(class_exists("{$name}_feed")){
            $isview = $this->view instanceof view? false : true;
            $class = "{$name}_feed";
            return new $class($isview, $this->query);
        }else{
            return false;
        }
    }
    public function build(){
        $dbprefix = DBPREFIX;
        $sql = '';
        foreach($this->query['joins'] as $join){
            $sql .= " JOIN {$join[0]} ON {$join[1]}";
        }
        $sql .= " WHERE";
        //add type
        $type = "";
        if(count($this->query['types']) > 0){
            foreach($this->query['types'] as $key => $value){
                if(!filter_var($value, FILTER_VALIDATE_INT)){
                    $this->db->prepare("SELECT {$dbprefix}content_type.type FROM {$dbprefix}content_type WHERE `desc`=?");
                    echo $this->db->get_error_message();
                    $this->db->sql->bind_param('s', $value);
                    $this->db->sql->bind_result($value);
                    $this->db->query();
                }
                if($key != 0){
                    $type .= " OR {$dbprefix}content.type = $value";
                }else{
                    $type .= " ({$dbprefix}content.type = $value";
                }
                $type .= ")";
            }
        }
        $sql .=  $type;
        // If there was a type statment add a AND to the sql
        if(!empty($type)) $sql .= " AND";
        // add tax
        $tax = "";
        
        // if tax wasn't empty add add and statment
        if(!empty($tax)) $sql .= " AND";
        //level
        if(filter_var($this->query['level'], FILTER_VALIDATE_INT)
        && $this->query['level'] >= 0
        && $this->query['level'] <= 10){
            $sql .= " {$dbprefix}content.permissions <= {$this->query['level']}";
        }else{
            $sql .= " {$dbprefix}content.permissions <= 10";
        }
        // table values
        $fields = "";
        foreach($this->query['fields'] as $field){
            if(filter_var($field[2], FILTER_VALIDATE_INT)
            || filter_var($field[2], FILTER_VALIDATE_FLOAT)
            || filter_var($field[2], FILTER_VALIDATE_BOOLEAN)){
                $fields .= " AND {$dbprefix}{$field[0]}.{$field[1]} = {$field[2]}";
            }else{
                $fields .= " AND {$dbprefix}{$field[0]}.{$field[1]} = '{$field[2]}'";
            }
        }
        $sql .= $fields;
        return $sql;
    }
    public function order_by(){
        /*  Pass the field names of the fields that should be used to sort the data
         *
        */
        $params = func_get_args();
        $num = func_num_args();
        if($num > 0){
            $orderby = "ORDER BY ". array_shift($params);
            foreach($params as $param){
                $orderby .= ", $param";
            }
            $this->query['orderby'] = $orderby;
            return $this;
        }else{
            return $this;
        }
    }
}
?>