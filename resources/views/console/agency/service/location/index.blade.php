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
            
            <!-- Filter Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Filter Locations</h5>
                </div>
                <div class="card-body">
                    <form id="locations-filter" method="GET" action="{{route('console.agency.service.location.index', ['agency' => $agency->id, 'service' => $service->id])}}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="q" class="form-label">Search Location</label>
                                    <input id="q" name="q" type="text" class="form-control" placeholder="Search location…" value="{{ request('q') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select" name="status" id="status">
                                        <option value="">All statuses</option>
                                        @foreach ($statuses as $key => $value)
                                            <option value="{{ $key }}" @selected((string)request('status') === (string)$key)>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label class="form-label">&nbsp;</label>
                                    <div class="d-grid gap-2">
                                        <button class="btn btn-outline-secondary" type="submit" id="locations-filter-button">Filter</button>
                                        <a href="{{route('console.agency.service.location.index', ['agency' => $agency->id, 'service' => $service->id])}}" class="btn btn-outline-secondary" id="locations-reset-button">Reset</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Locations Cards -->
            <div class="row">
                @forelse($locations as $index => $location)
                    <div class="col-lg-6 col-xl-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h6 class="mb-0 text-primary">
                                    <i class="bi bi-geo-alt-fill me-2"></i>
                                    Location #{{ $locations->firstItem() + $index }}
                                </h6>
                                <span class="badge {{ $location->status == 'active' ? 'bg-success' : 'bg-secondary' }}">
                                    {{ ucfirst($location->status) }}
                                </span>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">{{ $location->name }}</h5>
                                
                                <div class="mb-3">
                                    <small class="text-muted">Service</small>
                                    <p class="mb-1">{{ $location->service->name ?? $service->name }}</p>
                                </div>

                                @if($location->latitude && $location->longitude)
                                    <div class="mb-3">
                                        <small class="text-muted">Coordinates</small>
                                        <p class="mb-1">
                                            <i class="bi bi-geo me-1"></i>
                                            {{ number_format($location->latitude, 6) }}, {{ number_format($location->longitude, 6) }}
                                        </p>
                                    </div>
                                @endif

                                @if($location->radius)
                                    <div class="mb-3">
                                        <small class="text-muted">Service Radius</small>
                                        <p class="mb-1">
                                            <i class="bi bi-circle me-1"></i>
                                            {{ $location->radius }} km
                                        </p>
                                    </div>
                                @endif

                                @if($location->pricing)
                                    <div class="mb-3">
                                        <small class="text-muted">Pricing</small>
                                        <p class="mb-1">
                                            <i class="bi bi-currency-dollar me-1"></i>
                                            {{ $location->pricing }}
                                        </p>
                                    </div>
                                @endif
                            </div>
                            <div class="card-footer bg-transparent">
                                <div class="d-flex gap-2">
                                    @canView('countries-edit')
                                        <a href="{{route('console.agency.service.location.edit', ['agency' => $agency->id, 'service' => $service->id, 'location' => $location->id])}}" 
                                           class="btn btn-sm btn-outline-primary flex-fill">
                                            <i class="bi bi-pencil me-1"></i>
                                            Edit
                                        </a>
                                    @endCanView
                                    @canView('countries-view')
                                        <a href="{{route('console.agency.service.location.show', ['agency' => $agency->id, 'service' => $service->id, 'location' => $location->id])}}" 
                                           class="btn btn-sm btn-outline-info flex-fill">
                                            <i class="bi bi-eye me-1"></i>
                                            View
                                        </a>
                                    @endCanView
                                    @canView('countries-delete')
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-danger"
                                                onclick="deleteLocation({{ $location->id }})">
                                            <i class="bi bi-trash me-1"></i>
                                            Delete
                                        </button>
                                    @endCanView
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body text-center py-5">
                                <i class="bi bi-geo-alt display-1 text-muted mb-3"></i>
                                <h4 class="text-muted">No locations found</h4>
                                <p class="text-muted mb-4">
                                    @if(request('q') || request('status'))
                                        No locations match your current filters. Try adjusting your search criteria.
                                    @else
                                        There are no locations for this service yet.
                                    @endif
                                </p>
                                @canView('countries-create')
                                    <a href="{{route('console.agency.service.location.create',['agency' => $agency->id,'service' => $service->id])}}" 
                                       class="btn btn-primary">
                                        <svg class="custom-add-icon">
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
    
    <!-- Pagination -->
    @if(isset($locations) && $locations->hasPages())
        <div class="row justify-content-center mt-4">
            <div class="col">
                <div class="d-flex justify-content-center">
                    {{ $locations->withQueryString()->links() }}
                </div>
            </div>
        </div>
    @endif

    @push('scripts')
    <script src="{{asset('assets/js/console/countries.js')}}"></script>
    <script>
        function deleteLocation(locationId) {
            if (confirm('Are you sure you want to delete this location?')) {
                // Add your delete logic here
                // You might want to submit a form or make an AJAX request
                console.log('Delete location:', locationId);
            }
        }
    </script>
    @endpush
</x-app-layout>