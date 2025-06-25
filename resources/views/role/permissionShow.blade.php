<x-admin-layout>
<form action="{{ route('permission.assign.store', $role) }}" method="post">
 @csrf
   
    @foreach($permissionGroups as $permissionGroup)
        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    {{ $permissionGroup->name }}
                </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show d-flex ml-4" aria-labelledby="headingOne" data-bs-parent="#accordionExample" >
                @foreach($permissionGroup->permissions as $permission)
                <div class="accordion-body ">
                <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" class="form-check-input">{{ $permission->name }}
                </div>
                @endforeach
                </div>
            </div>
        </div>
    @endforeach
    
 <button type="submit" class="btn btn-primary">Assign Permission</button>
 </form>
</x-admin-layout>