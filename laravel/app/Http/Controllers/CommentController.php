<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Project;
use App\Task;
use App\Tasklist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Input;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Project $project
     * @param Tasklist $tasklist
     * @param Task $task
     */
    public function store(Project $project, Tasklist $tasklist, Task $task)
    {
        $new_comment = Input::get('comment');

        if(Input::get('comment_and_notify')) {
            $user = Auth::user();
            Mail::send('emails.reminder', ['user' => $user, 'comment' => $new_comment], function ($m) use ($user, $task) {
                $m->to($user->email, $user->name)->subject($task->name)->from(array($user->email=>$user->name));
            });
        }

        $task_id = Input::get('task_id');

        if(Input::get('complete_task')) {
            $task = Task::find($task_id);
            $task->completed = 1;
            // TODO find on stack exchange a method to automatically update completed_at when flag is set
            $task->completed_at = \Carbon\Carbon::now();
            $task->save();
        }

        if(Input::get('postpone')) {
            $task = Task::find($task_id);
            $task->due_at = \Carbon\Carbon::now()
                ->addHours(24)
                ->timezone('Africa/Johannesburg');
            $task->save();
        }

        if ($new_comment) {
            $user_id = Input::get('user_id');
            //echo "Storing comment " . $new_comment;
            $comment = new Comment();
            $comment->comment = $new_comment;
            $comment->task_id = $task_id;
            $comment->user_id = $user_id;
            $comment->save();
        }
        return Redirect::route('project.tasklist.task.show', [$project->slug, $tasklist->slug, $task->slug])->with('message', 'Comment added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Project $project
     * @param Tasklist $tasklist
     * @param Task|\App\Task $task
     * @param \Illuminate\Http\Request $request
     * @return Response
     * @internal param \App\Project $project
     */
    public function update(Project $project, Tasklist $tasklist, Task $task, Request $request)
    {
        //return Redirect::route('project.tasklist.show', [$project->slug, $tasklist->slug])->with('message', 'Task updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
