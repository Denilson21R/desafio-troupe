<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    public function getUsers()
    {
        $users = User::orderBy('name')->get();

        if (empty($users)){
            $users = [];
        }

        return response()->json($users,200);
    }

    public function getUser(Request $request, $cpf)
    {
        $user = User::where('cpf', $cpf)->first();

        if(!empty($user)){
            return response()->json($user->getAttributes(), 200);
        }

        return response()->json(['error' => 'user not found'], 404);
    }

    public function postUser(Request $request)
    {

        $this->validate($request, [
            'name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'phone' => 'required|alpha_num',
            'cep' => 'required|size:8',
            'cpf' => 'required'
        ]);

        if(!empty($request->cpf)) {
            $user_exist = User::where('cpf', $request->cpf)->first();

            if (empty($user_exist)) {

                if (!empty($request->cep) && empty($request->public_place) && empty($request->district) && empty($request->city) && empty($request->uf)){
                    $dados_cep = $this->getDataCpf($request->cep);
                    if(!empty($dados_cep)){
                        $request = $this->fillRequestWithCpfData($request, $dados_cep);
                    }else{
                        return response()->json(['error' => 'could not find the data with this zip code'], 422);
                    }
                }

                if (!empty($request->cep) && !empty($request->city) && !empty($request->uf)){
                    $user = User::create($request->all());
                    return response()->json($user->getAttributes(), 201);
                }else if($request->cep && !$request->city && !$request->uf){
                    return response()->json(['error' => 'Unable to fill city and state'], 422);
                }
            } else {
                return response()->json(['error' => 'user already exist'], 422);
            }
        }else{
            return response()->json(['error' => 'missing required parameters'], 422);
        }
    }

    public function updateUser(Request $request, $cpf)
    {

        $this->validate($request, [
            'name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'phone' => 'required|alpha_num',
            'cep' => 'required|size:8'
        ]);

        $user = User::where('cpf', $cpf)->first();

        if (!empty($user) && !empty($request)){

            $user->name = $request->name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->phone = $request->phone;

            if(!empty($request->cep) && empty($request->public_place) && empty($request->district) && empty($request->city) && empty($request->uf)){
                $dados_cep = $this->getDataCpf($request->cep);
                if($dados_cep){
                    $user->fillWithDataCpfData($dados_cep);
                }else{
                    return response()->json(['error' => 'zip code not found'], 422);
                }
            }else {
                $user->cep = $request->cep;
                $user->public_place = $request->public_place;
                $user->district = $request->district;
                $user->city = $request->city;
                $user->uf = $request->uf;
            }

            $user->save();
            return response()->json($user->getAttributes(), 200);
        }else{
            return response()->json(['error' => 'user not found'], 404);
        }
    }

    public function deleteUser(Request $request, $cpf)
    {
        $user = User::where('cpf', $cpf)->first();

        if(!empty($user)){
            $user->delete();
            return response()->json([], 204);
        }else{
            return response()->json(['error' => 'user not found'], 404);
        }
    }

    private function getDataCpf($cep)
    {
        $cep_adaptado = str_replace('.','', str_replace('-','', $cep));
        $link_get_cep = 'https://viacep.com.br/ws/'.$cep_adaptado.'/json/';
        $response_cep = Http::get($link_get_cep);
        if($response_cep->status() == 200){
            return json_decode($response_cep->body());
        }else{
            return null;
        }
    }

    private function fillRequestWithCpfData(Request $request, $dados_cep) :Request
    {
        $request->request->add([
            'uf' => $dados_cep->uf,
            'city' => $dados_cep->localidade,
            'public_place' => $dados_cep->logradouro,
            'district' => $dados_cep->bairro,
        ]);
        return $request;
    }
}

