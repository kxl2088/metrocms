<?php defined('BASEPATH') OR exit('No direct script access allowed');

// Upper left anchors
$lang['log.posts_title']        = 'Logs Registrados no Banco';
$lang['log.physical_title']     = 'Arquivos de Log Físicos';
$lang['log.quick_select_title'] = 'Seleção rápida';

// Upper right anchors
$lang['log.sync_logs']     = 'Sincronizar arquivos de logs';
$lang['log.truncate_logs'] = 'Esvaziar todos os logs do banco';

// Notifications
$lang['log.finished_scrolling']         = 'Rolagem terminou';
$lang['log.sync_success']               = 'Seus aquivos de log foram sincronizados com sucesso.';
$lang['log.download_success']           = 'Seus arquivos de log foram baixados com sucesso.';
$lang['log.resync_success']             = 'Ressincronizados com sucesso "%s"';
$lang['log.resync_success_multiple']    = 'Ressincronizados com sucesso o seguinte arquivo de log(s): <strong>%s</strong>';
$lang['log.resync_error']               = 'Algo deu errado ao tentar sincronizar novamente "%s"';
$lang['log.resync_not_exists']          = 'Não há nenhum arquivo de log com ID <strong>%s</strong> na base de dados';
$lang['log.resync_not_exists_multiple'] = 'Há/existem arquivos de log encontrados com o ID seguinte: <strong>%s</strong>';
$lang['log.resync_too_large']           = 'O arquivo de log "%s" obtido parece ser muito grande para armazenamento';
$lang['log.resync_too_large_multiple']  = 'O arquivo de log seguinte obtido parecem ser muito grande para armazenamento: <strong>%s</strong>';
$lang['log.delete_success']             = 'O registro do banco de dados "%s" foi apagado.';
$lang['log.delete_all_success']         = 'A tabela do banco de dados foi limpo de todos os logs.';
$lang['log.mass_delete_success']        = 'O banco de dados "%s" foi excluído.';
$lang['log.delete_error']               = 'Não há registros de banco de dados que foram apagados.';
$lang['log.currently_no_logs']          = 'Não existem registos de base de dados no momento.';
$lang['log.no_logs']                    = 'Não há arquivos de log em seu diretório.';
$lang['log.edit_log_title']             = 'Arquivo de log de <strong>%s</strong> ("%s")';
$lang['log.sync_too_big_notices']       = 'Os registros a seguir, eram grandes demais para sincronizar: %s.';
$lang['log.delete_physical_seccess']    = 'Apagou o arquivo com sucesso do diretório de log.';
$lang['log.select_log_files_error']     = '<p>Por favor seleccione <strong>um ou mais</strong> arquivos de log primeiro antes de executar uma ação.</p><p>Clique para fechar esta mensagem.</p>';
$lang['log.physical_info']              = 'Arquivos grandes têm um ponto de exclamação não pode ser adicionado ao banco de dados. Arquivos já armazenados no banco de dados serão sincronizados. Por favor, seja paciente enquanto estiver em (re)sincronização ou apagando arquivos de log!';
$lang['log.no_logs_selected']           = '<p><strong>Nenhum arquivo de log</strong> foi selecionado. Nenhuma ação pode ser tomada sem ter os arquivos selecionados.</p><p>Clique para fechar esta mensagem.</p>';

// Log file anchors
$lang['log.scroll_to_bottom']      = 'Rolar para baixo';
$lang['log.scroll_to_top']         = 'Rolar para cima';
$lang['log.first_occurence_label'] = 'Primeira ocorrência';
$lang['log.last_occurence_label']  = 'Última ocorrência';

// Labels
$lang['log.actions_label']                            = 'Ações';
$lang['log.error_header_label']                       = 'Cabeçalho de erro';
$lang['log.number_of_occurences_label']               = 'Número de ocorrências';
$lang['log.resync_label']                             = 'Resincronizar';
$lang['log.size_label']                               = 'Tamanho';
$lang['log.date_label']                               = 'Data';
$lang['log.error_label']                              = 'Erro';
$lang['log.header_label']                             = 'Cabeçalho';
$lang['log.date_synced_label']                        = 'Data da sincronia';
$lang['log.sync_label']                               = 'Resincronizar';
$lang['log.invalid-query_label']                      = 'Consultas inválidas';
$lang['log.other_label']                              = 'Outros erros';
$lang['log.page-missing_label']                       = 'Páginas em falta';
$lang['log.query-error_label']                        = 'Erros de consulta';
$lang['log.severity-warning_label']                   = 'Advertências de gravidade';
$lang['log.severity-notice_label']                    = 'Avisos de gravidade';
$lang['log.unable-to-load-the-requested-class_label'] = 'Não foi possível carregar a classe solicitada';
$lang['log.unable-to-select-database_label']          = 'Não foi possível selecionar de banco de dados';
$lang['log.download_physical']                        = 'Baixar para o seu computador';
$lang['log.delete_physical']                          = 'Excluir arquivos de log físico';
$lang['log.edited_on_label']                          = 'Editado em';
$lang['log.size_label']                               = 'Tamanho';
$lang['log.empty_log_directory']                      = ' (vazio)';
$lang['log.toggle_select']                            = 'Alterar Seleção';
$lang['log.non_synchronized']                         = 'Não sincronizada';
$lang['log.oversized']                                = 'Grande demais';
$lang['log.severity']                                = 'Gravidade';
$lang['log.total_counted_errors']                    = 'Total de erros encontrados';