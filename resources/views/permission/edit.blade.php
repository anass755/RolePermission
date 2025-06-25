<x-admin-layout>
<div id="addEmployeeModal" >
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="post" action="{{ route('permissions.update',$permission->id) }}">
                @csrf
                @method('PATCH')
				<div class="modal-header">						
					<h4 class="modal-title">Edit Permission </h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">					
					<div class="form-group">
						<label>Name</label>
						<input type="text" class="form-control" name="name" value="{{ $permission->name }}" required>
					</div>
					<div class="form-group">
						<label>Key</label>
						<input type="text" class="form-control" name="key" value="{{ $permission->key }}" required>
					</div>
					<div class="form-group">
						<label>Sort Order</label>
						<input type="text" class="form-control" name="sortorder" value="{{ $permission->sort_order }}" required>
					</div>				
				</div>
				<div class="modal-footer">
					<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
					<input type="submit" class="btn btn-success" value="Edit">
				</div>
			</form>
		</div>
	</div>
</div>
</x-admin-layout>