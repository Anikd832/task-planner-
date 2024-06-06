<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Filters\TeacherFilter;
use App\Http\Requests\TeacherRequest;
use App\Http\Resources\TeacherResource;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(TeacherFilter $filter)
    {
        return TeacherResource::collection(
            Teacher::with('user')->paginate(request('limit') ?? 10)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  TeacherRequest  $form
     */
    public function store(TeacherRequest $form)
    {
        try {
            $user = User::create([
                "full_name" => $form->full_name,
                "password" => bcrypt(123456)
            ]);
            $teacher = Teacher::create([
                "title" => $form->title,
                "user_id" => $user->id
            ]);
            return new TeacherResource($teacher->load('user'));
        } catch (\Exception $e) {
            return respondError('Failed to create teacher. ' . $e->getMessage(), 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Teacher $teacher)
    {
        return new TeacherResource($teacher->load($this->eagerLoad()));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  TeacherRequest  $form
     */
    public function update(TeacherRequest $form, string $id)
    {
        try {
            $teacher = Teacher::findOrFail($id);
            $user = User::findOrFail($id);
            $teacher->update([
                "title" => $form->title
            ]);
            $user->update(["full_name" => $form->full_name,]);
            // dd($teacher);
            return new TeacherResource($teacher, $user);
        } catch (\Exception $e) {
            return respondError('Failed to update teacher.', 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $teacher = Teacher::findOrFail($id);
            if ($teacher->delete()) {
                return respondSuccess("Teacher deleted successfully.");
            }
            return respondError("Failed to delete teacher.");
        } catch (\Exception $e) {
            return respondError("Failed to delete teacher.");
        }
    }
}
