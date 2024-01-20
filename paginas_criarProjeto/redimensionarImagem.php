<?php
$imagem = $logoRedimensionar.$logo;

// Tamanhos máximos predefinidos
$larguraMaxima = 1200;
$alturaMaxima = 1000;

// Obtém as dimensões da imagem
list($larguraOriginal, $alturaOriginal) = getimagesize($imagem);

// Calcula as novas dimensões mantendo as proporções
$ratio = min($larguraMaxima / $larguraOriginal, $alturaMaxima / $alturaOriginal);
$larguraNova = $larguraOriginal * $ratio * 0.5; // Reduz para 50% do tamanho original
$alturaNova = $alturaOriginal * $ratio * 0.5; // Reduz para 50% do tamanho original

// Verifica se a imagem precisa ser redimensionada
if ($larguraOriginal > $larguraMaxima || $alturaOriginal > $alturaMaxima) {
  // Aplica o estilo de 50% de largura ou altura
  $estilo = 'style="width: ' . $larguraNova . 'px; height: ' . $alturaNova . 'px;"';
} else {
  // Não é necessário aplicar estilo
  $estilo = ''; 
}
?>
