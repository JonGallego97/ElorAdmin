<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Module;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\HasApiTokens;


class ModuleController extends Controller
{
    /**
    * @OA\Get(
    *   path="/api/v1/modules",
    *   tags={"Modules"},
    *   summary="Shows modules",
    *   @OA\Response(
    *       response=200,
    *       description="Shows all modules."
    *   ),
    *   @OA\Response(
    *       response=204,
    *       description="There are no modules."
    *   ),
    *   @OA\Response(
    *       response=401,
    *       description="You must log in."
    *   ),
    *   @OA\Response(
    *       response="default",
    *       description="Error has ocurred."
    *   ),
    *   security={
    *       {"bearerAuth": {}}
    *   }
    *)
    */
    public function index(Request $request)
    {

        /* $modules = Module::with('cycles')->orderBy('name','asc')->get();
        if(!is_null($modules)) {
            return response()->json(['modules'=>$modules])->setStatusCode(Response::HTTP_OK);
        } else {
            return response()->json(['modules'=>$modules])->setStatusCode(Response::HTTP_NO_CONTENT);
        } */

        $perPage = App::make('paginationCount');

        $modules = Module::with('cycles')->orderBy('name','asc')->paginate($perPage);

        // Comprueba si hay usuarios disponibles
        if ($modules->isNotEmpty()) {
            // Prepara los datos de paginación para la respuesta
            $paginationData = [
                'total' => $modules->total(), // Número total de datos
                'per_page' => $modules->perPage(), // Datos por página
                'current_page' => $modules->currentPage(), // Página actual
                'last_page' => $modules->lastPage(), // Última página
                'next_page_url' => $modules->nextPageUrl(), // URL de la próxima página
                'prev_page_url' => $modules->previousPageUrl(), // URL de la página anterior
                'from' => $modules->firstItem(), // Número del primer ítem en la página
                'to' => $modules->lastItem() // Número del último ítem en la página
            ];

            // Devuelve los usuarios junto con los datos de paginación
            return response()->json([
                'modules' => $modules->items(), // O usa simplemente $users para incluir los datos de paginación automáticamente
                'pagination' => $paginationData,
            ])->setStatusCode(Response::HTTP_OK);
        } else {
            // Devuelve respuesta para indicar que no hay contenido
            return response()->json(['message' => 'No users found'])->setStatusCode(Response::HTTP_NO_CONTENT);
        }
        
        
    }



    /**
    * @OA\Post(
    *   path="/api/v1/modules",
    *   summary="Create a module",
    *   tags={"Modules"},
    *   @OA\Parameter(
    *       name="name",
    *       in="query",
    *       description="Module Name",
    *       required=true,
    *       @OA\Schema(
    *           type="string"
    *       )
    *   ),
    *   @OA\Parameter(
    *       name="code",
    *       in="query",
    *       description="Module code",
    *       required=true,
    *       @OA\Schema(
    *           type="integer"
    *       )
    *   ),
    *   @OA\Parameter(
    *       name="hours",
    *       in="query",
    *       description="Module duration hours",
    *       required=true,
    *       @OA\Schema(
    *           type="integer"
    *       )
    *   ),
    *   @OA\Parameter(
    *       name="cycles",
    *       in="query",
    *       description="Cycles",
    *       required=true,
    *       @OA\Schema(
    *           type="array",
    *           @OA\Items(
    *               type="integer"
    *           )
    *       )
    *   ),  
    *   @OA\Response(
    *       response=200,
    *       description="successful operation",
    *       @OA\JsonContent(
    *           type="string"
    *       ),
    *   ),
    *   @OA\Response(
    *       response=401,
    *       description="Unauthenticated"
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
            'code.required' => __('errorMessageCodeEmpty'),
            'code.integer' => __('errorMessageCodeInteger'),
            'code.unique' => __('errorModuleCodeExists'),
            'hours.required' => __('errorMessageHoursEmpty'),
            'hours.integer' => __('errorMessageHoursInteger'),
            'cycles.required' => __('errorCycleRequired'),
        ];

        $request->validate([
            'name' => ['required', 'regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ\s]+$/u'],
            'code' => ['required', 'integer', 'unique:modules'],
            'hours' => ['required', 'integer'],
            'cycles' => ['required'],
        ], $messages);

        $module = new Module();
        $module->code = $request->code;
        $module->name = ucfirst(strtolower($request->name));
        $module->hours = $request->hours;

        $created = $module->save();

        
        if($created) {
            $attached = $module->cycles()->attach($request->cycles);

            if($attached) {
                $module->load('cycles');
                return response()->json(['module'=>$module])->setStatusCode(Response::HTTP_CREATED);
            } else {
                $module->delete();
                return response()->json(['module'=>$module])->setStatusCode(Response::HTTP_BAD_REQUEST);
            }

        } else {
            return response()->json(['module'=>$module])->setStatusCode(Response::HTTP_BAD_REQUEST);
        }
    }

    /**
    * @OA\Get(
    *   path="/api/v1/modules/{id}",
    *   summary="Shows one module",
    *   tags={"Modules"},
    *   @OA\Parameter(
    *       name="id",
    *       description="Module ID",
    *       required=true,
    *       in="path",
    *       @OA\Schema(
    *           type="integer"
    *       )
    *   ),
    *   @OA\Response(
    *       response=200,
    *       description="Shows a role."
    *   ),
    *   @OA\Response(
    *       response="default",
    *       description="Ha ocurrido un error."
    *   ),
    *   security={
    *       {"bearerAuth": {}}
    *   }
    * )
    */
    public function show(Module $module)
    {
        $module = Module::with('cycles')->where('id',$module->id)->get();
        if(!$module->isEmpty()) {
            return response()->json(['module'=>$module])->setStatusCode(Response::HTTP_OK);
        } else {
            return response()->json(['module'=>$module])->setStatusCode(Response::HTTP_NO_CONTENT);
        }
    }


    /**
    * @OA\Put(
    *   path="/api/v1/modules/{id}",
    *   summary="Edit a Module",
    *   tags={"Modules"},
    *   @OA\Parameter(
    *       name="id",
    *       description="Role ID",
    *       required=true,
    *       in="path",
    *       @OA\Schema(
    *           type="integer"
    *       )
    *   ),
    *   @OA\Parameter(
    *       name="name",
    *       in="query",
    *       description="Name of the Module",
    *       required=true,
    *       @OA\Schema(
    *           type="string"
    *       )
    *   ),
    *   @OA\Parameter(
    *       name="code",
    *       in="query",
    *       description="Code of the Module",
    *       required=true,
    *       @OA\Schema(
    *           type="integer"
    *       )
    *   ),
    *   @OA\Parameter(
    *       name="hours",
    *       in="query",
    *       description="Hours of duration of the Module",
    *       required=true,
    *       @OA\Schema(
    *           type="integer"
    *       )
    *   ),
    *   @OA\Parameter(
    *       name="cycles[]",
    *       in="query",
    *       description="Cycles",
    *       required=true,
    *       @OA\Schema(
    *           type="array",
    *           @OA\Items(
    *               type="integer"
    *           )
    *       )
    *   ),
    *   @OA\Response(
    *       response=200,
    *       description="Role actualizado."
    *   ),
    *   @OA\Response(
    *       response="default",
    *       description="Ha ocurrido un error."
    *   ),
    *   security={
    *       {"bearerAuth": {}}
    *   }
    * )
    */
    public function update(Request $request, Module $module)
    {
        $messages = [
            'name.required' => __('errorMessageNameEmpty'),
            'name.regex' => __('errorMessageNameLettersOnly'),
            'code.required' => __('errorMessageCodeEmpty'),
            'code.integer' => __('errorMessageCodeInteger'),
            'code.unique' => __('errorModuleCodeExists'),
            'hours.required' => __('errorMessageHoursEmpty'),
            'hours.integer' => __('errorMessageHoursInteger'),
            'cycles.required' => __('errorCycleRequired'),
        ];

        $request->validate([
            'name' => ['required', 'regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ\s]+$/u'],
            'code' => ['required', 'integer', Rule::unique('modules')->ignore($module->id)],
            'hours' => ['required', 'integer'],
            'cycles' => ['required'],
        ], $messages);

        $module->code = $request->code;
        $module->name = ucfirst(strtolower($request->name));
        $module->hours = $request->hours;

        $updated = $module->save();

        if($updated) {

            $synced = $module->cycles()->sync($request->cycles);
            
            if($synced) {
                $module->load('cycles');

                return response()->json(['module'=>$module])->setStatusCode(Response::HTTP_OK);
            } else {
                return response()->json(['module'=>$module])->setStatusCode(Response::HTTP_BAD_REQUEST);
            }

            
        } else {
            return response()->json(['module'=>$module])->setStatusCode(Response::HTTP_BAD_REQUEST);
        }
    }

     /**
    * @OA\Delete(
    *   path="/api/v1/modules/{id}",
    *   summary="Delete modules",
    *   tags={"Modules"},
    *   @OA\Parameter(
    *       name="id",
    *       description="Module ID",
    *       required=true,
    *       in="path",
    *       @OA\Schema(
    *           type="integer"
    *       )
    *   ),
    *   @OA\Response(
    *       response=200,
    *       description="Module deleted."
    *   ),
    *   @OA\Response(
    *       response=400,
    *       description="Module doesn't exist."
    *   ),
    *   @OA\Response(
    *       response="default",
    *       description="Ha ocurrido un error."
    *   ),
    *   security={
    *       {"bearerAuth": {}}
    *   }
    * )
    */
    public function destroy(Module $module)
    {
        $deleted = $module->delete();
        if($deleted) {
            return response()->json(['module'=>$module])->setStatusCode(Response::HTTP_OK);
        } else {
            return response()->json(['module'=>$module])->setStatusCode(Response::HTTP_BAD_REQUEST);
        }
    }
}
