<?php
function crypto_rand_secure($min, $max)
{
    $range = $max - $min;
    if ($range < 1) return $min; // not so random...
    $log = ceil(log($range, 2));
    $bytes = (int) ($log / 8) + 1; // length in bytes
    $bits = (int) $log + 1; // length in bits
    $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
    do {
        $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
        $rnd = $rnd & $filter; // discard irrelevant bits
    } while ($rnd > $range);
    return $min + $rnd;
}

function getToken($length)
{
    $token = "";
    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
    $codeAlphabet.= "0123456789";
    $max = strlen($codeAlphabet); // edited

    for ($i=0; $i < $length; $i++) {
        $token .= $codeAlphabet[crypto_rand_secure(0, $max-1)];
    }

    return $token;
}


$fileName = str_replace(' ', '', $_FILES["image1"]["name"]); // The file name
$fileTmpLoc = $_FILES["image1"]["tmp_name"];
$fileType = $_FILES["image1"]["type"];
$fileSize = $_FILES["image1"]["size"];
$fileErrorMsg = $_FILES["image1"]["error"];
$folderName = getToken(10);
mkdir("puzzle_images/".$folderName);
if(move_uploaded_file($fileTmpLoc, "puzzle_images/$folderName/image.jpg")) { 
   echo "puzzle_images/$folderName/image.jpg upload is complete"; 
} else { 
   echo "move_uploaded_file function failed"; 
}
?>