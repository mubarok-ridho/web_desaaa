<?php
// Konfigurasi Cloudinary
$cloud_name = 'djlnxwmqk';
$api_key = '896975467237439';
$api_secret = 'uF-XRF2f4xXu-9pne5SKYcbGGUo';

// URL API Cloudinary (raw files)
$url = "https://$api_key:$api_secret@api.cloudinary.com/v1_1/$cloud_name/resources/raw";
$response = file_get_contents($url);
$data = json_decode($response, true);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>File Upload Viewer</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    body {
      background: #f9f9f9;
    }
    .file-grid {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
    }
    .file-item {
      width: 200px;
      padding: 15px;
      background: white;
      border-radius: 10px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      text-align: center;
    }
    .file-item i {
      font-size: 40px;
      color: #007bff;
      margin-bottom: 10px;
    }
    .file-item a {
      text-decoration: none;
      color: #333;
      word-break: break-word;
    }
    .file-item a:hover {
      color: #007bff;
    }
  </style>
</head>
<body>
<div class="container mt-4">
  <h3><i class="fas fa-folder-open"></i> File yang Sudah Diupload</h3>
  <hr>

  <?php if (!empty($data['resources'])): ?>
  <div class="file-grid">
    <?php foreach ($data['resources'] as $file): 
      $filename = basename($file['public_id']);
      $ext = pathinfo($file['public_id'], PATHINFO_EXTENSION);
      $url = $file['secure_url'];
      $previewable = preg_match('/\.(pdf|csv|txt)$/i', $url);
    ?>
      <div class="file-item">
        <i class="fas fa-file-alt"></i><br>
        <?php if ($previewable): ?>
          <a href="#" class="preview-link" data-url="<?= $url ?>" data-name="<?= $filename ?>">
            <?= $filename ?>
          </a>
        <?php else: ?>
          <a href="<?= $url ?>" target="_blank"><?= $filename ?></a>
        <?php endif; ?>
        <div class="text-muted" style="font-size:12px;">
          <?= round($file['bytes'] / 1024, 2) ?> KB
        </div>
      </div>
    <?php endforeach; ?>
  </div>
  <?php else: ?>
    <p class="text-danger">Tidak ada file ditemukan.</p>
  <?php endif; ?>
</div>

<!-- MODAL PREVIEW -->
<div class="modal fade" id="filePreviewModal" tabindex="-1" role="dialog" aria-labelledby="previewLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="previewLabel">Preview File</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <iframe id="previewFrame" src="" frameborder="0" width="100%" height="600px"></iframe>
      </div>
    </div>
  </div>
</div>

<!-- DEPENDENCIES -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

<!-- MODAL PREVIEW SCRIPT -->
<script>
  $(document).ready(function() {
    $('.preview-link').click(function(e) {
      e.preventDefault();
      const fileUrl = $(this).data('url');
      const fileName = $(this).data('name');
      $('#previewFrame').attr('src', fileUrl);
      $('#previewLabel').text('Preview: ' + fileName);
      $('#filePreviewModal').modal('show');
    });
  });
</script>
</body>
</html>
