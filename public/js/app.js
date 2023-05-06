const player = new Plyr('video');

function previewImage(event) {
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
