<?php

namespace App\Http\Controllers\Parent;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Auth;
use Datatables;

use App\models\Parents;
use App\models\Invoice;
use App\models\InvoiceItem;

class InvoiceController extends BaseController{
    function all(){
        $user_id = Auth::user()->id;

        $this->setPageTitle('Invoices', 'View All Invoices');
        return view('include.rolebase-views.parentpanel.invoice.all', [
            "parent_id" => $user_id,
        ]);
    }
    function datatable(Request $req){
        $parent_id = $req->parent_id;
        $Invoice = Invoice::whereHas('getParent', function($q) use($parent_id){
            $q->where('user_id', $parent_id);
        })
        ->with([
            'getParent',
            "getCreatedBy"
        ])->latest();
        
        return Datatables::of($Invoice)
        ->addColumn('action', function ($Invoice) {

            $viewInvoice = route('parentpanel.student.lesson.view_invoice', $Invoice->id);
            $ret = "";
            $ret .= '<a href="'.$viewInvoice.'"><i class="fa fa-eye ms-text-danger"></i></a>';

            return $ret;

        })
        ->rawColumns(['action', 'image'])
        ->make(true);
    }
    function view_invoice($id){
        $this->setPageTitle('Invoices', 'View All Invoices');
        $data = Invoice::where([
            "id" => $id
        ])->with([
            "getInvoiceItems" => function($q){
                $q->with([
                    "getStudent",
                ]);
            },
            'getParent',
            "getCreatedBy"
        ])->first();
       // dd($data);
        return view('include.rolebase-views.parentpanel.invoice.individual_invoice',[
            "invoice_no" => $data->id,
            "invoice_create_date" => $data->date,
            "invoice_data" => $data,
        ]);
    }
    function save_invoice(Request $req){
        echo 1;
    }
}