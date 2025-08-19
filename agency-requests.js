$(document).ready(function() {
    
    // View Agency Request Modal
    $(document).on('click', '.view-request-btn', function() {
        const requestId = $(this).data('id');
        
        $.ajax({
            url: `/admin/agency-requests/${requestId}`,
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function() {
                // Show loading spinner
                $('#viewRequestModal .modal-body').html('<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Loading...</div>');
                $('#viewRequestModal').modal('show');
            },
            success: function(response) {
                if (response.success) {
                    const data = response.data;
                    
                    // Populate modal with request data
                    const modalContent = `
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Company Name:</strong> ${data.company_name || 'N/A'}</p>
                                <p><strong>Email:</strong> ${data.email || 'N/A'}</p>
                                <p><strong>Phone:</strong> ${data.phone || 'N/A'}</p>
                                <p><strong>Contact Person:</strong> ${data.contact_person_name || 'N/A'}</p>
                                <p><strong>Address:</strong> ${data.address || 'N/A'}</p>
                                <p><strong>PIN:</strong> ${data.pin || 'N/A'}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>City:</strong> ${data.city || 'N/A'}</p>
                                <p><strong>State/Province:</strong> ${data.state_province || 'N/A'}</p>
                                <p><strong>Country:</strong> ${data.country || 'N/A'}</p>
                                <p><strong>Type of Services:</strong> ${data.type_of_services || 'N/A'}</p>
                                <p><strong>Status:</strong> <span class="badge badge-${getStatusClass(data.status)}">${data.status || 'Pending'}</span></p>
                                <p><strong>Submitted:</strong> ${formatDate(data.created_at)}</p>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <p><strong>Brief Description:</strong></p>
                                <p class="text-muted">${data.brief_description || 'No description provided'}</p>
                            </div>
                        </div>
                        ${data.logo_photo ? `
                            <div class="row mt-3">
                                <div class="col-12">
                                    <p><strong>Logo/Photo:</strong></p>
                                    <img src="${data.logo_photo}" alt="Company Logo" class="img-thumbnail" style="max-width: 200px;">
                                </div>
                            </div>
                        ` : ''}
                        ${data.attachment_license ? `
                            <div class="row mt-3">
                                <div class="col-12">
                                    <p><strong>License/Attachment:</strong></p>
                                    <a href="${data.attachment_license}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-download"></i> View Document
                                    </a>
                                </div>
                            </div>
                        ` : ''}
                        <div class="row mt-4">
                            <div class="col-12 text-center">
                                ${data.status === 'pending' ? `
                                    <button type="button" class="btn btn-success approve-btn" data-id="${data.id}">
                                        <i class="fas fa-check"></i> Approve
                                    </button>
                                    <button type="button" class="btn btn-danger reject-btn ml-2" data-id="${data.id}">
                                        <i class="fas fa-times"></i> Reject
                                    </button>
                                ` : `
                                    <p class="text-muted">This request has already been ${data.status}</p>
                                `}
                            </div>
                        </div>
                    `;
                    
                    $('#viewRequestModal .modal-body').html(modalContent);
                } else {
                    $('#viewRequestModal .modal-body').html('<div class="alert alert-danger">Error loading request details</div>');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                $('#viewRequestModal .modal-body').html('<div class="alert alert-danger">Error loading request details</div>');
            }
        });
    });

    // Approve Agency Request
    $(document).on('click', '.approve-btn', function() {
        const requestId = $(this).data('id');
        
        // Show confirmation dialog
        if (!confirm('Are you sure you want to approve this agency request? This will create a new agency record.')) {
            return;
        }
        
        processAgencyRequest(requestId, 'approve', $(this));
    });

    // Reject Agency Request
    $(document).on('click', '.reject-btn', function() {
        const requestId = $(this).data('id');
        
        // Show confirmation dialog
        if (!confirm('Are you sure you want to reject this agency request?')) {
            return;
        }
        
        processAgencyRequest(requestId, 'reject', $(this));
    });

    // Function to process agency request (approve/reject)
    function processAgencyRequest(requestId, action, buttonElement) {
        const originalText = buttonElement.html();
        
        $.ajax({
            url: '/admin/agency-requests/approve',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                request_id: requestId,
                action: action
            },
            beforeSend: function() {
                // Disable buttons and show loading
                $('.approve-btn, .reject-btn').prop('disabled', true);
                buttonElement.html('<i class="fas fa-spinner fa-spin"></i> Processing...');
            },
            success: function(response) {
                if (response.success) {
                    // Show success message
                    showNotification('success', response.message);
                    
                    // Close modal
                    $('#viewRequestModal').modal('hide');
                    
                    // Refresh the requests table/list
                    if (typeof refreshRequestsTable === 'function') {
                        refreshRequestsTable();
                    } else {
                        // Reload page if refresh function doesn't exist
                        location.reload();
                    }
                } else {
                    showNotification('error', response.message || 'An error occurred');
                    // Re-enable buttons
                    $('.approve-btn, .reject-btn').prop('disabled', false);
                    buttonElement.html(originalText);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                let errorMessage = 'An error occurred while processing the request';
                
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                
                showNotification('error', errorMessage);
                
                // Re-enable buttons
                $('.approve-btn, .reject-btn').prop('disabled', false);
                buttonElement.html(originalText);
            }
        });
    }

    // Helper function to get status class for badges
    function getStatusClass(status) {
        switch(status) {
            case 'pending': return 'warning';
            case 'approved': return 'success';
            case 'rejected': return 'danger';
            default: return 'secondary';
        }
    }

    // Helper function to format date
    function formatDate(dateString) {
        if (!dateString) return 'N/A';
        
        const date = new Date(dateString);
        return date.toLocaleDateString() + ' ' + date.toLocaleTimeString();
    }

    // Helper function to show notifications
    function showNotification(type, message) {
        // You can customize this based on your notification system
        // Using toastr as an example
        if (typeof toastr !== 'undefined') {
            toastr[type](message);
        } else {
            // Fallback to alert
            alert(message);
        }
    }

    // Optional: Function to refresh requests table
    function refreshRequestsTable() {
        // If you're using DataTables
        if ($.fn.DataTable && $('#requestsTable').length) {
            $('#requestsTable').DataTable().ajax.reload();
            return;
        }
        
        // If you're using a custom table, reload the data
        loadAgencyRequests();
    }

    // Optional: Load agency requests for index page
    function loadAgencyRequests() {
        $.ajax({
            url: '/admin/agency-requests',
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    // Update your table with the new data
                    updateRequestsTable(response.data);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error loading requests:', error);
            }
        });
    }

    // Optional: Update requests table HTML
    function updateRequestsTable(requests) {
        const tableBody = $('#requestsTable tbody');
        tableBody.empty();
        
        requests.forEach(function(request) {
            const row = `
                <tr>
                    <td>${request.id}</td>
                    <td>${request.company_name}</td>
                    <td>${request.email}</td>
                    <td>${request.contact_person_name}</td>
                    <td><span class="badge badge-${getStatusClass(request.status)}">${request.status}</span></td>
                    <td>${formatDate(request.created_at)}</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-info view-request-btn" data-id="${request.id}">
                            <i class="fas fa-eye"></i> View
                        </button>
                    </td>
                </tr>
            `;
            tableBody.append(row);
        });
    }
});