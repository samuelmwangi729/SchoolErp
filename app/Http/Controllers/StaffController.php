<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\StaffType;
use Session;
use App\User;
use Hash;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types=StaffType::all();
        $staffs=User::where('isInd',0)->get();
        return view('Staff.Index')->with('types',$types)
        ->with('staffs',$staffs);
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

    public function type(Request $request){
        $this->validate($request,[
            'Type'=>'required'
        ]);
        StaffType::create($request->all());
        Session::flash('success','The Staff Type has Been Added');
        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $this->validate($request,[
            'name'=>'required',
            'phone'=>'required',
            'tsc'=>'required',
            'username'=>['required','unique:users'],
            'level'=>'required',
            'email'=>['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'=>'required',
        ]);
        if($request->password != $request->password_confirmation){
            Session::flash("error","the passwords do not match");
            return redirect()->back();
        }
        User::create([
            'name' => $request->name,
            'phone'=>$request->phone,
            'tsc'=>$request->tsc,
            'username'=>$request->username,
            'subject1'=>"null",
            'subject2'=>"null",
            'email' => $request->email,
            'employer'=>"null",
            'level'=>$request->level,
            'password' => Hash::make($request->password),
        ]);
        Session::flash("success","Staff Successfully Registered");
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function delete($id)
    {
        $type=StaffType::find($id);
        if(empty($type)){
            Session::flash('error','Type does Not Exist');
            return redirect()->back();
        }
        $type->destroy($id);
        Session::flash('error','Type Successfuly Deleted');
        return redirect()->back();
    }
}
