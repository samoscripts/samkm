document.addEventListener('DOMContentLoaded', (event) => {
    // refreshPdfList();
});

async function refreshPdfList() {
    try {
        const response = await fetch('/api/pdf-list');
        const data = await response.json();
        const pdfListContainer = document.getElementById('pdf-list-container');
        pdfListContainer.innerHTML = '';
        data.forEach(pdf => {
            const pdfItem = document.createElement('div');
            pdfItem.classList.add('mb-4', 'flex', 'items-center');
            pdfItem.innerHTML = `
                <a href="${pdf.url}" target="_blank" class="block text-blue-500 hover:underline mr-4">
                    <i class="fas fa-file-pdf"></i> ${pdf.name}
                </a>
                <a href="${pdf.url}" target="_blank" class="text-green-500 hover:text-green-700 mr-4">
                    <i class="fas fa-eye"></i> Show
                </a>
                <a href="${pdf.url}" download class="text-blue-500 hover:text-blue-700 mr-4">
                    <i class="fas fa-download"></i> Download
                </a>
                <a href="#" class="text-red-500 hover:text-red-700">
                    <i class="fas fa-times"></i>
                </a>
            `;
            pdfListContainer.appendChild(pdfItem);
        });
    } catch (error) {
        console.error('Error refreshing PDF list:', error);
    }
}

document.getElementById('form').addEventListener('submit', function(event) {
    event.preventDefault();
    const formData = new FormData(event.target);
    const data = Object.fromEntries(formData.entries());

    // Show the preloader
    document.getElementById('preloader').classList.remove('hidden');
    document.getElementById('pdf-list-container').innerHTML = '';

    fetch('/api/mileage', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            if (data.status === 'error') {
                alert(data.message);
                // Handle the error (e.g., display a message to the user)
            } else {
                // Clear the pdf-list-container element
                refreshPdfList();
            }
        })
        .catch(error => {
            console.error('Error:', error);
        })
        .finally(() => {
            // Hide the preloader
            document.getElementById('preloader').classList.add('hidden');
        });
});