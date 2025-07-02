<?php
if (isset($_FILES['csv_file'])) {
  $file = $_FILES['csv_file']['tmp_name'];
  $content = file_get_contents($file);
  $content = mb_convert_encoding($content, 'UTF-8', 'auto');

  $temp = tmpfile();
  fwrite($temp, $content);
  rewind($temp);

  $firstLine = fgets($temp);
  $delimiter = ';';
  if (count(str_getcsv($firstLine, ',')) == 8) {
    $delimiter = ',';
  }
  rewind($temp);

  echo "<p><strong>Delimiter terdeteksi:</strong> " . htmlspecialchars($delimiter) . "</p>";
  echo "<table border='1' cellpadding='6'>";
  while (($data = fgetcsv($temp, 1000, $delimiter)) !== FALSE) {
    echo "<tr>";
    foreach ($data as $cell) {
      echo "<td>" . htmlspecialchars($cell) . "</td>";
    }
    echo "</tr>";
  }
  echo "</table>";
  fclose($temp);
}
?>

<form method="post" enctype="multipart/form-data">
  <label>Pilih file CSV:</label>
  <input type="file" name="csv_file" required>
  <button type="submit">Cek Isi CSV</button>
</form>
