<?php

namespace App\Http\Controllers;

use App\TagModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use function PHPSTORM_META\map;

class ApiController extends Controller
{
    public function _construct()
    {
        
    }
    public function autocomplete(Request $request)
    {
            $value = $request->get('value');
            $data = DB::table('tags')
                    ->where('name', 'LIKE', '%'.$value.'%')
                    ->get()
                    ->map(function ($tags)
                    {
                        return [
                            'id'      => $tags->id,
                            'value'   => $tags->name,
                        ];
                    });
            return response()->json($data);
        
    }
    public function createTags(Request $request)
    {

        $value = $request->get('value');
        if ($value != '') {
           TagModel::create(['name' => $value]);
            return response()->json(['success' => '<div class="alert alert-success" role="alert">Tag created</div>']);
        }else{
            return response()->json(['error' => '<div class="alert alert-danger" role="alert">Tag already exist or something went wrong.</div>']); 
        }
    }
}
