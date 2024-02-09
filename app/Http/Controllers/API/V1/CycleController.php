<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Cycle;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\App;


class CycleController extends Controller
{
    /**
    * @OA\Get(
    *   path="/api/v1/cycles",
    *   tags={"Cycles"},
    *   summary="Shows cycles",
    *   @OA\Response(
    *       response=200,
    *       description="Shows all cycles."
    * ),
    *   @OA\Response(
    *       response=204,
    *       description="There are no cycles."
    * ),
    * @OA\Response(
    *   response="default",
    *   description="Error has ocurred."
    *   ),
    *   security={
    *       {"bearerAuth": {}}
    *   }
    *)
    */
    public function index()
    {
        /* $cycles = Cycle::with('modules', 'department')
            ->orderBy('id')->get();
        if(!is_null($cycles)) {
            foreach ($cycles as $cycle) {
                $cycle->modules;
                $cycle->department;
                foreach ($cycle->modules as $module) {
                    $module->pivot = null;
                }

            }
            return response()->json(['cycles'=>$cycles])->setStatusCode(Response::HTTP_OK);
        } else {
            return response()->json(['cycles'=>$cycles])->setStatusCode(Response::HTTP_NO_CONTENT);
        } */
        $perPage = App::make('paginationCount');
        $cycles = Cycle::orderBy('id','asc')->paginate($perPage);

        // Comprueba si hay usuarios disponibles
        if ($cycles->isNotEmpty()) {
            // Prepara los datos de paginación para la respuesta
            $paginationData = [
                'total' => $cycles->total(), // Número total de datos
                'per_page' => $cycles->perPage(), // Datos por página
                'current_page' => $cycles->currentPage(), // Página actual
                'last_page' => $cycles->lastPage(), // Última página
                'next_page_url' => $cycles->nextPageUrl(), // URL de la próxima página
                'prev_page_url' => $cycles->previousPageUrl(), // URL de la página anterior
                'from' => $cycles->firstItem(), // Número del primer ítem en la página
                'to' => $cycles->lastItem() // Número del último ítem en la página
            ];

            // Devuelve los usuarios junto con los datos de paginación
            return response()->json([
                'cycles' => $cycles->items(), // O usa simplemente $users para incluir los datos de paginación automáticamente
                'pagination' => $paginationData,
            ])->setStatusCode(Response::HTTP_OK);
        } else {
            // Devuelve respuesta para indicar que no hay contenido
            return response()->json(['message' => 'No users found'])->setStatusCode(Response::HTTP_NO_CONTENT);
        }
    }

    /**
    * @OA\Post(
    *   path="/api/v1/cycles",
    *   summary="Create a cycle",
    *   tags={"Cycles"},
    *   @OA\Parameter(
    *       name="name",
    *       in="query",
    *       description="Role Name",
    *       required=true,
    *       @OA\Schema(
    *           type="string"
    *       )
    *   ),
    *   @OA\Parameter(
    *       name="department_id",
    *       in="query",
    *       description="Department ID",
    *       required=true,
    *       @OA\Schema(
    *           type="integer"
    *       )
    *   ),
    *   @OA\Parameter(
    *       name="modules[]",
    *       in="query",
    *       description="Modules",
    *       required=true,
    *       @OA\Schema(
    *           type="array",
    *           @OA\Items(
    *               type="integer"
    *           )
    *       )
    *   ),
    *   @OA\Parameter(
    *       name="modules[]",
    *       in="query",
    *       description="Modules",
    *       required=true,
    *       @OA\Schema(
    *           type="array",
    *           @OA\Items(
    *               type="integer"
    *           )
    *       )
    *   ),
    *   @OA\Response(
    *       response=201,
    *       description="Cycle created.",
    *       @OA\JsonContent(
    *           type="object",
    *           @OA\Property(
    *               property="cycle",
    *               type="object",
    *               @OA\Property(
    *                   property="id",
    *                   type="integer"
    *               ),
    *               @OA\Property(
    *                   property="name",
    *                   type="string"
    *               ),
    *           )
    *       ),
    *   ),
    *   @OA\Response(
    *       response=400,
    *       description="Bad Request",
    *       @OA\JsonContent(
    *           type="string"
    *       ),
    *   ),
    *   @OA\Response(
    *       response=401,
    *       description="Unauthenticated"
    *   ),
    *   @OA\Response(
    *       response="default",
    *       description="Error has ocurred."
    *   ),
    *   security={
    *       {"bearerAuth": {}}
    *   }
    * )
    */
    public function store(Request $request)
    {
        $messages = [
            'name.required' => __('errorMessageNameEmpty'),
            'name.regex' => __('errorMessageNameLettersOnly'),
            'department_id.required' => __('errorMessageDepartmentEmpty'),
            'department_id.integer' => __('errorMessageDepartmentEmpty'),
            'modules.required' => __('errorCycleRequired'),
            'modules.integer' => __('errorCycleRequired'),
        ];

        $request->validate([
            'name' => ['required', 'regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ\s]+$/u'],
            'name' => ['required', 'integer'],
            'modules' => ['required','array','integer'],
        ], $messages);

        $cycle = new Cycle();
        $cycle->name = $request['name'];
        $cycle->department_id = $request['department_id'];

        $created = $cycle->save();
        if($created) {
            $cycle->modules()->attach($request->input('modules', []));
            $cycle->load('modules');
            return response()->json(['cycle'=>$cycle])->setStatusCode(Response::HTTP_CREATED);
        } else {
            return response()->json(['cycle'=>$cycle])->setStatusCode(Response::HTTP_BAD_REQUEST);
        }
    }

    /**
    * @OA\Get(
    *   path="/api/v1/cycles/{id}",
    *   summary="Shows one cycle",
    *   tags={"Cycles"},
    *   @OA\Parameter(
    *       name="id",
    *       description="Cycle ID",
    *       required=true,
    *       in="path",
    *       @OA\Schema(
    *           type="integer"
    *       )
    *   ),
    *   @OA\Response(
    *       response=200,
    *       description="Request accepted."
    *   ),
    *   @OA\Response(
    *       response=204,
    *       description="That Role doesn't exist."
    *   ),
    *   @OA\Response(
    *       response=401,
    *       description="Unauthenticated"
    *   ),
    *   @OA\Response(
    *       response="default",
    *       description="Error has ocurred."
    *   ),
    *   security={
    *       {"bearerAuth": {}}
    *   }
    * )
    */
    public function show(int $id)
    {
        $cycle = new Cycle();
        $cycle = Cycle::with('modules','department')->find($id);
        if (optional($cycle)->id !== null) {
            return response()->json(['cycle' => $cycle])
                ->setStatusCode(Response::HTTP_OK);
        } else {
            return response()->json(['message' => 'Cycle not found'])
                ->setStatusCode(Response::HTTP_NO_CONTENT);
        }

    }

    /**
    * @OA\Put(
    *   path="/api/v1/cycles/{id}",
    *   summary="Edit a cycle",
    *   tags={"Cycles"},
    *   @OA\Parameter(
    *       name="id",
    *       description="Cycle ID",
    *       required=true,
    *       in="path",
    *       @OA\Schema(
    *           type="integer"
    *       )
    *   ),
    *   @OA\Parameter(
    *       name="name",
    *       in="query",
    *       description="Name of the cycle",
    *       required=true,
    *       @OA\Schema(
    *           type="string"
    *       )
    *   ),
    *   @OA\Parameter(
    *       name="department_id",
    *       in="query",
    *       description="Department ID",
    *       required=true,
    *       @OA\Schema(
    *           type="integer"
    *       )
    *   ),
    *   @OA\Parameter(
    *       name="modules[]",
    *       in="query",
    *       description="Modules",
    *       required=true,
    *       @OA\Schema(
    *           type="array",
    *           @OA\Items(
    *               type="integer"
    *           )
    *       )
    *   ),
    *   @OA\Response(
    *       response=201,
    *       description="Cycle updated."
    *   ),
    *   @OA\Response(
    *       response=400,
    *       description="Cycle doesnt exist."
    *   ),
    *   @OA\Response(
    *       response=401,
    *       description="Unauthenticated"
    *   ),
    *   @OA\Response(
    *       response="default",
    *       description="Error has ocurred."
    *   ),
    *   security={
    *       {"bearerAuth": {}}
    *   }
    * )
    */
    public function update(Request $request, Cycle $cycle)
    {
        $messages = [
            'name.required' => __('errorMessageNameEmpty'),
            'name.regex' => __('errorMessageNameLettersOnly'),
            'department_id.required' => __('errorMessageDepartmentEmpty'),
            'department_id.integer' => __('errorMessageDepartmentEmpty'),
            'modules.required' => __('errorCycleRequired'),
            'modules.integer' => __('errorCycleRequired'),
        ];

        $request->validate([
            'name' => ['required', 'regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ\s]+$/u'],
            'department_id' => ['required', 'integer'],
            'modules' => ['required','array','integer'],
        ], $messages);

        $cycle->name = $request['name'];
        $cycle->department_id = $request['department_id'];

        $updated = $cycle->save();
        if($updated) {
            $$cycle->modules()->sync($request->input('modules', []));
            $cycle->load('modules');
            return response()->json(['cycle'=>$cycle])->setStatusCode(Response::HTTP_CREATED);
        } else {
            return response()->json(['cycle'=>$cycle])->setStatusCode(Response::HTTP_BAD_REQUEST);
        }
    }

    /**
    * @OA\Delete(
    *   path="/api/v1/cycles/{id}",
    *   summary="Delete cycle",
    *   tags={"Cycles"},
    *   @OA\Parameter(
    *       name="id",
    *       description="Cycle ID",
    *       required=true,
    *       in="path",
    *       @OA\Schema(
    *           type="integer"
    *       )
    *   ),
    *   @OA\Response(
    *       response=204,
    *       description="Cycle deleted."
    *   ),
    *   @OA\Response(
    *       response=400,
    *       description="Cycle doesnt exist."
    *   ),
    *   @OA\Response(
    *       response=401,
    *       description="Unauthenticated"
    *   ),
    *   @OA\Response(
    *       response="default",
    *       description="Error has ocurred."
    *   ),
    *   security={
    *       {"bearerAuth": {}}
    *   }
    * )
    */
    public function destroy(Cycle $cycle)
    {
        $deleted = $cycle->delete();
        if ($deleted) {
            return response()->json(['cycle'=>$cycle])->setStatusCode(Response::HTTP_NO_CONTENT);
        } else {
            return response()->json(['cycle'=>$cycle])->setStatusCode(Response::HTTP_BAD_REQUEST);
        }
    }
}
