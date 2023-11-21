{{-- STYLE --}}
<style>
</style>

{{-- CONTENT --}}
<div class="container">
    <div class="d-flex justify-content-between">
        <h1>Lista de Clientes:</h1>

        <button type="button" class="btn btn-primary" onclick="open_modal_client_create();">Novo Cliente</button>
    </div>

    <table id="table_clients" class="table table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>CPF</th>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Ações</th>
            </tr>
        </thead>

        <tbody></tbody>
    </table>
</div>

{{-- MODAL --}}
<div class="modal fade" id="modal_client_create">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cadastrar Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form id="modal_client_create_form">
                    @csrf

                    <div class="form-group mb-2">
                        <label for="modal_client_create_form_cpf" class="form-label">CPF:</label>
                        <input type="text" name="cpf" id="modal_client_create_form_cpf" class="form-control mask_cpf" placeholder="000.000.000-00">
                    </div>

                    <div class="form-group mb-2">
                        <label for="modal_client_create_form_name" class="form-label">Nome:</label>
                        <input type="text" name="name" id="modal_client_create_form_name" class="form-control" placeholder="Nome">
                    </div>

                    <div class="form-group mb-2">
                        <label for="modal_client_create_form_surname" class="form-label">Sobrenome:</label>
                        <input type="text" name="surname" id="modal_client_create_form_surname" class="form-control" placeholder="Sobrenome">
                    </div>

                    <div class="form-group mb-2">
                        <label for="modal_client_create_form_birthdate" class="form-label">Data de nascimento:</label>
                        <input type="date" name="birthdate" id="modal_client_create_form_birthdate" class="form-control" placeholder="Data de nascimento">
                    </div>

                    <div class="form-group mb-2">
                        <label for="modal_client_create_form_email" class="form-label">E-mail:</label>
                        <input type="email" name="email" id="modal_client_create_form_email" class="form-control" placeholder="E-mail">
                    </div>

                    <div class="form-group mb-2">
                        <label for="modal_client_create_form_gender" class="form-label">Gênero:</label>
                        <select name="gender" id="modal_client_create_form_gender" class="form-select">
                            <option value="male">Masculino</option>
                            <option value="female">Feminino</option>
                        </select>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal>Fechar</button>
                <button type=" button" class="btn btn-danger" onclick="submit_client_create_restart();">Recomeçar</button>
                <button type="button" class="btn btn-success" onclick="submit_client_create();">Inserir</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_client_edit">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form id="modal_client_edit_form">
                    @csrf

                    <input type="hidden" name="id" id="modal_client_edit_form_id">

                    <div class="form-group mb-2">
                        <label for="modal_client_edit_form_cpf" class="form-label">CPF:</label>
                        <input type="text" name="cpf" id="modal_client_edit_form_cpf" class="form-control mask_cpf" placeholder="000.000.000-00">
                    </div>

                    <div class="form-group mb-2">
                        <label for="modal_client_edit_form_name" class="form-label">Nome:</label>
                        <input type="text" name="name" id="modal_client_edit_form_name" class="form-control" placeholder="Nome">
                    </div>

                    <div class="form-group mb-2">
                        <label for="modal_client_edit_form_surname" class="form-label">Sobrenome:</label>
                        <input type="text" name="surname" id="modal_client_edit_form_surname" class="form-control" placeholder="Sobrenome">
                    </div>

                    <div class="form-group mb-2">
                        <label for="modal_client_edit_form_birthdate" class="form-label">Data de nascimento:</label>
                        <input type="date" name="birthdate" id="modal_client_edit_form_birthdate" class="form-control" placeholder="Data de nascimento">
                    </div>

                    <div class="form-group mb-2">
                        <label for="modal_client_edit_form_email" class="form-label">E-mail:</label>
                        <input type="email" name="email" id="modal_client_edit_form_email" class="form-control" placeholder="E-mail">
                    </div>

                    <div class="form-group mb-2">
                        <label for="modal_client_edit_form_gender" class="form-label">Gênero:</label>
                        <select name="gender" id="modal_client_edit_form_gender" class="form-select">
                            <option value="male">Masculino</option>
                            <option value="female">Feminino</option>
                        </select>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-success" onclick="submit_modal_client_edit_form();">Atualizar</button>
            </div>
        </div>
    </div>
</div>

{{-- SCRIPT --}}
<script>
    function test() {
        $('#modal_client_create_form_cpf').val('123.456.789-09');
        $('#modal_client_create_form_name').val('Gabriel');
        $('#modal_client_create_form_surname').val('De luca balieiro melo');
        $('#modal_client_create_form_birthdate').val('2003-06-23');
        $('#modal_client_create_form_email').val('work.gabrieldeluca@gmail.com');
        $('#modal_client_create_form_gender').val('male');
    }

    async function get_clients() {
        $('#table_clients').find('tbody').empty();

        await fetch(route('/get-clients'))
            .then(res => res.json())
            .then(data => {
                const {
                    status,
                    clients
                } = data;

                if (status == 'success') {
                    clients.forEach(client => {
                        const {
                            id,
                            cpf,
                            name,
                            surname,
                            birthdate,
                            email,
                            gender,
                            created_at
                        } = client;

                        $('#table_clients').find('tbody').append(`
                            <tr>
                                <td>${id}</td>
                                <td>${name}</td>
                                <td>${cpf}</td>
                                <td>${email}</td>
                                <td>
                                    <button type="button" class="btn btn-primary bg-primary" onclick="open_modal_client_edit('${id}');">Editar</button>
                                    <button type="button" class="btn btn-danger bg-danger" onclick="client_remove('${id}');">Apagar</button>
                                </td>
                            </tr>
                        `);
                    });
                }
            });
    }

    async function open_modal_client_edit(id) {
        await fetch(route('/get-client/' + id))
            .then(res => res.json())
            .then(data => {
                const {
                    status,
                    message,
                    errors,
                    client
                } = data;

                if (status == 'success') {
                    const {
                        id,
                        cpf,
                        name,
                        surname,
                        birthdate,
                        email,
                        gender
                    } = client;

                    $('#modal_client_edit_form_id').val(id);
                    $('#modal_client_edit_form_cpf').val(cpf);
                    $('#modal_client_edit_form_name').val(name);
                    $('#modal_client_edit_form_surname').val(surname);
                    $('#modal_client_edit_form_birthdate').val(birthdate);
                    $('#modal_client_edit_form_email').val(email);
                    $('#modal_client_edit_form_gender').val(gender);
                    $('#modal_client_edit').modal('show');

                    return;

                } else if (status == 'error') {
                    toastr.error(message);
                    return;

                } else if (status == 'errors') {
                    toastr.error('<li>' + Object.values(errors).join('</li><li>') + '</li>');
                    return;

                }
            });
    }

    async function submit_modal_client_edit_form() {
        const formData = new FormData($('#modal_client_edit_form')[0]);

        if (!formData.get('id')) {
            toastr.error('O campo ID é obrigatório.');
            return;

        } else if (!formData.get('cpf')) {
            $('#modal_client_edit_form_cpf').focus();
            toastr.error('O campo CPF é obrigatório.');
            return;

        } else if (validate_cpf(formData.get('cpf')) == false) {
            $('#modal_client_edit_form_cpf').focus();
            toastr.error('O campo CPF está inválido.');
            return;

        } else if (!formData.get('name')) {
            $('#modal_client_edit_form_name').focus();
            toastr.error('O campo Nome é obrigatório.');
            return;

        } else if (!formData.get('surname')) {
            $('#modal_client_edit_form_surname').focus();
            toastr.error('O campo Sobrenome é obrigatório.');
            return;

        } else if (!formData.get('birthdate')) {
            $('#modal_client_edit_form_birthdate').focus();
            toastr.error('O campo Data de Nascimento é obrigatório.');
            return;

        } else if (!formData.get('email')) {
            $('#modal_client_edit_form_email').focus();
            toastr.error('O campo E-mail é obrigatório.');
            return;

        } else if (validate_email(formData.get('email')) == false) {
            $('#modal_client_edit_form_email').focus();
            toastr.error('O campo E-mail está inválido.');
            return;

        } else if (!formData.get('gender')) {
            $('#modal_client_edit_form_email').focus();
            toastr.error('O campo Gênero é obrigatório.');
            return;

        } else if (['male', 'female'].includes(formData.get('gender')) == false) {
            $('#modal_client_edit_form_email').focus();
            toastr.error('O campo Gênero está inválido.');
            return;

        }

        await fetch(route('/client-update'), {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(async data => {
                const {
                    status,
                    message,
                    errors
                } = data;

                if (status == 'success') {
                    await get_clients();
                    $('#modal_client_edit').modal('hide');
                    toastr.success(message);
                    return;

                } else if (status == 'error') {
                    toastr.error(message);
                    return;

                } else if (status == 'errors') {
                    toastr.error('<li>' + Object.values(errors).join('</li><li>') + '</li>');
                    return;

                }
            });
    }

    async function client_remove(id) {
        if (confirm('Você tem certeza que deseja remover esse cliente?') == false) {
            return;
        }

        await fetch(route('/client-delete/' + id))
            .then(res => res.json())
            .then(async data => {
                const {
                    status,
                    message,
                    errors
                } = data;

                if (status == 'success') {
                    await get_clients();
                    toastr.success(message);
                    return;

                } else if (status == 'error') {
                    toastr.error(message);
                    return;

                } else if (status == 'errors') {
                    toastr.error('<li>' + Object.values(errors).join('</li><li>') + '</li>');
                    return;

                }
            });
    }

    function open_modal_client_create() {
        $('#modal_client_create_form')[0].reset();
        $('#modal_client_create_form_cpf').focus();
        $('#modal_client_create').modal('show');
    }

    async function submit_client_create() {
        const formData = new FormData($('#modal_client_create_form')[0]);

        if (!formData.get('cpf')) {
            $('#modal_client_create_form_cpf').focus();
            toastr.error('O campo CPF é obrigatório.');
            return;

        } else if (validate_cpf(formData.get('cpf')) == false) {
            $('#modal_client_create_form_cpf').focus();
            toastr.error('O campo CPF está inválido.');
            return;

        } else if (!formData.get('name')) {
            $('#modal_client_create_form_name').focus();
            toastr.error('O campo Nome é obrigatório.');
            return;

        } else if (!formData.get('surname')) {
            $('#modal_client_create_form_surname').focus();
            toastr.error('O campo Sobrenome é obrigatório.');
            return;

        } else if (!formData.get('birthdate')) {
            $('#modal_client_create_form_birthdate').focus();
            toastr.error('O campo Data de Nascimento é obrigatório.');
            return;

        } else if (!formData.get('email')) {
            $('#modal_client_create_form_email').focus();
            toastr.error('O campo E-mail é obrigatório.');
            return;

        } else if (validate_email(formData.get('email')) == false) {
            $('#modal_client_create_form_email').focus();
            toastr.error('O campo E-mail está inválido.');
            return;

        } else if (!formData.get('gender')) {
            $('#modal_client_create_form_email').focus();
            toastr.error('O campo Gênero é obrigatório.');
            return;

        } else if (['male', 'female'].includes(formData.get('gender')) == false) {
            $('#modal_client_create_form_email').focus();
            toastr.error('O campo Gênero está inválido.');
            return;

        }

        await fetch(route('/client-create'), {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(async data => {
                const {
                    status,
                    message,
                    errors
                } = data;

                if (status == 'success') {
                    await get_clients();
                    $('#modal_client_create').modal('hide');
                    toastr.success(message);
                    return;

                } else if (status == 'error') {
                    toastr.error(message);
                    return;

                } else if (status == 'errors') {
                    toastr.error('<li>' + Object.values(errors).join('</li><li>') + '</li>');
                    return;

                }
            });
    }

    function submit_client_create_restart() {
        $('#modal_client_create_form')[0].reset();
        $('#modal_client_create_form_cpf').focus();
    }


    async function get_all_clients() {
        let all_clients = [];

        await fetch(route('/get-all-clients-data'))
            .then(res => res.json())
            .then(data => {
                const {
                    status,
                    message,
                    errors,

                    clients
                } = data;

                if (status == 'success') {
                    all_clients = clients;
                }
            });

        return all_clients;
    }

    async function send_all_data_to_api() {
        const formData = new FormData();
        formData.append('clients', JSON.stringify(await get_all_clients()));

        await fetch('https://api-teste.ip4y.com.br/cadastro', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                // ...
            });
    }

    $(document).ready(async function() {
        await get_clients();

        $('.mask_cpf').mask('000.000.000-00');
        $('#modal_client_create_form_cpf').mask('000.000.000-00');
    });
</script>
