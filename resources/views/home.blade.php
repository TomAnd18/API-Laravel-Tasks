
@extends('layouts.app')

{{-- Importa el modelo Task --}}
@php
    use App\Models\Task;
@endphp

@section('content')
    <ul class="nav nav-pills nav-fill gap-2 p-1 small bg-primary rounded-5 shadow-sm" id="pillNav2" role="tablist" style="--bs-nav-link-color: var(--bs-white); --bs-nav-pills-link-active-color: var(--bs-primary); --bs-nav-pills-link-active-bg: var(--bs-white); width: 90%;">
        <li class="nav-item" role="presentation">
            <button class="nav-link active rounded-5" id="pills-home-tab" data-bs-target="#pills-home" data-bs-toggle="tab" type="button" role="tab" aria-selected="true">Mis tareas</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link rounded-5" id="pills-contact-tab" data-bs-target="#pills-contact" data-bs-toggle="tab" type="button" role="tab" aria-selected="false">Nueva Tarea</button>
        </li>
    </ul>

    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
            <ol id="tasks-list" class="list-group list-group-numbered">
                {{-- Realiza la consulta a la base de datos --}}
                @foreach (Task::all() as $task)

                    <li class="list-group-item d-flex justify-content-between align-items-start itemList-style" data-task-id="{{ $task->id }}">
                        <div class="ms-2 me-auto container-tittle-descrip">
                            <div class="fw-bold" id="e-tittle-{{$task->id}}"> {{ $task->tittle }} <span class="tag-container"> #{{ $task->tag }} </span> </div>
                            <div class="descrip-container-text" id="e-description-{{$task->id}}"> {{ $task->description }} </div>
                            <div class="container-deadline">
                                <span class="title-created"> Fecha de Entrega: </span>
                                <span class="date-tittlecreated" id="date-creation"> {{ $task->deadline }} </span>
                            </div>
                            <div class="container-created">
                                <span class="title-created"> Fecha de Creación: </span>
                                <span class="date-tittlecreated" id="date-creation"> {{ $task->created_at }} </span>
                            </div>
                        </div>
                        <div class="container-optiontasks">
                            <span id="delete-task-btn" class="item-optiontask option-colortwo"> <i data-feather="trash-2"></i> </span>
                            <span id="update-task-btn" class="item-optiontask option-colorthree" data-bs-toggle="modal" data-bs-target="#exampleModal"> <i data-feather="edit"></i> </span>
                        </div>
                    </li>
                    
                @endforeach
            </ol>
        </div>
        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0"> Sin tareas </div>
        <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab" tabindex="0">
            <form id="task-form">
                @csrf
                <div class="form-floating mb-3">
                    <input name="tittle" type="text" class="form-control" id="tittle" placeholder="name@example.com" maxlength="15" required>
                    <label for="tittle">Título</label>
                </div>
                <div class="form-floating mb-3">
                    <input name="description" type="text" class="form-control" id="description" placeholder="name@example.com" maxlength="30" required>
                    <label for="description">Descripcion</label>
                </div>
                <select name="tag" id="tag" class="form-select" aria-label="Default select example" required>
                    <option value="" disabled selected>Etiqueta</option>
                    <option value="Escuela">Escuela</option>
                    <option value="Facultad">Facultad</option>
                    <option value="Trabajo">Trabajo</option>
                </select>
                <br>
                <div class="form-floating">
                    <input name="deadline" id="deadline" type="date" class="form-control" placeholder="Password" min="1000-01-01" max="9999-12-31" required>
                    <label for="deadline">Fecha de entrega</label>
                </div>
                <br>
                <div>
                    <button class="btn btn-primary" type="submit">Registrar tarea</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Update -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modifcar Tarea</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="task-form-update">
                        @csrf
                        <div class="form-floating mb-3">
                            <input name="tittleUpdate" type="text" class="form-control" id="tittleUpdate" placeholder="name@example.com" maxlength="15" required>
                            <label for="tittleUpdate">Título</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input name="descriptionUpdate" type="text" class="form-control" id="descriptionUpdate" placeholder="name@example.com" maxlength="30" required>
                            <label for="descriptionUpdate">Descripcion</label>
                        </div>
                        <select name="tagUpdate" id="tagUpdate" class="form-select" aria-label="Default select example" required>
                            <option value="" disabled selected>Etiqueta</option>
                            <option value="Escuela">Escuela</option>
                            <option value="Facultad">Facultad</option>
                            <option value="Trabajo">Trabajo</option>
                        </select>
                        <br>
                        <div class="form-floating">
                            <input name="deadlineUpdate" id="deadlineUpdate" type="date" class="form-control" placeholder="Password" required>
                            <label for="deadlineUpdate">Fecha de entrega</label>
                        </div>
                        <br>
                        <div class="btn-updateModalStyle">
                            <button id="btn-updateTaskModal" class="btn btn-primary" type="submit">Actualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    
    
@endsection

