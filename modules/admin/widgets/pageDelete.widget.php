<?php
if(!defined('__nexus')){
    header("HTTP/1.0 404 not found");
    $redirect = new reroute();
    $redirect->route('error', '404');
}
class page_delete extends widget{
    protected $control, $params;
    public function __construct(db $db, $params){
        try{
            parent::__construct($db, $params);
        }catch(Exception $e){
            $redirect = new reroute();
            $redirect->route('error', 'database');
        }
    }
    public function set_header(){
        $this->header = 'Delete Pages';
    }
    public function set_body(){
        $body = '';
        $this->body = $contents;
    }
    public function process($module, $method, $values){
        /* delete the page with the corresponding id */
        $dbprefix = DBPREFIX;
        @$id = $values['id'];
        if(!empty($id)){
            $this->db->prepare("DELETE FROM {$dbprefix}content WHERE content_id=?");
            $this->db->sql->bind_param('i', $id);
            $this->db->query();
            $this->db->prepare("DELETE FROM {$dbprefix}page WHERE id=?");
            $this->db->sql->bind_param('i', $id);
            $this->db->query();
        }
    }
}