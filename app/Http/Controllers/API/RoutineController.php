<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Filters\RoutineFilter;
use App\Http\Requests\RoutineRequest;
use App\Http\Resources\RoutineResource;
use App\Http\Resources\TeacherResource;
use App\Models\Day;
use App\Models\Routine;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;

class RoutineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(RoutineFilter $filter)
    {
        return RoutineResource::collection(
            Routine::with($this->eagerLoad())
                ->filter($filter)
                ->paginate(request('limit') ?? 10)
        );
    }

    /**
     * Display a listing of the resource.
     */
    public function getSubjectTeacherDay()
    {
        $subject = Subject::get();
        $teacher = Teacher::with('user')->get();
        $day = Day::get();
        return respondJson([
            'subjects' => $subject,
            'teachers' => TeacherResource::collection($teacher),
            'days' => $day
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  RoutineRequest  $form
     */
    public function store(RoutineRequest $form)
    {
        try {
            $routine = Routine::create($form->persist());
            $user = User::create();
            return new RoutineResource($routine->load($this->eagerLoad()));
        } catch (\Exception $e) {
            return respondError('Failed to create routine. ' . $e->getMessage(), 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Routine $routine)
    {
        return new RoutineResource($routine->load($this->eagerLoad()));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  RoutineRequest  $form
     */
    public function update(RoutineRequest $form, string $id)
    {
        try {
            $routine = Routine::findOrFail($id);
            $routine->update($form->persist($routine));
            return new RoutineResource($routine);
        } catch (\Exception $e) {
            return respondError('Failed to update routine.', 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $routine = Routine::findOrFail($id);
            if ($routine->delete()) {
                return respondSuccess("Routine deleted successfully.");
            }
            return respondError("Failed to delete routine.");
        } catch (\Exception $e) {
            return respondError("Failed to delete routine.");
        }
    }

    /**
     * Eager load model relations.
     */
    public function eagerLoad()
    {
        return [
            'user',
            'subject',
            'day',
            'teacher',
            'teacher.user'
        ];
    }
}
