<?php

namespace App\Http\Controllers\API;

use App\Exceptions\ApiErrorException;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExternalComissionRequest;
use App\Models\ExternalCommission;
use App\Services\ExternalComission\DeleteExternalComissionService;
use App\Services\ExternalComission\GetExternalComissionService;
use App\Services\ExternalComission\StoreExternalComissionService;
use App\Services\ExternalComission\UpdateExternalComissionService;
use Illuminate\Http\Request;

class ExternalComissionController extends Controller
{
    public function index(GetExternalComissionService $service)
    {
        try {

            $tables = $service->process();

            return response()->json($tables); 

        } catch (\Exception $e) {
            throw new ApiErrorException($e->getMessage(), 500);
        }
    }

    public function store(ExternalComissionRequest $request, StoreExternalComissionService $service)
    {
        try {

            $service->process($request->all());

            return response()->json([
                'success' => true,
            ]);

        } catch (\Exception $e) {
            throw new ApiErrorException($e->getMessage(), 500);
        }
    }

    public function update(ExternalComissionRequest $request, UpdateExternalComissionService $service, $id)
    {
        try {

            $service->process($request->all(), $id);

            return response()->json([
                'success' => true,
            ]);

        } catch (\Exception $e) {
            throw new ApiErrorException('Erro ao atualizar comissão.', 500);
        }
    }

    public function destroy($id)
    {
        try {

            $comission = new DeleteExternalComissionService();
            $comission->process($id);

            return response()->json([
                'success' => true,
            ]);

        } catch (\Exception $e) {
            throw new ApiErrorException('Erro ao excluir comissão.', 500);
        }
    }
}
