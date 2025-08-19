@extends('layouts.admin')

@section('title', 'Agency Requests')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Agency Requests</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="requestsTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Company Name</th>
                                    <th>Email</th>
                                    <th>Contact Person</th>
                                    <th>Status</th>
                                    <th>Submitted Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($agencyRequests as $request)
                                <tr>
                                    <td>{{ $request->id }}</td>
                                    <td>{{ $request->company_name }}</td>
                                    <td>{{ $request->email }}</td>
                                    <td>{{ $request->contact_person_name }}</td>
                                    <td>
                                        <span class="badge badge-{{ $request->status === 'pending' ? 'warning' : ($request->status === 'approved' ? 'success' : 'danger') }}">
                                            {{ ucfirst($request->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $request->created_at->format('M d, Y H:i A') }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-info view-request-btn" data-id="{{ $request->id }}">
                                            <i class="fas fa-eye"></i> View
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- View Request Modal -->
<div class="modal fade" id="viewRequestModal" tabindex="-1" role="dialog" aria-labelledby="viewRequestModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewRequestModalLabel">Agency Request Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Content will be loaded via AJAX -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Include jQuery if not already included -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Include your custom JavaScript -->
<script src="{{ asset('js/agency-requests.js') }}"></script>

<!-- Optional: Include toastr for better notifications -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<!-- Optional: DataTables for better table functionality -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize DataTables if you want advanced table features
    $('#requestsTable').DataTable({
        responsive: true,
        order: [[0, 'desc']], // Order by ID descending
        columnDefs: [
            { orderable: false, targets: [6] } // Disable sorting on Actions column
        ]
    });
});
</script>
@endsection

@section('styles')
<style>
.modal-lg {
    max-width: 800px;
}

.badge {
    font-size: 0.875em;
}

.img-thumbnail {
    max-height: 150px;
}

.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}

.table th {
    border-top: none;
    font-weight: 600;
}

.card {
    box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
    border: none;
}

.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
}
</style>
@endsection