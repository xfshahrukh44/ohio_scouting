<div class="modal-body row">
    <!-- title -->
    <div class="form-group col-md-4 col-sm-3">
        <label>Title:</label>
        <input type="text" name="title" placeholder="Title" class="form-control title" required>
    </div>
    <!-- image -->
    <div class="form-group col-md-4">
        <label>Image:</label>
        <input type="file" name="image" placeholder="Image" class="form-control image">
        <div class="col-md-3 preview_wrapper" hidden>
            <img src="<?php echo(asset('img/noimg.jpg')); ?>" class="preview_image" alt="" width="100%">
        </div>
    </div>
    <!-- type -->
    <div class="form-group col-md-4">
        <label>Type:</label>
        <select name="type" class="form-control type" required>
            <option value="">Select Type</option>
            <option value="Article">Article</option>
            <option value="News">News</option>
            <option value="Headline">Headline</option>
        </select>
    </div>
    <!-- description -->
    <div class="form-group col-md-12">
        <label>Description:</label>
        <textarea type="text" name="description" placeholder="Description" class="form-control description"></textarea>
    </div>
    <!-- date -->
    <div class="form-group col-md-12 col-sm-3">
        <label>Date:</label>
        <input type="date" name="date" placeholder="Date" class="form-control date">
    </div>
</div>