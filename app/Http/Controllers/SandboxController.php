<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SandboxController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('sandbox.index');
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

    public function runCode(Request $request)
    {
        $text = $request->text;
        
        $client = new http\Client;
        $request = new http\Client\Request;

        $body = new http\Message\Body;
        $body->addForm([
            'text' => '~ Function for Fizzbuzz(kafesheqer) in 5HQ1P
        
          printo("Pershendetje Bote!")
        
          per fizzbuzz = 0 deri 51 tani
              nese fizzbuzz % 3 == 0 edhe fizzbuzz % 5 == 0 tani
                  printo("fizzbuzz")
                  vazhdo
        
              tjeter fizzbuzz % 3 == 0 tani
                  printo("fizz")
                  vazhdo
        
              tjeter fizzbuzz % 5 == 0 tani
                  printo("buzz")
                  vazhdo
              fund
        
              printo(fizzbuzz)
          fund'
          ], null);

        $request->setRequestUrl('http://127.0.0.1:8000/compile-sq');
        $request->setRequestMethod('POST');
        $request->setBody($body);

        $client->enqueue($request)->send();
        $response = $client->getResponse();

        // return $response;
        return response()->json($response);
    }
}
