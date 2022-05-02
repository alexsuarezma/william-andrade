<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\CursoController;

use App\Http\Controllers\HomeController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

Route::middleware('auth')->prefix('user')->group(function () {
    
    Route::put('/update/password', [UserController::class, 'updatePasswordUser'])->name('update.password.verification');
    Route::put('/information/profile', [UserController::class, 'updateInformationProfile'])->name('user.profile.information.update');
});

Route::get('/register', function () {
    return redirect()->route('user.create');
});

Route::middleware(['auth'])->prefix('admin')->group(function () {

    
    Route::get('/user/register', [\Laravel\Fortify\Http\Controllers\RegisteredUserController::class, 'create'])->name('user.create')->middleware('permission:usuario.crear');
    Route::get('/user/update/{id}', [UserController::class, 'updateInformationUserView'])->name('user.update')->middleware('permission:usuario.editar.avanzado');

    // Route::get('/user/update/{id}', [UserController::class, 'updateView'])->name('user.update');
    Route::get('/user/list', [UserController::class, 'index'])->name('user.index')->middleware('permission:usuario.index');
    Route::post('/user/register', [UserController::class, 'create'])->name('user.create.post')->middleware('permission:usuario.crear');
    
    Route::put('/update', [UserController::class, 'update'])->name('user.update.put')->middleware('permission:usuario.editar.avanzado');
    Route::put('/user/change-password', [UserController::class, 'changePassword'])->name('user.update.password.put')->middleware('permission:usuario.editar.avanzado');
    Route::put('/user/desactive/account', [UserController::class, 'desactiveAccount'])->name('user.desactive.account')->middleware('permission:usuario.desactivar.activar');
    Route::put('/users/password/', [UserController::class, 'updatePasswordsUsers'])->name('user.passwords.update')->middleware('permission:usuario.editar.avanzado');
    Route::put('/user/information', [UserController::class, 'updateInformationUser'])->name('user.information.update')->middleware('permission:usuario.editar.avanzado');

    Route::get('/role/create', [RoleController::class, 'createView'])->name('role.create.get')->middleware('permission:rol.crear');
    Route::get('/role/update/{id}', [RoleController::class, 'updateView'])->name('role.update.get')->middleware('permission:rol.editar.avanzado');
    Route::get('/role/list', [RoleController::class, 'index'])->name('role.index')->middleware('permission:rol.index');
    Route::post('/role/register', [RoleController::class, 'create'])->name('role.create.post')->middleware('permission:rol.crear');
    Route::put('/role/update', [RoleController::class, 'update'])->name('role.update.put')->middleware('permission:rol.editar.avanzado');
    Route::post('/role/assign/', [RoleController::class, 'assignRoleToUser'])->name('role.assign.create')->middleware('permission:rol.asignar');
    Route::post('/role/revoke/', [RoleController::class, 'revokeRoleToUser'])->name('role.revoke.delete')->middleware('permission:rol.revocar');
    Route::delete('/role/delete/', [RoleController::class, 'delete'])->name('role.delete')->middleware('permission:rol.eliminar');

    // Route::get('/balance/final', [ReportesController::class, 'reporteBalanceFinal'])->name('reports.balance.general.get');//->middleware('permission:rol.editar.avanzado');
    // Route::get('/print/balance/final/{anio}', [ReportesController::class, 'printReporteBalanceFinal'])->name('print.reports.balance.general.get');
});

Route::middleware('auth')->prefix('curso')->group(function () {
    
    Route::get('/create', [CursoController::class, 'register'])->name('curso.create')->middleware('permission:curso.crear');
    Route::get('/update/{id}', [CursoController::class, 'updateView'])->name('curso.update')->middleware('permission:curso.editar.avanzado');
    Route::get('/list', [CursoController::class, 'index'])->name('curso.index');//->middleware('permission:curso.index');
    Route::post('/register', [CursoController::class, 'create'])->name('curso.create.post')->middleware('permission:curso.crear');
    Route::put('/update', [CursoController::class, 'update'])->name('curso.update.put')->middleware('permission:curso.editar.avanzado');

    // Route::get('/inscribirse', [CursoController::class, 'inscribirseView'])->name('curso.inscribirse')->middleware('permission:curso.inscribirse');
    Route::post('/inscribir', [CursoController::class, 'inscribirse'])->name('curso.inscribirse.post')->middleware('permission:curso.inscribirse');

    // Route::get('/salir', [CursoController::class, 'desinscribirseView'])->name('curso.salir')->middleware('permission:curso.salir');
    Route::post('/salirse', [CursoController::class, 'desinscribirse'])->name('curso.salir.post')->middleware('permission:curso.salir');

    Route::get('/info/{id}', [CursoController::class, 'infoView'])->name('curso.info');
});

//
// Route::middleware('auth')->prefix('cliente')->group(function () {
    
//     Route::get('/register', [ClienteController::class, 'register'])->name('cliente.create')->middleware('permission:cliente.crear');
//     Route::get('/update/{id}', [ClienteController::class, 'updateView'])->name('cliente.update')->middleware('permission:cliente.editar.avanzado');
//     Route::get('/list', [ClienteController::class, 'index'])->name('cliente.index')->middleware('permission:cliente.index');
//     Route::post('/register', [ClienteController::class, 'create'])->name('cliente.create.post')->middleware('permission:cliente.crear');
//     Route::put('/update', [ClienteController::class, 'update'])->name('cliente.update.put')->middleware('permission:cliente.editar.avanzado');
// });

// Route::middleware('auth')->prefix('tipo/gasto')->group(function () {
    
//     Route::get('/register', [TipoGastoController::class, 'register'])->name('tipo.gasto.create')->middleware('permission:tipo.gasto.crear');
//     Route::get('/update/{id}', [TipoGastoController::class, 'updateView'])->name('tipo.gasto.update')->middleware('permission:tipo.gasto.editar.avanzado');
//     Route::get('/list', [TipoGastoController::class, 'index'])->name('tipo.gasto.index')->middleware('permission:tipo.gasto.index');
//     Route::post('/register', [TipoGastoController::class, 'create'])->name('tipo.gasto.create.post')->middleware('permission:tipo.gasto.crear');
//     Route::put('/update', [TipoGastoController::class, 'update'])->name('tipo.gasto.update.put')->middleware('permission:tipo.gasto.editar.avanzado');
// });

// Route::middleware('auth')->prefix('producto')->group(function () {
    
//     Route::get('/register', [ProductoController::class, 'register'])->name('producto.create')->middleware('permission:producto.crear');
//     Route::get('/update/{id}', [ProductoController::class, 'updateView'])->name('producto.update')->middleware('permission:producto.editar.avanzado');
//     Route::get('/list', [ProductoController::class, 'index'])->name('producto.index')->middleware('permission:producto.index');
//     Route::post('/register', [ProductoController::class, 'create'])->name('producto.create.post')->middleware('permission:producto.crear');
//     Route::put('/update', [ProductoController::class, 'update'])->name('producto.update.put')->middleware('permission:producto.editar.avanzado');
// });

// Route::middleware('auth')->prefix('sector')->group(function () {
    
//     Route::get('/register', [SectorLoteController::class, 'register'])->name('sector.create')->middleware('permission:sector.crear');
//     Route::get('/update/{id}', [SectorLoteController::class, 'updateView'])->name('sector.update')->middleware('permission:sector.editar.avanzado');
//     Route::get('/list', [SectorLoteController::class, 'index'])->name('sector.index')->middleware('permission:sector.index');
//     Route::post('/register', [SectorLoteController::class, 'create'])->name('sector.create.post')->middleware('permission:sector.crear');
//     Route::put('/update', [SectorLoteController::class, 'update'])->name('sector.update.put')->middleware('permission:sector.editar.avanzado');
//     Route::put('/update/vigencia', [SectorLoteController::class, 'updateVigencia'])->name('sector.update.vigencia.put')->middleware('permission:sector.eliminar');
    
// });

// Route::middleware('auth')->prefix('lote')->group(function () {
    
//     Route::get('/register', [SectorLoteController::class, 'register'])->name('lote.create')->middleware('permission:lote.crear');
//     Route::get('/update/{id}', [SectorLoteController::class, 'updateView'])->name('lote.update')->middleware('permission:lote.editar.avanzado');
//     Route::get('/list', [SectorLoteController::class, 'index'])->name('lote.index')->middleware('permission:lote.index');
//     Route::post('/register', [SectorLoteController::class, 'create'])->name('lote.create.post')->middleware('permission:lote.crear');
//     Route::put('/update', [SectorLoteController::class, 'update'])->name('lote.update.put')->middleware('permission:lote.editar.avanzado');
//     Route::put('/update/vigencia', [SectorLoteController::class, 'updateVigencia'])->name('lote.update.vigencia.put')->middleware('permission:lote.eliminar');
// });

// Route::middleware('auth')->prefix('gasto')->group(function () {
    
//     Route::get('/register', [GastoController::class, 'register'])->name('gasto.create')->middleware('permission:gasto.crear');
//     Route::get('/update/{id}', [GastoController::class, 'updateView'])->name('gasto.update')->middleware('permission:gasto.editar.avanzado');
//     Route::get('/list', [GastoController::class, 'index'])->name('gasto.index')->middleware('permission:gasto.index');
//     Route::post('/register', [GastoController::class, 'create'])->name('gasto.create.post')->middleware('permission:gasto.crear');
//     Route::put('/update', [GastoController::class, 'update'])->name('gasto.update.put')->middleware('permission:gasto.editar.avanzado');
//     Route::put('/anular', [GastoController::class, 'anular'])->name('gasto.anular.put')->middleware('permission:gasto.eliminar');

//     Route::post('/print/report', [GastoController::class, 'printReportToPdf'])->name('gasto.print.report.post');
//     Route::get('/print/document/{id}', [GastoController::class, 'printDocumentToPdf'])->name('gasto.print.document.get');
// });

// Route::middleware('auth')->prefix('produccion')->group(function () {
    
//     Route::get('/register', [ProduccionController::class, 'register'])->name('produccion.create')->middleware('permission:produccion.crear');
//     Route::get('/update/{id}', [ProduccionController::class, 'updateView'])->name('produccion.update')->middleware('permission:produccion.editar.avanzado');
//     Route::get('/list', [ProduccionController::class, 'index'])->name('produccion.index')->middleware('permission:produccion.index');
//     Route::post('/register', [ProduccionController::class, 'create'])->name('produccion.create.post')->middleware('permission:produccion.crear');
//     Route::put('/update', [ProduccionController::class, 'update'])->name('produccion.update.put')->middleware('permission:produccion.editar.avanzado');
//     Route::put('/anular', [ProduccionController::class, 'anular'])->name('produccion.anular.put')->middleware('permission:produccion.eliminar');

//     Route::post('/print/report', [ProduccionController::class, 'printReportToPdf'])->name('produccion.print.report.post');
//     Route::get('/print/document/{id}', [ProduccionController::class, 'printDocumentToPdf'])->name('produccion.print.document.get');
// });

// Route::middleware('auth')->prefix('venta')->group(function () {
    
//     Route::get('/register', [VentaController::class, 'register'])->name('venta.create')->middleware('permission:venta.crear');
//     Route::get('/update/{id}', [VentaController::class, 'updateView'])->name('venta.update')->middleware('permission:venta.editar.avanzado');
//     Route::get('/list', [VentaController::class, 'index'])->name('venta.index')->middleware('permission:venta.index');
//     Route::post('/register', [VentaController::class, 'create'])->name('venta.create.post')->middleware('permission:venta.crear');
//     Route::put('/update', [VentaController::class, 'update'])->name('venta.update.put')->middleware('permission:venta.editar.avanzado');
//     Route::put('/anular', [VentaController::class, 'anular'])->name('venta.anular.put')->middleware('permission:venta.eliminar');

//     Route::post('/print/report', [VentaController::class, 'printReportToPdf'])->name('venta.print.report.post');
//     Route::get('/print/document/{id}', [VentaController::class, 'printDocumentToPdf'])->name('venta.print.document.get');
// });

// Route::middleware('auth')->prefix('empleado')->group(function () {

//     Route::get('/register', [EmpleadoController::class, 'register'])->name('empleado.create')->middleware('permission:empleado.crear');
//     Route::get('/update/{id}', [EmpleadoController::class, 'updateView'])->name('empleado.update')->middleware('permission:empleado.editar.avanzado');
//     Route::get('/list', [EmpleadoController::class, 'index'])->name('empleado.index')->middleware('permission:empleado.index');
//     Route::post('/register', [EmpleadoController::class, 'create'])->name('empleado.create.post')->middleware('permission:empleado.crear');
//     Route::put('/update', [EmpleadoController::class, 'update'])->name('empleado.update.put')->middleware('permission:empleado.editar.avanzado');
// });



