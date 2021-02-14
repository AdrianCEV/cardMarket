<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Collection;
use App\Models\Card;

class CollectionController extends Controller
{
    //
    
    public function createCollection(Request $request) {
        
        $response = "";
        
        /* Para crear el primer JSON de referencia */
		


		//Leer el contenido de la petición
		$data = $request->getContent();

		//Decodificar el json
		$data = json_decode($data);

		//Si hay un json válido, crear el libro
		if($data){
			$collection = new Collection();
            $card = new Card();

			//TODO: Validar los datos antes de guardar el libro

			$collection->nameCollection = $data->nameCollection;
            $collection->symbol = $data->symbol;
            $collection->dateEdition = $data->dateEdition;   
            
            $card->nameCard = $data->nameCard;
            $card->description = $data->description;
            $card->collection = $data->collection;
            
            $card->collection_id = (isset($data->collection_id) ? $data->collection_id : $card->collection_id);

			try{
				$collection->save();
                $card->save();
				$response = "OK";
			}catch(\Exception $e){
				$response = $e->getMessage();
			}

			
		}

		
		return response($response);
        
        
    }
}
