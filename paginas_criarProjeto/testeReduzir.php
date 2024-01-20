<?php
$imagemRecortada = 'Recortadasimp_chico17035.png';
$pythonScript = 'C:/Users/solda/AppData/Local/Programs/Python/Python311/python.exe';
$pythonScriptPath = __DIR__ . '/../run_examples.py';
$command = $pythonScript . ' ' . $pythonScriptPath . ' ' . escapeshellarg($imagemRecortada);

$output = shell_exec($command);

echo $output;
?>