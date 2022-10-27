<?php

// // Load an image from jpeg URL
// $im = imagecreatefromjpeg(
// 'https://media.geeksforgeeks.org/wp-content/uploads/20200123100652/geeksforgeeks12.jpg');

// // View the loaded image in browser using imagejpeg() function
// header('Content-type: image/jpg');
// // Decrease the quality of image to 2
// imagejpeg($im, null, 1);
// //imagedestroy($im);


/* if(isset($_POST['ArrayData'])){

        foreach ($_POST['ArrayData'] as  $key => $value)
        {
            echo 'The product  = '.$value["0"].' and the quantity = '.$value["2"];
        }

    } */




$ipaddress = $_SERVER['REMOTE_ADDR'];
echo "Your IP Address is " . $ipaddress . '</br>';

echo $_SERVER['HTTP_USER_AGENT'] . '</br>';




$str = $_SERVER['HTTP_USER_AGENT'];

$pos1 = strpos($str, '(') + 1;
$pos2 = strpos($str, ')') - $pos1;
$part = substr($str, $pos1, $pos2);
$DeviceArray = explode(";", $part);
print_r($DeviceArray);
echo $OS = $DeviceArray[0];
echo '</br>';
echo $Device =  $DeviceArray[1] . ' ' . $DeviceArray[2];


?>

<!DOCTYPE html>
<html>

<head>
    <title>Getting Clients IP</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>


    <?php echo $_SERVER['SERVER_NAME'];

    $datetime_1 = '2022-02-10 11:15:30';
    $datetime_2 = '2022-04-12 13:30:45';

    $start_datetime = new DateTime($datetime_1);
    $diff = $start_datetime->diff(new DateTime($datetime_2));

    echo $diff->days . ' Days total<br>';
    echo $diff->y . ' Years<br>';
    echo $diff->m . ' Months<br>';
    echo $diff->d . ' Days<br>';
    echo $diff->h . ' Hours<br>';
    echo $diff->i . ' Minutes<br>';
    echo $diff->s . ' Seconds<br>';












    ?>




    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>


    <!-- <canvas id="qrcode"></canvas> -->
    <script type="text/javascript">
        new QRious({
            element: document.getElementById("qrcode"),
            value: "https://webisora.com"
        });
    </script>



    <!-- <canvas id="qrcode-2"></canvas> -->
    <script type="text/javascript">
        var qrcode = new QRious({
            element: document.getElementById("qrcode-2"),
            background: '#ffffff',
            backgroundAlpha: 1,
            foreground: '#5868bf',
            foregroundAlpha: 1,
            level: 'H',
            padding: 0,
            size: 128,
            value: "https://webisora.com"
        });
    </script>











</body>

</html>