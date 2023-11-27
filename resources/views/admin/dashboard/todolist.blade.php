@if (count($todo_list_data) > 0)
<ul class="todo-list">
    @foreach ($todo_list_data as $key=>$list)
    <li>
        <div class="d-flex align-items-start">
        <div class="checkbox checkbox-success">
            <input id="todo{{$key}}" type="checkbox" class="--ischecked" data-task-id="{{$list->id}}" @if ($list->is_checked) {{"checked"}} @endif>
            <label for="todo{{$key}}">{{ $list->task_detail }}</label>
        </div>
        <div class="d-flex ml-2">
            <i class="far fa fa-edit --open-task-popup" data-task-id="{{$list->id}}" style="cursor: pointer;"></i>
            <i class="far fa fa-trash ml-2 --delete-task" data-task-id="{{$list->id}}" style="cursor: pointer;"></i>
        </div>
        </div>
    </li>
    @endforeach
</ul>
@endif