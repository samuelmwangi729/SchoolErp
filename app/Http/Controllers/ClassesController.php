<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Stream;
use Session;
use App\Classes;
class ClassesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $streams=Stream::all();
        $classes=Classes::all();
        return view('Classes.Index')
        ->with('classes',$classes)
        ->with('streams',$streams);
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
            'Class'=>[
                'required',
                'unique:classes'
            ]
            ]);
            Classes::create($request->all());
            Session::flash('success','Class Successfully Added');
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
        $class=Classes::find($id);
        if(empty($class)){
            Session::flash("error","class Not Found");
            return redirect()->back();
        }
        $class->destroy($id);
        Session::flash('error','Class Successfully Deleted');
        return redirect()->back();
    }
    public function delete($id)
    {
        $class=Stream::find($id);
        if(empty($class)){
            Session::flash("error","Stream Not Found");
            return redirect()->back();
        }
        $class->destroy($id);
        Session::flash('error','Stream Successfully Deleted');
        return redirect()->back();
    }
    public function stream(Request $request){
        $this->validate($request,[
            'Stream'=>['required','unique:streams']
        ]);
        Stream::create($request->all());
        Session::flash('success','Stream Successfully Added');
        return redirect()->back();
    }
}
