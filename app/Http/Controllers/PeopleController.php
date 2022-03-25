<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PeopleController extends Controller
{
    public function index(Request $request)
    {
        $orderBy = ($request->query('orderby') !== null) ? $request->query('orderby') : 'id';
        $filterName = ($request->query('filtername') !== null) ? $request->query('filtername') : '';

        return DB::table('people')
        ->select('*')
        ->where('name','LIKE',"%{$filterName}%")
        ->orderBy($orderBy)
        ->paginate(3);
    }

    public function show($id)
    {
        return DB::table('people')
        ->select('people.id','people.name','people.planet_id','planets.name','planets.rotation_period','planets.orbital_period','people.created_at','people.updated_at')
        ->join('planets','people.planet_id','=','planets.id')
        ->where('people.id','=',$id)
        ->limit(1)
        ->get();
    }
}