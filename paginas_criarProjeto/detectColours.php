<?php
if (!isset($_SESSION)) {
  session_start();
}




function detectColors($image, $num, $level)
{
  $level = (int) $level;
  $palette = array();
  $size = getimagesize($image);
  if (!$size) {
    return FALSE;
  }
  switch ($size['mime']) {
    case 'image/jpeg':
      $img = imagecreatefromjpeg($image);
      break;
    case 'image/png':
      $img = imagecreatefrompng($image);
      imagealphablending($img, false);
      imagesavealpha($img, true);
      break;
    case 'image/gif':
      $img = imagecreatefromgif($image);
      break;
    default:
      return FALSE;
  }
  if (!$img) {
    return FALSE;
  }
  for ($i = 0; $i < $size[0]; $i += $level) {
    for ($j = 0; $j < $size[1]; $j += $level) {
      $thisColor = imagecolorat($img, $i, $j);
      $rgb = imagecolorsforindex($img, $thisColor);

      // Check for transparency and skip the pixel if it's transparent
      if ($rgb['alpha'] === 127) {
        continue;
      }

      $color = sprintf('%02X%02X%02X', (round(round(($rgb['red'] / 0x33)) * 0x33)), round(round(($rgb['green'] / 0x33)) * 0x33), round(round(($rgb['blue'] / 0x33)) * 0x33));
      $palette[$color] = isset($palette[$color]) ? ++$palette[$color] : 1;
    }
  }
  arsort($palette);
  return array_slice(array_keys($palette), 0, $num);
}



function hexToRgb($hex)
{
  list($r, $g, $b) = sscanf($hex, "%02x%02x%02x");
  return array($r, $g, $b);
}


?>