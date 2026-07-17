<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvestigationBoard\CreateBoardConnectionRequest;
use App\Http\Requests\InvestigationBoard\MoveBoardItemRequest;
use App\Http\Requests\InvestigationBoard\PinEvidenceRequest;
use App\Http\Requests\InvestigationBoard\ResizeBoardItemRequest;
use App\Models\CaseFile;
use App\Models\InvestigationBoardConnection;
use App\Models\InvestigationBoardItem;
use App\Models\InvestigationCase;
use App\Services\InvestigationBoardService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InvestigationBoardController extends Controller
{
    public function __construct(
        private readonly InvestigationBoardService $investigationBoardService
    ) {
    }

    public function show(Request $request, InvestigationCase $case)
{
    $player = $request->attributes->get('player');
    $section = 'Board';

    $workspaceData = $this->investigationBoardService->buildBoardWorkspaceViewData(
        $player,
        $case,
        $section
    );

    return view('dashboard.board.index', array_merge([
        'player' => $player,
        'case' => $case,
        'section' => $section,
        'workspace_mode' => 'investigation',
    ], $workspaceData));
}
    public function pinEvidence(
        PinEvidenceRequest $request,
        InvestigationCase $case,
        CaseFile $file
    ): JsonResponse {
        abort_if((int) $file->case_id !== (int) $case->id, 404);

        $player = $request->attributes->get('player');
        $board = $this->investigationBoardService->getBoard($player, $case);
        $item = $this->investigationBoardService->pinEvidence($board, $file);

        return response()->json([
            'message' => 'Evidence pinned successfully.',
            'item' => $item,
            'items' => $this->investigationBoardService->getItems($board),
            'connections' => $this->investigationBoardService->getConnections($board),
        ]);
    }

    public function unpinEvidence(
        Request $request,
        InvestigationCase $case,
        CaseFile $file
    ): JsonResponse {
        abort_if((int) $file->case_id !== (int) $case->id, 404);

        $player = $request->attributes->get('player');
        $board = $this->investigationBoardService->getBoard($player, $case);

        $this->investigationBoardService->unpinEvidence($board, $file);

        return response()->json([
            'message' => 'Evidence unpinned successfully.',
            'items' => $this->investigationBoardService->getItems($board),
            'connections' => $this->investigationBoardService->getConnections($board),
        ]);
    }

    public function moveItem(
        MoveBoardItemRequest $request,
        InvestigationCase $case,
        InvestigationBoardItem $item
    ): JsonResponse {
        $player = $request->attributes->get('player');
        $board = $this->investigationBoardService->getBoard($player, $case);

        abort_if((int) $item->investigation_board_id !== (int) $board->id, 404);

        $updatedItem = $this->investigationBoardService->moveItem(
            $item,
            (float) $request->input('position_x'),
            (float) $request->input('position_y')
        );

        return response()->json([
            'message' => 'Board item position updated successfully.',
            'item' => $updatedItem,
            'items' => $this->investigationBoardService->getItems($board),
            'connections' => $this->investigationBoardService->getConnections($board),
        ]);
    }

    public function resizeItem(
        ResizeBoardItemRequest $request,
        InvestigationCase $case,
        InvestigationBoardItem $item
    ): JsonResponse {
        $player = $request->attributes->get('player');
        $board = $this->investigationBoardService->getBoard($player, $case);

        abort_if((int) $item->investigation_board_id !== (int) $board->id, 404);

        $width = $request->filled('width')
            ? (float) $request->input('width')
            : null;

        $height = $request->filled('height')
            ? (float) $request->input('height')
            : null;

        $updatedItem = $this->investigationBoardService->resizeItem($item, $width, $height);

        return response()->json([
            'message' => 'Board item size updated successfully.',
            'item' => $updatedItem,
            'items' => $this->investigationBoardService->getItems($board),
            'connections' => $this->investigationBoardService->getConnections($board),
        ]);
    }

    public function bringToFront(
        Request $request,
        InvestigationCase $case,
        InvestigationBoardItem $item
    ): JsonResponse {
        $player = $request->attributes->get('player');
        $board = $this->investigationBoardService->getBoard($player, $case);

        abort_if((int) $item->investigation_board_id !== (int) $board->id, 404);

        $updatedItem = $this->investigationBoardService->bringToFront($item);

        return response()->json([
            'message' => 'Board item brought to front successfully.',
            'item' => $updatedItem,
            'items' => $this->investigationBoardService->getItems($board),
            'connections' => $this->investigationBoardService->getConnections($board),
        ]);
    }

    public function autosave(
        Request $request,
        InvestigationCase $case
    ): JsonResponse {
        $player = $request->attributes->get('player');
        $board = $this->investigationBoardService->getBoard($player, $case);
        $board = $this->investigationBoardService->autosave($board);

        return response()->json([
            'message' => 'Board autosaved successfully.',
            'board' => $board,
            'items' => $this->investigationBoardService->getItems($board),
            'connections' => $this->investigationBoardService->getConnections($board),
        ]);
    }

    public function createConnection(
        CreateBoardConnectionRequest $request,
        InvestigationCase $case
    ): JsonResponse {
        $player = $request->attributes->get('player');
        $board = $this->investigationBoardService->getBoard($player, $case);

        $sourceItem = InvestigationBoardItem::query()->find($request->integer('source_board_item_id'));
        $targetItem = InvestigationBoardItem::query()->find($request->integer('target_board_item_id'));

        abort_if(! $sourceItem || ! $targetItem, 404);
        abort_if((int) $sourceItem->investigation_board_id !== (int) $board->id, 404);
        abort_if((int) $targetItem->investigation_board_id !== (int) $board->id, 404);

        $connection = $this->investigationBoardService->createConnection(
            $board,
            $sourceItem,
            $targetItem,
            $request->input('reason'),
            (string) $request->input('confidence_level')
        );

        return response()->json([
            'message' => 'Connection created successfully.',
            'connection' => $connection,
            'items' => $this->investigationBoardService->getItems($board),
            'connections' => $this->investigationBoardService->getConnections($board),
        ]);
    }

    public function deleteConnection(
        Request $request,
        InvestigationCase $case,
        InvestigationBoardConnection $connection
    ): JsonResponse {
        $player = $request->attributes->get('player');
        $board = $this->investigationBoardService->getBoard($player, $case);

        abort_if((int) $connection->investigation_board_id !== (int) $board->id, 404);

        $this->investigationBoardService->deleteConnection($board, $connection);

        return response()->json([
            'message' => 'Connection deleted successfully.',
            'items' => $this->investigationBoardService->getItems($board),
            'connections' => $this->investigationBoardService->getConnections($board),
        ]);
    }
}