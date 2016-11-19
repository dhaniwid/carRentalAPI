<?php namespace App;

/**
 * Created by: Ramadhani Widodo
 * Created date: 19 November 2016
 * Description: Client Model, created on #606 Ticket
 */

use Illuminate\Database\Eloquent\Model;

class Client extends Model {
    // tell Eloquent which table we're going to use
    protected $table = 'clients';
}
