<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use \Firebase\JWT\JWT;
use Illuminate\Support\Str;

class UserController extends Controller
{
    //
    
    public function createUser(Request $request) {
        
        $response = "";
        

		

		//Leer el contenido de la petición
		$data = $request->getContent();

		//Decodificar el json
		$data = json_decode($data);

		//Si hay un json válido, crear el libro
		if($data){
			$user = new User();

			//TODO: Validar los datos antes de guardar el libro

			$user->username = $data->username;
            $user->email = $data->email;
            $user->password = hash::make($data->password);
            $user->role = $data->role;
                        

			try{
				$user->save();
				$response = "OK";
			}catch(\Exception $e){
				$response = $e->getMessage();
			}

			
		}

		
		return response($response);
        
        
    }
    

    public function login(Request $request){
    	$respuesta = "";

		//Procesar los datos recibidos
		$data = $request->getContent();

		//Verificar que hay datos
		$data = json_decode($data);

		if($data){
			
			if(isset($data->email)&&isset($data->password)){

				$user = User::where("email",$data->email)->first();

				if($user){

					if(Hash::check($data->password, $user->password)){
                        
                        $key = "papasopkdapsdkdilaisdhfadhsugadkpjhghjkaeghku345345868KJHFHFG*";
                        
                        $token = JWT::encode($data->email, $key);


						$user->api_token = $token;

						$user->save();

						$respuesta = $token;
                        
                        $respuesta = "Se ha iniciado sesión correctamente.";

					} else{
						$respuesta = "Contraseña incorrecta";
					}

				} else{
					$respuesta = "Usuario no encontrado";
				}

			} else{
				$respuesta = "Faltan datos";
			}

		} else {
			$respuesta = "Datos incorrectos";
		}
		


		return response($respuesta);
    }
    
    public function recoverPassword(Request $request){

        $respuesta = "";

        $data = User::where('email',$request->email) -> first();

        $newPassword = Str::random(10);

        $hashedPassword = Hash::make($newPassword);

        try{
            $data->password = $hashedPassword;
            $data->save();
            $respuesta = "Esta es tu nueva contraseña: " . $newPassword;
        }catch(\Exception $e){
            $respuesta = $e->getMessage();
        }

        return response($respuesta);
    }
    
    
    
}
