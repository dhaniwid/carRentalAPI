<?php namespace App\Http\Controllers;

/**
 * Created by: Ramadhani Widodo
 * Created date: 19 November 2016
 * Description: Rental Controller
 */
use Request,
    Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
// My own customized use
use App\Rental;

class RentalController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
            // #664-CRUD-Rental
            // List all of cars here
            $rental = Rental::all();
            
            return $rental;
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
            // #664-Crud-Rental
            // Post new created car here
            // get POST value here
            $new_data = Request::all();
            // validate them
            $result = $this->customValidation($new_data);
            
            if ($result != NULL) {
                return $result;
            }
            
            // business validation
            $bus_result = $this->businessValidation($new_data);
            
            if ($bus_result != NULL) {
                return $bus_result;
            }
            
            // if everything is OK, proceed to store new data
            $rental = new Rental;
            
            $rental->car_id = $new_data['car_id'];
            $rental->client_id = $new_data['client_id'];
            $rental->date_from = $new_data['date_from'];
            $rental->date_to = $new_data['date_to'];
            
            $rental->save();
            
            return array("id" => $rental->id);
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
            // #664-CRUD-Rental
            // find existing data within the id
            $rental = Rental::find($id);
            
            if ($rental) {
                $edit_data = Request::all();
                // validate them
                $result = $this->customValidation($edit_data);

                if ($result != NULL) {
                    return $result;
                }
                
                // business validation
                $bus_result = $this->businessValidation($edit_data, $id);

                if ($bus_result != NULL) {
                    return $bus_result;
                }
                
                // proceed to update
                $rental->car_id = $edit_data['car_id'];
                $rental->client_id = $edit_data['client_id'];
                $rental->date_from = $edit_data['date_from'];
                $rental->date_to = $edit_data['date_to'];
                
                $rental->update();
                
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
            // #664-CRUD-Rental
            // Find existing data within the id
            $rental = Rental::find($id);
            
            if ($rental) {
                // proceed to delete
                $rental->delete();
                return array("Data successfully deleted");
            } else {
                return array("No data found to be deleted");
            }
	}

        /*
         * #664-CRUD-Rental
         * Validation method
         */
        public function customValidation($data) {
            $error_messages = array();
            // check all mandatory fields
            // 1. Check Car ID
            if (empty($data['car_id']) || $data['car_id'] == "") {
                // put the error message
                array_push($error_messages, "Car ID cannot be empty!\n");
            } else {
                // check existence of the car_id
                $car = \App\Car::find($data['car_id']);
                
                if ($car == NULL) {
                    // doesn't exist
                    array_push($error_messages, "Car doesn't exist!\n");
                }
            }
            
            // 2. Check Client ID
            if (empty($data['client_id']) || $data['client_id'] == "") {
                // put the error message
                array_push($error_messages, "Client ID cannot be empty!\n");
            } else {
                // check existence of the client_id
                $client = \App\Client::find($data['client_id']);
                
                if ($client == NULL) {
                    // doesn't exist
                    array_push($error_messages, "Client doesn't exist!\n");
                }
            }
            
            // 3. Check Date From
            if (empty($data['date_from']) || $data['date_from'] == "") {
                // put the error message
                array_push($error_messages, "Date From cannot be empty!\n");
            } else {
                // check date validation
                if ($data['date_from'] > $data["date_to"]) {
                    array_push($error_messages, "Date From cannot be more than Date To!\n");
                }
            }
            
            // 4. Check Date To
            if (empty($data['date_to']) || $data['date_to'] == "") {
                // put the error message
                array_push($error_messages, "Date To cannot be empty!\n");
            } else {
                // check date validation
                if ($data['date_to'] < $data["date_from"]) {
                    array_push($error_messages, "Date To cannot be less than Date From!\n");
                }
            }
            
            return $error_messages;
        }
        
        /*
         * #664-CRUD-Rental
         * Business validation method
         */
        
        public function businessValidation ($data, $id = NULL) {
            $error_messages = array();
            // check whether client is renting another car at selected rent date
            $client_rent = DB::select("select r.* from rentals r where r.client_id = ? and ((r.date_from BETWEEN ? AND ?) 
                or (r.date_to BETWEEN ? AND ?));", array($data['client_id'], $data['date_from'], $data['date_to'], $data['date_from'], $data['date_to']));
            
            if ($client_rent) {
                if ($id != NULL && $id != $client_rent[0]->id) {
                    // client is renting another car at selected date
                    array_push($error_messages, "Client is renting another car at selected date!");
                }
            }
            
            // check whether car is being rented at selected date
            $car_rented = DB::select("select r.* from rentals r where r.car_id = ? and ((r.date_from BETWEEN ? AND ?) 
                or (r.date_to BETWEEN ? AND ?));", array($data['car_id'], $data['date_from'], $data['date_to'], $data['date_from'], $data['date_to']));
            
            if ($car_rented) {
                if ($id != NULL && $id != $car_rented[0]->id) {
                    // client is renting another car at selected date
                    array_push($error_messages, "Car is being rented at selected date!");
                }
            }
            
            // check duration of selected date
            $date_from = strtotime($data['date_from']);
            $date_to = strtotime($data['date_to']);
            
            $datediff = $date_to - $date_from;
            $datediff_real = $datediff / (60 * 60 * 24);
            
            if ($datediff_real >= 3) {
                // client is going to rent car more than 3 days
                array_push($error_messages, "Maximum 3 days for renting our cars!");
            }
            
            // check whether date is +1 day from current day until +7 days from current day
            $today = strtotime(date("Y-m-d"));
            $tomorrow = date('Y-m-d', strtotime("+1 day", $today));
            $week_later = date('Y-m-d', strtotime("+7 day", $today));
            
            if ($data['date_from'] < $tomorrow || $data['date_to'] > $week_later 
                    || $data['date_from'] > $week_later) {
                array_push($error_messages, "Please select rent date between +1 day from current day until +7 days from current day!");
            }
            
            return $error_messages;
        }
        
        /*
         * 669-Available-Car-Information
         */
        public function getAvailableCars ($date) {
            // check date format
            if (!$this->validateDate($date)) {
                return "Please set date on correct format (DD-MM-YYYY)";
            }
            
            // check whether car is being rented at selected date
            $cars = DB::select("select c.brand, c.type, c.plate
                        from rentals r 
                        left join cars c on c.id = r.car_id
                        where 1=1
                        and r.car_id NOT IN (select car_id from rentals 
                        where date_format(date_from, '%d-%m-%Y') = ? or date_format(date_to, '%d-%m-%Y') = ?);", array($date, $date));
            
            if ($cars) {
                return array("date" => $date, "free_cars" => $cars);
            } else {
                return array("date" => $date, "free_cars" => "No cars available");
            }
        }
        
        /*
         * 668-Rented-Car-Information
         */
        public function getRentedCars ($date) {
            // check date format
            if (!$this->validateDate($date)) {
                return "Please set date on correct format (DD-MM-YYYY)";
            }
            
            // check whether car is being rented at selected date
            $cars = DB::select("select c.brand, c.type, c.plate 
                        from rentals r 
                        left join cars c on c.id = r.car_id
                        where 1=1
                        and r.car_id IN (select car_id from rentals 
                        where date_format(date_from, '%d-%m-%Y') = ? or date_format(date_to, '%d-%m-%Y') = ?);", array($date, $date));
            
            if ($cars) {
                return array("date" => $date, "rented_cars" => $cars);
            } else {
                return array("date" => $date, "rented_cars" => "No cars rented");
            }
        }
        
        // validating date
        function validateDate($date) {
            $d = \DateTime::createFromFormat('d-m-Y', $date);
            
            if ($d && $d->format('d-m-Y') == $date) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
}
