<div class="kanban-board">
    <div class="kanban-block text-center" id="todo">
        <div>To Do</div>
        <ul id="todo_list" class="connectedSortable" kanboard="todo">
            @if(!empty($todo_lists))
                @foreach($todo_lists as $todo_list)
                    <li id="{{$todo_list->id}}" class="ui-state-default">{{$todo_list->task}}</li>
                @endforeach
            @endif
        </ul>
    </div>
    <div id="inprogress" class="kanban-block text-center">
        <div>In Progress</div>
        <ul id="inprogress_list" class="connectedSortable" kanboard="inprogress">
            @if(!empty($inprogress_lists))
                @foreach($inprogress_lists as $inprogress_list)
                    <li id="{{$inprogress_list->id}}" class="ui-state-default">{{$inprogress_list->task}}</li>
                @endforeach
            @endif
        </ul>
    </div>
    <div class="kanban-block text-center" id="done">
        <div>Done</div>
        <ul id="done_list" class="connectedSortable" kanboard="done">
            @if(!empty($done_lists))
                @foreach($done_lists as $done_list)
                    <li id="{{$done_list->id}}" class="ui-state-default">{{$done_list->task}}</li>
                @endforeach
            @endif
        </ul>
    </div>
</div>
