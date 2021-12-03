<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QuestionModels;
use App\Models\CategoryQuestionModel;
use App\Models\AnwserModel;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class QuestionController extends Controller
{
    public function index(Request $request){
        $questions = QuestionModels::orderBy('id', 'desc')->select(['id', 'title', 'type_checkbox']);
        $oldValue = (object)[];
        if(isset($request['Title']) && !empty($request['Title'])){
            $questions = $questions->where('title', 'like', '%'. $request['Title'] . '%');
            $oldValue->Title = $request['Title'];
        }
        if(isset($request['Type']) && !empty($request['Type'])){
            $questions = $questions->where('type_checkbox', 'like', '%'. $request['Type'] . '%');
            $oldValue->Type = $request['Type'];
        }
        $questions = $questions->paginate(User::PAGINATE);
        $questions->map(function($value){
            $value['type_checkbox'] = QuestionModels::CHECKBOX_NAME[$value['type_checkbox']] ?? 'error';
            return $value;
        });
        return view('questions.question', compact('questions', 'oldValue'));
    }

    public function create(){
        return view('questions.question-create');
    }

    public function store(Request $request){
        // return response()->json(['data' => $request->all()]);
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'type_checkbox' => 'required|in:' . implode(',', [
                QuestionModels::TYPE_RADIO,
                QuestionModels::TYPE_CHECK_BOX,
                QuestionModels::TYPE_INPUT
            ]),
            'anwsers' => 'required|array|min:2',
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
            $question = QuestionModels::create([
                'title' => $request['title'],
                'type_checkbox' => $request['type_checkbox'],
                'require' => $request['require'],
                'more' => $request['more'],
            ]);
            foreach($request['anwsers'] as $value){
                AnwserModel::create([
                    'question_id' => $question['id'],
                    'title' => $value,
                ]);
            }
            DB::commit();
            return response()->json([
                'status' => true,
                'data' => [],
                'mess' => 'Success',
            ]);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'status' => false,
                'data' => [],
                'mess' => $e,
            ]);
        }
    }

    public function edit($id){
        $question = QuestionModels::find($id);
        $anwsers = AnwserModel::where('question_id', $id)->get(['question_id', 'title']);
        return view('questions.question-create', compact('question', 'anwsers'));
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'type_checkbox' => 'required|in:' . implode(',', [
                QuestionModels::TYPE_RADIO,
                QuestionModels::TYPE_CHECK_BOX,
                QuestionModels::TYPE_INPUT
            ]),
            'anwsers' => 'required|array|min:2',
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
            QuestionModels::where('id', $id)->update([
                'title' => $request['title'],
                'type_checkbox' => $request['type_checkbox'],
                'require' => $request['require'],
                'more' => $request['more'],
            ]);
            AnwserModel::where('question_id', $id)->delete();
            foreach($request['anwsers'] as $value){
                AnwserModel::create([
                    'question_id' => $id,
                    'title' => $value,
                ]);
            }
            DB::commit();
            return response()->json([
                'status' => true,
                'data' => [],
                'mess' => 'Success',
            ]);
        }catch(\Exception $e){
            DB::rollback();
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
            QuestionModels::find($id)->delete();
            CategoryQuestionModel::where('question_id', $id)->delete();
            DB::commit();
            return redirect()->route('questions.index');
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
            QuestionModels::find($id)->replicate()->save();
            $anwser = AnwserModel::where('question_id', $id)->get();
            $lastID =  QuestionModels::latest('id')->first(['id']);
            foreach($anwser as $value){
                $newCategoryQuestion = $value->replicate();
                $newCategoryQuestion['question_id'] = $lastID['id'];
                $newCategoryQuestion->save();
            }
            DB::commit();
            return redirect()->route('questions.index');
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json([
                'status' => false,
                'data' => [],
                'mess' => $e,
            ]);
        }
    }
}
