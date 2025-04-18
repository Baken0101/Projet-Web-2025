<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;   // Provides authorize() and policy helpers
use Illuminate\Foundation\Bus\DispatchesJobs;               // Enables dispatching of queued jobs
use Illuminate\Foundation\Validation\ValidatesRequests;     // Adds the validate() method for incoming requests
use Illuminate\Routing\Controller as BaseController;        // Core Laravel controller functionality

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
