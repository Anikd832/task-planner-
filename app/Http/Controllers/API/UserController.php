<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Filters\UserFilter;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(UserFilter $filter)
    {
        if (request()->has('fetch') && request('fetch') == 'all') {
            return UserResource::collection(
                User::get()
            )->additional([
                'success' => true,
                'message' => 'All Users'
            ]);
        }
        return UserResource::collection(
            User::filter($filter)->paginate(request('limit') ?? 10)
        )->additional([
            'success' => true,
            'message' => 'Paginated Users List'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  UserRequest  $form
     */
    public function store(UserRequest $form)
    {
        try {
            $user = User::create($form->persist());
            return new UserResource($user);
        } catch (\Exception $e) {
            return respondError('Failed to create task. ' . $e->getMessage(), 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            return new UserResource(
                User::whereId($id)
                    ->with($this->eagerLoad())
                    ->firstOrFail()
            );
        } catch (\Exception $e) {
            return respondError('No results found.', 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UserRequest  $form
     */
    public function update(UserRequest $form, string $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->update($form->persist());
            return new UserResource($user);
        } catch (\Exception $e) {
            return respondError('Failed to update user.', 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = User::findOrFail($id);
            if ($user->delete()) {
                return respondSuccess("User deleted successfully.");
            }
            return respondError("Failed to delete user.");
        } catch (\Exception $e) {
            return respondError("Failed to delete user.");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function authUser(Request $request): UserResource
    {
        return new UserResource(auth()->user());
    }

    /**
     * Eager load model relations.
     */
    public function eagerLoad()
    {
        return [
            'user'
        ];
    }
}
