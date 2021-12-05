<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CategoryModel;
use App\Models\QuestionModels;
use App\Http\Requests\handleAnwser;
use App\Models\AnwserModel;
use App\Models\AnwserQuestionModel;
use App\Models\CategoryQuestionModel;
use App\Models\UserAnwserModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FrontController extends Controller
{
    public function getAnwser(Request $request){
        require_once('../public/js/declare.php');
        $categories = CategoryModel::all();
        if(!isset($request['category_id']) && empty($request['category_id'])){
            $request['category_id'] = 1;
        }
        $categoryQuestion = CategoryQuestionModel::where('category_id', $request['category_id'])->get();
        $questions = [];
        if($categoryQuestion){
            foreach($categoryQuestion as $value){
                array_push($questions, QuestionModels::find($value['question_id']));
            }
        }
        $cities = User::groupBy('city')->pluck('city');
        $wards = [];
        $user = User::get();
        foreach($questions as $key => $value){
            $anwser = AnwserModel::where('question_id', $value['id'])->get(['title']);
            $form[$key]['anwser'] = [];
            foreach($anwser as $item){
                array_push($form[$key]['anwser'], $item);
            }
            $form[$key]['title'] = $value['title'];
            $form[$key]['type'] = $value['type_checkbox'];
            $form[$key]['require'] = $value['require'];
            $form[$key]['db'] = true;
            $form[$key]['content'] = [];
            $form[$key]['key'] = 'questions';
            $form[$key]['more'] = $value['more'];
            $form[$key]['id'] = $value['id'];
        }
        return view('frontend.front', compact('categories', 'questions', 'form', 'cities', 'wards'));
    }

    public function postAnwser(handleAnwser $request){
        DB::beginTransaction();
        try{
            $userAnwser = UserAnwserModel::create([
                'user_id' => $request['qquser_id'],
                'category_id' => $request['category_id'],
            ]);
            foreach($request->all() as $key => $value){
                if(is_array($value)){
                    if(count($value) > 0){
                        if($value[0] != null){
                            AnwserQuestionModel::create([
                                'user_anwser_id' => $userAnwser['id'],
                                'question_id' => $key,
                                'anwser' => implode(',', $value),
                            ]);
                        }
                    }
                }
            }
            DB::commit();
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'status' => false,
                'data' => [],
                'mess' => $e,
            ]);
        }
    }

    public function getUser(Request $request){
        $validator = Validator::make($request->all(), [
            'post_code' => 'required',
            'city' => 'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'data' => [],
                'mess' => $validator->errors(),
            ]);
        }
        $status = false;
        $user = User::select(['id', 'name', 'ward']);
        if(isset($request['post_code']) && !empty($request['post_code'])){
            $user = $user->where('post_code', $request['post_code']);
            $status = true;
        }
        if(isset($request['city']) && !empty($request['city'])){
            $user = $user->where('city', $request['city']);
            $status = true;
        }
        if(isset($request['ward']) && !empty($request['ward'])){
            $user = $user->where('ward', $request['ward']);
            $status = true;
        }
        if(isset($request['name']) && !empty($request['name'])){
            $user = $user->where('name', $request['name']);
            $status = true;
        }
        $status ? $user = $user->get() : $user = [];
        return response()->json([
            'status' => true,
            'data' => $user,
            'mess' => 'Success',
        ]);
    }
}
