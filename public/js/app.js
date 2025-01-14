//******** Gestion de l'aperçu d'image dans le formulaire d'ajout d'un témoignage *************//
function previewImage(event) {
  const allowedFormats = ['image/jpg', 'image/jpeg', 'image/png'];
  const maxSize = 2 * 1024 * 1024; // 2 Mo
  const imageFile = event.target.files[0];
  const imagePreview = document.getElementById('image-preview');
  const imageError = document.getElementById('image-error');
  const imageValid = document.getElementById('image-valid');
  const defaultImageUrl = imagePreview.dataset.defaultImageUrl;

  if (!imageFile) {
      // Si l'utilisateur annule le choix, revenir à l'image par défaut
      imagePreview.src = defaultImageUrl;
      return;
  }

  if (allowedFormats.indexOf(imageFile.type) === -1) {
      imageError.textContent = 'Veuillez sélectionner un fichier au format jpg, jpeg ou png.';
      event.target.value = '';
      imagePreview.src = defaultImageUrl;
      imageValid.style.display = 'none';
      return;
  }

  if (imageFile.size > maxSize) {
      imageError.textContent = 'Le fichier est trop volumineux. Sa taille ne doit pas dépasser 2 Mo.';
      event.target.value = '';
      imagePreview.src = defaultImageUrl;
      imageValid.style.display = 'none';
      return;
  }

  imageError.textContent = '';
  imageValid.style.display = 'block';
  var reader = new FileReader();
  reader.onload = function () {
      imagePreview.src = reader.result;
  }
  reader.readAsDataURL(imageFile);
}


// Gestion du lazy loading pour les images
document.addEventListener("DOMContentLoaded", function() {
    var lazyImages = [].slice.call(document.querySelectorAll("img[loading='lazy']"));
  
    if ("IntersectionObserver" in window) {
      let lazyImageObserver = new IntersectionObserver(function(entries, observer) {
        entries.forEach(function(entry) {
          if (entry.isIntersecting) {
            let lazyImage = entry.target;
            lazyImage.src = lazyImage.dataset.src;
            lazyImageObserver.unobserve(lazyImage);
          }
        });
      });
  
      lazyImages.forEach(function(lazyImage) {
        lazyImageObserver.observe(lazyImage);
      });
    }
  });
  
