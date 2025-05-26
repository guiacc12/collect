<div class="modal fade" id="modalAdicionarServicoColaborador" tabindex="-1" role="dialog"
        aria-labelledby="modalAdicionarServicoColaboradorLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAdicionarServicoColaboradorLabel">Adicionar Serviço ao Colaborador</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formAdicionarServicoColaborador">
                        @csrf
                        <div class="form-group">
                            <label for="servico_id">Serviço</label>
                            <select class="form-control" id="servico_id" name="servico_id" required>
                                <option value="">Selecione um serviço</option>
                                <!-- Serviços serão carregados dinamicamente via JavaScript -->
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="quantidade">Quantidade</label>
                            <input type="number" class="form-control" id="quantidade" name="quantidade" min="1"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="valor">Valor Unitário</label>
                            <input type="number" class="form-control" id="valor" name="valor" step="0.01"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="data_producao">Data de Produção</label>
                            <input type="date" class="form-control" id="data_producao" name="data_producao" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" id="btnSalvarServicoColaborador">Salvar</button>
                </div>
            </div>
        </div>
    </div>
