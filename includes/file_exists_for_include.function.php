<?php
function file_exists_for_include($file){
    /* This function is a simple function that checks if a file exists on the 
     * Include path(which is how nexus includes all of its files)
    */
    if(!file_exists($file)){
        $paths = explode(PATH_SEPARATOR,get_include_path());
        foreach($paths as $p){
            if(file_exists(preg_replace('%/$%','',$p)."/$file")){
                return true;
            }
        }
        return false;
    }
    else{
        return true;
    }
}
?>