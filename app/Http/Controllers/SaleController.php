<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Sale;


class SaleController extends Controller
{
    //
    
    public function createSale(Request $request) {
        
        $response = "";
        
        /* Para crear el primer JSON de referencia */
		


		//Leer el contenido de la petición
		$data = $request->getContent();

		//Decodificar el json
		$data = json_decode($data);

		//Si hay un json válido, crear el libro
		if($data){
			$sale = new Sale();

			//TODO: Validar los datos antes de guardar el libro

			$sale->nameSale = $data->nameSale;
            $sale->copies = $data->copies;
            $sale->price = $data->price;   
            
            $sale->card_id = (isset($data->card_id) ? $data->card_id : $sale->card_id);

			try{
				$sale->save();
				$response = "OK";
			}catch(\Exception $e){
				$response = $e->getMessage();
			}

			
		}

		
		return response($response);
        
        
    }
    
    public function listSale(Request $request, $nameSale){

        $sale = Sale::where('nameSale','like','%'. $nameSale .'%')->get();


            $data = [];

            foreach ($sale as $a){

                $data[] =    [

                    'nameSale' => $a->nameSale,
                    'copies' => $a->copies,
                    'price' => $a->price,
                    'card_id' => $a->card_id

                ];
        }

        return $data;
    }
}
