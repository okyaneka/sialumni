<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class DownloadDataController extends Controller
{
    //
    function index()
    {
    	return view('downloads.get');
    }

    function download()
    {
    	$filename = 'Data Alumni';

    	return Excel::download(new UsersExport, $filename.'.xlsx');
    }
}
