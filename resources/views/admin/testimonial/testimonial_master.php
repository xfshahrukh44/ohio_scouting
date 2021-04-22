<div class="modal-body row">
    <!-- name -->
    <div class="form-group col-md-12 col-sm-3">
        <label>Name:</label>
        <input type="text" name="name" placeholder="Name" class="form-control name" required>
    </div>
    <!-- designation -->
    <div class="form-group col-md-12 col-sm-3">
        <label>Designation:</label>
        <input type="text" name="designation" placeholder="Designation" class="form-control designation" required>
    </div>
    <!-- description -->
    <div class="form-group col-md-12">
        <label>Description:</label>
        <textarea type="text" name="description" placeholder="Description" class="form-control description"></textarea>
    </div>
    <!-- image -->
    <div class="form-group col-md-12">
        <label>Image:</label>
        <input type="file" name="image" placeholder="Image" class="form-control image">
        <div class="col-md-3 preview_wrapper" hidden>
            <img src="<?php echo(asset('img/noimg.jpg')); ?>" class="preview_image" alt="" width="100%">
        </div>
    </div>
    <!-- status -->
    <div class="form-group col-md-12">
        <label>Status:</label>
        <br>
        <label class="switch">
            <input type="checkbox" name="status" class="status form-control">
            <span class="slider"></span>
        </label>
    </div>
    </label>
</div>