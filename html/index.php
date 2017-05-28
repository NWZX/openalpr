<?php
if (isset ($_FILES['image']) and $_FILES['image']['error'] == 0) {
    if ($_FILES['image']['size'] <= 10000000) {
        $info = pathinfo($_FILES['image']['name']);
        $ext = $info['extension'];
        $ext_trust = array('jpg');
        if (in_array($ext, $ext_trust)) {
            move_uploaded_file($_FILES['image']['tmp_name'], 'upload/'.basename($_FILES['image']['name']));
            exec('alpr -c eu upload/'.basename($_FILES['image']['name']).' 2>&1', $output);
            if (preg_match("\s+- [A-Z1-9]+\s+confidence: [1-9.]+", $output[3])) {
                $plate = preg_replace("\s+- ([A-Z1-9]+)\s+confidence: [1-9.]+", "{\"Plate\":\"$1\"}", $output[3]);
                echo $plate;
            }
            else {
                echo "{\"Plate\":\"null\"}";
            }
        }
    }
}
