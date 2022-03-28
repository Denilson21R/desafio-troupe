<?php

namespace Tests;

use App\Models\User;

class UserControllerTest extends TestCase
{

    public function testCanGetAllUsers(){
        //act
        $result = $this->get('/users');

        //assert
        $result->assertResponseOk();
    }

    public function testCanGetUserById(){
        //prepare
        $user = User::factory()->create();

        //act
        $result = $this->get('/users/' . $user->cpf);

        //assert
        $result->assertResponseOk();
        $result->seeJsonEquals($user->getAttributes());
    }

    public function testReturnErrorWhenCpfNotFoundOnGetUserByCpf(){
        //act
        $result = $this->get('/users/111');

        //assert
        $result->assertResponseStatus(404);
    }

    public function testCanSaveUser(){
        //prepare
        $user = [
            'name' => 'Denilson',
            'last_name' => 'Rocha',
            'cpf' => '123.123.123-95',
            'email' => 'testeemail@email.com',
            'phone' => '19912345678',
            'cep' => '91234000',
            'public_place' => 'Rua Teste',
            'district' => 'Jardim Teste',
            'city' => 'Teste',
            'uf' => 'SP',
        ];

        //act
        $result = $this->post('/users', $user);

        //assert
        $result->seeInDatabase('users', $user);
    }

    public function testReturnErrorWhenMissingParametersOnSaveUser(){
        //act
        $result = $this->post('/users', []);

        //assert
        $result->assertResponseStatus(422);
    }

    public function testCanDeleteUserByCpf(){
        //prepare
        $user = User::factory()->create();

        //act
        $result = $this->delete('/users/' . $user->cpf);

        //assert
        $result->assertResponseStatus(204);
        $result->notSeeInDatabase('users', $user->getAttributes());
    }

    public function testReturnErrorWhenCpfNotFoundOnDeleteUser(){
        //act
        $result = $this->delete('/users/111');

        //assert
        $result->assertResponseStatus(404);
    }

    public function testCanUpdateUser(){
        //prepare
        $user = User::factory()->create();

        $user = [
            'id' => $user->id,
            'cpf' => $user->cpf,
            'name' => $user->name,
            'last_name' => $user->last_name,
            'email' => 'email.teste@email.com',
            'phone' => '19999999999',
            'cep' => '13530000',
            'public_place' => $user->public_place,
            'district' => $user->district,
            'city' => $user->city,
            'uf' => $user->uf,
        ];

        //act
        $result = $this->put('/users/'.$user['cpf'], $user);

        //assert
        $result->seeInDatabase('users', $user);
        $result->assertResponseOk();
        $result->seeJsonEquals($user);
    }

    public function testReturnErrorWhenCpfNotFoundOnUpdateUser(){
        //prepare
        $user = User::factory()->create();

        $user_update = [
            'id' => $user->id,
            'cpf' => $user->cpf,
            'name' => $user->name,
            'last_name' => $user->last_name,
            'email' => 'email.teste@email.com',
            'phone' => '19999999999',
            'cep' => '13530000',
            'public_place' => $user->public_place,
            'district' => $user->district,
            'city' => $user->city,
            'uf' => $user->uf,
        ];

        //act
        $result = $this->put('/users/111', $user_update);

        //assert
        $result->seeInDatabase('users', $user->getAttributes());
        $result->assertResponseStatus(404);
    }

    public function testReturnErrorWhenMissingParametersOnUpdateUser(){
        //prepare
        $user = User::factory()->create();

        $user_update = [
            'id' => $user->id,
            'cpf' => $user->cpf,
            'name' => $user->name,
            'last_name' => $user->last_name,
            'email' => 'email.teste@email.com',
            'phone' => '+55 19 99999 9999',
        ];

        //act
        $result = $this->put('/users/'.$user['cpf'], $user_update);

        //assert
        $result->assertResponseStatus(422);
    }

    public function testReturnErrorWhenCpfAlreadyExistsOnSaveUser(){
        //prepare
        $user = User::factory()->create();

        //act
        $result = $this->post('/users', $user->getAttributes());

        //assert
        $result->assertResponseStatus(422);
    }

    public function testFillDataUsingCpfOnSaveUser(){
        //prepare
        $user = [
            'name' => 'Donald',
            'last_name' => 'Rodrigues',
            'cpf' => '973.122.153-95',
            'email' => 'emaildonald@email.com',
            'phone' => '+55 11 98270 5678',
            'cep' => '01001-000',
        ];

        $user_with_data_fill = [
            'name' => 'Donald',
            'last_name' => 'Rodrigues',
            'cpf' => '973.122.153-95',
            'email' => 'emaildonald@email.com',
            'phone' => '+55 11 98270 5678',
            'cep' => '01001-000',
            'uf' => 'SP',
            'city' => 'São Paulo',
            'public_place' => 'Praça da Sé',
            'district' => 'Sé',
        ];

        //assert
        $result = $this->post('/users', $user);

        //assert
        $this->assertResponseStatus(201);
        $result->seeInDatabase('users', $user_with_data_fill);
    }

    public function testFillDataUsingCpfOnUpdateUser(){
        //prepare
        $user = User::factory()->create();

        $user_to_update = [
            'id' => $user->id,
            'cpf' => $user->cpf,
            'name' => $user->name,
            'last_name' => $user->last_name,
            'email' => 'email.teste@email.com',
            'phone' => '+55 19 99999 9999',
            'cep' => '13530-000'
        ];

        $user_updated = [
            'id' => $user->id,
            'cpf' => $user->cpf,
            'name' => $user->name,
            'last_name' => $user->last_name,
            'email' => 'email.teste@email.com',
            'phone' => '+55 19 99999 9999',
            'cep' => '13530-000',
            'city' => 'Itirapina',
            'UF' => 'SP'
        ];

        //act
        $result = $this->put('/users/'.$user['cpf'], $user_to_update);

        //assert
        $result->assertResponseStatus(200);
        $result->seeInDatabase('users', $user_updated);
    }

}
