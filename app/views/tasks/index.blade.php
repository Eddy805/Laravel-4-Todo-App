@extends('layouts.main')

@section('content')
    <header class="header">
        <h1>Tasks</h1>
        {{ Form::open(['route' => 'tasks.store']) }}

            @if($errors->any())
                @foreach($errors->all() as $error)
                <p class="error">{{ $error }}</p>
                @endforeach
            @endif

            <p>
                {{ Form::text('title', '', ['id' => 'title',  'placeholder' => 'What needs to be done?']) }}
                {{ Form::submit('Add') }}
            </p>
        {{ Form::close() }}
    </header>
    <nav class="nav">
        {{ link_to_route('tasks.index', 'All') }}
        {{ link_to_route('tasks.index', 'Active', ['filter' => 'active']) }}
        {{ link_to_route('tasks.index', 'Completed', ['filter' => 'completed']) }}
    </nav>
    <ul class="list">
        @foreach($tasks as $task)
            <li class="task @if($task->completed) completed @endif" id="task-{{ $task->id }}"  data-id="{{ $task->id }}" data-title="{{ $task->title }}">
                <a href="javascript:;" class="remove">x</a>
                {{ Form::checkbox('id', $task->id, $task->completed) }}
                <label class="title">{{ $task->title }}</label>
            </li>
        @endforeach
    </ul>
@stop
