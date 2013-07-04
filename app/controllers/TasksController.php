<?php

class TasksController extends BaseController
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $tasks = Task::orderBy('completed', 'asc')->orderBy('created_at', 'desc')->where(function($query){
            if (Input::has('filter')) {
                $query->where('completed', '=', Input::get('filter') == 'active' ? 0 : 1);
            }
        })->get();

        return View::make('tasks.index', compact('tasks'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $validation = Validator::make(Input::all(), [
            'title' => ['required']
        ]);

        if ($validation->passes()) {
            $task = new Task(Input::all());
            $task->save();
            return Redirect::route('tasks.index');
        }

        return Redirect::back()->withInput()->withErrors($validation);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $task = Task::find($id);

        if ($task == null)
            App::abort(404);

        // update completed field
        if (Input::has('completed')) {
            $task->completed = intval(Input::get('completed')) == 1 ? true : false;
        }

        // update title field
        if (Input::has('title')) {
            $title = Input::get('title');
            if (empty($title) || trim($title) == '')
                return Response::make('title required', 400);
            $task->title = $title;
        }

        if ($task->save())
            return Response::make('updated');
        return Response::make('server error', 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        Task::destroy($id);
        return Response::make('removed');
    }

}
