<?php defined('BASEPATH') OR exit('No direct script access allowed');

//message
$lang['streams:no_data'] = 'Não há itens a serem exibidos.'; 
$lang['streams:success'] = 'Ação executada com sucesso.'; 
$lang['streams:error'] = 'Ocorreu um erro ao executar a ação.'; 
$lang['streams:mass_delete_error'] 	= 'Ocorreu um erro ao tentar remover a aplicação aplicação API "%s".';
$lang['streams:mass_delete_success']	= '%s Aplicativos de %s foram removidos com exito.';
$lang['streams:no_select_error'] 		= 'Antes você precisa selecionar um aplicativo API para remover.';

//titles
$lang['streams:api'] = 'Aplicações API'; 
$lang['streams:create_api'] = 'Adicionar Aplicativo'; 
$lang['streams:edit_api'] = 'Editando Aplicativo: %s'; 
$lang['streams:api_list'] = 'Lista de Aplicativos'; 

//labels
$lang['streams:created_label'] = 'Criado em'; 
$lang['streams:updated_label'] = 'Alterado em'; 
$lang['streams:created_by_label'] = 'Criado por'; 
$lang['streams:application_label'] = 'Aplicação'; 
$lang['streams:contact_label'] = 'Contato'; 
$lang['streams:company_label'] = 'Empresa'; 
$lang['streams:nip_label'] = 'CNPJ'; 
$lang['streams:phone_label'] = 'Telefone'; 
$lang['streams:email_label'] = 'E-mail'; 
$lang['streams:token_label'] = 'Token'; 
$lang['streams:permissions_label'] = 'Permissões'; 
$lang['streams:enabled_label'] = 'Habilitado'; 
$lang['streams:expires_on_label'] = 'Expira em'; 

//tabs
$lang['streams:data_tab'] = 'Dados Básicos'; 
$lang['streams:permissions_tab'] = 'Permissões'; 
$lang['streams:client_tab'] = 'Proprietário'; 

//permissions
$lang['streams:permission_insert'] = 'Inserir'; 
$lang['streams:permission_update'] = 'Alterar'; 
$lang['streams:permission_delete'] = 'Excluir'; 
$lang['streams:permission_select'] = 'Consultar'; 

//descriptions
$lang['streams:permissions_desc'] = 'Selecione os fluxos e as permissões que deseja conceder para esta aplicação.'; 
$lang['streams:permission:stream_slug'] = 'Tabela de fluxo'; 
$lang['streams:permission:stream_namespace'] = 'Slug do Fluxo'; 
$lang['streams:permission:roles'] = 'Regras'; 
$lang['streams:expired'] = 'Expirado'; 

//message permission
$lang['streams:access_denied'] = 'Acesso negado!'; 
$lang['streams:access_denied_no_permissions'] = 'Acesso negado! Nível de permissão insuficiente'; 
$lang['streams:no_requests'] = 'Acesso negado! Nenhuma requisição foi localizada'; 
$lang['streams:no_api_selected'] = 'Acesso negado! Nenhuma aplicação API foi selecionada'; 
$lang['streams:no_token'] = 'Acesso Negado! Nenhuma chave aplicação API foi informada'; 
$lang['streams:invalid_token'] = 'Acesso Negado! Chave aplicação API inválida'; 
$lang['streams:token_expired'] = 'Acesso Negado! Chave aplicação API expirada'; 
$lang['streams:invalid_action'] = 'Acesso negado! Requisição inválida'; 
$lang['streams:access_successfully'] = 'Sucesso'; 
$lang['streams:invalid_query'] = 'Erro! Query inválida ou a consulta não obteve resultados'; 
$lang['streams:no_group_eliguibe'] = 'Nenhum grupo elegível foi encontrado.';