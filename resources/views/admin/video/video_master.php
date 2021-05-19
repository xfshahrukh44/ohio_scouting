<div class="modal-body row">
    <!-- title -->
    <div class="form-group col-md-6 col-sm-3">
        <label>Title:</label>
        <input type="text" name="title" placeholder="Title" class="form-control title" required>
    </div>
    <!-- image -->
    <div class="form-group col-md-6">
        <label>Image:</label>
        <input type="file" name="image" placeholder="Image" class="form-control image">
        <div class="col-md-3 preview_wrapper" hidden>
            <img src="<?php echo(asset('img/noimg.jpg')); ?>" class="preview_image" alt="" width="100%">
        </div>
    </div>
    <!-- type -->
    <div class="form-group col-md-6">
        <label>Type:</label>
        <select name="type" class="form-control type" required>
            <option value="">Select Type</option>
            <option value="Newest">Newest</option>
            <option value="Featured">Featured</option>
            <option value="Popular">Popular</option>
        </select>
    </div>
    <!-- link -->
    <div class="form-group col-md-6 col-sm-3">
        <label>Link:</label>
        <input type="text" name="link" placeholder="Link" class="form-control link" required>
    </div>
</div>