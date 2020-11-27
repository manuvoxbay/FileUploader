<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use App\FileHandler;
use App\History;
use Illuminate\Support\Facades\DB;
use Config;

class FileController extends Controller
{

	public function index(Request $request)
	{	
		try
		{
			$pages							= Config::get('file_config.pagination');
			$query 							= FileHandler::query();
			if(!empty($request->search))
			{
				if(@preg_match($request->search, null) !== false)
				{
					$query 					= $query->where('file', 'REGEXP', $request->search);
				}
				else
				{
					$query 					= $query->where('file','like',$request->search.'%');
				}
			}			
			$files 							= $query->paginate($pages);
			if(!$files)
			{
				Session::flash('error', "Error:: Failed to load files");
				return view('welcome',[]);
			}
			return view('welcome',compact('files'));
		}
		catch(\Exception $e)
		{
			Session::flash('error', "Error:: Failed to load files");
			return view('welcome',[]);
		}
	}


    public function save(Request $request)
    {
    	$request->validate([
    	    'image' 					=> 'required|mimes:txt,doc,docx,pdf,png,jpeg,jpg,gif|max:2048',
    	]);

    	DB::beginTransaction();
    	try
    	{
			if ($request->hasFile('image')) 
			{
				if ($request->file('image')->isValid()) 
				{
					$rand_name 			= Str::uuid()->toString();
					$extension 			= $request->image->extension();
					$url 				= $request->image->storeAs('/public/files', $rand_name.".".$extension);
					$file_name 			= $rand_name.".".$extension;

					if(empty($url))
					{
						Session::flash('error', "Error:: Failed to upload file");
						return back();
					}

					$fileInfo			= new FileHandler();
					$fileInfo->file 	= $file_name;
					$fileInfo->save();

					$fileInfo			= new History();
					$fileInfo->file 	= $file_name;
					$fileInfo->save();
				}
			}
			DB::commit();
			Session::flash('success', "Success:: File uploaded successfully");
			return \Redirect::back();
    	}
    	catch(\Exception $e)
    	{
    		DB::rollBack();
    		Session::flash('error', "Error:: Failed to upload file");
    		return back();
    	}
    }

    public function delete(Request $request)
    {
    	$request->validate([
    	    'file_id' 					=> 'required|bail|numeric|exists:file_handlers,id',
    	]);

    	DB::beginTransaction();
    	try
    	{
    		$fileData 					= FileHandler::findOrFail($request->file_id);
    		$file 						= $fileData->file;
    		$path 						= public_path().'/storage/files/'.$file;

    		if(file_exists($path))
    		{
    			unlink($path);
    		}
    		$fileData->delete();

    		$fileInfo			= new History();
    		$fileInfo->file 	= $file;
    		$fileInfo->type 	= 2;
    		$fileInfo->save();

    		DB::commit();
    		Session::flash('success', "Success:: File deleted successfully");
    		return \Redirect::back();
    	}
    	catch(\Exception $e)
    	{
    		DB::rollBack();
    		Session::flash('error', "Error:: Failed to delete file");
    		return back();
    	}
    }

    public function history()
    {
    	try 
    	{
    		$pages							= Config::get('file_config.pagination');
    		$files 							= History::paginate($pages);

    		return view('history',compact('files'));
    	}
		catch(\Exception $e)
		{			
			Session::flash('error', "Error:: Failed to load data");
			return back();
		}
    }
}
