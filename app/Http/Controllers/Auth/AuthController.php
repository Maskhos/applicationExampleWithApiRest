<?php

namespace App\Http\Controllers\Auth;
use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use App\Http\Requests;
use GuzzleHttp\Client;
class AuthController extends Controller
{
  /*
  |--------------------------------------------------------------------------
  | Registration & Login Controller
  |--------------------------------------------------------------------------
  |
  | This controller handles the registration of new users, as well as the
  | authentication of existing users. By default, this controller uses
  | a simple trait to add these behaviors. Why don't you explore it?
  |
  */

  use AuthenticatesAndRegistersUsers, ThrottlesLogins;

  /**
  * Where to redirect users after login / registration.
  *
  * @var string
  */
  protected $redirectTo = '/';

  /**
  * Create a new authentication controller instance.
  *
  * @return void
  */
  public function __construct()
  {
    $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
  }

  /**
  * Get a validator for an incoming registration request.
  *
  * @param  array  $data
  * @return \Illuminate\Contracts\Validation\Validator
  */
  protected function validator(array $data)
  {
    return Validator::make($data, [
      'name' => 'required|max:255',
      'email' => 'required|email|max:255|unique:users',
      'password' => 'required|min:6|confirmed',
    ]);
  }
/*  protected function postLogin(Request $data){
    $url = 'http://localhost/apiRest/public/user/credentials';
    $client = new Client([
      'base_uri' => $url,
      // You can set any number of default request options.
      'timeout'  => 2.0]);

      $data = array( 'email' => $data->email,'password' => bcrypt($data->password));
      var_dump($data);
      $response = $client->request('POST', $url, [
        'form_params' => $data

      ]);
      $code = $response->getStatusCode(); // 200
      $reason = $response->getReasonPhrase(); // OK
      echo $code;
      // Implicitly cast the body to a string and echo it

      $contenido = json_decode($response->getBody())->data;
      var_dump( $contenido);
      if($code ==200)
      {
        /*$user = new User();
        $user->usname= $contenido->usname;
        $user->email = $contenido->email;
        $user->id = $contenido->id;
        $user->password = $contenido->password;
        Authenticatable::attempt(array('email' => $contenido->email, 'password' => $contenido->password), true);
        return view('home');
      }else{
        $user = new User();
        $user->usname= "";
        $user->email = "";
        $user->id = "";
        $user->password = "";
        return  ;
      }
*/
    //}
    /**
    * Create a new user instance after a valid registration.
    *
    * @param  array  $data
    * @return User
    */
    protected function create(array $data)
    {

      $url = 'http://localhost/apiRest/public/user';
      $client = new Client([
        'base_uri' => $url,
        // You can set any number of default request options.
        'timeout'  => 2.0]);

        $data = array('usbirthDate'=> 1 , 'usname' => $data['name'], 'email' => $data['email'],'password' => bcrypt($data['password']), 'faction_id'=>1 ,'country_id'=>2);
        $response = $client->request('POST', $url, [
          'form_params' => $data

        ]);

        $code = $response->getStatusCode(); // 200
        $reason = $response->getReasonPhrase(); // OK
        echo $code;
        // Implicitly cast the body to a string and echo it

        $contenido = json_decode($response->getBody())->data;
        var_dump( $contenido);
        if($code ==201)
        {
          $user = new User();
          $user->usname= $contenido->usname;
          $user->email = $contenido->email;
          $user->id = $contenido->id;
          $user->password = $contenido->password;

          return $user;
        }else{
          $user = new User();
          $user->usname= "";
          $user->email = "";
          $user->id = "";
          $user->password = "";
          return $user ;
        }
      }
    }
