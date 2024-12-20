<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class RoleController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->_apiResponse(
            true,
            200,
            Role::all()
        );
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
        ]);

        $role = Role::query()->firstOrCreate($validator->validated());

        return $this->_apiResponse(true, 201, $role, 'Role created successfully.');
    }

    /**
     * @param Role $role
     * @return JsonResponse
     */
    public function show(Role $role): JsonResponse
    {
        return $this->_apiResponse(true, 200, $role->toArray(), 'Role retrieved successfully.');
    }

    /**
     * @param Request $request
     * @param Role $role
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, Role $role): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
        ]);

        $role->update($validator->validated());

        return $this->_apiResponse(true, 201, $role->toArray(), 'Role updated successfully.');
    }

    public function destroy(Role $role): JsonResponse
    {
        $role->delete();
        return $this->_apiResponse(true, 200, $role->toArray(), 'Role deleted successfully.');
    }
}
