<div class="modal-body row">
    <!-- name -->
    <div class="form-group col-md-6 col-sm-3">
        <label>Name:</label>
        <input type="text" name="name" placeholder="Name" class="form-control name" required>
    </div>
    <!-- title -->
    <div class="form-group col-md-6 col-sm-3">
        <label>Title:</label>
        <input type="text" name="title" placeholder="Title" class="form-control title" required>
    </div>
    <!-- content -->
    <div class="form-group col-md-12">
        <label>Content:</label>
        <textarea type="text" name="content" placeholder="Content" class="form-control content"></textarea>
    </div>
    <!-- content_2 -->
    <div class="form-group col-md-12">
        <label>Content 2:</label>
        <textarea type="text" name="content_2" placeholder="Content 2" class="form-control content_2"></textarea>
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