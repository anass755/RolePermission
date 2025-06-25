<x-admin-layout>
<div id="addEmployeeModal" >
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="post" action="{{ route('users.update',$user->id) }}">
                @csrf
				@method('PUT')
				<div class="modal-header">						
					<h4 class="modal-title">Edit Users</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">					
					<div class="form-group">
						<label>Name</label>
						<input type="text" class="form-control" name="name" value="{{ $user->name }}"required>
					</div>
					<div class="form-group">
						<label>Email</label>
						<input type="text" class="form-control" name="email" value="{{ $user->email }}" required>
					</div>
					 @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror 
					<label for="role">Role</label>
					@foreach($roles as $role)
					<div>
						<input type="checkbox"  @checked($user->roles->contains($role->id)) id="" name="roles[]" value="{{ $role->id }}">{{ $role->name }}
					</div>	
					@endforeach	
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