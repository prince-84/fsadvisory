<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use OwenIt\Auditing\Models\Audit;

class AuditController extends Controller
{
    public function index(Request $request)
    {
        $query = Audit::with('user')->latest('id');

        // Filter by Event
        if ($request->filled('event')) {
            $query->where('event', $request->event);
        }

        // Filter by Model Type
        if ($request->filled('model')) {
            $modelClass = $request->model;
            if (!str_contains($modelClass, '\\')) {
                $modelClass = 'App\\Models\\' . $modelClass;
            }
            $query->where('auditable_type', $modelClass);
        }

        // Filter by User
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by Search Query (IP, URL, ID)
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('ip_address', 'like', "%{$search}%")
                  ->orWhere('url', 'like', "%{$search}%")
                  ->orWhere('auditable_id', $search)
                  ->orWhere('old_values', 'like', "%{$search}%")
                  ->orWhere('new_values', 'like', "%{$search}%");
            });
        }

        // Filter by Date Range
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $audits = $query->paginate(20)->withQueryString();

        // Calculate Stats
        $stats = [
            'total'   => Audit::count(),
            'created' => Audit::where('event', 'created')->count(),
            'updated' => Audit::where('event', 'updated')->count(),
            'deleted' => Audit::where('event', 'deleted')->count(),
        ];

        // Available Models for Dropdown
        $availableModels = [
            'Page'        => 'Pages',
            'PageSection' => 'Page Sections',
            'Project'     => 'Projects',
            'City'        => 'Cities',
            'Community'   => 'Communities',
            'Amenity'     => 'Amenities',
            'Blog'        => 'Blogs',
            'SiteSetting' => 'Site Settings',
            'User'        => 'Users',
        ];

        return view('admin.audits.index', compact('audits', 'stats', 'availableModels'));
    }

    public function show($id)
    {
        $audit = Audit::with('user')->findOrFail($id);

        $modelName = class_basename($audit->auditable_type);
        $user = $audit->user;

        return response()->json([
            'id'             => $audit->id,
            'event'          => $audit->event,
            'model'          => $modelName,
            'model_id'       => $audit->auditable_id,
            'user_name'      => $user ? $user->name : 'System / Guest',
            'user_email'     => $user ? $user->email : '-',
            'ip_address'     => $audit->ip_address ?? '127.0.0.1',
            'user_agent'     => $audit->user_agent,
            'url'            => $audit->url,
            'date_formatted' => $audit->created_at->format('M d, Y h:i:s A'),
            'date_diff'      => $audit->created_at->diffForHumans(),
            'old_values'     => $audit->old_values,
            'new_values'     => $audit->new_values,
        ]);
    }
}

