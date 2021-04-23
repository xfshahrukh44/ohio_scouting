@csrf
<div class="modal-body row">
    <!-- image -->
    <div class="form-group col-md-3">
        <label for="">Image:</label>
        <input type="file" name="image" placeholder="Image" class="form-control form-control-sm image">
        <div class="col-md-3 preview_wrapper" hidden>
            <img src="<?php echo(asset('img/noimg.jpg')); ?>" class="preview_image" alt="" width="100">
        </div>
    </div>
    <!-- title -->
    <div class="form-group col-md-3">
        <label for="">Title:</label>
        <input type="text" name="title" placeholder="Title" class="form-control form-control-sm title" required>
    </div>
    <!-- city -->
    <div class="form-group col-md-3">
        <label for="">City:</label>
        <input type="text" name="city" placeholder="City" class="form-control form-control-sm city" required>
    </div>
    <!-- type -->
    <div class="form-group col-md-3">
        <label for="">Type</label>
        <select name="type" class="form-control form-control-sm type" style="width: 100%; height: 35px;">
            <option value="">Select listing type</option>
            <option value="House">House</option>
            <option value="Apartment">Apartment</option>
        </select>
    </div>
    <!-- location -->
    <div class="form-group col-md-12">
        <label for="">Location:</label>
        <textarea type="text" name="location" placeholder="Location" class="form-control form-control-sm location"></textarea>
    </div>
    <!-- area -->
    <div class="form-group col-md-3">
        <label for="">Area(Sq. Yd.)</label>
        <input type="number" min=0 name="area" placeholder="Enter Area" class="form-control form-control-sm area" required value=0>
    </div>
    <!-- bathrooms -->
    <div class="form-group col-md-3">
        <label for="">Bathrooms</label>
        <input type="number" min=0 name="bathrooms" placeholder="Enter Bathrooms" class="form-control form-control-sm bathrooms" required value=0>
    </div>
    <!-- attach_bathrooms -->
    <div class="form-group col-md-3">
        <label for="">Attach Bathrooms</label>
        <input type="number" min=0 name="attach_bathrooms" placeholder="Enter Attach Bathrooms" class="form-control form-control-sm attach_bathrooms" required value=0>
    </div>
    <!-- bedrooms -->
    <div class="form-group col-md-3">
        <label for="">Bedrooms</label>
        <input type="number" min=0 name="bedrooms" placeholder="Enter Bedrooms" class="form-control form-control-sm bedrooms" required value=0>
    </div>
    <!-- price -->
    <div class="form-group col-md-4">
        <label for="">Price</label>
        <input type="number" min=0 name="price" placeholder="Enter Price" class="form-control form-control-sm price" required value=0 step=".1">
    </div>
    <!-- purpose -->
    <div class="form-group col-md-4">
        <label for="">Purpose</label>
        <select name="purpose" class="form-control form-control-sm purpose" style="width: 100%; height: 35px;">
            <option value="">Select listing purpose</option>
            <option value="Rent">Rent</option>
            <option value="Sale">Sale</option>
        </select>
    </div>
    <!-- status -->
    <div class="form-group col-md-4">
        <label for="">Status</label>
        <select name="status" class="form-control form-control-sm status" style="width: 100%; height: 35px;">
            <option value="">Select listing status</option>
            <option value="Active">Active</option>
            <option value="Inactive">Inactive</option>
        </select>
    </div>
    <!-- description -->
    <div class="form-group col-md-12">
        <label for="">Description:</label>
        <textarea type="text" name="description" placeholder="Description" class="form-control form-control-sm description"></textarea>
    </div>
    <!-- listing_images -->
    <div class="form-group col-md-12">
        <label>Additional Images:</label> <br>
        <input type="file" name="listing_images[]" class="form-control" multiple>
    </div>
</div>