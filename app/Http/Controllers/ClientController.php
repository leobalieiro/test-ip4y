<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    public function view_create()
    {
        return view('layouts.client', [
            'title' => 'Cadastro de Clientes',
            'page' => 'pages.client_create'
        ]);
    }

    public function create(Request $request)
    {
        $rules = Validator::make($request->all(), [
            'cpf' => ['required', 'unique:clients,cpf', 'cpf'],
            'name' => ['required'],
            'surname' => ['required'],
            'birthdate' => ['required'],
            'email' => ['required', 'email'],
            'gender' => ['required', 'in:' . join(',', ['male', 'female'])],
        ], [
            'cpf' => ['required' => 'O campo CPF é vázio.', 'unique' => 'Esse CPF já está cadastrado.', 'cpf' => 'O campo CPF não é válido.'],
            'name' => ['required' => 'O campo Nome é vázio.'],
            'surname' => ['required' => 'O campo Sobrenome é vázio.'],
            'birthdate' => ['required' => 'O campo Data de Nascimento é vázio'],
            'email' => ['required' => 'O campo E-mail é vázio.', 'email' => 'O campo E-mail não é válido.'],
            'gender' => ['required' => 'O campo Gênero é vázio.', 'in' => 'O campo Gênero não é válido'],
        ]);
        if ($rules->fails()) {
            return response()->json([
                'status' => 'errors',
                'errors' => $rules->errors()
            ]);
        }

        $client = Client::create([
            'cpf' => $request->post('cpf'),
            'name' => $request->post('name'),
            'surname' => $request->post('surname'),
            'birthdate' => $request->post('birthdate'),
            'email' => $request->post('email'),
            'gender' => $request->post('gender'),
        ]);
        if (!$client) {
            return response()->json([
                'status' => 'error',
                'message' => 'Erro ao cadastrar cliente, por favor tente novamente.',
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Cliente cadastrado com sucesso.',
        ]);
    }

    public function get_all()
    {
        $clients = Client::select([
            'id',
            'name',
            'cpf',
            'email'
        ])->get();
        if ($clients->count() == 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'Não localizamos nenhum cliente.'
            ]);
        }

        return response()->json([
            'status' => 'success',
            'clients' => $clients
        ]);
    }

    public function get($id)
    {
        $client = Client::select([
            'id',
            'cpf',
            'name',
            'surname',
            'birthdate',
            'email',
            'gender'
        ])->where([
            'id' => $id
        ])->get();
        if ($client->count() == 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'Não localizamos nenhum cliente.'
            ]);
        }

        return response()->json([
            'status' => 'success',
            'client' => $client[0]
        ]);
    }

    public function update(Request $request)
    {
        $rules = Validator::make($request->all(), [
            'id' => ['required'],
            'cpf' => ['required', 'unique:clients,cpf,' . $request->post('id'), 'cpf'],
            'name' => ['required'],
            'surname' => ['required'],
            'birthdate' => ['required'],
            'email' => ['required', 'email'],
            'gender' => ['required', 'in:' . join(',', ['male', 'female'])],
        ], [
            'id' => ['required' => 'O campo ID é obrigatório.'],
            'cpf' => ['required' => 'O campo CPF é obrigatório.', 'unique' => 'Esse CPF já está cadastrado.', 'cpf' => 'O campo CPF não é válido.'],
            'name' => ['required' => 'O campo Nome é obrigatório.'],
            'surname' => ['required' => 'O campo Sobrenome é obrigatório.'],
            'birthdate' => ['required' => 'O campo Data de Nascimento é obrigatório'],
            'email' => ['required' => 'O campo E-mail é obrigatório.', 'email' => 'O campo E-mail não é válido.'],
            'gender' => ['required' => 'O campo Gênero é obrigatório.', 'in' => 'O campo Gênero não é válido'],
        ]);
        if ($rules->fails()) {
            return response()->json([
                'status' => 'errors',
                'errors' => $rules->errors()
            ]);
        }

        $client = Client::where('id', $request->post('id'))
            ->update([
                'cpf' => $request->post('cpf'),
                'name' => $request->post('name'),
                'surname' => $request->post('surname'),
                'birthdate' => $request->post('birthdate'),
                'email' => $request->post('email'),
                'gender' => $request->post('gender'),
            ]);
        if (!$client) {
            return response()->json([
                'status' => 'error',
                'message' => 'Erro ao atualizar cliente, por favor tente novamente.',
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Cliente atualizado com sucesso.',
        ]);
    }

    public function delete($id)
    {
        $client = Client::where('id', $id)->delete();
        if (!$client) {
            return response()->json([
                'status' => 'error',
                'message' => 'Erro ao apagar cliente, por favor tente novamente.',
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Cliente apagado com sucesso!',
        ]);
    }

    public function get_all_data()
    {
        $clients = Client::get();

        return response()->json([
            'status' => 'success',
            'clients' => $clients
        ]);
    }

    public function send_data_to_api()
    {
        $clients = Client::get();

        $response = Http::post('https://api-teste.ip4y.com.br/cadastro', [
            'clients' => $clients
        ]);
        // ...
    }
}
