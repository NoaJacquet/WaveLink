document.addEventListener("DOMContentLoaded", () => {
    const dropZone = document.getElementById("dropZone");
    const inputFile = document.getElementById("inputFile");
    const imagePreview = document.getElementById("imagePreview");

    dropZone.addEventListener("click", () => {
        inputFile.click();
    });

    inputFile.addEventListener("change", handleFileSelect);

    // Ajoutez cet événement de clic pour changer l'image
    imagePreview.querySelector(".image-preview__image").addEventListener("click", () => {
        inputFile.click();
    });

    function handleFileSelect() {
        const files = inputFile.files;

        if (files.length > 0) {
            const reader = new FileReader();

            reader.onload = function (e) {
                imagePreview.querySelector(".image-preview__image").src = e.target.result;
                imagePreview.querySelector(".image-preview__prompt").style.display = "none";
                dropZone.style.display = "none";
                imagePreview.style.display = "block";
                document.querySelector(".change-image-section").style.display = "block";
            };

            reader.readAsDataURL(files[0]);
        }
    }
});

// Récupérer les éléments nécessaires
const imagePreview = document.getElementById('imagePreview');
const changeImageText = document.getElementById('changeImageText');
const inputFile = document.getElementById('inputFile');

// Ajouter un gestionnaire d'événement au survol de l'image
imagePreview.addEventListener('mouseover', function () {
    changeImageText.style.display = 'block';
});

// Ajouter un gestionnaire d'événement lorsque la souris quitte l'image
imagePreview.addEventListener('mouseout', function () {
    changeImageText.style.display = 'none';
});

// Ajouter un gestionnaire d'événement de clic pour le texte "Changer l'image"
changeImageText.addEventListener('click', function () {
    inputFile.click(); // Déclencher le clic sur le champ de fichier
});