<x-admin-layout>
<div id="addEmployeeModal" >
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="post" action="{{ route('products.update',$product->id) }}">
                @csrf
                @method('put')
				<div class="modal-header">						
					<h4 class="modal-title">Edit Product</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">					
					<div class="form-group">
						<label>Name</label>
						<input type="text" class="form-control" name="name" value="{{ $product->name }}">
					</div>
					<div class="form-group">
						<label>Description</label>
						<input type="text" class="form-control" name="description" value="{{ $product->description }}">
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