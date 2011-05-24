<?php
if(!defined('__nexus')){
    header("HTTP/1.0 404 not found");
    $redirect = new reroute();
    $redirect->route('error', '404');
}
class form {
    protected $fields = array(), $action, $method, $widget;
    public function __construct($action, $method, $fields){
        $this->action = $action;
        $this->method = $method;
        $this->fields = $fields;
    }
    public function process($form, db $db){
    
    }
    public function on_success(){
        $redirect = new reroute();
        $redirect->route();
    }
    public function get_form(){
        $index = count($this->fields);
        while(isset($this->fields[$index])) $index++;
        $this->fields[$index] =  array(
            'name' => 'action',
            'label' => '',
            'type' => 'hidden',
            'default' => $this->action
        );
        $this->fields[++$index] =  array(
            'name' => 'method',
            'label' => '',
            'type' => 'hidden',
            'default' => $this->method
        );
        if(!empty($this->method)){
            $this->fields[++$index] =  array(
                'name' => 'widget',
                'label' => '',
                'type' => 'hidden',
                'default' => $this->widget
            );
        }
        $output = '<form action="" method="post">';
        foreach($this->fields as $key => $input){
            if(@$input['name'] != 'action' && @$input['name'] != 'method'){
                @$input['name'] = "{$this->method}[{$input['name']}]";
            }
            if(@$input['type'] != 'hidden' && $input['type'] != 'submit' && $input['type'] != 'textarea'){
                @$fields = sprintf('<p class="input"><label for="%1$s">%2$s</label><input type="%3$s" name="%1$s" value="%4$s" ></p>',$input['name'], $input['label'], $input['type'], $input['default']);
            }else if($input['type'] == 'submit'){
                @$fields = sprintf('<p class="input submit"><input type="%1$s" value="%2$s" ></p>', $input['type'], $input['default']);
            }else if($input['type'] == 'hidden'){
                @$fields = sprintf('<input type="%2$s" name="%1$s" value="%3$s" >',$input['name'], $input['type'], $input['default']);
            }else{
                @$fields = sprintf('<p class="input textarea"><label for="%2$s">%3$s</label><textarea name="%2$s">%1$s</textarea></p>', $input['default'], $input['name'], $input['label']);
            }
            if($input['type'] == 'file'){
                $output = str_replace('<form ', '<form enctype="multipart/form-data" ',$output);
            }
            $output .= $fields;
        }
        $output .= "</form>";
        return $output;
    }
    public function error($form, $message){
        $array = $this->fields;
        array_pop($array);
        foreach($array as $key => $value){
            @$this->fields[$key]['default'] = $form[$this->fields[$key]['name']];
        }
        return ucwords($message);
    }
    public function set_action($action){
        $this->action = $action;
    }
    public function set_method($method){
        $this->method = $method;
    }
    public function set_widget($widget){
        $this->widget = $widget;
    }
    public function get_fields(){
        return $this->fields;
    }
    public function set_fields($fields){
        $this->fields = $fields;
    }
}
?>