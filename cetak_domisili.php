<?php
require_once 'vendor/autoload.php';

ob_start();
include 'template_domisili.php';

$content = ob_get_contents();
ob_end_clean();

$encryption = crypt("domisili", "heCTast");
$file = $encryption.'.pdf';

$mpdf = new \Mpdf\Mpdf([
  'format' => 'letter',
]);
$mpdf->WriteHTML($content);
$mpdf->Output($file, 'I');
exit;

?>