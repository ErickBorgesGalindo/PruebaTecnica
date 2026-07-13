<?php

namespace App\Traits;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

trait Auditable
{
    public function logAudit(string $entityType, string $action, $oldData = null, $newData = null): void
    {
        $user = Auth::user();

        AuditLog::create([
            'entity_type' => $entityType,
            'entity_id'   => $oldData['id'] ?? $newData['id'] ?? null,
            'action'      => $action,
            'old_data'    => $oldData,
            'new_data'    => $newData,
            'user_id'     => $user?->id ?? null,
            'user_name'   => $user?->name ?? 'Sistema',
        ]);
    }
}