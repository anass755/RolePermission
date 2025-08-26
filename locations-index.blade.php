<x-app-layout :breadcrumbs="$breadcrumbs">
    <div class="row justify-content-center mt-2">
        <div class="col">
            <div class="row">
             <div class="col-8">
                <h3 class="fw-bold text-primary d-flex align-items-center gap-2">
                    <i class="bi bi-geo-alt-fill text-primary">
                        <span>Locations for {{ $agency->name }} – 
                            <span class="text-dark">
                                {{ strToUpper($service->name)  }}
                            </span> Service
                        </span>
                    </i> 
                        
                </h3>
            </div>
                @canView('countries-create')
                    <div class="col-4 text-end">
                        <a href="{{route('console.agency.service.location.create',['agency' => $agency->id,'service' => $service->id])}}" class="btn btn-primary mb-3">
                            <svg class="custom-add-icon">
                                <use xlink:href="{{ asset('assets/icons/custom/symbol-defs.svg')}}#custom-plus"></use>
                            </svg>   
                            Add
                        </a>
                    </div>
                @endCanView
            </div>
            <div class="card">
                <div class="card-header">
                    <form id="locations-filter" method="GET" action="{{route('console.agency.service.location.index', ['agency' => $agency->id, 'service' => $service->id])}}">
                        <div class="row pt-2">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <input id="q" name="q" type="text" class="form-control" placeholder="Search location…" value="{{ request('q') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <select class="form-select" name="status" id="status">
                                        <option value="">All statuses</option>
                                        @foreach ($statuses as $key => $value)
                                            <option value="{{ $key }}" @selected((string)request('status') === (string)$key)>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3 text-end">
                                    <button class="btn btn-outline-secondary" type="submit" id="locations-filter-button">Filter</button>
                                    <a href="" class="btn btn-outline-secondary" id="locations-reset-button">Reset</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card-body">
                    <div class="row g-3" id="locations-container">
                        @forelse($locations as $index => $location)
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="card h-100 shadow-sm border-0 location-card">
                                    <div class="card-header bg-light border-0 d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-primary me-2">#{{ $index + 1 }}</span>
                                            <h6 class="mb-0 fw-bold text-truncate">{{ $location->name }}</h6>
                                        </div>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                Actions
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                @canView('locations-show')
                                                    <li>
                                                        <a class="dropdown-item" href="{{route('console.agency.service.location.show', ['agency' => $agency->id, 'service' => $service->id, 'location' => $location->id])}}">
                                                            <i class="bi bi-eye me-2"></i>View
                                                        </a>
                                                    </li>
                                                @endCanView
                                                @canView('locations-edit')
                                                    <li>
                                                        <a class="dropdown-item" href="{{route('console.agency.service.location.edit', ['agency' => $agency->id, 'service' => $service->id, 'location' => $location->id])}}">
                                                            <i class="bi bi-pencil me-2"></i>Edit
                                                        </a>
                                                    </li>
                                                @endCanView
                                                @canView('locations-delete')
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li>
                                                        <form action="{{route('console.agency.service.location.destroy', ['agency' => $agency->id, 'service' => $service->id, 'location' => $location->id])}}" method="POST" class="d-inline delete-form">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item text-danger">
                                                                <i class="bi bi-trash me-2"></i>Delete
                                                            </button>
                                                        </form>
                                                    </li>
                                                @endCanView
                                            </ul>
                                        </div>
                                    </div>
                                    
                                    <div class="card-body">
                                        <div class="row g-2 mb-3">
                                            <div class="col-12">
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="bi bi-building text-muted me-2"></i>
                                                    <small class="text-muted">Service:</small>
                                                </div>
                                                <p class="mb-0 fw-medium">{{ $location->service->name ?? 'N/A' }}</p>
                                            </div>
                                        </div>

                                        <div class="row g-2 mb-3">
                                            <div class="col-6">
                                                <div class="d-flex align-items-center mb-1">
                                                    <i class="bi bi-geo-alt text-muted me-2"></i>
                                                    <small class="text-muted">Coordinates:</small>
                                                </div>
                                                <p class="mb-0 small">
                                                    @if($location->latitude && $location->longitude)
                                                        {{ number_format($location->latitude, 6) }}, {{ number_format($location->longitude, 6) }}
                                                    @else
                                                        Not set
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="col-6">
                                                <div class="d-flex align-items-center mb-1">
                                                    <i class="bi bi-circle text-muted me-2"></i>
                                                    <small class="text-muted">Radius:</small>
                                                </div>
                                                <p class="mb-0 small">{{ $location->radius ?? 'N/A' }} km</p>
                                            </div>
                                        </div>

                                        <div class="row g-2 mb-3">
                                            <div class="col-12">
                                                <div class="d-flex align-items-center mb-1">
                                                    <i class="bi bi-currency-dollar text-muted me-2"></i>
                                                    <small class="text-muted">Pricing:</small>
                                                </div>
                                                <p class="mb-0">
                                                    @if($location->pricing)
                                                        <span class="fw-bold text-success">${{ number_format($location->pricing, 2) }}</span>
                                                    @else
                                                        <span class="text-muted">Not set</span>
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-footer bg-white border-0 pt-0">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                @if($location->status == 'active')
                                                    <span class="badge bg-success">
                                                        <i class="bi bi-check-circle me-1"></i>Active
                                                    </span>
                                                @elseif($location->status == 'inactive')
                                                    <span class="badge bg-danger">
                                                        <i class="bi bi-x-circle me-1"></i>Inactive
                                                    </span>
                                                @else
                                                    <span class="badge bg-warning">
                                                        <i class="bi bi-exclamation-triangle me-1"></i>{{ ucfirst($location->status) }}
                                                    </span>
                                                @endif
                                            </div>
                                            @canView('locations-show')
                                                <a href="{{route('console.agency.service.location.show', ['agency' => $agency->id, 'service' => $service->id, 'location' => $location->id])}}" class="btn btn-sm btn-outline-primary">
                                                    View Details <i class="bi bi-arrow-right ms-1"></i>
                                                </a>
                                            @endCanView
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="card border-0 bg-light">
                                    <div class="card-body text-center py-5">
                                        <i class="bi bi-geo-alt text-muted" style="font-size: 3rem;"></i>
                                        <h5 class="text-muted mt-3">No locations found</h5>
                                        <p class="text-muted mb-3">There are no locations matching your search criteria.</p>
                                        @canView('countries-create')
                                            <a href="{{route('console.agency.service.location.create',['agency' => $agency->id,'service' => $service->id])}}" class="btn btn-primary">
                                                <svg class="custom-add-icon me-1">
                                                    <use xlink:href="{{ asset('assets/icons/custom/symbol-defs.svg')}}#custom-plus"></use>
                                                </svg>   
                                                Add First Location
                                            </a>
                                        @endCanView
                                    </div>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center mt-3">
        <div class="col">
            {{-- {{ $locations->links() }} --}}
        </div>
    </div>

    @push('styles')
    <style>
        .location-card {
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }
        
        .location-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        }

        .location-card .card-header {
            border-bottom: 1px solid rgba(0, 0, 0, 0.125);
        }

        .location-card .card-body {
            padding: 1rem;
        }

        .location-card .card-footer {
            background-color: #f8f9fa !important;
            border-top: 1px solid rgba(0, 0, 0, 0.125);
        }

        @media (max-width: 768px) {
            .location-card .card-header h6 {
                font-size: 0.9rem;
            }
            
            .location-card .card-body {
                padding: 0.75rem;
            }
        }
    </style>
    @endpush

    @push('scripts')
    <script src="{{asset('assets/js/console/countries.js')}}"></script>
    <script>
        // Handle delete confirmation
        document.addEventListener('DOMContentLoaded', function() {
            const deleteForms = document.querySelectorAll('.delete-form');
            deleteForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    if (confirm('Are you sure you want to delete this location? This action cannot be undone.')) {
                        this.submit();
                    }
                });
            });
        });
    </script>
    @endpush
</x-app-layout>