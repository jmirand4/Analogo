from recolor import Core
import os
import sys

logo = sys.argv[1]

# Obtendo o diretório atual do script
current_directory = os.path.dirname(os.path.abspath(__file__))

# Construindo os caminhos absolutos para os diretórios e arquivos de saída
output_directory = os.path.join(current_directory, 'imagens', 'daltonismo')
os.makedirs(output_directory, exist_ok=True)

image_path = os.path.join(current_directory, 'imagens', logo)
image_name = os.path.splitext(logo)[0] + '.png_' + 'protanopia' + os.path.splitext(logo)[1]
image_name2 = os.path.splitext(logo)[0] + '.png_' + 'deutranopia' + os.path.splitext(logo)[1]
image_name3 = os.path.splitext(logo)[0] + '.png_' + 'tritanopia' + os.path.splitext(logo)[1]
image_name4 = os.path.splitext(logo)[0] + '.png_' + 'hybrid' + os.path.splitext(logo)[1]
image_name5 = os.path.splitext(logo)[0] + '.png_' + 'CorrectingImageforProtanopia' + os.path.splitext(logo)[1]
image_name6 = os.path.splitext(logo)[0] + '.png_' + 'protanopia' + os.path.splitext(logo)[1]
image_name7 = os.path.splitext(logo)[0] + '.png_' + 'CorrectingImageforDeutranopia' + os.path.splitext(logo)[1]
image_name8 = os.path.splitext(logo)[0] + '.png_' + 'deutranopia' + os.path.splitext(logo)[1]
image_name9 = os.path.splitext(logo)[0] + '.png_' + 'CorrectingImageforHybrid' + os.path.splitext(logo)[1]

output_path = os.path.join(output_directory, image_name)
output_path2 = os.path.join(output_directory, image_name2)
output_path3 = os.path.join(output_directory, image_name3)
output_path4 = os.path.join(output_directory, image_name4)
output_path5 = os.path.join(output_directory, image_name5)
output_path6 = os.path.join(output_directory, image_name6)
output_path7 = os.path.join(output_directory, image_name7)
output_path8 = os.path.join(output_directory, image_name8)
output_path9 = os.path.join(output_directory, image_name9)

def main():
    # Simulating Protanopia with diagnosed degree of 0.9 and saving the image to file.
    Core.simulate(input_path=image_path,
                  return_type='save',
                  save_path=output_path,
                  simulate_type='protanopia',
                  simulate_degree_primary=0.9)

    # Simulating Deutranopia with diagnosed degree of 0.9 and saving the image to file.
    Core.simulate(input_path=image_path,
                  return_type='save',
                  save_path=output_path2,
                  simulate_type='deutranopia',
                  simulate_degree_primary=0.9)

    # Simulating Tritanopia with diagnosed degree of 0.9 and saving the image to file.
    Core.simulate(input_path=image_path,
                  return_type='save',
                  save_path=output_path3,
                  simulate_type='tritanopia',
                  simulate_degree_primary=0.9)

    # Simulating Hybrid (Protanomaly + Deutranomaly) with diagnosed degree of 0.9 and 1.0 and saving the image to file.
    Core.simulate(input_path=image_path,
                  return_type='save',
                  save_path=output_path4,
                  simulate_type='hybrid',
                  simulate_degree_primary=0.5,
                  simulate_degree_sec=0.5)

    # Correcting Image for Protanopia with diagnosed degree of 1.0 and saving the image to file.
    Core.correct(input_path=image_path,
                 return_type='save',
                 save_path=output_path5,
                 protanopia_degree=0.9,
                 deutranopia_degree=0.0)

    # Also simulate the corrected image to see difference.
    Core.simulate(input_path=image_path,
                  return_type='save',
                  save_path=output_path6,
                  simulate_type='protanopia',
                  simulate_degree_primary=0.9)

    # Correcting Image for Deutranopia with diagnosed degree of 1.0 and saving the image to file.
    Core.correct(input_path=image_path,
                 return_type='save',
                 save_path=output_path7,
                 protanopia_degree=0.0,
                 deutranopia_degree=1.0)

    # Also simulate the corrected image to see difference.
    Core.simulate(input_path=image_path,
                  return_type='save',
                  save_path=output_path8,
                  simulate_type='deutranopia',
                  simulate_degree_primary=0.9)

    # Correcting Image for Hybrid with diagnosed degree of 1.0 for both protanopia and
    # deutranopia and saving the image to file.
    Core.correct(input_path=image_path,
                 return_type='save',
                 save_path=output_path9,
                 protanopia_degree=0.5,
                 deutranopia_degree=0.5)

    # You can also use different return types and get numpy array or PIL.Image for further processing.
    # See recolor.py
    return


if __name__ == '__main__':
    main()
