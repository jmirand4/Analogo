import sys
from rembg import remove
from PIL import Image
import os



def main():

    # Obtém o nome base do arquivo PHP
    nome_base = sys.argv[1]

    # Caminho para o diretório das imagens
    diretorio_imagens = "imagens/recortada"

    # Lista dos diferentes tipos de imagens
    tipos_parte = [
        "parte1",
        "parte2",
        "parte3",
        "parte4"
    ]

    # Itera sobre os tipos de imagens
    for tipo_parte in tipos_parte:
        # Define o caminho da imagem a ser processada
        caminho_imagem = os.path.join(diretorio_imagens, f"{nome_base}{tipo_parte}.png")

        # Carrega a imagem
        imagem = Image.open(caminho_imagem)

        # Remove o fundo da imagem
        imagem_sem_fundo = remove(imagem)

        # Define o caminho para salvar a imagem com o mesmo nome, mas no formato PNG
        caminho_saida = os.path.join(diretorio_imagens, f"{nome_base}{tipo_parte}.png")

        # Salva a imagem sem fundo com o mesmo nome, no formato PNG
        imagem_sem_fundo.save(caminho_saida)

        # Exibe uma mensagem de confirmação com o nome da imagem processada
        print(f"Imagem {caminho_saida} criada com sucesso!")

if __name__ == '__main__':
    main()
