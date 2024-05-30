<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class taskController extends Controller
{
    public function index() {
        $tasks = Task::all();

        $data = [
            'tasks' => $tasks,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function createTask(Request $request) {
        //Validar datos de la tarea a crear
        $validator = Validator::make($request->all(), [
            'tittle' => 'required|max:15',
            'description' => 'required|max:30',
            'tag' => 'required|max:20',
            'deadline' => 'required|max:10',
        ]);

        if( $validator->fails() ) {
            $data = [
                'message' => 'Error en la validación de datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];

            return response()->json($data, 400);
        }


        //Crear tarea
        $task = Task::create([
            'tittle' => $request->tittle,
            'description' => $request->description,
            'tag' => $request->tag,
            'deadline' => $request->deadline,
        ]);

        if(!$task) {
            $data = [
                'message' => 'Error al crear la tarea',
                'status' => 500
            ];

            return response()->json($data, 500);
        }

        $data = [
            'task' => $task,
            'status' => 201
        ];

        return response()->json($data, 201);
    }

    public function getTask($id) {
        //Buscar tarea
        $task = Task::find($id);

        if(!$task) {
            $data = [
                'message' => 'Tarea no encontrada',
                'status' => 404
            ];

            return response()->json($data, 404);
        }

        //Tarea encontrada
        $data = [
            'task' => $task,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function deleteTask($id) {
        //Buscar tarea
        $task = Task::find($id);

        if(!$task) {
            $data = [
                'message' => 'Tarea no encontrada para eliminar',
                'status' => 404
            ];

            return response()->json($data, 404);
        }

        //Eliminar tarea
        $task->delete();

        $data = [
            'message' => 'Tarea eliminada',
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function updateTask(Request $request, $id) {
        //Buscar tarea
        $task = Task::find($id);

        if(!$task) {
            $data = [
                'message' => 'Tarea no encontrada para actualizar',
                'status' => 404
            ];

            return response()->json($data, 404);
        }


        //Validar los nuevos datos de la tarea
        $validator = Validator::make($request->all(), [
            'tittle' => 'required|max:15',
            'description' => 'required|max:30',
            'tag' => 'required|max:20',
            'deadline' => 'required|max:10',
        ]);

        if( $validator->fails() ) {
            $data = [
                'message' => 'Error en la validación de datos nuevos',
                'errors' => $validator->errors(),
                'status' => 400
            ];

            return response()->json($data, 400);
        }

        //Actualizar datos nuevos a la tarea
        $task->tittle = $request->tittle;
        $task->description = $request->description;
        $task->tag = $request->tag;
        $task->deadline = $request->deadline;

        $task->save();

        $data = [
            'message' => 'Tarea actualizada correctamente',
            'task' => $task,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function updatePartialTask(Request $request, $id) {
        //Buscar tarea
        $task = Task::find($id);

        if(!$task) {
            $data = [
                'message' => 'Tarea no encontrada para actualizar',
                'status' => 404
            ];

            return response()->json($data, 404);
        }

        //Validar los nuevos datos de la tarea
        $validator = Validator::make($request->all(), [
            'tittle' => 'max:15',
            'description' => 'max:30',
            'tag' => 'max:20',
            'deadline' => 'max:10',
        ]);

        if( $validator->fails() ) {
            $data = [
                'message' => 'Error en la validación de datos nuevos',
                'errors' => $validator->errors(),
                'status' => 400
            ];

            return response()->json($data, 400);
        }

        //Actualizo los datos en el campo correspondiente
        if($request->has('tittle')) {
            $task->tittle = $request->tittle;
        }
        if($request->has('description')) {
            $task->description = $request->description;
        }
        if($request->has('tag')) {
            $task->tag = $request->tag;
        }
        if($request->has('deadline')) {
            $task->deadline = $request->deadline;
        }

        $task->save();

        $data = [
            'message' => 'Tarea actualizada correctamente',
            'task' => $task,
            'status' => 200
        ];

        return response()->json($data, 200);
    }
}
