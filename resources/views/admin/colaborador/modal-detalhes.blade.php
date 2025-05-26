<div class="modal fade" id="modalDetalhes" tabindex="-1" role="dialog" aria-labelledby="modalDetalhesLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDetalhesLabel">Detalhes do Colaborador</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="start_date">Data Início</label>
                        <input type="date" class="form-control" id="start_date">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="end_date">Data Fim</label>
                        <input type="date" class="form-control" id="end_date">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-1"></div>
                    <button id="btnBuscarServicos" class="btn btn-primary mb-3 col-md-4">Detalhar</button>
                    <div class="col-md-2"></div>
                    <button id="btnAdicionarServicoColaborador" class="btn btn-success mb-3 col-md-4">Adicionar Serviço</button>
                    <div class="col-md-1"></div>
                </div>
                <div class="mb-3">
                    <strong>Total de Peças:</strong> <span id="totalPecas">0</span>
                    <br>
                    <strong>Total a Receber:</strong> <span id="totalReceber">R$ 0,00</span>
                </div>



                <table id="servicosTable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Serviço</th>
                            <th>Quantidade</th>
                            <th>Valor Uni.</th>
                            <th>Valor Total</th>
                            <th>Data de Produção</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Dados carregados dinamicamente -->
                    </tbody>
                </table>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
