<?php

namespace App\Http\Controllers;


use App\Models\KanbanBoard;
use Illuminate\Http\Request;

class KanbanBoardController extends Controller
{
    public function index(){
        $data['todo_lists'] = KanbanBoard::where('status', 'todo')->orderBy('position', 'asc')->get();
        $data['inprogress_lists'] = KanbanBoard::where('status', 'inprogress')->orderBy('position', 'asc')->get();
        $data['done_lists'] = KanbanBoard::where('status', 'done')->orderBy('position', 'asc')->get();
        return view('kanban_board.index', $data);
    }

    public function store(Request $request){
        $input_kanban_board = $request->input_kanban_board;
        if(empty($input_kanban_board)){
            return false;
        }
        $allCount = KanbanBoard::latest('id')->first();
        if(!empty($allCount)){
            $allCount = $allCount->id;
        }

        $kan_board = new KanbanBoard();
        $kan_board->task = $input_kanban_board;
        $kan_board->status = "todo";
        $kan_board->position = $allCount+1;
        $kan_board->save();

        $data['todo_lists'] = KanbanBoard::where('status', 'todo')->orderBy('position', 'asc')->get();
        $data['inprogress_lists'] = KanbanBoard::where('status', 'inprogress')->orderBy('position', 'asc')->get();
        $data['done_lists'] = KanbanBoard::where('status', 'done')->orderBy('position', 'asc')->get();
        return view('kanban_board.include.list_data', $data)->render();
    }

    public function status_update(Request $request){
        $kanboard = $request->kanboard;
        $entityId = $request->entityId;
        $endPos = $request->endPos;
        $endPos = $endPos+1;

        if(empty($kanboard) || empty($entityId) || empty($endPos)){
            return false;
        }

        $crnt_kanban = KanbanBoard::where('id', $entityId)->first();
        $allCount = KanbanBoard::where([['status', $kanboard]])->count();
        if($allCount>0){
            if($endPos == 1){
                $previous = KanbanBoard::where([['status', $kanboard]])->orderBy('position', 'asc')->limit(1)->offset($endPos-1)->first();
                $position = (double) $previous->position - 0.1;
            }elseif ($endPos > $allCount){
                $next = KanbanBoard::where([['status', $kanboard]])->orderBy('position', 'asc')->limit(1)->offset($endPos-2)->first();
                $position = (double) $next->position + 0.1;
            }else{
                $previous = KanbanBoard::where([['status', $kanboard]])->orderBy('position', 'asc')->limit(1)->offset($endPos-2)->first();
                $next = KanbanBoard::where([['status', $kanboard]])->orderBy('position', 'asc')->limit(1)->offset($endPos-1)->first();
                $position =(double) ($previous->position + $next->position)/2;
            }
            $crnt_kanban->position = $position;
        }
        $crnt_kanban->status = $kanboard;

        $crnt_kanban->save();

        $data['todo_lists'] = KanbanBoard::where('status', 'todo')->orderBy('position', 'asc')->get();
        $data['inprogress_lists'] = KanbanBoard::where('status', 'inprogress')->orderBy('position', 'asc')->get();
        $data['done_lists'] = KanbanBoard::where('status', 'done')->orderBy('position', 'asc')->get();
        return view('kanban_board.include.list_data', $data)->render();
    }
}
