<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Session;
use Hash;
class TeachersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teachers=User::all();
        return view('Teachers.Index')->with('teachers',$teachers);
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
            'name'=>'required',
            'phone'=>'required',
            'tsc'=>'required',
            'username'=>['required','unique:users'],
            'subject1'=>'required',
            'subject2'=>'required',
            'email'=>['required', 'string', 'email', 'max:255', 'unique:users'],
            'employer'=>'required',
            'password'=>'required',
        ]);
        if($request->password != $request->password_confirmation){
            Session::flash('error','the passwords do not Match');
            return redirect()->back();
        }
        User::create([
            'name' => $request->name,
            'phone'=>$request->phone,
            'tsc'=>$request->tsc,
            'username'=>$request->username,
            'subject1'=>$request->subject1,
            'subject2'=>$request->subject2,
            'email' => $request->email,
            'employer'=>$request->employer,
            'password' => Hash::make($request->password),
        ]);
        Session::flash("success","the Teacher has been successfully Added");
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
        $teacher=User::find($id);
        if(is_null($teacher) || empty($teacher)){
            Session::flash("error","Teacher Not Available");
            return redirect()->back();
        }
        return view('Teachers.Edit')->with('teacher',$teacher);
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
            'name'=>'required',
            'phone'=>'required',
            'tsc'=>'required',
            'username'=>['required'],
            'subject1'=>'required',
            'subject2'=>'required',
            'email'=>['required', 'string', 'email', 'max:255'],
            'employer'=>'required',
        ]);
        $teacher=User::find($id);
        if(is_null($teacher) || empty($teacher)){
            Session::flash("error","Teacher Not Available");
            return redirect()->back();
        }
        $teacher->name =$request->name;
        $teacher->phone=$request->phone;
        $teacher->tsc=$request->tsc;
        $teacher->username=$request->username;
        $teacher->subject1=$request->subject1;
        $teacher->subject2=$request->subject2;
        $teacher->email = $request->email;
        $teacher->employer=$request->employer;
        $teacher->save();
        Session::flash("success","Details Updated");
        return redirect(route('teachers.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $teacher=User::find($id);
        if(is_null($teacher) || empty($teacher)){
            Session::flash("error","Teacher Not Available");
            return redirect()->back();
        }
        $teacher->destroy($id);
        Session::flash("error","Teacher Successfully deleted");
        return redirect()->back();
    }
}
