<?php

class AdminController extends BaseController {



	public function Index()
	{
	
		
		//$carros = DB::table('cars')->Join('models', 'cars.idModels', '=', 'models.idModels')->leftJoin('brands','models.idBrands','=', 'brands.idBrands')->get();
		return View::make('admin.listar_carro');
	}
	public function Create()
	{
		$brands = Brand::all();
		$fuels = Fuel::all();
		$exchanges = Exchange::all();
		$colors = Color::all();
		
		return View::make('admin.cadastrar_carro', compact('brands', 'fuels', 'exchanges', 'colors'));

	}
	public function gravaImg()
	{
		$filename 		 =  Time(). Input::file("file")->getClientOriginalName();
		$upload_success = Input::file("file")->move('img/carros', $filename);
		if( $upload_success ) {
	        	return Response::json('success', 200);
	        } else {
	        	return Response::json('error', 400);
	        }

	}
	public function edit($id)
	{
			$brands = Brand::all();
			$fuels = Fuel::all();
			$exchanges = Exchange::all();
			$colors = Color::all();
		    $car = Car::findOrFail($id);
			$model = Model::where('idModels', '=', $car->idModels)->first();
			$image= Image::where('idCars', '=', $car->idCars);
			$item =  Item::findOrFail($car->idItems);
			return View::make('admin.editar_carro', compact('car','image', 'brands', 'fuels', 'exchanges', 'colors','model', 'items'));	
	}
	public function update($id)
	{

		$modelo = new Model();
		$item = new Item();
		$carro = new Car();

	
		$carro = Car::findOrFail($id);
		$modelo =  Model::findOrFail($carro->idModels);
		$item =  Item::findOrFail($carro->idItems);
		
		$modelo->descModelos =Input::get('descModelos');
		$modelo->idBrands = Input::get('idBrands');
		$modelo->save();
		
 	
 	
 	
		$item->airBag =Input::get('airBag');
		$item->alarme = Input::get('alarme');
		$item->arCondicionado = Input::get('arCondicionado');
		$item->bancoMotoristaAjusteAltura = Input::get('bancoMotoristaAjusteAltura');
		$item->save();
		
	    $lastModeloRecord =  Model::all()->last();
 	    $lastItemoRecord =  Item::all()->last();
	
		$carro->idFuels = Input::get('idFuels');
		$carro->idExchange = Input::get('idExchange');
		$carro->idItems = $lastItemoRecord->idItems;
		$carro->idColors = Input::get('idColors');
		$carro->idModels = $lastModeloRecord->idModels;
		$carro->placaCarro = Input::get('placaCarro');
		$carro->anoModelo = Input::get('anoModelo');
		$carro->precoCarro = Input::get('precoCarro');
		$carro->quilometragemCarro = Input::get('quilometragemCarro');
		//print_r($carro);
		$carro->save();
		
		return Redirect::action('AdminController@index');

	}

	public function Store()	
	{
		//---Cria Modelo---//
		$modelo = new Model();
		$modelo->descModelos =Input::get('descModelos');
		$modelo->idBrands = Input::get('idBrands');
		$modelo->save();
		//-------fim Cria Modelo---------//
 		
 		//----Cria Item---//
 		$item = new Item();
		$item->airBag =Input::get('airBag');
		$item->alarme = Input::get('alarme');
		$item->arCondicionado = Input::get('arCondicionado');
		$item->bancoMotoristaAjusteAltura = Input::get('bancoMotoristaAjusteAltura');
		$item->save();
 		//-----fim cria item--------//

		//-----Pega último registro para cadastrar o carro------//
 	    $lastModeloRecord =  Model::all()->last();
 	    $lastItemoRecord =  Item::all()->last();
		//----------------------------------------//

		//----Cria Carro---//
		$carro = new Car();
		$carro->idFuels = Input::get('idFuels');
		$carro->idExchange = Input::get('idExchange');
		$carro->idItems = $lastItemoRecord->idItems;
		$carro->idColors = Input::get('idColors');
		$carro->idModels = $lastModeloRecord->idModels;
		$carro->placaCarro = Input::get('placaCarro');
		$carro->anoModelo = Input::get('anoModelo');
		$carro->precoCarro = Input::get('precoCarro');
		$carro->quilometragemCarro = Input::get('quilometragemCarro');
		//print_r($carro);
		$carro->save();
		//--Fim Cria Carro--//

		return Redirect::action('AdminController@index');
	}
	public function destroy($id)
	{
			$car = Car::findOrFail($id);
			$image = Image::where('idCars','=', $car->idCars)->delete();
			$car->delete();

		return Redirect::action('AdminController@index');
	}

}
