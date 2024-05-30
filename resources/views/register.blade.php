@extends('layouts.app')

@section('content')
    <form id="task-form">
        @csrf
        <div class="form-floating mb-3">
            <input name="tittle" type="text" class="form-control" id="tittle" placeholder="name@example.com">
            <label for="tittle">Título</label>
        </div>
        <div class="form-floating mb-3">
            <input name="description" type="text" class="form-control" id="description" placeholder="name@example.com">
            <label for="description">Descripcion</label>
        </div>
        <select name="tag" id="tag" class="form-select" aria-label="Default select example">
            <option selected>Etiqueta</option>
            <option value="1">Escuela</option>
            <option value="2">Facultad</option>
            <option value="3">Trabajo</option>
        </select>
        <br>
        <div class="form-floating">
            <input name="deadline" id="deadline" type="date" class="form-control" placeholder="Password">
            <label for="deadline">Fecha de entrega</label>
        </div>
        <br>
        <div>
            <button class="btn btn-primary" type="submit">Registrar tarea</button>
        </div>
    </form>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Event listener para el envío del formulario
            $('#task-form').submit(function(event) {
                event.preventDefault(); // Evitar el envío del formulario por defecto
                
                // Datos del formulario
                var formData = {
                    tittle: $('#tittle').val(),
                    description: $('#description').val(),
                    tag: $('#tag').val(),
                    deadline: $('#deadline').val(),
                };
                console.log(formData);
                // Envía la solicitud POST a la API
                $.ajax({
                    url: 'http://localhost:8000/api/task',
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        // Maneja la respuesta de la API
                        console.log(response);
                        // Actualiza la lista de tareas con la nueva tarea añadida
                        $('#tasks-list').append('<li>' + response.title + '</li>');
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });

        });
    </script>
@endsection

