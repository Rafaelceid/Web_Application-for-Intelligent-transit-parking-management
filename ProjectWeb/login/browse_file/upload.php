<?php
if (isset($_FILES['filename'])) 
    {
        $file = $_FILES['filename'];
        print_r($file);
        echo "omonoia";
    }
echo "skata";
?>