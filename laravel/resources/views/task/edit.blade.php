@extends('app')

@section('content')

    <ol class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><a href="/projects/">Projects</a></li>
        <li><a href="{{ route('project.show', [$project->slug]) }}">{{ $project->name }}</a></li>
        <li><a href="{{ route('project.tasklist.show', [$project->slug, $tasklist->slug]) }}">{{ $tasklist->name }}</a></li>
        <li class="active">{{  $task->name }}</li>
    </ol>

    <h2><small>Task</small> Edit "{{ $task->name }}"</h2>

    {!! Form::model($task, ['method' => 'PATCH', 'route' => ['project.tasklist.task.update', $project->slug, $tasklist->slug, $task->slug]]) !!}
        @include('task/partials/_form', ['submit_text' => 'Edit Task'])
    {!! Form::close() !!}
@endsection