document.addEventListener('DOMContentLoaded', function() {
    // Get the Add button and file input
    const addButton = document.querySelector('.btn-add');
    const fileInput = document.getElementById('csv-upload');
    const uploadForm = document.getElementById('csv-upload-form');

    // When the Add button is clicked, trigger the file input dialog
    addButton.addEventListener('click', function() {
        fileInput.click();  // This opens the file dialog
    });

    // When a file is selected, submit the form
    fileInput.addEventListener('change', function() {
        if (fileInput.files.length > 0) {
            uploadForm.submit();  // Submit the form after file selection
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {
    let expandedRow = null;

    document.querySelectorAll('.toggle-details').forEach(function (button) {
        button.addEventListener('click', function (e) {
            e.preventDefault();

            const auctionId = this.getAttribute('data-auction-id');
            const detailsRow = document.getElementById(`details-${auctionId}`);
            const expandButton = this.parentElement.querySelector('.toggle-details:not(.d-none)');
            const revertButton = this.parentElement.querySelector('.toggle-details.d-none');

            // Close previously expanded row if another row is expanded
            if (expandedRow && expandedRow !== detailsRow) {
                expandedRow.classList.add('d-none');
                const prevParent = expandedRow.previousElementSibling;
                prevParent.querySelector('.toggle-details:not(.d-none)').classList.remove('d-none');
                prevParent.querySelector('.toggle-details.d-none').classList.add('d-none');
            }

            // Toggle current row
            if (detailsRow.classList.contains('d-none')) {
                detailsRow.classList.remove('d-none');
                expandButton.classList.add('d-none');
                revertButton.classList.remove('d-none');
                expandedRow = detailsRow;
            } else {
                detailsRow.classList.add('d-none');
                expandButton.classList.remove('d-none');
                revertButton.classList.add('d-none');
                expandedRow = null;
            }
        });
    });

    document.querySelectorAll('.small-filter').forEach(function (filter) {
        filter.addEventListener('change', function () {
            // Collect all selected filter values
            const filters = {};
            document.querySelectorAll('.small-filter').forEach(function (select) {
                const name = select.getAttribute('aria-label').replace(' Filter', '').toLowerCase();
                const value = select.value;
                if (value) {
                    filters[name] = value;
                }
            });

            // Build URL with selected filters
            const params = new URLSearchParams(filters);
            window.location.href = `${window.location.pathname}?${params.toString()}`;
        });
    });

});
