<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;


use GuzzleHttp\Client;
// import the Intervention Image Manager Class
use Intervention\Image\ImageManagerStatic as Image;
class subirImagenPrueba extends Controller
{
  /**
  * Create a new controller instance.
  *
  * @return void
  */
  public function __construct()
  {
    $this->middleware('auth');
  }

  /**
  * Show the application dashboard.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    $client = new Client(['base_uri' => 'http://localhost/apiRest/public/']);
    // Send a request to https://foo.com/api/test
    $response = $client->request('GET', 'prueba');

    $contenido = json_decode($response->getBody());
    $code = $response->getStatusCode(); // 200
    $reason = $response->getReasonPhrase(); // OK

    // Implicitly cast the body to a string and echo it


    if($code ==200){
      $contenido = json_decode($response->getBody());
      return view('prueba.index')->with('prueba', $contenido->data);
    }
  }
  public function store(Request $request)
  {
  $img = Image::make($request->file('image'));;
    var_dump($img);
    $url = 'http://localhost/apiRest/public/prueba';
    $client = new Client([
      'base_uri' => $url,
      // You can set any number of default request options.
      'timeout'  => 2.0]);



      //$data = array('name'=> $request->name , 'image' =>  $tmpname);
      $response = $client->request('POST', $url,[
        "multipart"=> [
          [
            'name'     => 'name',
            'contents' => $request->name
          ],
          [
            'name'     => 'image',
            'filename' => $request->file('image')->getPathName(),
            'contents' => $img->encode('jpeg')
          ],
        ]
      ]);

      $code = $response->getStatusCode(); // 200
      $reason = $response->getReasonPhrase(); // OK
      echo $code;
      // Implicitly cast the body to a string and echo it

      $contenido = json_decode($response->getBody())->data;
      if($code ==201)
      {
        return redirect('/prueba');
      }else{
        return view("errors.index");
      }
    }
  }
