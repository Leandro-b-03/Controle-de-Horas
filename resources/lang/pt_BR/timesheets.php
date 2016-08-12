<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Timesheets Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used all library to build
    | the simple page files. You are free to change them to anything
    | you want to customize your views to better match your application.
    |
    */

    // Labels
    'error-lunch'                   => 'Voc&ecirc; ainda n&atilde;o completou 1 hora de almo&ccedil;o!',
    'error-responsible'             => 'O nome do respons&aacute;vel deve ter de 3 a 80 caract&eacute;res',
    'error-phone'                   => 'O telefone deve ter o formato (11) 11111-111 ou (11) 11111-1111',
    'error-email'                   => 'E-mail inv&aacute;lido',

    // Controller
    'create-new'                    => 'Criar novo ',
    'edit-new'                      => 'Editar novo ',
    'view-new'                      => 'Visualizar os ',
    'delete-new'                    => 'Deletar o(s) ',

    // View sentences
    'list'                          => 'lista de tarefas',
    'create'                        => 'criar cliente',
    'edit'                          => 'editar cliente',
    'new'                           => '<i class="fa fa-plus"></i> Novo cliente',
    'delete'                        => '<i class="fa fa-remove"></i> Deletar cliente(s)',
    'no-task'                       => 'Selecione uma tarefa',
    'lunch'                         => 'Ainda não há horário de almoço',
    'lunch-time'                    => 'Horário de saida: :start. Horario da volta: :end. Tempo total: :hours.',

    // Table
    'title-day'                     => 'Dia',
    'title-date'                    => 'Data',
    'title-holiday'                 => 'Feriado',
    'title-project'                 => 'Projeto',
    'title-start'                   => 'Iniciado',
    'title-end'                     => 'Terminado',
    'title-task'                    => 'Tarefa',
    'title-lunch'                   => 'Almo&ccedil;o',
    'title-nightly'                 => 'Noturno',
    'title-total_hours'             => 'Total de horas mínima a ser cumprida:',
    'title-total_work_month'        => 'Total de horas trabalhadas mês:',
    'title-total_credit'            => 'Total de horas crédito mês:',
    'title-total_debit'             => 'Total de horas débito mês:',
    'title-total_loitered'          => 'Total de horas ocioso mês:',
    'title-total_credit_debit'      => 'Total de horas crédito/débito:',

    // Words-Compost Words
    'day'                           => 'Dia',
    'lunch_start'                   => 'Almo&ccedil;o',
    'lunch_end'                     => 'Almo&ccedil;o',
    'start'                         => 'Iniciar',
    'end'                           => 'Fechar dia',
    'nightly_end'                   => 'Fechar extra',
    'finish'                        => 'Terminar',
    'pause'                         => 'Pausar',
    'fail'                          => 'Falha',
    'ok'                            => 'OK',
    'nok'                           => 'NOK',
    'impacted'                      => 'Impactado',
    'cancelled'                     => 'Cancelado',
    'task'                          => 'Tarefas',
    'monthly'                       => 'Mensal',
    'actual_month'                  => 'Mês atual',
    'started'                       => 'Inicio',
    'ended'                         => 'Término',
    'lunch_started'                 => 'Almoço inicio',
    'lunch_ended'                   => 'Almoço término',
    'lunch_total'                   => 'Total almoço',
    'total_day'                     => 'Total dia',
    'hours_to_achieve'              => 'Horas dia',
    'hours_credit'                  => 'Crédito de horas',
    'hours_debit'                   => 'Débito de horas',
    'add-row'                       => 'Adicionar linha',

    // Labels
    'label-start'                   => 'Entrada',
    'label-lunch_start'             => 'Almo&ccedil;o ida',
    'label-lunch_end'               => 'Almo&ccedil;o volta',
    'label-end'                     => 'Sa&iacute;da',

    // Tasks
    'tasks-start'                   => 'O colaborador :name começou uma nova atividade.',
    'tasks-done_1'                  => 'O colaborador :name terminou uma nova atividade.',
    'tasks-done_2'                  => 'O colaborador :name terminou uma nova atividade com :ok OK, :nok NOK, :impacted Impactados e :cancelled Cancelados.',

    // Messages
    'message-request'               => 'Por favor somente indique o campo que deseja a atera&ccedil;&atilde;o (Exemplo: deseja alterar a sa&iacute;da apenas coloque a hora desjada naquele campo).',
    'message-send_request'          => 'O(A) :name, solicitou a troca do hor&aacute;rio.<br />
                                        <table class="table table-responsive table-hover table-border table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <td>Entrada</td>
                                                    <td>Almo&ccedil;o ida</td>
                                                    <td>Almo&ccedil;o volta</td>
                                                    <td>Sa&iacute;da</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>:start</td>
                                                    <td>:lunch_start</td>
                                                    <td>:lunch_end</td>
                                                    <td>:end</td>
                                                </tr>
                                            </tbody>
                                        </table>',

    // Buttons
    'btn-request'                   => 'Requisitar'
];