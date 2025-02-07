

<!-- Dialog Box (Modal) -->
<div id="statusModal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Change Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="statusMessage">Are you sure you want to change the status?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="confirmStatusChange">Confirm</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Trigger dialog box when status is clicked
        $('#status').click(function() {
            var currentStatus = $(this).data('status');
            var newStatus = currentStatus === 'active' ? 'inactive' : 'active';
            $('#statusMessage').text('Are you sure you want to ' + newStatus + ' this user?');

            $('#statusModal').data('newStatus', newStatus).modal('show');
        });

        // Confirm status change
        $('#confirmStatusChange').click(function() {
            var newStatus = $('#statusModal').data('newStatus');
            $.ajax({
                url: '/update-status', // Your route to update status
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    status: newStatus,
                    user_id: {{ $user->id }}
                },
                success: function(response) {
                    if (response.success) {
                        $('#status').text(newStatus).data('status', newStatus);
                        $('#statusModal').modal('hide');
                    }
                },
                error: function() {
                    alert('There was an error updating the status.');
                }
            });
        });
    });
</script>
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

</script>
