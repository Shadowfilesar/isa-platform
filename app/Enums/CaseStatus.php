<?php

namespace App\Enums;

enum CaseStatus: string
{
    case Assigned = 'assigned';

    case InProgress = 'in_progress';

    case Completed = 'completed';

    case Failed = 'failed';
}