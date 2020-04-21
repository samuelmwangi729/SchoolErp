<fieldset>
    <legend>Add Student</legend>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label class="label-control" for="Student Names">
                    Student Name
                </label>
                <input type="text" name="StudentName" @error('StudentName') is-invalid @enderror  class="form-control input-sm" placeholder="Students Name" value="{{ $student->StudentName ?? '' }}">
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label for="Parent" class="label-control">Parent Name</label>
                <select name="parent" class="form-control input-sm">
                    @foreach ($parents as $parent)
                        <option value="{{ $parent->Names }}">{{ $parent->Names }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label for="Class" class="label-control">
                    Class
                </label>
                <select name="class" class="form-control input-sm">
                    @foreach ($classes  as $class )
                        <option value="{{ $class->Class }}">Form {{ $class->Class }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label for="Stream" class="label-control">
                    Stream
                </label>
                <select name="Stream" class="form-control input-sm">
                   @foreach ($streams as$stream )
                       <option value="{{ $stream->Stream }}">{{ $stream->Stream }}</option>
                   @endforeach
                </select>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label for="Admission Number" class="label-control">
                    Admission Number
                </label>
                <input type="text" class="form-control input-sm" name="AdmissionNumber" value="{{ $student->AdmissionNumber ?? Str::random(5) }}">
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label for="KCPE" class="label-control">
                    KCPE MARKS
                </label>
                <input type="number" class="form-control input-sm" name="Kcpe"  value="{{ $student->Kcpe ?? '' }}">
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label for="BirthDate" class="label-control">
                    BirthDate
                </label>
                <input type="date" class="form-control input-sm" name="birthDate" required>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label for="Gender" class="label-control">
                    Gender
                </label>
                <select class="form-control input-sm">
                    <option value="Male"><i class="fa fa-male"></i>&nbsp;Male</option>
                    <option value="Female"><i class="fa fa-female"></i>&nbsp;Female</option>
                </select>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label for="Dormitory" class="label-control">
                    Dormitory
                </label>
                <select class="form-control input-sm">
                    <option value="Male"><i class="fa fa-male"></i>&nbsp;Ruwenzori</option>
                    <option value="Female"><i class="fa fa-female"></i>&nbsp;M.t Longonot</option>
                </select>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label for="Passport" class="label-control">
                    Passport
                </label>
               <input type="file" class="form-control input-sm" name="Passport" value="{{ $student->Passport ?? '' }}" required>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label for="Nemis" class="label-control">
                    Nemis Number
                </label>
               <input type="text" class="form-control input-sm" name="Nemis" value="{{ $student->Nemis ?? '' }}">
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label for="Denomination" class="label-control">
                    Religion
                </label>
                <select class="form-control input-sm">
                    <option value="Christian">&nbsp;Christian</option>
                    <option value="Muslim">&nbsp;Muslim</option>
                    <option value="Other">&nbsp;Other</option>
                </select>
            </div>
        </div>
        <div class="col-sm-12 text-center">
            <div class="form-group">
                <label for="Denomination" class="label-control">
                    School Fees
                </label>
                <input type="text" class="form-control" name="SchoolFees" value="{{ $student->SchoolFees ?? 'Leave Empty For Now'}}">
            </div>
        </div>
    </div>
</fieldset>
