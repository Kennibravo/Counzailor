<?php

namespace App\Http\Controllers\Counsellee;

use App\Http\Controllers\Controller;
use App\Models\CounselRequest;
use Illuminate\Http\Request;

class CounselRequestController extends Controller
{
    public function index()
    {
        $counselRequests = CounselRequest::all();

        return $this->successResponse('All Counsel Requests', $counselRequests);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'message' => 'required|max:200',
            'category_id' => 'required|exists:categories,id'
        ]);

        $counselRequest = CounselRequest::create([
            'counsellee_id' => auth()->id(),
            'category_id' => $request->category_id,
            'message' => $request->message,
        ]);

        return $this->createdResponse('Counsel requests created successfully', $counselRequest);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'message' => 'required|max:200',
            'category_id' => 'required|exists:categories,id'
        ]);

        $counselRequest = CounselRequest::findOrFail($id);

        $counselRequest->update([
            'counsellee_id' => auth()->id(),
            'category_id' => $request->category_id,
            'message' => $request->message,
        ]);

        return $this->successResponse('Counsel requests updated successfully', $counselRequest);
    }

    public function show($id)
    {
        $counselRequest = CounselRequest::findOrFail($id);

        return $this->successResponse('Showing Counsel Request', $counselRequest);
    }

    public function showAllMyCounselRequests()
    {
        $counselRequests = CounselRequest::where('counsellee_id', auth()->id())
    }
    public function delete($id)
    {
        $counselRequest = CounselRequest::findOrFail($id);

        $counselRequest->delete();
    }
}
