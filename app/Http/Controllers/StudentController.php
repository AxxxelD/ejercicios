<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    // Mostrar todos
    public function index()
    {
        $students = Student::all();
        return response()->json($students);
    }

    // Guardar nuevo
    public function store(Request $request)
    {
        $student = Student::create($request->all());
        return response()->json(['mensaje' => 'Estudiante creado', 'data' => $student]);
    }

    // Mostrar un estudiante específico
    public function show(Student $student)
    {
        return response()->json($student);
    }

    // Actualizar
    public function update(Request $request, Student $student)
    {
        $student->update($request->all());
        return response()->json(['mensaje' => 'Actualizado', 'data' => $student]);
    }

    // Eliminar t $student)
    {
        $student->delete();
        return response()->json(['mensaje' => 'Eliminado']);
    }
}
