<div class="row">
    <!--Start Col-->
    <div class="col-sm-4">
        <div class="form-group">
            <label for="Title" class="label-control"><i class="fa fa-tag"></i>&nbsp;Title</label>
            <input type="text" class="form-control input-sm" name="Title" value="{{ $syllabus->Title ?? '' }}">
        </div>
    </div>
    <!--end col-->
     <!--Start Col-->
     <div class="col-sm-4">
        <div class="form-group">
            <label for="Description" class="label-control"><i class="fa fa-edit"></i>&nbsp;Description</label>
            <input type="text" class="form-control input-sm" name="Description" value="{{ $syllabus->Description ?? '' }}">
        </div>
    </div>
    <!--end col-->
    <!--Start Col-->
    <div class="col-sm-4">
        <div class="form-group">
            <label for="Class" class="label-control"><i class="fa fa-university"></i>&nbsp;Class</label>
            <select name="Class" class="form-control input-sm">
                <option value="1">Form 1</option>
                <option value="2">Form 2</option>
                <option value="3">Form 3</option>
                <option value="4">Form 4</option>
            </select>
        </div>
    </div>
    <!--end col-->
    <!--Start Col-->
    <div class="col-sm-6">
        <div class="form-group">
            <label for="Subject" class="label-control"><i class="fa fa-book"></i>&nbsp;Subject</label>
            <select name="Subject" class="form-control input-sm">
                <option value="English">English</option>
                <option value="Kiswahili">Kiswahili</option>
                <option value="Mathematics">Mathematics</option>
                <option value="Chemistry">Chemistry</option>
            </select>
        </div>
    </div>
    <!--end col-->
    <!--Start Col-->
    <div class="col-sm-6">
        <div class="form-group">
            <label for="File" class="label-control"><i class="fa fa-file"></i>&nbsp;Syllabus File</label>
            <input type="file" class="form-control input-sm" name="File">
        </div>
    </div>
    <!--end col-->
    
</div>