<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordResetRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Mail\mail_res_pass;
use App\Models\Alumno;
use Carbon\Carbon;
use App\User;
use Alert;
use DB;

class PerfilController extends Controller
{
    public function index(){ 
    	$data_user = User::join('areas as a','a.id','=','users.area')->where('users.id','=',Auth::User()->id)->select('a.nombre as area_nombre','users.name as usuario_nombre','users.email as usuario_correo')->get();
    	$roles = User::find(Auth::User()->id)->getRoleNames(); dd($roles);
    	return view('admin.perfil.index')
    	->with('data_usuario',$data_user[0])
    	->with('roles',$roles);
    }

	public function passwordMail()
	{
		return view('auth.passwords.email');
	}

    public function passwordResetLink(Request $request)
	{	
    	$email=User::where('email', $request->email)->first(); 
		if(is_null($email))		{  
			$emaila=Alumno::where('email', $request->email)->first(); 
			if(is_null($emaila))
			{
				Alert::error("Error","Este usuario no esta registrado, te sugerimos verificarlo");
				return view('auth.passwords.email');
			}
			else
			{ 
				//Generación de token y almacenado en la tabla password_resets
				$token = Str::random(64);
				DB::table('password_resets')->insert([
					'email' => $request->email,
					'token' => $token,
					'created_at' => Carbon::now()
				]);
		
				//Envío de email al usuario
				Mail::to( $request->email)->send(new mail_res_pass($token));
				//Retorno
				Alert::success('Correcto','Te hemos enviado un email a '.$request->email.' con un enlace para realizar el cambio de contraseña. Recuerda que pueden pasar algunos minutos para que el correo llegue a tu bandeja de entrada');
				return redirect('login');
			}
		}
		else
		{
			//Generación de token y almacenado en la tabla password_resets
			$token = Str::random(64);
			DB::table('password_resets')->insert([
				'email' => $request->email,
				'token' => $token,
				'created_at' => Carbon::now()
			]);

			//Envío de email al usuario
			Mail::to( $request->email)->send(new mail_res_pass($token));
			//Retorno
			Alert::success('Correcto','Te hemos enviado un email a '.$request->email.' con un enlace para realizar el cambio de contraseña. Recuerda que pueden pasar algunos minutos para que el correo llegue a tu bandeja de entrada');
			return redirect('login');
	
		}
    }

	public function passwordResetView($token)
	{
		$mail=DB::table('password_resets')->where('token',$token)->select('email')->first(); 
		if(is_null($mail))
		{
			Alert::error("Error","Ocurrio un error de autenticación, contacta con el area de sistemas del ITSCH");
			return view('auth.passwords.email');
		}
		else
		{
			return view('auth.passwords.reset')			
			->with('token',$token);
		}
		
	}

	public function passwordResetViewMiPerfil()
	{
		return view('admin.perfil.password_reset');
	}

	public function passwordReset(Request $request)
	{ 
		if($request->newPass!=$request->repNewPass)
		{
			Alert::error("Error","Las contraseñas introducidas deben ser iguales, inténtalo nuevamente");
			return view('auth.passwords.reset')			
			->with('token',$request->token);
		}
		else
		{
			if(strlen($request->newPass)<8 )
			{
				Alert::error("Error","La contraseña no reune los requisitos minimos de seguridad");
				return view('auth.passwords.reset')				
				->with('token',$request->token);
			}
			else
			{
				$mail=DB::table('password_resets')->where('token',$request->token)->select('email')->first();
				$user=$this->getUser($mail->email);				
				$user->password=bcrypt($request->newPass);
				$user->save();
				Alert::success("Correcto","Contraseña reseteada correctamente");
				return redirect()->route('login');
			}
		}
		
	}

	//Función que obtiene el usuario que desea cambiar su password
	private function getUser($email)
	{
		$user= User::where('email',$email)->first();
		if (is_null($user))
		{
			$user= Alumno::where('email',$email)->first();
		}
		return $user;
	}

    public function passwordUpdate(PasswordResetRequest $request){
    	if(!Hash::check($request->old_password, Auth::User()->password)){
    		Alert::error("Error","La contraseña actual no es correcta");
    		return redirect()->back();
    	} 
    	$user = User::find(Auth::User()->id);
    	$user->password = bcrypt($request->new_password);
    	$user->save();
    	Alert::success("Correcto","Contraseña reseteada correctamente");
    	return redirect()->route('perfil.index');
    }
}
