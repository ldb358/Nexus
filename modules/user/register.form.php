<?php
if(!defined('__nexus')){
    header("HTTP/1.0 404 not found");
    $redirect = new reroute();
    $redirect->route('error', '404');
}
include_once '/includes/form.class.php';
class user_register_form extends form{
    public function __construct(){
        $action = 'user';
        $method = 'register';
        $fields = array(
            array(
                'name' => 'username',
                'label' => 'Username',
                'type' => 'text',
                'default' => ''
            ),
            array(
                'name' => 'password',
                'label' => 'Password',
                'type' => 'password',
                'default' => ''
            ),
            array(
                'name' => 'cpassword',
                'label' => 'Confirm Password',
                'type' => 'password',
                'default' => ''
            ),
            array(
                'name' => 'email',
                'label' => 'Email',
                'type' => 'text',
                'default' => ''
            ),
            array(
                'name' => 'firstname',
                'label' => 'First Name',
                'type' => 'text',
                'default' => ''
            ),
            array(
                'name' => 'lastname',
                'label' => 'Last Name',
                'type' => 'text',
                'default' => ''
            ),
            array(
                'type' => 'submit',
                'default' => 'Login'
            )
        );
        parent::__construct($action, $method, $fields);
    }
    public function process($form, db $db){
        if(!empty($form['username'])
        && !empty( $form['password'])
        && !empty($form['cpassword'])
        && !empty($form['email'])
        && !empty($form['firstname'])
        && !empty($form['lastname'])){
            $db->prepare('SELECT COUNT(username) as total FROM '.DBPREFIX.'users WHERE username=?');
            $db->sql->bind_param('s', $form['username']);
            $db->sql->bind_result($total);
            $db->query();
            if($total == 0){
                if((strlen($form['username']) < 5) || (strlen($form['password']) < 5)){
                    return $this->error($form, 'you must have an username and password longer than 5 characters');
                }
                if($form['password'] == $form['cpassword']){
                    if(filter_var($form['email'],FILTER_VALIDATE_EMAIL)){
                        $db->prepare('SELECT id FROM '.DBPREFIX.'users ORDER BY id DESC LIMIT 1');
                        $db->sql->bind_param('');
                        $db->sql->bind_result($id);
                        $db->query();
                        $id++;
                        $password2 = hash('sha512',$id.$form['password'].$form['email']);
                        $db->prepare('INSERT INTO '.DBPREFIX.'users (id, username, password, email, firstname, lastname, level) VALUES(?, ?, ?, ?, ?, ?, 8)');
                        $db->sql->bind_param('isssss', $id, $form['username'], $password2, $form['email'], $form['firstname'], $form['lastname']);
                        $db->sql->bind_result();
                        $db->query();
                        if($db->get_affected_rows() == 1){
                            return '';
                        }else{
                            return $this->error($form, 'Register Failed');
                        }
                    }else{
                        return $this->error($form, 'Invalid Email');
                    }
                }else{
                    return $this->error($form, 'passwords don\'t match');
                }
            }else{
                return $this->error($form, 'That username has already been taken');
            }
        
        }else{
            return $this->error($form, 'There are missing fields, all fields are required.');
        }
        
    }
}
?>