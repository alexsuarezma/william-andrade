<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::create([ 'name' => 'Administrador' ]);
        $docente = Role::create([ 'name' => 'Docente' ]);
        $estudiante = Role::create([ 'name' => 'Estudiante' ]);

        Permission::create([ 'name' => 'usuario.index' ])->assignRole($admin);
        Permission::create([ 'name' => 'usuario.crear' ])->assignRole($admin);
        Permission::create([ 'name' => 'usuario.editar.basico' ])->assignRole($admin);
        Permission::create([ 'name' => 'usuario.editar.avanzado' ])->assignRole($admin);
        Permission::create([ 'name' => 'usuario.eliminar' ])->assignRole($admin);
        Permission::create([ 'name' => 'usuario.desactivar.activar' ])->assignRole($admin);

        Permission::create([ 'name' => 'rol.index' ])->assignRole($admin);
        Permission::create([ 'name' => 'rol.crear' ])->assignRole($admin);
        Permission::create([ 'name' => 'rol.editar.basico' ])->assignRole($admin);
        Permission::create([ 'name' => 'rol.editar.avanzado' ])->assignRole($admin);
        Permission::create([ 'name' => 'rol.eliminar' ])->assignRole($admin);
        Permission::create([ 'name' => 'rol.asignar' ])->assignRole($admin);
        Permission::create([ 'name' => 'rol.revocar' ])->assignRole($admin);
        
        Permission::create([ 'name' => 'curso.index' ])->assignRole($docente);
        Permission::create([ 'name' => 'curso.crear' ])->assignRole($docente);
        Permission::create([ 'name' => 'curso.editar.basico' ])->assignRole($docente);
        Permission::create([ 'name' => 'curso.editar.avanzado' ])->assignRole($docente);
        Permission::create([ 'name' => 'curso.eliminar' ])->assignRole($docente);
        
        Permission::create([ 'name' => 'curso.inscribirse' ])->assignRole($estudiante);
        Permission::create([ 'name' => 'curso.salir' ])->assignRole($estudiante);


        // Permission::create([ 'name' => 'cliente.index' ])->assignRole($admin);
        // Permission::create([ 'name' => 'cliente.crear' ])->assignRole($admin);
        // Permission::create([ 'name' => 'cliente.editar.basico' ])->assignRole($admin);
        // Permission::create([ 'name' => 'cliente.editar.avanzado' ])->assignRole($admin);
        // Permission::create([ 'name' => 'cliente.eliminar' ])->assignRole($admin);

        // Permission::create([ 'name' => 'tipo.gasto.index' ])->assignRole($admin);
        // Permission::create([ 'name' => 'tipo.gasto.crear' ])->assignRole($admin);
        // Permission::create([ 'name' => 'tipo.gasto.editar.basico' ])->assignRole($admin);
        // Permission::create([ 'name' => 'tipo.gasto.editar.avanzado' ])->assignRole($admin);
        // Permission::create([ 'name' => 'tipo.gasto.eliminar' ])->assignRole($admin);

        // Permission::create([ 'name' => 'producto.index' ])->assignRole($admin);
        // Permission::create([ 'name' => 'producto.crear' ])->assignRole($admin);
        // Permission::create([ 'name' => 'producto.editar.basico' ])->assignRole($admin);
        // Permission::create([ 'name' => 'producto.editar.avanzado' ])->assignRole($admin);
        // Permission::create([ 'name' => 'producto.eliminar' ])->assignRole($admin);

        // Permission::create([ 'name' => 'sector.index' ])->assignRole($admin);
        // Permission::create([ 'name' => 'sector.crear' ])->assignRole($admin);
        // Permission::create([ 'name' => 'sector.editar.basico' ])->assignRole($admin);
        // Permission::create([ 'name' => 'sector.editar.avanzado' ])->assignRole($admin);
        // Permission::create([ 'name' => 'sector.eliminar' ])->assignRole($admin);

        // Permission::create([ 'name' => 'lote.index' ])->assignRole($admin);
        // Permission::create([ 'name' => 'lote.crear' ])->assignRole($admin);
        // Permission::create([ 'name' => 'lote.editar.basico' ])->assignRole($admin);
        // Permission::create([ 'name' => 'lote.editar.avanzado' ])->assignRole($admin);
        // Permission::create([ 'name' => 'lote.eliminar' ])->assignRole($admin);

        // Permission::create([ 'name' => 'gasto.index' ])->assignRole($admin);
        // Permission::create([ 'name' => 'gasto.crear' ])->assignRole($admin);
        // Permission::create([ 'name' => 'gasto.editar.basico' ])->assignRole($admin);
        // Permission::create([ 'name' => 'gasto.editar.avanzado' ])->assignRole($admin);
        // Permission::create([ 'name' => 'gasto.eliminar' ])->assignRole($admin);

        // Permission::create([ 'name' => 'produccion.index' ])->assignRole($admin);
        // Permission::create([ 'name' => 'produccion.crear' ])->assignRole($admin);
        // Permission::create([ 'name' => 'produccion.editar.basico' ])->assignRole($admin);
        // Permission::create([ 'name' => 'produccion.editar.avanzado' ])->assignRole($admin);
        // Permission::create([ 'name' => 'produccion.eliminar' ])->assignRole($admin);

        // Permission::create([ 'name' => 'venta.index' ])->assignRole($admin);
        // Permission::create([ 'name' => 'venta.crear' ])->assignRole($admin);
        // Permission::create([ 'name' => 'venta.editar.basico' ])->assignRole($admin);
        // Permission::create([ 'name' => 'venta.editar.avanzado' ])->assignRole($admin);
        // Permission::create([ 'name' => 'venta.eliminar' ])->assignRole($admin);

        // Permission::create([ 'name' => 'empleado.index' ])->assignRole($admin);
        // Permission::create([ 'name' => 'empleado.crear' ])->assignRole($admin);
        // Permission::create([ 'name' => 'empleado.editar.basico' ])->assignRole($admin);
        // Permission::create([ 'name' => 'empleado.editar.avanzado' ])->assignRole($admin);
        // Permission::create([ 'name' => 'empleado.eliminar' ])->assignRole($admin);
        
        // Permission::create([ 'name' => 'registro.sin.restriccion.fecha' ])->assignRole($admin);
    }
}
