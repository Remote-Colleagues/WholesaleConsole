
<script>
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

        // Event listener for filter changes
        document.querySelectorAll('.small-filter').forEach(function (filter) {
        filter.addEventListener('change', function () {
            // Build URL with selected filter values
            const filters = {};
                document.querySelectorAll('.small-filter').forEach(function (select) {
                const name = select.getAttribute('aria-label').replace(' Filter', '').toLowerCase();
                const value = select.value;
                if (value) {
                    filters[name] = value;
                }
            });

                // Reload the page with the new URL
                let url = window.location.pathname + '?';
                for (let key in filters) {
                if (filters.hasOwnProperty(key)) {
                    url += `${key}=${filters[key]}&`;
                }
            }
                window.location.href = url.slice(0, -1); // Remove the trailing '&'
            });
    });
    });

</script>
