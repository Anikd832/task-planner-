<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Filters\SubjectFilter;
use App\Http\Requests\SubjectRequest;
use App\Http\Resources\SubjectResource;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SubjectFilter $filter)
    {
        return SubjectResource::collection(
            Subject::paginate(request('limit') ?? 10)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  SubjectRequest  $form
     */
    public function store(SubjectRequest $form)
    {
        try {
            $subject = Subject::create($form->persist());
            return new SubjectResource($subject->load($this->eagerLoad()));
        } catch (\Exception $e) {
            return respondError('Failed to create subject. ' . $e->getMessage(), 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject)
    {
        return new SubjectResource($subject->load($this->eagerLoad()));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  SubjectRequest  $form
     */
    public function update(SubjectRequest $form, string $id)
    {
        try {
            $subject = Subject::findOrFail($id);
            $subject->update($form->persistUpdate($subject));
            return new SubjectResource($subject);
        } catch (\Exception $e) {
            return respondError('Failed to update subject.', 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $subject = Subject::findOrFail($id);
            if ($subject->delete()) {
                return respondSuccess("Subject deleted successfully.");
            }
            return respondError("Failed to delete subject.");
        } catch (\Exception $e) {
            return respondError("Failed to delete subject.");
        }
    }
}
