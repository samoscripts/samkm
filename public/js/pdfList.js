document.addEventListener('DOMContentLoaded', (event) => {
    // refreshPdfList();
});

async function refreshPdfList() {
    try {
        const response = await fetch('/api/v1/mileagelog');
        const data = await response.json();
        const pdfListContainer = document.getElementById('pdf-list-container');
        pdfListContainer.innerHTML = '';
        data.forEach(pdf => {
            const pdfItem = document.createElement('div');
            pdfItem.classList.add('mb-0', 'flex', 'items-center');
            pdfItem.innerHTML = `
                <div class="flex items-center justify-between p-1 bg-gray-100 w-full">
                    <div class="flex items-center mr-4">
                        <i class="fas fa-file-pdf text-red-500 mr-2"></i>
                        <span class="font-semibold">${pdf.name}</span>
                    </div>
                    <div class="flex items-center">
                        <a href="${pdf.url}" target="_blank" class="text-green-500 hover:text-green-700 mr-4 flex items-center" title="Pokaż">
                            <i class="fas fa-eye mr-1"></i> 
                        </a>
                        <a href="${pdf.url}" class="text-blue-500 hover:text-blue-700 flex items-center" title="Pobierz">
                            <i class="fas fa-download mr-1"></i>
                        </a>
                    </div>
                </div>
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

    fetch('/api/v1/mileagelog', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
        .then(response => response.json())
        .then(data => {
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
