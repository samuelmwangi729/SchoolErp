<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Auth;
use App\Syllabus;
class SyllabiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("Syllabi.index")->with('syllabi',Syllabus::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'Title'=>'required',
            'Description'=>'required',
            'Subject'=>'required',
            'Class' => 'required',
            'File'=>'required'
        ]);
        $file=$request->File;
        $newFileName=time().$file->getClientOriginalName();
        $file->move('Syllabi/',$newFileName);
        Syllabus::create([
            'Title'=>$request->Title,
            'Description'=>$request->Description,
            'Subject'=>$request->Subject,
            'Class' => $request->Class,
            'UploadedBy'=>Auth::user()->username,
            'File'=>'Syllabi/'.$newFileName,
        ]);
        Session::flash('success','Syllabus Successfully Posted');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $syllabus=Syllabus::find($id);
        if(empty($syllabus)){
            Session::flash('error','the Syllabus Dow not exist');
            return redirect()->back();
        }
        return view('Syllabi.Edit')->with('syllabus',$syllabus);
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
            'Title'=>'required',
            'Description'=>'required',
            'Subject'=>'required',
            'Class' => 'required',
        ]);
        $syllabus=Syllabus::find($id);
        if(empty($syllabus)){
            Session::flash('error','the Syllabus Dow not exist');
            return redirect()->back();
        }
        if($request->hasFile('File')){
            $file=$request->File;
            $newFileName=time().$file->getClientOriginalName();
            $file->move('Syllabi/',$newFileName);
            $syllabus->File='Syllabi/'.$newFileName;
        }else{
            $syllabus->File=$syllabus->File;
        }
        $syllabus->Title=$request->Title;
        $syllabus->Description=$request->Description;
        $syllabus->Subject=$request->Subject;
        $syllabus->Class= $request->Class;
        $syllabus->UploadedBy=Auth::user()->username;
        $syllabus->save();
        Session::flash("success","The Syllabus Has been updated");
        return redirect()->route('syllabus.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $syllabus=Syllabus::find($id);
        if(empty($syllabus)){
            Session::flash('error','the Syllabus Dow not exist');
            return redirect()->back();
        }
        $syllabus->destroy($id);
        Session::flash('error','The Syllabus Has been successfully Deleted');
        return redirect()->back();
    }
}
