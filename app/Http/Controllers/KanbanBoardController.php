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
        $allCount = KanbanBoard::where('status', 'todo')->count();
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
        $endPos =(int) $request->endPos;
        $endPos = $endPos+1;
        $startPos =(int) $request->startPos;

        if(empty($kanboard) || empty($entityId) || empty($endPos)){
            return false;
        }

        $allInfos = KanbanBoard::where([['status', $kanboard], ['position','>', $endPos]])->orderBy('id', 'asc')->get();
        $allCount = count($allInfos);
        if($allCount>0){
            $i=$endPos+1;
            foreach ($allInfos as $allInfo){
                KanbanBoard::where('id', $allInfo->id)->update([
                    'position' => $i
                ]);
                $i++;
            }
        }


        KanbanBoard::where('id', $entityId)->update([
            'status' => $kanboard,
            'position' => $endPos
        ]);


        $data['todo_lists'] = KanbanBoard::where('status', 'todo')->orderBy('position', 'asc')->get();
        $data['inprogress_lists'] = KanbanBoard::where('status', 'inprogress')->orderBy('position', 'asc')->get();
        $data['done_lists'] = KanbanBoard::where('status', 'done')->orderBy('position', 'asc')->get();
        return view('kanban_board.include.list_data', $data)->render();
    }
}
