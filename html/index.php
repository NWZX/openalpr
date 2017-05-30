<?php
$uploaddir = '/var/www/html/upload/';
if (isset ($_FILES['image']) and $_FILES['image']['error'] == 0) {
    if ($_FILES['image']['size'] <= 10000000) {
        $info = pathinfo($_FILES['image']['name']);
        $ext = $info['extension'];
        $ext_trust = array('jpg');
        if (in_array($ext, $ext_trust)) {
            move_uploaded_file($_FILES['image']['tmp_name'], 'upload/'.basename($_FILES['image']['name']));
            exec('alpr -c eu upload/'.basename($_FILES['image']['name']).' 2>&1', $output);
            $re = '/-.+\sconfidence:\s[0-9.]+/i';
            $re2 = '/-(.+)\sconfidence:\s[0-9.]+/i';
            if (preg_match($re, $output[2])) {
                $plate = preg_replace($re2, "{\"Plate\":\"$1\"}", $output[2]);
                echo $plate;
            }
            else {
                echo "{\"Plate\":\"null\"}";
            }
        }
    }
}
