<x-app-layout :breadcrumbs="$breadcrumbs">
    <div class="row justify-content-center mt-2">
        <div class="col">
            <div class="row">
                <div class="col-md-4">  
                    <h3>Add Agency Service Location</h3>
                </div>
                <div class="col-md-8 text-end">  
                    <a href="" class="btn btn-primary mb-3">
                        <svg class="custom-back-icon">
                            <use xlink:href="{{ asset('assets/icons/custom/symbol-defs.svg')}}#custom-back"></use>
                        </svg>   
                        Back
                    </a>
                </div>
            </div>
            <div class="card">
                <form method="POST" action="">
                    @csrf
                    
                    <div class="card-body">
                        <div class="row">
                            <!-- Agency Name Field -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="agency_name">Agency Name*</label>
                                <input id="agency_name" class="form-control" type="text" name="agency_name" value="{{ old('agency_name') }}" />
                                <x-input-error :messages="$errors->get('agency_name')" class="mt-2" />
                            </div>

                            <!-- Service Name Field -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="service_name">Service Name*</label>
                                <input id="service_name" class="form-control" type="text" name="service_name" value="{{ old('service_name') }}" />
                                <x-input-error :messages="$errors->get('service_name')" class="mt-2" />
                            </div>
                            
                            <!-- Location Title Field (NEW) -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="location_title">Location Title*</label>
                                <input id="location_title" class="form-control" type="text" name="location_title" value="{{ old('location_title') }}" placeholder="Enter location title" />
                                <x-input-error :messages="$errors->get('location_title')" class="mt-2" />
                            </div>
                            
                            <!-- Location Field -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="location">Location*</label>
                                <input id="location" class="form-control" type="text" name="location" value="{{ old('location') }}" />
                                <x-input-error :messages="$errors->get('location')" class="mt-2" />
                            </div>
                            
                            <!-- Map Integration Section -->
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Select Location on Map</label>
                                <div id="map" style="height: 400px; width: 100%; border: 2px solid #ccc; border-radius: 8px;"></div>
                                <!-- Display fields -->
                                <div class="row mt-3">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Latitude</label>
                                        <input id="latitude" class="form-control" type="text" name="latitude" readonly>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Longitude</label>
                                        <input id="longitude" class="form-control" type="text" name="longitude" readonly>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Status Field -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="status">Status*</label>
                                <select class="form-select" name="status" id="status">
                                    <option value="">--Select--</option>
                                    @foreach($statuses as $key => $value)
                                        <option value="{{ $key }}" {{ old('status') == $key ? 'selected' : '' }}>
                                            {{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>
                            
                            <!-- Serving Radius Field (NEW) -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="serving_radius">Serving Radius (in KM)*</label>
                                <input id="serving_radius" class="form-control" type="number" name="serving_radius" value="{{ old('serving_radius') }}" placeholder="Enter radius in kilometers" step="0.01" min="0" />
                                <x-input-error :messages="$errors->get('serving_radius')" class="mt-2" />
                            </div>
                            
                            <!-- Location Pricing Field (NEW) -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="location_pricing">Location Pricing*</label>
                                <input id="location_pricing" class="form-control" type="number" name="location_pricing" value="{{ old('location_pricing') }}" placeholder="Enter price" step="0.01" min="0" />
                                <x-input-error :messages="$errors->get('location_pricing')" class="mt-2" />
                            </div>
                            
                            <!-- Price Units Field -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="price_unit_id">Price Units*</label>
                                <select name="price_unit_id" class="form-select" id="price_unit_id">
                                    <option value="">--Select--</option>
                                    @foreach($priceUnits as $priceUnit)
                                        <option value="{{ $priceUnit->id }}" {{ old('price_unit_id') == $priceUnit->id ? 'selected' : '' }}>
                                            {{ $priceUnit->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('price_unit_id')" class="mt-2" />
                            </div>
                            
                            <!-- Submit Button -->
                            <div class="col-md-12 mb-3">
                                <button type="submit" class="btn btn-dark">Create</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

        <script>
        $(function () {

            $('#country_id').on('change', function () {
                let country_id = $(this).val();
                $('#state_id').html('<option value="">SELECT STATE</option>');
                $('#city_id').html('<option value="">SELECT CITY</option>');
                if (country_id) {
                    $.get(`{{ route('console.get-state', '') }}/${country_id}`, function(states) {
                        $('#state_id').empty().append('<option value="">SELECT STATE</option>');
                        $.each(states, function(key, state) {
                            $('#state_id').append(`<option value="${state.id}">${state.name}</option>`);
                        });
                    });
                }
            });

            $('#state_id').on('change', function () {
                let state_id = $(this).val();
                $('#city_id').html('<option value="">SELECT CITY</option>');
                if (state_id) {
                    $.get(`{{ url('console/get-city') }}/${state_id}`, function(cities) {
                        $('#city_id').empty().append('<option value="">SELECT CITY</option>');
                        $.each(cities, function(key, city) {
                            $('#city_id').append(`<option value="${city.id}">${city.name}</option>`);
                        });
                    });
                }
            });
           
            var map = L.map('map').setView([56.1304, -106.3468], 4);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: '300',
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            var marker;
            var defaultCoords = [45.4215, -75.6998];

            $('#country_id, #city_id, #state_id').on('change', handleLocationChange);

            async function handleLocationChange() {
                const country = $('#country_id option:selected').text();
                const city = $('#city_id option:selected').text();
                const state = $('#state_id option:selected').text();

                if (country && country !== 'SELECT COUNTRY') {
                    await geocodeLocation(country, city, state);
                }
            }

            async function geocodeLocation(country, city, state) {
                try {
                    let queryParts = [];

                    if (city && city !== 'SELECT CITY') {
                        queryParts.push(city);
                    }
                    if (state && state !== 'SELECT STATE') {
                        queryParts.push(state);
                    }
                    if (country && country !== 'SELECT COUNTRY') {
                        queryParts.push(country);
                    }

                    let query = queryParts.join(', ');

                    const response = await fetch(
                        `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&limit=1`
                    );
                    const data = await response.json();

                    if (data.length > 0) {
                        const lat = parseFloat(data[0].lat);
                        const lng = parseFloat(data[0].lon);
                        await updateLocation(lat, lng);
                        map.setView([lat, lng], 10);
                    }
                } catch (error) {
                    console.error('Geocoding error:', error);
                }
            }

            async function updateLocation(lat, lng) {
                if (marker) {
                    marker.setLatLng([lat, lng]);
                } else {
                    marker = L.marker([lat, lng], {
                        draggable: true,
                        title: "Selected Location"
                    }).addTo(map);

                    marker.on('dragend', async function () {
                        const newPos = marker.getLatLng();
                        await updateLocation(newPos.lat, newPos.lng);
                    });
                }

                $('#latitude').val(lat.toFixed(6));
                $('#longitude').val(lng.toFixed(6));

                const address = await getAddress(lat, lng);
                marker.bindPopup(address).openPopup();
                map.panTo([lat, lng]);
            }

            async function getAddress(lat, lng) {
                try {
                    const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`);
                    const data = await response.json();
                    return data.display_name || "Address not found";
                } catch (error) {
                    console.error("Geocoding error:", error);
                    return "Could not retrieve address";
                }
            }

            updateLocation(defaultCoords[0], defaultCoords[1]);

            map.on('click', async function (e) {
                await updateLocation(e.latlng.lat, e.latlng.lng);
            });

        });
        </script>
    @endpush
</x-app-layout>