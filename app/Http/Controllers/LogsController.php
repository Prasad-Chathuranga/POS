<?php

namespace App\Http\Controllers;

use App\Models\Logs;
use Illuminate\Http\Request;

class LogsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $logs = Logs::with('user')->orderBy('id', 'desc')->get();
        return view('logs.index', compact('logs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
       
        $event = Logs::findOrFail($id);
    
        $data = 'DATABASE: ' . PHP_EOL . $this->toStr( json_decode($event->context,true) );

        if(!empty($event->request)):
            $data .= PHP_EOL . PHP_EOL . 'REQUEST:' . PHP_EOL . $this->toStr( json_decode($event->request,true) );
        endif;
     
        return response()->json(['data' => $data ]);
     
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Logs $logs)
    {
        
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Logs $logs)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Logs $logs)
    {
        //
    }

    public function getActivity($id){

        // $this->isAllowed('System', 'Activity');

        $event = Logs::findOrFail($id);

        $data = 'DATABASE: ' . PHP_EOL . $this->toStr( json_decode($event->context,true) );

        if(!empty($event->request)):
            $data .= PHP_EOL . PHP_EOL . 'REQUEST:' . PHP_EOL . $this->toStr( json_decode($event->request,true) );
        endif;

        return response()->json(['data' => $data ]);
    }

    protected function toStr($data){



        $string = '';


        foreach($data as $key => $value):

            if(is_array($value)):

                $string .= $key . '=' . $this->toStr($value) .PHP_EOL.PHP_EOL;

            else:

                $string .= $key . '=' . $value . PHP_EOL;

            endif;

        endforeach;

        return $string;
    }
}
