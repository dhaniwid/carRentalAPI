<?php namespace App\Http\Controllers;

/**
 * Created by: Ramadhani Widodo
 * Created date: 19 November 2016
 * Description: Car Controller
 */
use Request;
use App\Http\Controllers\Controller;
// My own customized use
use App\Car;

class CarController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
            // #661-CRUD-Car
            // List all of cars here
            $car = Car::all();
            
            return $car;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
            // #661-Crud-Car
            // Post new created car here
            // get POST value here
            $new_data = Request::all();
            // validate them
            $result = $this->customValidation($new_data);
            
            if ($result != NULL) {
                return $result;
            }
            
            // if everything is OK, proceed to store new data
            $car = new Car;
            
            $car->brand = $new_data['brand'];
            $car->type = $new_data['type'];
            $car->year = $new_data['year'];
            $car->color = $new_data['color'];
            $car->plate = $new_data['plate'];
            
            $car->save();
            
            return array("id" => $car->id);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
            // #661-CRUD-Car
            // find existing data within the id
            $car = Car::find($id);
            
            if ($car) {
                $edit_data = Request::all();
                // validate them
                $result = $this->customValidation($edit_data);

                if ($result != NULL) {
                    return $result;
                }
                
                // proceed to update
                $car->brand = $edit_data['brand'];
                $car->type = $edit_data['type'];
                $car->year = $edit_data['year'];
                $car->color = $edit_data['color'];
                $car->plate = $edit_data['plate'];
                
                $car->update();
                
                return array("Data successfully updated");
                
            } else {
                return array("No data found to be updated!");
            }
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
            // #661-CRUD-Car
            // Find existing data within the id
            $car = Car::find($id);
            
            if ($car) {
                // proceed to delete
                $car->delete();
                return array("Data successfully deleted");
            } else {
                return array("No data found to be deleted");
            }
	}

        /*
         * #661-CRUD-Car
         * Validation method
         */
        public function customValidation($data) {
            $error_messages = array();
            // check all mandatory fields
            // 1. Check brand
            if (empty($data['brand']) || $data['brand'] == "") {
                // put the error message
                array_push($error_messages, "Brand cannot be empty!\n");
            }
            
            // 2. Check type
            if (empty($data['type']) || $data['type'] == "") {
                // put the error message
                array_push($error_messages, "Type cannot be empty!\n");
            } 
            
            // 3. Check year
            if (empty($data['year']) || $data['year'] == "") {
                // put the error message
                array_push($error_messages, "Year cannot be empty!\n");
            } else {
                // check whether using year from future
                if ($data['year'] > date("Y")) {
                    array_push($error_messages, "Year cannot be from future!\n");
                }
            }
            
            // 4. Check color
            if (empty($data['color']) || $data['color'] == "") {
                // put the error message
                array_push($error_messages, "Color cannot be empty!\n");
            }
            
            // 5. Check plate
            if (empty($data['plate']) || $data['plate'] == "") {
                // put the error message
                array_push($error_messages, "Plate cannot be empty!\n");
            } else {
                // Check duplicated plate
                $car = Car::where('plate', '=', $data['plate'])->first();
                if ($car) {
                    // means already exists
                    array_push($error_messages, "Plate number already exists!\n");
                }
            }
            
            return $error_messages;
        }
        
}
