<?php namespace App\Http\Controllers;

/**
 * Created by: Ramadhani Widodo
 * Created date: 19 November 2016
 * Description: Client Controller
 */
use Request;
use App\Http\Controllers\Controller;
// My own customized use
use App\Client;

class ClientController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{   
            // #606-CRUD-Clients
            // List all of clients here
            $client = Client::all();
            
            return $client;
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
            // #606-Crud-Clients
            // Post new created user here
            // get POST value here
            $new_data = Request::all();
            // validate them
            $result = $this->customValidation($new_data);
            
            if ($result != NULL) {
                return $result;
            }
            
            // if everything is OK, proceed to store new data
            $client = new Client;
            
            $client->name = $new_data['name'];
            $client->gender = $new_data['gender'];
            
            $client->save();
            
            return array("id" => $client->id);
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
            // #606-CRUD-Client
            // find existing data within the id
            $client = Client::find($id);
            
            if ($client) {
                $edit_data = Request::all();
                // validate them
                $result = $this->customValidation($edit_data);

                if ($result != NULL) {
                    return $result;
                }
                
                // proceed to update
                $client->name = $edit_data["name"];
                $client->gender = $edit_data["gender"];
                
                $client->update();
                
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
            // #606-CRUD-Client
            // Find existing data within the id
            $client = Client::find($id);
            
            if ($client) {
                // proceed to delete
                $client->delete();
                return array("Data successfully deleted");
            } else {
                return array("No data found to be deleted");
            }
	}
        
        /*
         * #606-CRUD-Client
         * Validation method
         */
        public function customValidation($data) {
            $error_messages = array();
            // check all mandatory fields
            // 1. Check name
            if (empty($data['name']) || $data['name'] == "") {
                // put the error message
                array_push($error_messages, "Name cannot be empty!\n");
            }
            
            // 2. Check gender
            if (empty($data['gender']) || $data['gender'] == "") {
                // put the error message
                array_push($error_messages, "Gender cannot be empty!\n");
            } else {
                // check the values, should be either "male" or "female"
                switch ($data['gender']) {
                    case "male": break;
                    case "female": break;
                    default: 
                    // put the error message
                    array_push($error_messages, "No other gender than male or female please!\n");break;
                }
            }
            
            return $error_messages;
        }
}
