const slider = document.getElementById('pixelizacao');
const output = document.getElementById('valor-pixelizacao');
const canvas = document.getElementById('canvas');
const imagem = new Image();

imagem.onload = function() {
  canvas.width = imagem.width;
  canvas.height = imagem.height;
  renderizarImagem(imagem, 1);
}

imagem.src = nomeImagem;

function renderizarImagem(imagem, pixelizacao) {
  const largura = canvas.width * pixelizacao * 0.1;
  const altura = canvas.height * pixelizacao * 0.1;
  const ctx = canvas.getContext('2d');

  // Create a temporary canvas and context
  const tempCanvas = document.createElement('canvas');
  const tempCtx = tempCanvas.getContext('2d');

  // Set the dimensions of the temporary canvas
  tempCanvas.width = largura;
  tempCanvas.height = altura;

  // Draw the smaller version of the image on the temporary canvas
  tempCtx.imageSmoothingEnabled = false;
  tempCtx.drawImage(imagem, 0, 0, largura, altura);

  // Clear the main canvas and draw the smaller image from the temporary canvas
  ctx.clearRect(0, 0, canvas.width, canvas.height);
  ctx.imageSmoothingEnabled = false;
  ctx.drawImage(tempCanvas, 0, 0, largura, altura, 0, 0, canvas.width, canvas.height);
}



slider.oninput = function() {
  output.textContent = this.value;
  renderizarImagem(imagem, this.value);
};

const btn20 = document.getElementById('btn-20');
btn20.addEventListener('click', function() {
  slider.value = 2;
  output.textContent = 2;
  renderizarImagem(imagem, 2);
});

const btn30 = document.getElementById('btn-30');
btn30.addEventListener('click', function() {
  slider.value = 3;
  output.textContent = 3;
  renderizarImagem(imagem, 3);
});

const btn50 = document.getElementById('btn-50');
btn50.addEventListener('click', function() {
  slider.value = 5;
  output.textContent = 5;
  renderizarImagem(imagem, 5);
});

const btn80 = document.getElementById('btn-80');
btn80.addEventListener('click', function() {
  slider.value = 8;
  output.textContent = 8;
  renderizarImagem(imagem, 8);
});
