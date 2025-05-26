<div class="modal fade" id="addServicoModal" tabindex="-1" role="dialog" aria-labelledby="addServicoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addServicoModalLabel">Adicionar Serviço</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formServico">
                    @csrf
                    <div class="form-group">
                        <label for="nome">Nome do Serviço</label>
                        <input type="text" class="form-control" id="nome" name="nome" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" id="btnSalvarServico">Salvar</button>
            </div>
        </div>
    </div>
</div>
