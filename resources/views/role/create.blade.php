<x-admin-layout>
<div id="addEmployeeModal" >
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="post" action="{{ route('roles.store') }}">
                @csrf
				<div class="modal-header">						
					<h4 class="modal-title">Add Roles</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">					
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