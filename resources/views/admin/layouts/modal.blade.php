<div class="modal fade" id="{{ $preload['id'] }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">{{$preload['title']}}</h4>
        </div>
        <div class="modal-body">
            @yield('conteudo')
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Sair</button>
            <button type="button" class="btn btn-primary">Salvar</button>
        </div>
        </div>
    </div>
</div>
