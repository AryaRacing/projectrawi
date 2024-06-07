<?php
include_once "../config/dbconnect.php";

function generateRandomKey($length = 32) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    $max = strlen($characters) - 1;
    
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $max)];
    }
    
    return $randomString;
}

// Function to encrypt data using AES
function encryptAES($data, $key, $iv) {
    $cipher = "aes-256-cbc"; // AES encryption algorithm and mode
    $encrypted = openssl_encrypt($data, $cipher, $key, OPENSSL_RAW_DATA, $iv);
    return $encrypted;
}

// Function to encode with Base64 and Caesar cipher
function superEncrypt($data) {
    // Base64 Encoding
    $base64Encoded = base64_encode($data);

    // Caesar Cipher with shift value 17
    $shift = 17;
    $caesarCipher = '';
    $length = strlen($base64Encoded);
    for ($i = 0; $i < $length; $i++) {
        $char = $base64Encoded[$i];
        if (ctype_alpha($char)) {
            $asciiStart = ord(ctype_upper($char) ? 'A' : 'a');
            $caesarCipher .= chr(($shift + ord($char) - $asciiStart) % 26 + $asciiStart);
        } else {
            $caesarCipher .= $char;
        }
    }
    return $caesarCipher;
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $Name = $_POST['p_nama'];
    $alamat= $_POST['p_alamat'];
    $tanggallahir= $_POST['p_tanggal'];
    $nomor= $_POST['p_nomor'];
    $category = !empty($_POST['category']) ? $_POST['category'] : null;

    $enName = superEncrypt($Name);
    $enAlamat = superEncrypt($alamat);
    $enTanggalLahir = superEncrypt($tanggallahir);
    $enNomor = superEncrypt($nomor);

    $allowedTypes = ['image/jpeg', 'image/png'];
    $uploadedFileType = $_FILES['file']['type'];

    if (!in_array($uploadedFileType, $allowedTypes)) {
        echo "Only JPG and PNG files are allowed.";
        exit; // Stop further execution
    }

    // Read the image file content
    $fileContent = file_get_contents($_FILES['file']['tmp_name']);

    // AES encryption parameters
    $encryptionKey = generateRandomKey(32);
    $iv = openssl_random_pseudo_bytes(16); // Initialization Vector

    // Encrypt the image content
    $encryptedImage = encryptAES($fileContent, $encryptionKey, $iv);

    // Store the encrypted image data and IV
    $target_dir = "../uploads/";
    $encryptedFileName = "encrypted_picture_" . $_FILES['file']['name']; 
    $finalEncryptedImage = $target_dir . $encryptedFileName;

    // Combine encrypted image data and IV into an array for storage
    $encryptedData = [
        'data' => $encryptedImage,
        'iv' => $iv
    ];

    // Serialize and store the encrypted image data along with IV
    file_put_contents($finalEncryptedImage, serialize($encryptedData));

    // Store the encryption key in the database
    if ($category !== null) {
        $insert = mysqli_query($conn, "INSERT INTO customer (nama, alamat, tanggal_lahir, nomor_hp, category_id, berkas_foto, encryption_key, iv) 
            VALUES ('$enName', '$enAlamat', '$enTanggalLahir', '$enNomor', '$category', '$finalEncryptedImage', '$encryptionKey','$iv')");
    } else {
        $insert = mysqli_query($conn, "INSERT INTO customer (nama, alamat, tanggal_lahir, nomor_hp, berkas_foto, encryption_key, iv) 
            VALUES ('$enName', '$enAlamat', '$enTanggalLahir', '$enNomor', '$finalEncryptedImage', '$encryptionKey','$iv')");
    }

    if(!$insert) {
        echo mysqli_error($conn);
        header("Location: ../mainMenu.php?category=error");
    } else {
        echo "Records added successfully.";
        header("Location: ../mainMenu.php?category=success");
    }
}
?>
