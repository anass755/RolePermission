<x-admin-layout>
<div class="container-xl">
	<div class="table-responsive">
		<div class="table-wrapper">
			<div class="table-title">
				<div class="row">
					<div class="col-sm-6">
						<h2>Manage <b>Permission Group</b></h2>
					</div>
					<div class="col-sm-6">
						<a href="{{ route('permissionGroup.create') }}" class="btn btn-success" ><i class="material-icons">&#xE147;</i> <span>Add Permission Group</span></a>
						<a href="#deleteEmployeeModal" class="btn btn-danger" data-toggle="modal"><i class="material-icons">&#xE15C;</i> <span>Delete</span></a>						
					</div>
				</div>
			</div>
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th>
						</th>
						<th>Name</th>
						<th>Sort Order</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
                    @foreach($permissions as $permission)
					<tr>
						<td>
						</td>
						<td>{{ $permission->name }}</td>
						<td>{{ $permission->sort_order }}</td>
						<td>
							<a href="{{ route('permissionGroup.edit',$permission->id) }}" class="edit" ><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
                            <form action="{{ route('permissionGroup.destroy',$permission->id) }}" method="post" class="d-flex">
                                @csrf
                                @method('DELETE')
                               <button type="submit" style="border:none"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></button>
                            </form>
							
						</td>
					</tr>
                    @endforeach
				</tbody>
			</table>
			<div class="clearfix">
				<div class="hint-text">Showing <b>5</b> out of <b>25</b> entries</div>
				<ul class="pagination">
					
				</ul>
			</div>
		</div>
	</div>        
</div>
<!-- Edit Modal HTML -->

<!-- Edit Modal HTML -->

<!-- Delete Modal HTML -->
<div id="deleteEmployeeModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form>
				<div class="modal-header">						
					<h4 class="modal-title">Delete Employee</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">					
					<p>Are you sure you want to delete these Records?</p>
					<p class="text-warning"><small>This action cannot be undone.</small></p>
				</div>
				<div class="modal-footer">
					<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
					<input type="submit" class="btn btn-danger" value="Delete">
				</div>
			</form>
		</div>
	</div>
</div>
</x-admin-layout>