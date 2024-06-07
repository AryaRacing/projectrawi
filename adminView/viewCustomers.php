<?php
function decryptAES($data, $key, $iv) {
    $cipher = "aes-256-cbc"; // AES decryption algorithm and mode
    $decrypted = openssl_decrypt($data, $cipher, $key, OPENSSL_RAW_DATA, $iv);

    if ($decrypted === false) {
        // Error occurred during decryption
        $error = openssl_error_string();
        error_log("Decryption error: $error");
        return null; // or handle the error as required
    }

    return $decrypted;
}

function superDecrypt($data) {
    // Caesar Cipher decryption with shift value 17 
    $shift = 17;
    $caesarDecipher = '';
    $length = strlen($data);
    for ($i = 0; $i < $length; $i++) {
        $char = $data[$i];
        if (ctype_alpha($char)) {
            $asciiStart = ord(ctype_upper($char) ? 'A' : 'a');
            $caesarDecipher .= chr((26 + ord($char) - $shift - $asciiStart) % 26 + $asciiStart);
        } else {
            $caesarDecipher .= $char;
        }
    }

    // Base64 Decoding
    $base64Decoded = base64_decode($caesarDecipher);
    return $base64Decoded;
}
?>

<div>
  <h2>Data Customer</h2>
  <table class="table">
    <thead>
      <tr>
        <th class="text-center">Nomor</th>
        <th class="text-center">Foto ID Customer</th>
        <th class="text-center">Nama Customer</th>
        <th class="text-center">Alamat</th>
        <th class="text-center">Tanggal Lahir</th>
        <th class="text-center">Nomor HP</th>
        <th class="text-center">Class</th>
        <th class="text-center" colspan="2">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
      include_once "../config/dbconnect.php";

      $sql = "SELECT * FROM customer INNER JOIN category ON customer.category_id = category.category_id";
      $result = $conn->query($sql);
      $count = 1;
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          ?>
          <tr>
            <td class="text-center"><?= $count ?></td>
            <td>
              <?php
              // Decrypt the image
              $encryptedImagePath = $row["berkas_foto"];
              $encryptionKey = $row["encryption_key"];
              $iv = $row["iv"];

              // Retrieve serialized encrypted data
              $serializedEncryptedData = file_get_contents($encryptedImagePath);

              // Unserialize the data to extract encrypted image and IV
              $encryptedData = unserialize($serializedEncryptedData);
              $encryptedImage = $encryptedData['data'];
              $iv = $encryptedData['iv'];

              $decryptedImage = decryptAES($encryptedImage, $encryptionKey, $iv);

              // Display the decrypted image (assuming it's an image file)
              if ($decryptedImage !== null) {
                $imageData = base64_encode($decryptedImage);
                echo '<img src="data:image/jpeg;base64,' . $imageData . '" style="max-width: 100px; max-height: 100px;" />';
              } else {
                echo 'Error decrypting the image.';
              }
              ?>
            </td>
            <?php
            $decryptedName = superDecrypt($row["nama"]);
            $decryptedAlamat = superDecrypt($row["alamat"]);
            $decryptedTanggalLahir = superDecrypt($row["tanggal_lahir"]);
            $decryptedNomor = superDecrypt($row["nomor_hp"]);

            echo "<td>$decryptedName</td>";
            echo "<td>$decryptedAlamat</td>";
            echo "<td>$decryptedTanggalLahir</td>";
            echo "<td>$decryptedNomor</td>";
            ?>
            <td><?= $row["nama_cat"] ?></td>
            <td><button class="btn btn-danger" style="height:40px" onclick="itemDelete('<?= $row['id_customer'] ?>')">Delete</button></td>
          </tr>
          <?php
          $count++;
        }
      } else {
        echo "<tr><td colspan='8' class='text-center'>Tidak Ada Data Pelanggan</td></tr>";
      }
      ?>
    </tbody>
  </table>

  <!-- Trigger the modal with a button -->
  <button type="button" class="btn btn-secondary " style="height:40px" data-toggle="modal" data-target="#myModal">
    Tambah Customer Baru
  </button>

  <!-- Modal -->
  <div class="modal fade"id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Data Pelanggan Baru</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <form enctype='multipart/form-data' action="./controller/addCustomer.php" method="POST">
            <div class="form-group">
              <label for="nama">Nama Pelanggan:</label>
              <input type="text" class="form-control" name="p_nama" required>
            </div>
            <div class="form-group">
              <label for="alamat">Alamat:</label>
              <input type="text" class="form-control" name="p_alamat" required>
            </div>
            <div class="form-group">
              <label for="tanggal">Tanggal Lahir:</label>
              <input type="date" class="form-control" name="p_tanggal" required>
            </div>
            <div class="form-group">
              <label for="nomor">Nomor HP:</label>
              <input type="text" class="form-control" name="p_nomor" required>
            </div>
            <div class="form-group">
              <label for="category">Member Class:</label>
              <select class="form-control" name="category" required>
                <option disabled selected>Pilih Class</option>
                <?php
                  $sql = "SELECT * FROM category";
                  $result = $conn->query($sql);

                  if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                      echo "<option value='" . $row['category_id'] . "'>" . $row['nama_cat'] . "</option>";
                    }
                  }
                ?>
              </select>
            </div>
            <div class="form-group">
              <label for="file">Masukkan Gambar:</label>
              <input type="file" class="form-control-file" name="file" accept="image/*" required>
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-secondary" name="uploadpelanggan" style="height:40px">Simpan</button>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="height:40px">Close</button>
        </div>
      </div>
      
    </div>
  </div>
</div>

