<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InvestigationCase;
use App\Models\MissionCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\Rule;

class MissionCodeController extends Controller
{
    public function index(Request $request)
    {
        $filters = $this->filters($request);

        return view('admin.mission-codes.index', [

            'missionCodes' => $this->filteredQuery($filters)
                ->with([
                    'investigationCase',
                    'player',
                ])
                ->latest()
                ->paginate(20)
                ->withQueryString(),

            'cases' => InvestigationCase::query()
                ->orderBy('code')
                ->get(),

            'filters' => $filters,

        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([

            'case_id' => [
                'required',
                'integer',
                'exists:cases,id',
            ],

            'quantity' => [
                'required',
                'integer',
                'min:1',
            ],

        ]);

        $quantity = (int) $validated['quantity'];

        for ($index = 0; $index < $quantity; $index++) {

            MissionCode::create([

                'case_id' => $validated['case_id'],

                'activation_code' => $this->uniqueActivationCode(),

                'used' => false,

            ]);
        }

        return redirect()
            ->route('admin.mission-codes.index')
            ->with(
                'success',
                $quantity === 1
                    ? 'Mission code generated.'
                    : 'Mission codes generated.'
            );
    }

    public function export(Request $request)
    {
        $filters = $this->filters($request);

        $missionCodes = $this->filteredQuery($filters)
            ->with([
                'investigationCase',
                'player',
            ])
            ->orderBy('activation_code')
            ->get();

        $filename = 'mission-codes-'.now()->format('Ymd-His').'.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ];

        return Response::stream(function () use ($missionCodes) {

            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'Activation Code',
                'Case Code',
                'Case Title',
                'Status',
                'Used By',
                'Activated At',
                'Created At',
            ]);

            foreach ($missionCodes as $missionCode) {

                fputcsv($handle, [
                    $missionCode->activation_code,
                    $missionCode->investigationCase?->code,
                    $missionCode->investigationCase?->title,
                    $missionCode->used ? 'Used' : 'Unused',
                    $missionCode->player?->account_code,
                    optional($missionCode->activated_at)->toDateTimeString(),
                    optional($missionCode->created_at)->toDateTimeString(),
                ]);
            }

            fclose($handle);

        }, 200, $headers);
    }

    public function destroy(MissionCode $missionCode)
    {
        if ($missionCode->used) {

            return back()->withErrors([
                'mission_code' => 'Used mission codes cannot be deleted.',
            ]);
        }

        $missionCode->delete();

        return redirect()
            ->route('admin.mission-codes.index')
            ->with(
                'success',
                'Mission code deleted.'
            );
    }

    private function filters(Request $request): array
    {
        $validated = $request->validate([

            'search' => [
                'nullable',
                'string',
                'max:255',
            ],

            'status' => [
                'nullable',
                Rule::in([
                    'all',
                    'used',
                    'unused',
                ]),
            ],

        ]);

        return [
            'search' => $validated['search'] ?? null,
            'status' => $validated['status'] ?? 'all',
        ];
    }

    private function filteredQuery(array $filters)
    {
        return MissionCode::query()
            ->when($filters['search'], function ($query, string $search) {
                $query->where(
                    'activation_code',
                    'like',
                    '%'.$search.'%'
                );
            })
            ->when($filters['status'] === 'used', function ($query) {
                $query->where('used', true);
            })
            ->when($filters['status'] === 'unused', function ($query) {
                $query->where('used', false);
            });
    }

    private function uniqueActivationCode(): string
    {
        do {

            $code = $this->generateActivationCode();

        } while (
            MissionCode::query()
                ->where('activation_code', $code)
                ->exists()
        );

        return $code;
    }

    private function generateActivationCode(): string
    {
        $characters = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';

        return 'ISA-'
            .$this->randomSegment($characters, 4)
            .'-'
            .$this->randomSegment($characters, 4);
    }

    private function randomSegment(
        string $characters,
        int $length
    ): string {
        $segment = '';

        $maximum = strlen($characters) - 1;

        for ($index = 0; $index < $length; $index++) {

            $segment .= $characters[random_int(0, $maximum)];
        }

        return $segment;
    }
}
