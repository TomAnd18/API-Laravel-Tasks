$(document).ready(function() {
    const url = 'http://localhost:8000/api';

    addTask();
    addEventDelete();
    addEventUpdate();
    updateTask();

    function addTask() {
        $('#task-form').submit(function(event) {
            event.preventDefault();
            
            var formData = {
                tittle: $('#tittle').val(),
                description: $('#description').val(),
                tag: $('#tag').val(),
                deadline: $('#deadline').val(),
            };
            
            // Envía la solicitud POST a la API
            $.ajax({
                url: `${url}/task`,
                method: 'POST',
                data: formData,
                success: function(response) {
                    // Maneja la respuesta de la API
                    window.location.href = '/';
    
                    // // Actualiza la lista de tareas con la nueva tarea creada
                    // var taskHtml = '<li class="list-group-item d-flex justify-content-between align-items-start" data-task-id="'+ response.task.id +'">';
                    // taskHtml += '<div class="ms-2 me-auto">';
                    // taskHtml += '<div class="fw-bold" id="e-tittle-' + response.task.id + '" >' + response.task.tittle + '</div>';
                    // taskHtml += '<div class="descrip-container-text" id="e-description-' + response.task.id + '" >' + response.task.description + '</div>';

                    // taskHtml += '<div class="container-created">';
                    // taskHtml += '<span class="title-created"> Fecha de Creación: </span>';
                    // taskHtml += '<span class="date-tittlecreated" id="date-creation">' + transformDate(response.task.created_at) + '</span>';
                    // taskHtml += '</div>';

                    // taskHtml += '</div>';
                    // taskHtml += '<div class="container-optiontasks">';
                    // taskHtml += '<span id="delete-task-btn" class="item-optiontask option-colortwo">';
                    // taskHtml += '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2" style="width: 100%; height: 100%;"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>';
                    // taskHtml += '</span>';
                    // taskHtml += '<span id="update-task-btn" class="item-optiontask option-colorthree" data-bs-toggle="modal" data-bs-target="#exampleModal">';
                    // taskHtml += '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit" style="width: 100%; height: 100%;"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>';
                    // taskHtml += '</span>';
                    // taskHtml += '</div>';
                    // taskHtml += '</li>';
    
                    // //Agrego la tarea a la lista
                    // $('#tasks-list').append(taskHtml);
    
                    // //Limpio el formulario
                    // $('#task-form')[0].reset();
    
                    // var buttonHome = document.getElementById('pills-home-tab');
                    // var buttonContact = document.getElementById('pills-contact-tab');
                    // var contentHome = document.getElementById('pills-home');
                    // var contentContact = document.getElementById('pills-contact');
    
                    // buttonHome.classList.add('active');
                    // buttonHome.setAttribute('aria-selected', 'true');
                    // buttonContact.classList.remove('active');
                    // buttonContact.setAttribute('aria-selected', 'false');
                    
                    // contentContact.classList.remove('active');
                    // contentContact.classList.remove('show');
                    // contentHome.classList.add('active');
                    // contentHome.classList.add('show');
    
                    // addEventDelete();
                    // addEventUpdate();
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
    }

    function transformDate(inputDate) {
        // Crear un objeto Date a partir de la cadena de fecha
        let date = new Date(inputDate);
    
        // Extraer los componentes de la fecha
        let year = date.getFullYear();
        let month = String(date.getMonth() + 1).padStart(2, '0'); // Los meses van de 0 a 11
        let day = String(date.getDate()).padStart(2, '0');
        let hours = String(date.getHours()+3).padStart(2, '0');
        let minutes = String(date.getMinutes()).padStart(2, '0');
        let seconds = String(date.getSeconds()).padStart(2, '0');
    
        // Construir la cadena en el formato deseado
        let formattedDate = `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
    
        return formattedDate;
    }

    function addEventDelete() {
        // Obtener el elemento span
        document.querySelectorAll('#delete-task-btn').forEach(function(button) {
            button.addEventListener('click', function() {
                // Eliminar la tarea del DOM
                var task = this.parentNode.parentNode;
                task.remove();

                eliminarTarea(this.parentNode.parentNode.dataset.taskId);
            });
        });
    }


    function eliminarTarea(taskId) {
        // Enviar una solicitud POST al servidor con el ID de la tarea a eliminar
        fetch(`${url}/task/${taskId}`, {
            method: 'DELETE'
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al eliminar la tarea');
            }
            // Tarea eliminada con éxito
            console.log('Tarea eliminada con éxito');
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    function addEventUpdate() {
        document.querySelectorAll('#update-task-btn').forEach(function(button) {
            button.addEventListener('click', function() {
                
                //Limpio el form y desactivo el btn temporalmente
                $('#task-form-update')[0].reset();
                document.getElementById('btn-updateTaskModal').disabled = true;

                const taskId = this.parentNode.parentNode.dataset.taskId;

                fetch(`${url}/task/${taskId}`, {
                        method: 'GET'
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data.task);
                        
                        document.querySelector('#tittleUpdate').value = data.task.tittle;
                        document.querySelector('#descriptionUpdate').value = data.task.description;
                        document.querySelector('#tagUpdate').value = data.task.tag;
                        document.querySelector('#deadlineUpdate').value = data.task.deadline;

                        // Establece el ID de la tarea actual en el formulario
                        document.querySelector('#task-form-update').dataset.taskId = taskId;
                        //Activo el btn
                        document.getElementById('btn-updateTaskModal').disabled = false;
                    })
                    .catch(error => console.log(error));
            })
        })
    }

    function updateTask() {
        const btnUpdate = document.querySelector('#task-form-update');
        btnUpdate.addEventListener("submit", e => {
            e.preventDefault();

            const taskId = document.querySelector('#task-form-update').dataset.taskId;

            const datosUpdate = {
                tittle: document.querySelector('#tittleUpdate').value,
                description: document.querySelector('#descriptionUpdate').value,
                tag: document.querySelector('#tagUpdate').value,
                deadline: document.querySelector('#deadlineUpdate').value
            }

            console.log(datosUpdate);
            console.log('ID = ',taskId);

            fetch(`${url}/task/${taskId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(datosUpdate)
            })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    window.location.href = '/';
                })
                .catch(error => console.log(error))
        });
    }
});
