import sys
from rembg import remove
from PIL import Image
import os

def main():
    # Obtém o nome da imagem a partir do argumento do script
    nome_imagem = sys.argv[1]

    # Caminho para o diretório das imagens
    diretorio_imagens = os.path.abspath(os.path.join(os.getcwd(), '..', '..','WebApp1', 'imagens', 'daltonismo'))

    # Lista dos diferentes tipos de imagens
    tipos_imagens = [
        'protanopia',
        'deutranopia',
        'tritanopia',
        'hybrid',
        'CorrectingImageforProtanopia',
        'CorrectingImageforDeutranopia',
        'CorrectingImageforHybrid'
    ]

    # Itera sobre os tipos de imagens
    for tipo_imagem in tipos_imagens:
        # Define o caminho da imagem de entrada
        caminho_imagem_entrada = os.path.join(diretorio_imagens, f'{nome_imagem}_{tipo_imagem}.png')

        # Verifica se o arquivo de imagem existe
        if not os.path.exists(caminho_imagem_entrada):
            print(f'O arquivo de imagem {caminho_imagem_entrada} não existe.')
            continue

        # Define o caminho para salvar a imagem de saída
        caminho_imagem_saida = os.path.join(diretorio_imagens, f'{nome_imagem}_{tipo_imagem}.png')

        # Carrega a imagem de entrada
        imagem_entrada = Image.open(caminho_imagem_entrada)

        # Remove o fundo da imagem
        imagem_sem_fundo = remove(imagem_entrada)

        # Salva a imagem sem fundo com o mesmo nome
        imagem_sem_fundo.save(caminho_imagem_saida)

        # Exibe uma mensagem de confirmação com o nome da imagem processada
        print(f'Imagem {caminho_imagem_saida} criada com sucesso!')
    
if __name__ == '__main__':
    main()
