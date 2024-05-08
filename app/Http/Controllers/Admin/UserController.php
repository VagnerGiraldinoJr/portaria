<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\TableCode;
use App\Http\Requests\Admin\User\UserInsertRequest ;
use App\Http\Requests\Admin\User\UserEditarRequest ;
use DB;
use Kodeine\Acl\Models\Eloquent\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB as FacadesDB;

class UserController extends Controller
{
    public function __construct(User $users)
    {
        $this->user = $users;

        // Default values
        $this->params['titulo']='Usuário';
        $this->params['main_route']='admin.user';

    }

    public function index()
    {
        
        // PARAMS DEFAULT
        $this->params['subtitulo']='Usuários Cadastrados';
        $this->params['arvore'][0] = [
                    'url' => 'admin/user',
                    'titulo' => 'Usuários'
        ];

        $params = $this->params;

        $data = $this->user->where('unidade_id',Auth::user()->unidade_id)->get();

        // dd($data);
       
        return view('admin.user.index',compact('params','data'));
    }

    public function create(TableCode $codes , Role $roles)
    {
        // PARAMS DEFAULT
        $this->params['subtitulo']='Cadastrar Usuário';
        $this->params['arvore']=[
           [
               'url' => 'admin/user',
               'titulo' => 'Usuário'
           ],
           [
               'url' => '',
               'titulo' => 'Cadastrar'
           ]];
       $params = $this->params;
       $preload['roles'] = $roles->select('name','id')->get()->pluck('name','id');
       return view('admin.user.create',compact('params','preload'));
    }

    public function store(UserInsertRequest $request)
    {
        $dataForm  = $request->all();

        $dataForm['password'] = Hash::make($dataForm['password']);
        $dataForm['atendimento'] = (!isset($dataForm['atendimento'])?0:$dataForm['atendimento']);
        $dataForm['unidade_id'] = Auth::user()->unidade_id;
        $insert = $this->user->create($dataForm);
        if($insert->assignRole( $dataForm['role'] )){
            return redirect()->route($this->params['main_route'].'.index');
        }else{
            return redirect()->route($this->params['main_route'].'.create')->withErrors(['Falha ao fazer Inserir.']);
        }
    }

    public function show($id,Role $roles)
    {
        $this->params['subtitulo']='Deletar Usuário';
        $this->params['arvore']=[
           [
               'url' => 'admin/user',
               'titulo' => 'Usuário'
           ],
           [
               'url' => '',
               'titulo' => 'Deletar'
           ]];
        $params = $this->params;

        $data = $this->user->select(DB::raw('users.*, r.id as role'))
                    ->join('role_user as ru', 'ru.user_id','users.id')
                    ->join('roles as r', 'r.id','ru.role_id')
                    ->where('users.id',$id)
                    ->get()
                    ->first();
        $preload['roles'] = $roles->select('name','id')->get()->pluck('name','id');
        return view('admin.user.show',compact('params','data','preload'));
    }

    public function edit($id,Role $roles)
    {
        $this->params['subtitulo']='Editar Usuário';
        $this->params['arvore']=[
           [
               'url' => 'admin/user',
               'titulo' => 'Usuário'
           ],
           [
               'url' => '',
               'titulo' => 'Cadastrar'
           ]];
       $params = $this->params;


       $data = $this->user->select(DB::raw('users.*, r.id as role'))
                            ->join('role_user as ru', 'ru.user_id','users.id')
                            ->join('roles as r', 'r.id','ru.role_id')
                            ->where('users.id',$id)
                            ->get()
                            ->first();
       $preload['roles'] = $roles->select('name','id')->get()->pluck('name','id');

       return view('admin.user.create',compact('params', 'data','preload'));
    }

    public function update(UserEditarRequest $request, $id)
    {
        $data = $this->user->find($id);

        $dataForm  = $request->all();

        if($data->update($dataForm)){
            $data->revokeAllRoles();
            $data->assignRole( $dataForm['role'] );
            return redirect()->route($this->params['main_route'].'.index');
        }else{
            return redirect()->route($this->params['main_route'].'.create')->withErrors(['Falha ao editar.']);
        }
    }

    public function destroy($id)
    {
        $data = $this->user->find($id);

        if($data->delete()){
            return redirect()->route($this->params['main_route'].'.index');
        }else{
            return redirect()->route($this->params['main_route'].'.create')->withErrors(['Falha ao deletar.']);
        }
    }
}
