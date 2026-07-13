<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        $query = AuditLog::orderBy('created_at', 'desc');

        if ($request->has('entity_type') && $request->entity_type !== '') {
            $query->where('entity_type', $request->entity_type);
        }

        if ($request->has('action') && $request->action !== '') {
            $query->where('action', $request->action);
        }

        return $query->paginate(20);
    }
}