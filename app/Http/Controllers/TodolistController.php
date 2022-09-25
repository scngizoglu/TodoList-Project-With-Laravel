<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Todolist;
use Illuminate\Http\Request;
use Session;

class TodolistController extends Controller
{
    public function todolist()
    {
        $data=array();
        if(Session::has('loginId'))
        {
            $data=User::where('id','=',Session::get('loginId'))->first();
        }
            $userId=Session::get('loginId');
            $todolists=Todolist::where('userId',$userId)->get();
            return view('todolist',compact('todolists'));
    }
    public function store(Request $request)
    {
        $data=$request->validate([
            'content'=>'required',
            'userId'=>'required'
        ]);
        Todolist::create($data);
        return back();
    }
    public function destroy(Todolist $todolist)
    {
        $todolist->delete();
        return back();
    }
    public function listUpdate(Request $request)
    {
        $queryStatus = false;
        $updateQuery = Todolist::whereId($request->id)->update([
            'content' => $request->content
        ]);

        if($updateQuery){
            $queryStatus = true;
        }
        
        return response()->json([
            'status' => $queryStatus       
        ],200);
    }
    
}
