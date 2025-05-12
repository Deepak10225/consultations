<?php

namespace App\Http\Controllers\Api;

use App\Events\ConsultationUpdated;
use App\Http\Controllers\Controller;
use App\Models\Consultation;
use Illuminate\Http\Request;

class ConsultationController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $query = auth()->user()->consultations();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('scheduled_at', 'like', "%{$search}%");
            });
        }

        return $query->orderBy('scheduled_at', 'desc')->get();
    }

   public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string|max:1000',
        'scheduled_at' => 'required|date|after_or_equal:now',
    ]);

    $consultation = auth()->user()->consultations()->create($validated);

    return response()->json($consultation, 201);
}


    public function show($id)
    {
        $consultation = Consultation::find($id);
         if (!$consultation) {
            return response()->json([
                'status' => false,
                'message' => 'id not match  with any record'
            ]);
        }
        $this->authorizeAccess($consultation);

        return response()->json($consultation);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string|max:1000',
            'scheduled_at' => 'sometimes|required|date|after_or_equal:now',
        ]);
        $consultation = Consultation::findOrFail($id);
       
        $this->authorizeAccess($consultation);


        $consultation->update($validated);

        event(new ConsultationUpdated($consultation));

        return response()->json(['success' => true, 'data' => $consultation]);
    }

    public function destroy($id)
    {
        $consultation = Consultation::find($id);
        if (!$consultation) {
            return response()->json([
                'status' => false,
                'message' => 'id not match with any record'
            ]);
        }
        $this->authorizeAccess($consultation);

        $consultation->delete();

        return response()->json(['message' => 'Deleted']);
    }

    protected function authorizeAccess(Consultation $consultation)
    {
        if ($consultation->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }
    }
}
