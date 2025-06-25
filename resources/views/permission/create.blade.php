<x-admin-layout>
<div id="addEmployeeModal" >
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="post" action="{{ route('permissions.store') }}">
                @csrf
				<div class="modal-header">						
					<h4 class="modal-title">Add Permission </h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">	
					<div class="form-group">
						<select name="permissionGroup" id="" class="form-control">
							<option value="">Select Any Permission Group</option>
							@foreach($permissionGroups as $permissionGroup)
							<option value="{{ $permissionGroup->id }}">{{ $permissionGroup->name }}</option>
							@endforeach
						</select>
					</div>				
					<div class="form-group">
						<label>Name</label>
						<input type="text" class="form-control" name="name" required>
					</div>
					<div class="form-group">
						<label>Key</label>
						<input type="text" class="form-control" name="key" required>
					</div>
					@error('key')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
					<div class="form-group">
						<label>Sort Order</label>
						<input type="text" class="form-control" name="sortorder" required>
					</div>				
				</div>
				<div class="modal-footer">
					<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
					<input type="submit" class="btn btn-success" value="Add">
				</div>
			</form>
		</div>
	</div>
</div>
</x-admin-layout>