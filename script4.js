const redSlider = document.getElementById('red-slider');
const greenSlider = document.getElementById('green-slider');
const blueSlider = document.getElementById('blue-slider');
const canvas1 = document.getElementById('canvas2');
canvas1.style.marginLeft = 'auto';
canvas1.style.marginRight = 'auto';
const ctx = canvas1.getContext('2d');
const img = new Image();

img.src = nomeImagem;
img.onload = () => {
  canvas1.width = img.width;
  canvas1.height = img.height;
  const x = (canvas1.width - img.width) / 2;
  const y = (canvas1.height - img.height) / 2;
  ctx.drawImage(img, x, y);
}

redSlider.addEventListener('input', updateImageColors);
greenSlider.addEventListener('input', updateImageColors);
blueSlider.addEventListener('input', updateImageColors);

function updateImageColors() {
  const redValue = parseInt(redSlider.value);
  const greenValue = parseInt(greenSlider.value);
  const blueValue = parseInt(blueSlider.value);
  
  const x = (canvas1.width - img.width) / 2;
  const y = (canvas1.height - img.height) / 2;
  ctx.drawImage(img, x, y);
  
  const imageData = ctx.getImageData(0, 0, canvas1.width, canvas1.height);
  const data = imageData.data;
  
  for (let i = 0; i < data.length; i += 4) {
    data[i] += redValue;
    data[i + 1] += greenValue;
    data[i + 2] += blueValue;
  }
  
  ctx.putImageData(imageData, x, y);
}
