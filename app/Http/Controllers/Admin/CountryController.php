<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\models\Country;
use Datatables;
use Illuminate\Support\Facades\Gate;

class CountryController extends BaseController
{


    public function get_country_forms()
    {
        $Country = Country::get();

        return Datatables::of($Country)
            ->addColumn('action', function ($Country) {

                $editurl = route('admin.country.edit', $Country->id);
                $deleteurl = route('admin.country.delete', $Country->id);
              

                $ret = '';
                if (Gate::allows('country-edit')) {
                    $ret .= '<a class="" href="' . $editurl . '" ><i class="fa fa-pencil"></i></a>&nbsp;|&nbsp;';
                }

                if (Gate::allows('country-delete')) {
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
        $this->setPageTitle('Country', 'View All Country');
        return view('admin.country.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->setPageTitle('Create Country', 'Create Country');
        return view('admin.country.create');
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
            'CountryName' => 'required',
            'currency' => 'required',
            'code' => 'required',
            'currencysymbol' => 'required',
        ]);


      
        $country  = new Country();
        $country->CountryName = $request->CountryName;
        $country->CountryShortName = $request->CountryShortName;
        $country->currency = $request->currency;
        $country->code = $request->code;
        $country->symbol = $request->currencysymbol;
        $country->save();
      
        if (!$country) {
            return $this->responseRedirectBack('Error occurred while creating Country.', 'error', true, true);
        }
        return $this->responseRedirect('admin.country.index', 'Country added successfully', 'success', false, false);
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
        $targetCountry = Country::find($id);
      
        $this->setPageTitle('Country', 'Edit Country : ' . $targetCountry->CountryName);
        return view('admin.country.edit', compact('targetCountry'));
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
            'CountryName' => 'required|max:191',
            'currency' => 'required',
            'code' => 'required',
            'currencysymbol' => 'required',
        ]);

       

        $Country = new Country();
        $Country->CountryName = $request->CountryName;
        $Country->CountryShortName = $request->CountryShortName;
        $Country->currency = $request->currency;
        $Country->code = $request->code;
        $Country->symbol = $request->currencysymbol;
        $Country->id = $request->id;
        $Country->exists = true;
        $Country->save();
        if (!$Country) {
            return $this->responseRedirectBack('Error occurred while updating Country.', 'error', true, true);
        }
        return $this->responseRedirectBack('Country updated successfully', 'success', false, false);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $Country = Country::where('id',$id)->delete();

        if (!$Country) {
            return $this->responseRedirectBack('Error occurred while deleting country.', 'error', true, true);
        }
        return $this->responseRedirect('admin.country.index', 'Country deleted successfully', 'success', false, false);
    }
}
