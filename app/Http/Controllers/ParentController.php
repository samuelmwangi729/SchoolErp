<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Parents;
use Session;

class ParentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parents=Parents::where('id','>','0')->paginate(15);
        return view('Parents.Index')->with('parents',$parents);
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
            'Names'=>'required',
            'Email'=>'required',
            'Gender'=>'required',
            'AcademicLevel'=>'required',
            'Disabled'=>'required',
            'PhoneNumber'=>'required',
            'Nationality'=>'required',
            'PostalAddress'=>'required'
        ]);
        Parents::create([
            'Names'=>$request->Names,
            'Email'=>$request->Email,
            'Gender'=>$request->Gender,
            'AcademicLevel'=>$request->AcademicLevel,
            'Disabled'=>$request->Disabled,
            'PhoneNumber'=>$request->PhoneNumber,
            'Nationality'=>$request->Nationality,
            'Passport'=>'Parents/default.png',
            'PostalAddress'=>$request->PostalAddress
        ]);
        Session::flash('success','Parent Details Successfully Captured');
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
        $parent=Parents::find($id);
        if(empty($parent)){
            Session::flash('error','Parent Does Not Exist');
            return redirect()->back();
        }
        return view('Parents.Edit')->with('parent',$parent);
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
            'Names'=>'required',
            'Email'=>'required',
            'Gender'=>'required',
            'AcademicLevel'=>'required',
            'Disabled'=>'required',
            'PhoneNumber'=>'required',
            'Nationality'=>'required',
            'PostalAddress'=>'required'
        ]);
        $parent=Parents::find($id);
        if(empty($parent)){
            Session::flash('error','Parent Does Not Exist');
            return redirect()->back();
        }
        $parent->Names=$request->Names;
        $parent->Email=$request->Email;
        $parent->Gender=$request->Gender;
        $parent->AcademicLevel=$request->AcademicLevel;
        $parent->Disabled=$request->Disabled;
        $parent->PhoneNumber=$request->PhoneNumber;
        $parent->Nationality=$request->Nationality;
        $parent->Passport='Parents/default.png';
        $parent->PostalAddress=$request->PostalAddress;
        $parent->save();
        Session::flash('success','Parent Details Successfully Added');
        return redirect()->route('parents.index');
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
}
