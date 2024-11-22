const imageInput = document.getElementById('foto');
const canvas = document.getElementById('canvas');
const ctx = canvas.getContext('2d');
const foto = document.querySelector('.poster img');
const formule = document.querySelector('#aanmaken form');
// imageInput.addEventListener('change', handleFileSelect);
let compressedImageBlob = null;

function handleFileSelect(event) {
    const file = event.target.files[0];
    if (file && file.type.startsWith('image/')) {
        const img = new Image();

        img.onload = () => {
            // Set the desired output size (width and height)
            const maxWidth = 600;  // Set the desired width
            const maxHeight = 450; // Set the desired height

            // Calculate the new dimensions based on the aspect ratio
            let width = img.width;
            let height = img.height;

            // Maintain aspect ratio while resizing
            if (width > height) {
                if (width > maxWidth) {
                    height *= maxWidth / width;
                    width = maxWidth;
                }
            } else {
                if (height > maxHeight) {
                    width *= maxHeight / height;
                    height = maxHeight;
                }
            }

            // Set canvas size to match the new image size
            canvas.width = width;
            canvas.height = height;

            // Draw the image on the canvas with the new size
            ctx.drawImage(img, 0, 0, width, height);

            // Compress and export the resized image as a JPEG (you can change to PNG or other formats)
            const compressedImage = canvas.toDataURL('image/jpeg', 0.2); // 0.7 is the quality (0-1)
            

            /* OPZICHSTAAND DING OM FOTOLIMIET TE EISEN */
            const file = imageInput.files[0];
    
            if (file) { // Ensure a file is selected
                if (file.size > sizeLimit) {
                    alert('De afbeelding is te groot. Kies een afbeelding kleiner dan 5 MB.');
                    // Clear the file input to prevent form submission with the large file
                    imageInput.value = '';
                    foto.src = ''
                } else {
                    foto.src = img.src;
                }
            }

            
            // Convert the compressed image (data URL) to a Blob
            const byteString = atob(compressedImage.split(',')[1]); // Decode base64
            const arrayBuffer = new ArrayBuffer(byteString.length);
            const uintArray = new Uint8Array(arrayBuffer);

            // Copy the bytes into the array
            for (let i = 0; i < byteString.length; i++) {
                uintArray[i] = byteString.charCodeAt(i);
            }

            // Create a Blob from the Uint8Array
            compressedImageBlob = new Blob([uintArray], { type: 'image/jpeg' });
            console.log('Compressed image Blob:', compressedImageBlob);
        };

        img.src = URL.createObjectURL(file);
    } else {
        alert('Please select a valid image file.');
    }
}
    



let sliderZoom = document.querySelector('#zoom');
let sliderHorizontaal = document.querySelector('#horizontaal');
let sliderVerticaal = document.querySelector('#verticaal');
let fotokader = document.querySelector('figure')
let sliders = document.querySelector('#sliders')
let colorPicker = document.querySelector('input[type="color"');
// let achtergrond = document.querySelector('#achtergrond')

// achtergrond.addEventListener('change', (e) => {
//     console.log(e.target.value);
//     placeholder.remove();
//     fotokader.style.backgroundImage = "url('./media/achtergronden/" + e.target.value + "')";
// });

if (foto.src && foto.src !== "") {
    sliders.style.display = "inherit";
}

let scaleValue = (sliderZoom.value / 100);
let horizontaal = sliderHorizontaal.value;
let verticaal = sliderVerticaal.value;
foto.style.scale = scaleValue;
foto.style.transform = "translate(-" + (50/scaleValue) + "%, -" + (50/scaleValue) + "%)"
foto.style.top = verticaal + "%";
foto.style.left = horizontaal + "%";

let uploadButton = document.querySelector('input[type="file"]');
uploadButton.addEventListener('change', handleFileSelect);
//     const currFiles = e.target.files
//     if(currFiles.length > 0){
//         let src = URL.createObjectURL(currFiles[0])
//         foto.src = src
//     } else {
//         foto.src = ""
//     }
// })

sliderZoom.addEventListener('input', (e) => {
    scaleValue = (e.target.value / 100);
    foto.style.scale = scaleValue;
    foto.style.transform = "translate(-" + (50/scaleValue) + "%, -" + (50/scaleValue) + "%)"
})


sliderVerticaal.addEventListener('input', (e) => {
    verticaal = e.target.value
    foto.style.top = verticaal + "%";
})

sliderHorizontaal.addEventListener('input', (e) => {
    horizontaal = e.target.value
    foto.style.left = horizontaal + "%";
})

colorPicker.addEventListener('input', (e) => {
    fotokader.style.backgroundColor = e.target.value;
});

formule.addEventListener('submit', function (event) {
    // Only prevent default if no image is compressed yet
    if (!compressedImageBlob) {
        alert('No image has been compressed yet.');
        event.preventDefault(); // Prevent the form from submitting
        return;
    }

    // Create a new hidden file input element
    const newFileInput = document.createElement('input');
    newFileInput.type = 'file';
    newFileInput.name = 'miniatuur'; // The name that the server will use to access the file
    newFileInput.style.display = 'none'; // Hide the input element

    // Create a DataTransfer object to simulate file selection
    const dataTransfer = new DataTransfer();
    dataTransfer.items.add(new File([compressedImageBlob], 'compressed_image.jpg'));
    newFileInput.files = dataTransfer.files;

    // Append the new file input to the form
    formule.appendChild(newFileInput);

    console.log('File input added:', dataTransfer.files);

});

// Set the size limit in bytes (5 MB = 5 * 1024 * 1024)
const sizeLimit = 1  * 1024 * 1024;


// // Add an event listener for file input changes
// imageInput.addEventListener('change', function () {
//     // Get the file from the input
//     const file = imageInput.files[0];
    
//     if (file) { // Ensure a file is selected
//         if (file.size > sizeLimit) {
//             alert('De afbeelding is te groot. Kies een afbeelding kleiner dan 5 MB.');
//             // Clear the file input to prevent form submission with the large file
//             imageInput.value = '';
//             foto.src = ''
//         }
//     }
// });