<?php
if (isset ($_FILES['image']) and $_FILES['image']['error'] == 0) {
    if ($_FILES['image']['size'] <= 10000000) {
        $info = pathinfo($_FILES['image']['name']);
        $ext = $info['extension'];
        $ext_trust = array('jpg','jpeg','png');
        if(in_array($ext, $ext_trust)){
            move_uploaded_file($_FILES['image']['tmp_name'], 'upload/'.basename($_FILES['image']['name']));
            exec('alpr -c eu upload/'.basename($_FILES['image']['name']), $output);
            echo  '{"Plate":"'.$output[3].'"}';
        }
    }
}
