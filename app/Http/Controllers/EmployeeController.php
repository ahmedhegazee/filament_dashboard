<?php

namespace App\Http\Controllers;

use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $country = $request->get('country');
        $state = $request->get('state');
        $city = $request->get('city');
        $department = $request->get('department');
        $query = Employee::when($country, fn ($query) => $query->where('country_id', $country))
            ->when($city, fn ($query) => $query->where('city_id', $city))
            ->when($department, fn ($query) => $query->where('department_id', $department))
            ->when($state, fn ($query) => $query->where('state_id', $state))
            ->with(['department', 'city', 'country', 'state'])
            ->orderBy('last_name')
            ->paginate();
        return EmployeeResource::collection($query);
    }
}