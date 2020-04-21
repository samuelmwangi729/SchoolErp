<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\{Parents,Student,Stream,Classes,CurrentTerm,Fee};
use Excel;

class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students=Student::all();
        $classes=Classes::all();
        $streams=Stream::all();
        $parents=Parents::orderBy('id','desc')->get();
        return view('Students.all')
        ->with("classes",$classes)
        ->with("streams",$streams)
        ->with("parents",$parents)
        ->with('students',$students);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parents=Parents::orderBy('id','desc')->get();
        $classes=Classes::all();
        $streams=Stream::all();
        return view('Students.add')
        ->with("classes",$classes)
        ->with("streams",$streams)
        ->with('parents',$parents);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'StudentName'=>'required',
            'parent'=>'required',
            'class'=>'required',
            'Stream'=>'required',
            'AdmissionNumber'=>['required','unique:students'],
            'Kcpe'=>'required',
            'birthDate'=>'required',
            'Passport'=>'required',
            'Nemis'=>['required','unique:students']
        ]);
        $term=CurrentTerm::all()->last()->CurrentTerm;
         $row=Fee::where([
            'Class'=>$request->class,
           'Term'=>$term
       ])->get();
       $sum=0;
       for($i=0;$i<count($row);$i++){
        $sum=$sum+$row[$i]->Amount;
       }
        $file=$request->Passport;
        $newName=time().$file->getClientOriginalName();
        $file->move('Students/',$newName);
        Student::create([
            'StudentName'=>$request->StudentName,
            'parent'=>$request->parent,
            'class'=>$request->class,
            'Stream'=>$request->Stream,
            'AdmissionNumber'=>$request->AdmissionNumber,
            'Kcpe'=>$request->Kcpe,
            'birthDate'=>$request->birthDate,
            'Passport'=>'Students/'.$newName,
            'Nemis'=>$request->Nemis,
            'SchoolFees'=>$sum,
            'Balance'=>$sum,
        ]);
        Session::flash('success','Student Successfully Added');
        return redirect()->back();
    }
        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function bulk(Request $request)
    {
        $this->validate($request,[
            'StudentFile'=>'required|mimes:xls,xlsx'
        ]);
        $file=$request->StudentFile;
        $newName=$file->getClientOriginalName();
        $data=Excel::load($newName)->get();
        dd($data);
        // $file->move('Students/',$newName);
        Student::create([
            'StudentName'=>$request->StudentName,
            'parent'=>$request->parent,
            'class'=>$request->class,
            'Stream'=>$request->Stream,
            'AdmissionNumber'=>$request->AdmissionNumber,
            'Kcpe'=>$request->Kcpe,
            'birthDate'=>$request->birthDate,
            'Passport'=>'Students/'.$newName,
            'Nemis'=>$request->Nemis
        ]);
        Session::flash('success','Student Successfully Added');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $student=Student::where('id',$id)->get();
        if(is_null($student) || $student->count()==0){
            Session::flash("error","No Student With Such Details Exist");
            return redirect()->back();
        }
        Session::flash("data",$student);
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $student=Student::where('id',$id)->get();
        if(is_null($student) || $student->count()==0){
            Session::flash("error","No Student With Such Details Exist");
            return redirect()->back();
        }
        $parents=Parents::orderBy('id','desc')->get();
        Session::flash("datae",$student);
        $students=Student::all();
        $classes=Classes::all();
        $streams=Stream::all();
       return view('Students.all')
       ->with("students",$students)
       ->with("classes",$classes)
       ->with("streams",$streams)
       ->with('parents',$parents);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'StudentName'=>'required',
            'parent'=>'required',
            'class'=>'required',
            'Stream'=>'required',
            'AdmissionNumber'=>['required'],
            'Kcpe'=>'required',
            'birthDate'=>'required',
            'Passport'=>'required',
            'Nemis'=>['required']
        ]);
        $student=Student::find($id);
        if(empty($student)){
           Session::flash("error","No Such Student Available. Please Try Again");
           return redirect()->back();
        }
        if($request->hasFile('Passport')){
           $file=$request->Passport;
           $newName=time().$file->getClientOriginalName();
           $file->move('Students/',$newName);
           $student->Passport='Students/'.$newName;
        }
        $student->StudentName=$request->StudentName;
        $student->parent=$request->parent;
        $student->class=$request->class;
        $student->Stream=$request->Stream;
        $student->AdmissionNumber=$request->AdmissionNumber;
        $student->Kcpe=$request->Kcpe;
        $student->birthDate=$request->birthDate;
        $student->Nemis=$request->Nemis;
        $student->SchoolFees=$request->SchoolFees;
        $student->Balance=$request->SchoolFees;
        $student->save();
        Session::flash("success","Student Details Successfully Updated");
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $student=Student::find($id);
        if(is_null($student)|| $student->count()==0){
            Session::flash("error","student does not exist");
            return redirect()->back();
        }
        $student->destroy($id);
        Session::flash("success","Student Deleted");
        return redirect()->back();
    }
}
