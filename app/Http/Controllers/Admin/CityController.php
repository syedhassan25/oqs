<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\models\Country;
use App\models\City;
use Datatables;
use Illuminate\Support\Facades\Gate;

class CityController extends BaseController
{



    public function get_city_forms(Request $request)
    {
        $City = City::leftJoin('countries', 'countries.id', '=', 'cities.CountryID')->select('cities.*','countries.CountryName');
        
        if($request->countryid){
            $City->where('CountryID',$request->countryid);
        }else{
            $City->where('CountryID',167);
        }
       $City->get();

        return Datatables::of($City)
            ->addColumn('action', function ($City) {

                $editurl = route('admin.city.edit', $City->id);
                $deleteurl = route('admin.city.delete', $City->id);
              

                $ret = '';
                if (Gate::allows('city-edit')) {
                    $ret .= '<a class="" href="' . $editurl . '" ><i class="fa fa-pencil"></i></a>&nbsp;|&nbsp;';
                }

                if (Gate::allows('city-delete')) {
                    $ret .= '<a  href="' . $deleteurl . '" onclick="return confirm(`Are you sure? Once deleted, you will not be able to recover this data`)" ><i class="fa fa-trash ms-text-danger"></i></a>';
                }

                return $ret;

            })
            ->rawColumns(['action','image'])
            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $countrys =  Country::get();
        $this->setPageTitle('City', 'View All City');
        return view('admin.city.index',compact('countrys'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         $countrys =  Country::get();
        $this->setPageTitle('Create City', 'City');
        return view('admin.city.create',compact('countrys'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'Country' => 'required',
            'CityName' => 'required',
        ]);


      
        $City  = new City();
        $City->CityName = $request->CityName;
        $City->CountryID = $request->Country;
        $City->save();
      
        if (!$City) {
            return $this->responseRedirectBack('Error occurred while creating City.', 'error', true, true);
        }
        return $this->responseRedirect('admin.city.index', 'City added successfully', 'success', false, false);
 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $targetCity = City::find($id);
      
        $this->setPageTitle('City', 'Edit City : ' . $targetCity->CityName);
        $countrys =  Country::get();
        return view('admin.city.edit', compact('targetCity','countrys'));
    }

    public function get_city_by_country($id){
        return City::where('CountryID',$id)->get();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'Country' => 'required',
            'CityName' => 'required',
        ]);


      
        $City  = new City();
        $City->CityName = $request->CityName;
        $City->CountryID = $request->Country;
        $City->exists = true;
        $City->id = $request->id;
        $City->save();
      
        if (!$City) {
            return $this->responseRedirectBack('Error occurred while updating City.', 'error', true, true);
        }
        return $this->responseRedirectBack('City updated successfully', 'success', false, false);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
