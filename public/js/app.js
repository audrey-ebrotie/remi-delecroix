//******** Gestion de l'aperçu d'image dans le formulaire d'ajout d'un témoignage *************//

function previewImage(event) {
    const allowedFormats = ['image/jpg', 'image/jpeg', 'image/png'];
    const maxSize = 2 * 1024 * 1024; // 2 Mo
    const imageFile = event.target.files[0];
    const imagePreview = document.getElementById('image-preview');
    const imageError = document.getElementById('image-error');
    const imageValid = document.getElementById('image-valid');
    const defaultImageUrl = imagePreview.dataset.defaultImageUrl;

    if (allowedFormats.indexOf(imageFile.type) === -1) {
        // Format invalide
        imageError.textContent = 'Veuillez sélectionner un fichier au format jpg, jpeg ou png.';
        event.target.value = null;
        imagePreview.src = defaultImageUrl;
        imageValid.style.display = 'none';
        return;
    }

    if (imageFile.size > maxSize) {
        // Poids trop élevé
        imageError.textContent = 'Le fichier est trop volumineux. Sa taille ne doit pas dépasser 2 Mo.';
        event.target.value = null;
        imagePreview.src = defaultImageUrl;
        imageValid.style.display = 'none';
        return;
    }

    // Tout est correct, affichage de l'aperçu de l'image et du message "Image valide"
    imageError.textContent = '';
    imageValid.style.display = 'block';
    var reader = new FileReader();
    reader.onload = function () {
        var output = document.getElementById('image-preview');
        output.src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}

// Ajouter un écouteur d'événement sur le champ de fichier pour prévisualiser l'image sélectionnée
var fileInput = document.querySelector('#comment_image_file');
fileInput.addEventListener('change', function(event) {
    var imagePreview = document.querySelector('#image-preview');
    imagePreview.style.display = 'block';
    previewImage(event);
});

//******** Gestion de la popup de vérification avant validation d'un témoignage *************//

// document.querySelector('#comment-form').addEventListener('submit', function(event) {
//     console.log('form submit event triggered');
//     event.preventDefault();
//     $('#confirmSubmitModal').modal('show');
// });

// document.querySelector('#confirmSubmit').addEventListener('click', function() {
//     console.log('confirm button clicked');
//     document.querySelector('#comment-form').submit();
// });

// $('#confirmSubmitModal').on('shown.bs.modal', function () {
//     console.log('modal is shown');
// })