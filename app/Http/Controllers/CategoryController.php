<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoryModel;
use App\Models\QuestionModels;
use App\Models\CategoryQuestionModel;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index(Request $request){
        $category = CategoryModel::orderBy('id', 'desc')->select(['id', 'title', 'type']);
        $oldValue = (object)[];
        if(isset($request['Title']) && !empty($request['Title'])){
            $category = $category->where('title', 'like', '%'. $request['Title'] . '%');
            $oldValue->Title = $request['Title'];
        }
        $category = $category->paginate(User::PAGINATE);
        return view('categories.category', compact('category', 'oldValue'));
    }

    public function create(){
        $questions = QuestionModels::all(['id', 'title']);
        return view('categories.category-create', compact('questions'));
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'type' => 'required|in:' . implode(',',
                [ CategoryModel::TYPE_PUBLIC, CategoryModel::TYPE_PRIVATE ]),
            'questions' => 'required|array',
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'data' => [],
                'mess' => $validator->errors(),
            ]);
        }
        DB::beginTransaction();
        try{
            $category = CategoryModel::create([
                'title' => $request['title'],
                'type' => $request['type'],
            ]);
            foreach($request['questions'] as $value){
                CategoryQuestionModel::create([
                    'category_id' => $category['id'],
                    'question_id' => $value,
                ]);
            }
            DB::commit();
            return response()->json([
                'status' => true,
                'data' => [],
                'mess' => 'Success',
            ]);
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json([
                'status' => false,
                'data' => [],
                'mess' => $e,
            ]);
        }
    }

    public function edit($id){
        $category = CategoryModel::find($id);
        $questions = QuestionModels::all(['id', 'title']);
        $questionHasCheck = CategoryQuestionModel::where('category_id', $id)->pluck('question_id')->toArray();
        return view('categories.category-create', compact('category', 'questions', 'questionHasCheck'));
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'type' => 'required|in:' . implode(',',
                [ CategoryModel::TYPE_PUBLIC, CategoryModel::TYPE_PRIVATE ]),
            'questions' => 'required|array',
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'data' => [],
                'mess' => $validator->errors(),
            ]);
        }
        DB::beginTransaction();
        try{
            $category = CategoryModel::find($id);
            $category->update([
                'title' => $request['title'],
                'type' => $request['type'],
            ]);
            CategoryQuestionModel::where('category_id', $id)->delete();
            foreach($request['questions'] as $value){
                CategoryQuestionModel::create([
                    'category_id' => $id,
                    'question_id' => $value
                ]);
            }
            DB::commit();
            return response()->json([
                'status' => true,
                'data' => [],
                'mess' => "Success",
            ]);
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json([
                'status' => false,
                'data' => [],
                'mess' => $e,
            ]);
        }
    }

    public function destroy($id){
        DB::beginTransaction();
        try{
            CategoryModel::find($id)->delete();
            CategoryQuestionModel::where('category_id', $id)->delete();
            DB::commit();
            return redirect()->route('categories.index');
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json([
                'status' => false,
                'data' => [],
                'mess' => $e,
            ]);
        }
    }

    public function copy($id){
        DB::beginTransaction();
        try{
            CategoryModel::find($id)->replicate()->save();
            $categoryQuestion = CategoryQuestionModel::where('category_id', $id)->get();
            $lastID =  CategoryModel::latest('id')->first(['id']);
            foreach($categoryQuestion as $value){
                $newCategoryQuestion = $value->replicate();
                $newCategoryQuestion['category_id'] = $lastID['id'];
                $newCategoryQuestion->save();
            }
            DB::commit();
            return redirect()->route('categories.index');
        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'status' => false,
                'data' => [],
                'mess' => $e,
            ]);
        }
    }
}
