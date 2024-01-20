import sys
from rembg import remove
from PIL import Image
import os


def main():

    # Obtém o nome base do arquivo PHP
    nome_base = sys.argv[1]

    # Caminho para o diretório das imagens (pasta "imagens" fora da pasta atual)
    diretorio_imagens = os.path.abspath(os.path.join(os.path.dirname(__file__), '..', 'imagens'))

    # Define o caminho da imagem a ser processada
    caminho_imagem = os.path.join(diretorio_imagens, f"{nome_base}")

    # Carrega a imagem
    imagem = Image.open(caminho_imagem)

    # Remove o fundo da imagem
    imagem_sem_fundo = remove(imagem)

    # Define o caminho para salvar a imagem com o mesmo nome
    caminho_saida = os.path.join(diretorio_imagens, f"{nome_base}")

    # Salva a imagem sem fundo com o mesmo nome
    imagem_sem_fundo.save(caminho_saida)

    # Exibe uma mensagem de confirmação com o nome da imagem processada
    print(f"Imagem {caminho_saida} criada com sucesso!")

if __name__ == '__main__':
    main()
