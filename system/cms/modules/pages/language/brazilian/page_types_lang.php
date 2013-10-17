<?php defined('BASEPATH') or exit('No direct script access allowed');

// tabs
$lang['page_types:html_label']                 = 'HTML';
$lang['page_types:css_label']                  = 'CSS';
$lang['page_types:basic_info']                 = 'Informações Básicas'; 

// labels
$lang['page_types:updated_label']              = 'Atualizado';
$lang['page_types:layout']                     = 'Layout'; 
$lang['page_types:auto_create_stream']         = 'Criar Novo Dado Stream'; 
$lang['page_types:select_stream']              = 'Dado Stream'; 
$lang['page_types:theme_layout_label']         = 'Tema de layout';
$lang['page_types:save_as_files']              = 'Salvar como Arquivo'; 
$lang['page_types:content_label']              = 'Nome da Guia de Conteúdo'; 
$lang['page_types:title_label']                = 'Título'; 
$lang['page_types:sync_files']                 = 'Sincronizar Arquivos'; 

// titles
$lang['page_types:list_title']                 = 'Listar páginas de layout';
$lang['page_types:list_title_sing']            = 'Tipo de Página'; 
$lang['page_types:create_title']               = 'Adicionar página de layout';
$lang['page_types:edit_title']                 = 'Editar a página de layout "%s"';

// messages
$lang['page_types:no_pages']                   = 'Nenhuma página de layout.';
$lang['page_types:create_success_add_fields']  = 'Você criou um novo tipo de página, agora adicione os campos que você deseja sua ter na sua página.'; 
$lang['page_types:create_success']             = 'A página de layout foi criada.';
$lang['page_types:success_add_tag']            = 'O campo página foi adicionado. Contudo, antes de seus dados ser emitidos você deve inserir sua marca para o Tipo de Layout de Página'; 
$lang['page_types:create_error']               = 'A página de layout não foi criada.';
$lang['page_types:page_type.not_found_error']  = 'A página de layout não existe.';
$lang['page_types:edit_success']               = 'A página de layout "%s" foi salva.';
$lang['page_types:delete_home_error']          = 'Você não pode remover a página de layout padrão.';
$lang['page_types:delete_success']             = 'A página de layout #%s foi removida.';
$lang['page_types:mass_delete_success']        = '%s páginas de layout foram removidas.';
$lang['page_types:delete_none_notice']         = 'Nenhuma página de layout removida.';
$lang['page_types:already_exist_error']        = 'Uma tabela com esse nome já existe. Por favor, escolha um nome diferente para este tipo de página.'; 
$lang['page_types:_check_pt_slug_msg']         = 'Sua slug de tipo de página deve ser exclusivo.';

$lang['page_types:variable_introduction']      = 'Esta caixa de texto possui duas variáveis disponíveis';
$lang['page_types:variable_title']             = 'Contém o título da página.';
$lang['page_types:variable_body']              = 'Contém o corpo HTML da página.';
$lang['page_types:sync_notice']                = 'Apenas capaz de sincronizar %s do sistema de arquivos.'; 
$lang['page_types:sync_success']               = 'Arquivos sincronizados com sucesso.'; 
$lang['page_types:sync_fail']                  = 'Não é possível sincronizar seus arquivos.'; 

// Instructions
$lang['page_types:stream_instructions']        = 'Este fluxo manterá os campos personalizados para o seu tipo de página. Você pode escolher um novo fluxo, ou um será criado para você.'; 
$lang['page_types:saf_instructions']           = 'Marcar esta opção irá salvar o seu arquivo de layout de página, bem como qualquer CSS personalizado e JS como arquivos simples em sua pasta assets/page_types.'; 
$lang['page_types:content_label_instructions'] = 'Isso muda o nome do guia que mantém a sua página campos de tipos de fluxos.'; 
$lang['page_types:title_label_instructions']   = 'Isso renomeia o campo de título da página de "Título". Isso é útil se você estiver usando o "Título" como qualquer outra coisa, como "Nome do produto" ou "Nome do membro da equipe".'; 

// Misc
$lang['page_types:delete_message']             = 'Tem certeza de que deseja excluir este tipo de página? Isto irá apagar <strong>%s</strong> páginas usando este esquema, filhos página destas páginas, e todas as entradas de fluxo associados a estas páginas. <strong>Isso não pode ser desfeito.</strong> '; 

$lang['page_types:delete_streams_message']     = 'Isso também irá excluir o <strong>%s stream</strong> associada a este tipo de página.'; 