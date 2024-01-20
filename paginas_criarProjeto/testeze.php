<?php
$imagemRecortada = 'Recortadateste1667.png';
// Caminho absoluto para o script Python
$pythonScript = 'testeRemoverImagem.py';

// Comando para chamar o script Python com o caminho da imagem como argumento
$command = 'C:/Users/solda/AppData/Local/Programs/Python/Python311/python.exe ' . escapeshellarg($pythonScript) . ' ' . escapeshellarg($imagemRecortada);

// Executa o comando e obtém a saída
$output = shell_exec($command);

// Verifica se a execução foi bem-sucedida
if ($output !== null) {
    echo "Script Python executado com sucesso!";
} else {
    echo "Ocorreu um erro ao executar o script Python.";
}
?>
