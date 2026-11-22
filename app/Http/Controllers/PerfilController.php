<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordResetRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Mail\mail_res_pass;
use Carbon\Carbon;
use App\User;
use Alert;
use DB;

class PerfilController extends Controller
{
    public function index(){ 
    	$data_user = User::join('areas as a','a.id','=','users.area')->where('users.id','=',Auth::User()->id)->select('a.nombre as area_nombre','users.name as usuario_nombre','users.email as usuario_correo')->get();
    	$roles = User::find(Auth::User()->id)->getRoleNames(); 
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
    	$request->validate([
    		'email' => ['required', 'email'],
    	]);

    	$email = $request->email;

    	$administrativo = User::where('email', $email)->first();
    	if ($administrativo) {
    		if ($administrativo->active !== 'true') {
    			Alert::error('Error', 'Tu usuario se encuentra inactivo. Contacta al área de sistemas.');
    			return back()->withInput();
    		}

    		$token = Str::random(64);
    		DB::table('password_resets')->where('email', $email)->delete();
    		DB::table('password_resets')->insert([
    			'email' => $email,
    			'token' => $token,
    			'created_at' => Carbon::now(),
    		]);

    		Mail::to($email)->send(new mail_res_pass($token));
    		Alert::success('Correcto', 'Te hemos enviado un enlace de recuperación a '.$email.'.');
    		return redirect('login');
    	}

    	Alert::success(
    		'Solicitud recibida',
    		'Si el correo pertenece a una cuenta registrada, recibirás las instrucciones correspondientes.'
    	);
    	return redirect('login');
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
			if(
				strlen($request->newPass) < 8 ||
				!preg_match('/[A-Z]/', $request->newPass) ||
				!preg_match('/[0-9]/', $request->newPass) ||
				!preg_match('/[^A-Za-z0-9]/', $request->newPass)
			)
			{
				Alert::error("Error","La contraseña no reune los requisitos minimos de seguridad");
				return view('auth.passwords.reset')				
				->with('token',$request->token);
			}
			else
			{
				$mail = DB::table('password_resets')
					->where('token', $request->token)
					->select('email', 'created_at')
					->first();

				if (is_null($mail)) {
					Alert::error("Error","El enlace de recuperación no existe o ya fue utilizado.");
					return redirect('login');
				}

				if (Carbon::parse($mail->created_at)->addHour()->isPast()) {
					DB::table('password_resets')->where('token', $request->token)->delete();
					Alert::error("Error","El enlace de recuperación ha expirado.");
					return redirect('login');
				}

				$user = User::where('email', $mail->email)->first();
				if (is_null($user)) {
					Alert::error("Error","La contraseña institucional no puede restablecerse desde Créditos.");
					return redirect('login');
				}

				$user->password = bcrypt($request->newPass);
				$user->save();
				DB::table('password_resets')->where('email', $mail->email)->delete();
				Alert::success("Correcto","Contraseña reseteada correctamente");
				return redirect()->route('login');
			}
		}
		
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
