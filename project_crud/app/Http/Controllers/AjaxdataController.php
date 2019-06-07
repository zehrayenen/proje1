<?php

namespace App\Http\Controllers;
use Validator;
use Illuminate\Http\Request;
use App\Companies;
use App\Employees;
use Datatables;
class AjaxdataController extends Controller
{
    function index()
    {
        return view('project.ajaxdata');
        //http://127.0.0:8000/ajaxdata
    }
    function indexx()
    {
        return view('project.ajaxdata1');
        //http://127.0.0:8000/ajaxdata
    }
    function getdata()
    {
        $companies = Companies::select('company_id', 'name', 'address', 'phone', 'email', 'logo', 'website');
        return Datatables::of($companies)
            ->addColumn('action', function($companies){
                return '<a href="#" class="btn btn-xs btn-primary edit" company_id="'.$companies->company_id.'"><i class="glyphicon glyphicon-edit"></i> Edit</a><a href="#" class="btn btn-xs btn-danger delete" company_id="'.$companies->company_id.'"><i class="glyphicon glyphicon-remove"></i> Delete</a>';
            })
            ->make(true);
    }
    function getdata1()
    {
        $employees = Employees::select('employee_id','first_name', 'last_name', 'phone', 'email', 'company_id');
        return Datatables::of($employees)
            ->addColumn('action', function($employees){
                return '<a href="#" class="btn btn-xs btn-primary edit" employee_id="'.$employees->employee_id.'"><i class="glyphicon glyphicon-edit"></i> Edit</a><a href="#" class="btn btn-xs btn-danger delete" employee_id="'.$employees->employee_id.'"><i class="glyphicon glyphicon-remove"></i> Delete</a>';
            })
            ->make(true);
    }
    function postdata(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'address'  => 'required',
            'phone'  => 'required',
            'email'  => 'required',
            'logo'  => 'required',
            'website'  => 'required',
        ]);

        $error_array = array();
        $success_output = '';
        if ($validation->fails())
        {
            foreach($validation->messages()->getMessages() as $field_name => $messages)
            {
                $error_array[] = $messages;
            }
        }
        else
        {
            if($request->get('button_action') == "insert")
            {
                $companies = new Companies([
                    'name'    =>  $request->get('name'),
                    'address'     =>  $request->get('address'),
                    'phone'     =>  $request->get('phone'),
                    'email'     =>  $request->get('email'),
                    'logo'     =>  $request->get('logo'),
                    'website'     =>  $request->get('website')
                ]);
                $companies->save();
                $success_output = '<div class="alert alert-success">Data Inserted</div>';
            }
            if($request->get('button_action') == 'update')
            {

                $companies = Companies::find($request->get('company_id'));
                $companies->name = $request->get('name');
                $companies->address = $request->get('address');
                $companies->phone = $request->get('phone');
                $companies->email = $request->get('email');
                $companies->logo = $request->get('logo');
                $companies->website = $request->get('website');
                $companies->save();
                $success_output = '<div class="alert alert-success">Data Updated</div>';
            }
        }
        $output = array(
            'error'     =>  $error_array,
            'success'   =>  $success_output
        );
        echo json_encode($output);
    }
    function postdata1(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name'  => 'required',
            'phone'  => 'required',
            'email'  => 'required',
            'company_id'  => 'required',
        ]);

        $error_array = array();
        $success_output = '';
        if ($validation->fails())
        {
            foreach($validation->messages()->getMessages() as $field_name => $messages)
            {
                $error_array[] = $messages;
            }
        }
        else
        {
            if($request->get('button_action') == "insert")
            {
                $employees = new Employees([
                    'first_name'    =>  $request->get('first_name'),
                    'last_name'     =>  $request->get('last_name'),
                    'phone'     =>  $request->get('phone'),
                    'email'     =>  $request->get('email'),
                    'company_id'     =>  $request->get('company_id')
                ]);
                $employees->save();
                $success_output = '<div class="alert alert-success">Data Inserted</div>';
            }
            if($request->get('button_action') == 'update')
            {
                $employees = Employees::find($request->get('employee_id'));
                $employees->first_name = $request->get('first_name');
                $employees->last_name = $request->get('last_name');
                $employees->phone = $request->get('phone');
                $employees->email = $request->get('email');
                $employees->company_id = $request->get('company_id');
                $employees->save();
                $success_output = '<div class="alert alert-success">Data Updated</div>';

            }
        }
        $output = array(
            'error'     =>  $error_array,
            'success'   =>  $success_output
        );
        echo json_encode($output);
    }
    function fetchdata(Request $request)
    {
        $company_id = $request->input('company_id');
        $companies = Companies::find($company_id);
        $output = array(
            'name'    =>  $companies->name,
            'address'     =>  $companies->address,
            'phone'     =>  $companies->phone,
            'email'     =>  $companies->email,
            'logo'     =>  $companies->logo,
            'website'     =>  $companies->website

        );
        echo json_encode($output);
    }
    function fetchdata1(Request $request)
    {
        $employee_id = $request->input('employee_id');
        $employees = Employees::find($employee_id);
        $output = array(
            'first_name'    =>  $employees->first_name,
            'last_name'     =>  $employees->last_name,
            'phone'     =>  $employees->phone,
            'email'     =>  $employees->email,
            'company_id'     =>  $employees->company_id
        );
        echo json_encode($output);
    }
    function removedata(Request $request)
    {
        $companies = Companies::find($request->input('company_id'));
        if ($companies->delete()) {
            echo 'Data Deleted';
        }
    }
        function removedata1(Request $request)
        {
            $employees = Employees::find($request->input('employee_id'));
            if ($employees->delete()) {
                echo 'Data Deleted';
            }
        }
    }
