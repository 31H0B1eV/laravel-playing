<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\User;

class ProfileController extends Controller
{
    use ValidatesRequests;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
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
        $validator = \Validator::make($request->all(), [
            'data' => 'required|min:3',
        ]);

        $validator->after(function ($validator) use ($request) {
            if (!$this->validateDataBeforeUpdate($request['field_name'], $request['data'])) {
                $validator->errors()->add($request['field_name'], 'Cannot use this ' . $request['field_name']);
            }
        });

        if ($validator->fails()) {
            return $validator->errors();
        }

        $this->updateRecord($request, $id);

        return ['data' => 'success'];
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

    public function updateRecord($data, $user_id)
    {
        $user = User::where('id', '=', $user_id)->first();

        switch ($data['field_name']) {
            case 'name':
                $user->name = $data['data'];
                $user->save();
                break;            
            case 'email':
                $user->email = $data['data'];
                $user->save();
                break;            
            case 'login':
                $user->username = $data['data'];
                $user->save();
                break;            
            default:
                break;
        }

        return $user;
    }

    public function validateDataBeforeUpdate($name, $value)
    { // TODO: add more check for all fields.
        switch ($name) {
            case 'name':
                return true;
                break;
            
            case 'email':
                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) { // must be valid email
                    return false; 
                } else if (User::where('email', '=', $value)->first()) { // email must be unique
                    return false; 
                }
                return true;
                break;
            
            case 'login':
                if (User::where('username', '=', $value)->first()) { // must be unique
                    return false; 
                } 
                return true;
                break;
            
            default:
                return true;
                break;
        }
    }
}
