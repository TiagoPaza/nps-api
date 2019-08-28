<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        //Planos
        Permission::create(['name' => 'retorna planos']);
        Permission::create(['name' => 'insere plano']);
        Permission::create(['name' => 'retorna plano']);
        Permission::create(['name' => 'altera plano']);
        Permission::create(['name' => 'remove plano']);

        //Questões
        Permission::create(['name' => 'retorna questões']);
        Permission::create(['name' => 'insere questão']);
        Permission::create(['name' => 'retorna questão']);
        Permission::create(['name' => 'altera questão']);
        Permission::create(['name' => 'remove questão']);

        //Usuários
        Permission::create(['name' => 'retorna usuários']);
        Permission::create(['name' => 'insere usuário']);
        Permission::create(['name' => 'retorna usuário']);
        Permission::create(['name' => 'altera usuário']);
        Permission::create(['name' => 'remove usuário']);

        //Qustões ativos
        Permission::create(['name' => 'retorna questões ativas']);
        Permission::create(['name' => 'insere questão ativa']);
        Permission::create(['name' => 'retorna questão ativa']);
        Permission::create(['name' => 'altera questão ativa']);
        Permission::create(['name' => 'remove questão ativa']);

        //Qustões ativos
        Permission::create(['name' => 'retorna planos ativos']);
        Permission::create(['name' => 'insere plano ativo']);
        Permission::create(['name' => 'retorna plano ativo']);
        Permission::create(['name' => 'altera plano ativo']);
        Permission::create(['name' => 'remove plano ativo']);

        // Create role and assign created permissions
        $role = Role::create(['name' => 'Desenvolvimento']);
        $role->givePermissionTo(Permission::all());
    }
}
