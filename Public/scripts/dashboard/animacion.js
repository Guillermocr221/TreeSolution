//animacion
document.addEventListener("DOMContentLoaded", function() {
    var tituloAnimado = document.getElementById('tituloAnimado');
    var texto = tituloAnimado.textContent.trim();
    tituloAnimado.innerHTML = "";
  
    texto.split(" ").forEach(function(word, index, array) {
      if (index > 0) {
        tituloAnimado.appendChild(document.createTextNode('\u00A0')); // Add non-breaking space
      }
      var spanWord = document.createElement('span');
      tituloAnimado.appendChild(spanWord);
  
      // Add a span for each letter in the word
      word.split("").forEach(function(char, charIndex, charArray) {
        var spanChar = document.createElement('span');
        spanChar.textContent = char;
        spanChar.style.animation = 'desplazamiento 0.5s forwards cubic-bezier(0.5, 0, 0.5, 1)';
        spanChar.style.animationDelay = (index + charIndex * 0.1) + 's'; // Adjust delay for each letter
        spanWord.appendChild(spanChar);
      });
    });
  });
  