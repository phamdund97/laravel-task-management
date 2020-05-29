<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Task;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TaskController extends Controller
{
    /**
     * Show Select Project to view tasks.
     */
    public function index()
    {
        $taskByProject = auth()->user()->projects()->paginate(config('app.pagination'));
        return view('members.tasks.index', ['data' => $taskByProject, 'id' => Member::ID]);
    }

    /**
     * Show Tasks from id project.
     * @param $id
     * @return Factory|View
     */
    public function show($id)
    {
        $listTask = auth()->user()->tasks()->where('project_id', $id)->paginate(config('app.pagination'));
        $dataTask = [
            'listTask' => $listTask,
            'orderId' => Member::ID,
            'project_id' => $id,
            'paginate' => config('app.pagination')
        ];
        return view('members.tasks.tasks', ['dataTask' => $dataTask]);
    }

    /**
     * Complete Tasks
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request)
    {
        Task::findorFail($request->id)->update(['status' => Member::STATUS_CLOSE]);
        return redirect()->route('tasks.show', $request->projectId)->with('success', trans('message.task_success'));
    }
}
