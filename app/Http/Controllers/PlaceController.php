<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePlaceRequest;
use App\Http\Requests\UpdatePlaceRequest;
use App\Models\Place;
use Illuminate\Http\Request;
use App\Repositories\PlaceRepository;

class PlaceController extends Controller
{

    public function __construct(Place $places)
    {
        $this->places = $places;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $placeRepository = new PlaceRepository($this->places);

       

        if($request->has('filter')) {
            $placeRepository->filter($request->filter);
        }else{
            
        }

        return  response()->json($placeRepository->getResult(),200); 
    }
    

   /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePlaceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePlaceRequest $request)
    {

        $request->validate($this->places->rules(),$this->places->feedback());
        $place = $this->places->create([
            'name' => $request->name,
            'slug' => $request->slug,
            'city' => $request->city,
            'state' => $request->state,
            'status' => true
        ]);
       
        return response()->json($place,201);
    }

     /**
     * Display the specified resource.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $place = $this->places->find($id);
        if($place === null){
            return response()->json(['error' => 'Place Not exist'],404); 
            
        }
        return response()->json($place,200);
    }

   
    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePlaceRequest  $request
     * @param  Integer
     * @return \Illuminate\Http\Response
     */

    public function update(UpdatePlaceRequest $request, $id)
    {
        $places = $this->places->find($id);

        if($places === null) {
            return response()->json(['erro' => 'Impossível realizar a atualização. O recurso solicitado não existe'], 404);
        }

        if($request->method() === 'PATCH') {

            $regrasDinamicas = array();

            //going through all the rules defined in the Model
            foreach($places->rules() as $input => $regra) {
                
                //collect only the rules applicable to the partial parameters of the PATCH request
                if(array_key_exists($input, $request->all())) {
                    $regrasDinamicas[$input] = $regra;
                }
            }
            
            $request->validate($regrasDinamicas, $places->feedback());

        } else {
            $request->validate($places->rules(), $places->feedback());
        }
        $places->update($request->all());
        return response()->json($places,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {

        $places = $this->places->find($id);
        if($places === null){
            return response()->json(['error' => 'places not exist'],404);
        }
        $places->update([
            'status' => 0
        ]);
        return response()->json(['status' => 'successfully deleted'],200); 
    }
}
