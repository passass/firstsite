<?php

namespace App\Http\Controllers;


use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;


use App\Models\Todos;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Symfony\Component\HttpFoundation\Response;

class TodosController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Todos::where("user_id", "=", auth()->user()->id)->get();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('name');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        $todo = new Todos;
   
        $todo->title = "";
        $todo->text = "";
        $todo->user_id = $user->id;
        $todo->save();
        
        return ["id"=>$todo->id];
        //response('OK', 200)->header('Content-Type', 'text/plain');
    }

    /**
     * Display the specified resource.
     */
    public function show(Todos $todos)
    {
        if (!(auth()->check())) {
            return redirect('login');
        }

        $args = [];

        $args["todos"] = Todos::where("user_id", "=", auth()->user()->id)->get();

        return view('todos', $args);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Todos $todos)
    {
        return view('name');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Todos $todos, string $id)
    {
        $todo = Todos::where([
            ["id", "=", $id],
            ["user_id", "=", auth()->user()->id],
        ])->firstOrFail();

        $out = new \Symfony\Component\Console\Output\ConsoleOutput();

        $title = empty($request->title) ? "" : $request->title;
        $text = empty($request->text) ? "" : $request->text;
        $compeleted = empty($request->finished) ? false : $request->finished == "true";

        $out->writeln($compeleted . " | " . $request->finished . " |  " . boolval($request->finished) . " | ". empty($request->data));
        $todo->title = $title;
        $todo->text = $text;
        $todo->compeleted = $compeleted;
        $todo->save();
        return response('OK', 200)
        ->header('Content-Type', 'text/plain');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Todos $todos, string $id)
    {
        $todo = Todos::findOrFail($id);
        
        $todo->delete();

        return response('OK', 200)
        ->header('Content-Type', 'text/plain');
    }
}
