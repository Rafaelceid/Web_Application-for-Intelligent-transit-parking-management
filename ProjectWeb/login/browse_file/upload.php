<?php
if (isset($_FILES['filename'])) 
    {
        $file = $_FILES['filename'];
        print_r($file);
        $file_name = $file['name'];
        $file_tmp = $file['tmp_name'];
        $file_size = $file['size'];

        $file_ext = explode('.', $file_name);
        $file_ext = strtolower(end($file_ext));
        $check_ext = array("kml");
        if(in_array($file_ext,$check_ext))
        {
            echo"true";
        }
        
        

     }
?>