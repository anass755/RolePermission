<x-admin-layout>
<div id="addEmployeeModal" >
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="post" action="{{ route('users.store') }}">
                @csrf
				<div class="modal-header">						
					<h4 class="modal-title">Add Users</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">					
					<div class="form-group">
						<label>Name</label>
						<input type="text" class="form-control" name="name" required>
					</div>
					@error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
					<div class="form-group">
						<label>Email</label>
						<input type="text" class="form-control" name="email" required>
					</div>
					@error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
					<div class="form-group">
						<label>Password</label>
						<input type="password" class="form-control" name="password" required>
					</div>	
					@error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
					<div class="form-group">
						<label>Confirm Password</label>
						<input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
					</div>
					@error('password_confirmation')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror	
					<div class="form-group">
						<label for="role">Role</label>
						<div>
							@foreach($roles as $role)
							<div>
								<input type="checkbox"  id="" name="roles[]" value="{{ $role->id }}">{{ $role->name }}
							</div>
								
							@endforeach
						</div>
						
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
