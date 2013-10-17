<?php defined('BASEPATH') OR exit('No direct script access allowed');

#section settings
$lang['settings:site_name'] 					= 'Nome do site';
$lang['settings:site_name_desc'] 				= 'O nome do website para títulos de páginas e para usar por todo o site.';

$lang['settings:site_slogan'] 					= 'Slogan do site';
$lang['settings:site_slogan_desc'] 				= 'O slogan do website para títulos de páginas e para usar por todo o site.';

$lang['settings:site_lang']						= 'Idioma do site';
$lang['settings:site_lang_desc']				= 'O idioma nativo do website, usado para escolher modelos de e-mail para notificações internas e recebimento de contato dos visitantes além de outras funcionalidades que não devem se flexionar ao idioma de um usuário.';

$lang['settings:contact_email'] 				= 'E-mail de contato';
$lang['settings:contact_email_desc'] 			= 'Todos os e-mails de usuários, visitantes e do site devem ir para este endereço.';

$lang['settings:server_email'] 					= 'Servidor de e-mail';
$lang['settings:server_email_desc'] 			= 'Todos e-mails para usuários devem ir para este endereço de e-mail.';

$lang['settings:meta_topic']					= 'Meta tema';
$lang['settings:meta_topic_desc']				= 'Duas ou três palavras descrevendo o tipo de empresa/website.';

$lang['settings:currency'] 						= 'Moeda';
$lang['settings:currency_desc'] 				= 'O símbolo monetário para usar em produtos, serviços, etc.';

$lang['settings:dashboard_rss'] 				= 'RSS Feed do Dashboard';
$lang['settings:dashboard_rss_desc'] 			= 'Link para um feed RSS que deve ser mostrado no dashboard.';

$lang['settings:dashboard_rss_count'] 			= 'Itens RSS do Dashboard';
$lang['settings:dashboard_rss_count_desc'] 		= 'Quantos itens RSS devem ser mostrados no dashboard?';

$lang['settings:date_format'] 					= 'Formato de data';
$lang['settings:date_format_desc'] 				= 'Como devem ser exibidas as datas em todo o site e painel de controle? ' .
													'Utilize o <a href="http://php.net/manual/en/function.date.php" target="_black">formato de data</a> PHP - OU - ' .
													'Utilize o formato de <a href="http://php.net/manual/en/function.strftime.php" target="_black">strings formatadas como data</a> do PHP.';

$lang['settings:frontend_enabled'] 				= 'Situação do site';
$lang['settings:frontend_enabled_desc'] 		= 'Use esta opção para definir se a frente do site ficará visível ou não. Últil quando houver a necessidade de desligar o site para manutenção.';

$lang['settings:mail_protocol'] 				= 'Protocolo de e-mail';
$lang['settings:mail_protocol_desc'] 			= 'Selecione o protocolo de e-mail desejado.';

$lang['settings:mail_sendmail_path'] 			= 'Caminho do Sendmail';
$lang['settings:mail_sendmail_path_desc']		= 'Caminho para o sendmail.';

$lang['settings:mail_smtp_host'] 				= 'Host do SMTP';
$lang['settings:mail_smtp_host_desc'] 			= 'O nome do host do seu servidor SMTP.';

$lang['settings:mail_smtp_pass'] 				= 'Senha do SMTP';
$lang['settings:mail_smtp_pass_desc'] 			= 'A senha do SMTP.';

$lang['settings:mail_smtp_port'] 				= 'Porta do SMTP';
$lang['settings:mail_smtp_port_desc'] 			= 'O número da porta do SMTP.';

$lang['settings:mail_smtp_user'] 				= 'Usuário do SMTP';
$lang['settings:mail_smtp_user_desc'] 			= 'O nome de usuário do SMTP.';

$lang['settings:unavailable_message']			= 'Mensagem de indisponibilidade';
$lang['settings:unavailable_message_desc'] 		= 'Quando o site for desligado ou houver um problema maior, esta mensagem deverá aparecer para os usuários.';

$lang['settings:default_theme'] 				= 'Tema padrão';
$lang['settings:default_theme_desc'] 			= 'Selecione o tema que você quer que os usuários vejam por padrão.';

$lang['settings:activation_email'] 				= 'E-mail de ativação';
$lang['settings:activation_email_desc'] 		= 'Enviar um e-mail com link de ativação quando o usuário se cadastrar. Desative isto para que apenas administradores ativem as contas.';

$lang['settings:records_per_page'] 				= 'Registros por página';
$lang['settings:records_per_page_desc'] 		= 'Quantos registros nos devemos mostrar por página na secão administrativa?';

$lang['settings:rss_feed_items'] 				= 'Quantidade de itens do Feed';
$lang['settings:rss_feed_items_desc'] 			= 'Quantos itens nos devemos mostrar nos feeds de RSS/novidades?';

$lang['settings:require_lastname'] 				= 'Sobrenomes obrigatórios?';
$lang['settings:require_lastname_desc'] 		= 'Em algumas situações, um sobrenome pode não ser necessário. Você deseja forçar os usuários a digita-lo ou não?';

$lang['settings:enable_profiles'] 				= 'Ativar perfis';
$lang['settings:enable_profiles_desc'] 			= 'Permitir que usuários adicionem e editem perfis.';

$lang['settings:ga_email'] 						= 'E-mail do Google Analytic';
$lang['settings:ga_email_desc']					= 'E-mail utilizado para o Google Analytics, é necessário para mostrar o gráfico no dashboard.';

$lang['settings:ga_password'] 					= 'Senha do Google Analytic';
$lang['settings:ga_password_desc']				= 'Senha do Google Analytics. Isso também é necessária para mostrar o gráfico no dashboard.';

$lang['settings:ga_profile'] 					= 'Perfil do Google Analytic';
$lang['settings:ga_profile_desc']				= 'ID do Perfil para este site no Google Analytics.';

$lang['settings:ga_tracking'] 					= 'Cód. de acompanhamento Google';
$lang['settings:ga_tracking_desc']				= 'Digite seu código de acompanhamento do Google Analytics para ativar a captura de dados do Google Analytics. Ex.: UA-19483569-6';

$lang['settings:twitter_username'] 				= 'Nome de usuário';
$lang['settings:twitter_username_desc'] 		= 'Nome de usuário do Twitter.';

$lang['settings:twitter_feed_count'] 			= 'Contador do Feed';
$lang['settings:twitter_feed_count_desc'] 		= 'Quantos tweets devem ser retornados para o bloco de feed do Twitter?';

$lang['settings:twitter_cache'] 				= 'Tempo de cache';
$lang['settings:twitter_cache_desc'] 			= 'Quantos minutos seus Tweets devem ser armazenados temporariamente?';

$lang['settings:akismet_api_key'] 				= 'Chave da API do Akismet';
$lang['settings:akismet_api_key_desc'] 			= 'Akismet é um bloqueador de spam da equipe WordPress. Isto mantém spam sobre controle sem forçar que usuários façam a confirmação humana de CAPTCHA nos formulários.';

$lang['settings:comment_order'] 				= 'Ordenar comentários';
$lang['settings:comment_order_desc']			= 'A ordem de classificação no qual exibir comentários.';

$lang['settings:enable_comments'] 				= 'Permitir comentários';
$lang['settings:enable_comments_desc']			= 'Permite a escrita de comentários';

$lang['settings:moderate_comments'] 			= 'Moderar comentários';
$lang['settings:moderate_comments_desc']		= 'Forçar comentários a serem aprovados antes que apareçan no site.';

$lang['settings:version'] 						= 'Versão';
$lang['settings:version_desc'] 					= '';

$lang['settings:ckeditor_config']               = 'Configurações CKEditor';
$lang['settings:ckeditor_config_desc']          = 'Você pode encontrar uma lista válida de itens de configuração na <a target="_blank" href="http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.config.html">documentação CKEditor.</a>'; 

$lang['settings:enable_registration']           = 'Habilitar registro de usuário'; 
$lang['settings:enable_registration_desc']      = 'Habilita o registro de usuário através do website.'; 

$lang['settings:profile_visibility']            = 'Visibilidade do Perfil'; 
$lang['settings:profile_visibility_desc']       = 'Especifica quem pode ver o perfil de usuário no site público'; 

$lang['settings:cdn_domain']                    = 'Domínio CDN';
$lang['settings:cdn_domain_desc']               = 'Domínios CDN permitem descarregar conteúdo estático para vários servidores de borda, como a Amazon CloudFront ou MaxCDN.'; 

#section titles
$lang['settings:section_general']			= 'Geral';
$lang['settings:section_integration']			= 'Integração';
$lang['settings:section_files']                         = 'Arquivos';
$lang['settings:section_email']                         = 'E-mail';
$lang['settings:section_cpanel']			= 'cPanel';
$lang['settings:section_forums']			= 'Fórum';
$lang['settings:section_store']                         = 'Loja Virtual';
$lang['settings:section_support']			= 'Suporte';
$lang['settings:section_comments']			= 'Comentários';
$lang['settings:section_users']				= 'Usuários';
$lang['settings:section_statistics']			= 'Estatísticas';
$lang['settings:section_twitter']			= 'Twitter';

#checkbox and radio options
$lang['settings:form_option_English']				= 'Inglês';
$lang['settings:form_option_Yes']				= 'Sim';
$lang['settings:form_option_No']				= 'Não';
$lang['settings:form_option_Open']				= 'Aberto';
$lang['settings:form_option_Closed']			= 'Fechado';
$lang['settings:form_option_Enabled']			= 'Ativo';
$lang['settings:form_option_Disabled']			= 'Desativado';
$lang['settings:form_option_Required']			= 'Obrigatório';
$lang['settings:form_option_Optional']			= 'Opcional';
$lang['settings:form_option_Oldest First']		= 'Antigos primeiro';
$lang['settings:form_option_Newest First']		= 'Novos primeiro';
$lang['settings:form_option_profile_public']	= 'Visível para todos'; 
$lang['settings:form_option_profile_owner']		= 'Visíveis apenas para o proprietário do perfil';
$lang['settings:form_option_profile_hidden']	= 'Nunca visível'; 
$lang['settings:form_option_profile_member']	= 'Visíveis para qualquer usuário conectado'; 
$lang['settings:form_option_activate_by_default']      = 'Ative após o registrar'; 
$lang['settings:form_option_activate_by_email']        	= 'Ative por e-mail'; 
$lang['settings:form_option_activate_by_admin']        	= 'Ative por admin'; 
$lang['settings:form_option_no_activation']         	= 'Nenhuma activação'; 

// titles
$lang['settings:edit_title']					= 'Editar configurações';

// messages
$lang['settings:no_settings']					= 'Atualmente não existem definições.'; 
$lang['settings:save_success']					= 'Suas configurações foram salvas!';

// custom general
$lang['settings:site_public_lang'] = 'Idiomas Públicos'; 
$lang['settings:site_public_lang_desc'] = 'Quais são os idiomas que realmente serão suportados e oferecidos no front-end do seu site?'; 

$lang['settings:admin_force_https'] = 'Forçar HTTPS no Painel de Controle?'; 
$lang['settings:admin_force_https_desc'] = 'Permitir somente o protocolo HTTPS, enquanto estiver usando o Painel de Controle?'; 

// custom files
$lang['settings:files_enabled_providers'] = 'Habilitar provedores de armazenamento de arquivo em nuvem'; 
$lang['settings:files_enabled_providers_desc'] = 'Que os provedores de armazenamento de arquivos que você quer permitir? (Se você permitir que um provedor de nuvem você deve fornecer as chaves de autenticação válidos abaixo'; 

$lang['settings:files_s3_access_key'] = 'Chave de Acesso Amazon S3'; 
$lang['settings:files_s3_access_key_desc'] = 'Para permitir o armazenamento de arquivos em nuvem na sua conta Amazon S3 você deve fornecer sua chave de acesso. <a href="https://aws-portal.amazon.com/gp/aws/securityCredentials#access_credentials" target="_blank">Encontre as suas credenciais</a>.'; 

$lang['settings:files_s3_secret_key'] = 'Chave Secreta Amazon S3'; 
$lang['settings:files_s3_secret_key_desc'] = 'Você também deve fornecer o sua chave secreta Amazon S3. Você vai encontrá-lo no mesmo local que a sua chave de acesso em sua conta na Amazon.'; 

$lang['settings:files_s3_url'] = 'URL Amazon S3'; 
$lang['settings:files_s3_url_desc'] = 'Altere isto se você está usando um dos locais da Amazon dos EUA ou de um domínio personalizado.'; 

$lang['settings:files_s3_geographic_location'] = 'Localização Geográfica Amazon S3'; 
$lang['settings:files_s3_geographic_location_desc'] = 'EUA ou Europa. Se você mudar isso, você também deve alterar a URL Amazon S3.'; 

$lang['settings:files_cf_username'] = 'Usuário Rackspace Cloud Files'; 
$lang['settings:files_cf_username_desc'] = 'Para permitir o armazenamento de arquivos em nuvem no Rackspace Cloud Files digite seu nome de usuário. <a href="https://manage.rackspacecloud.com/APIAccess.do" target="_blank">Encontre as suas credenciais</a>'; 

$lang['settings:files_cf_api_key'] = 'Chave API Rackspace Cloud Files'; 
$lang['settings:files_cf_api_key_desc'] = 'Você também deve fornecer sua chave API do Rackspace. Você vai encontrá-lo no mesmo local que seu usuário em sua conta Rackspace.'; 

$lang['settings:files_upload_limit'] = 'Tamanho máximo de arquivos'; 
$lang['settings:files_upload_limit_desc'] = 'Tamanho máximo habilitado para o upload de arquivos. Especifique o tamanho em MB. Ex. 5'; 

$lang['settings:files_cache'] = 'Cache de Arquivos'; 
$lang['settings:files_cache_desc'] = 'Na saída de uma imagem via site.com/files, quanto tempo devemos definir a expiração do cache?'; 
$lang['settings:form_option_no-cache'] = 'Sem cache';
$lang['settings:form_option_1-minute'] = '1 minuto';
$lang['settings:form_option_1-hour'] = '1 hora';
$lang['settings:form_option_3-hour'] = '3 horas';
$lang['settings:form_option_8-hour'] = '8 horas';
$lang['settings:form_option_1-day'] = '1 dia';
$lang['settings:form_option_30-days'] = '30 dias';

//custom comments
$lang['settings:comment_markdown'] = 'Permitir Markdown'; 
$lang['settings:comment_markdown_desc'] = 'Você deseja permitir que os visitantes postarem comentários usando Markdown?'; 
$lang['settings:form_option_Text Only'] = 'Somente Texto';
$lang['settings:form_option_Allow Markdown'] = 'Permitir Markdown';

//custom users
$lang['settings:registered_email'] = 'E-mail Utilizador Registado'; 
$lang['settings:registered_email_desc'] = 'Envie um e-mail de notificação para o e-mail de contacto quando alguém se registra no site.'; 

$lang['settings:auto_username'] = 'Criar Usuário Automático?'; 
$lang['settings:auto_username_desc'] = 'Crie o nome de usuário automaticamente, ou seja, os usuários podem pular esta etapa do registo.'; 

$lang['settings:enable_recaptcha'] = 'Habilitar o uso do reCAPTCHA no registro de usuários?'; 
$lang['settings:enable_recaptcha_desc'] = 'Especifique se você deseja utilizar o uso do reCAPTCHA durante o registro de usuários. Os detalhes do reCAPTCHA na guia Geral serão necessários.'; 

$lang['settings:enable_maskedinputplugin_admin'] = 'Utilizar o Masked Input Plugin no Painel de Controle?'; 
$lang['settings:enable_maskedinputplugin_admin_desc'] = 'Habilita o uso de máscaras nos campos do perfil do usuário no painel de controle.'; 

$lang['settings:enable_maskedinputplugin_user'] = 'Utilizar o Masked Input Plugin no Perfil e Registro de Usuário?'; 
$lang['settings:enable_maskedinputplugin_user_desc'] = 'Habilita o uso de máscaras nos campos do perfil do usuário e no registro.'; 

$lang['settings:users_maskedinputplugin_code'] = 'Código do Masked Input Plugin'; 
$lang['settings:users_maskedinputplugin_code_desc'] = 'Especifique o código jquery do masked input plugin. Encontre mais informações na <a href="http://digitalbush.com/projects/masked-input-plugin/" target="_blank">documentação Masked Input Plugin</a>.'; 

//custom general
$lang['settings:recaptcha_public_key'] = 'reCAPTCHA Public Key'; 
$lang['settings:recaptcha_public_key_desc'] = 'Informe sua Public Key reCAPTCHA para enviar informações via formulários com segurança em seu site. Você encontrará estas informações em sua conta <a href="http://www.google.com/recaptcha" target="_blank">reCAPTCHA</a>.'; 

$lang['settings:recaptcha_private_key'] = 'reCAPTCHA Private Key'; 
$lang['settings:recaptcha_private_key_desc'] = 'Informe sua Private Key reCAPTCHA para enviar informações via formulários com segurança em seu site. Você encontrará estas informações em sua conta <a href="http://www.google.com/recaptcha" target="_blank">reCAPTCHA</a>.'; 

//custom blog

$lang['settings:blog_intro_limit'] = 'Limite da introdução do blog'; 
$lang['settings:blog_intro_limit_desc'] = 'Limite padrão de introdução ajudante para a lista de posts.'; 

$lang['settings:blog_use_intro_limit'] = 'Usar limite de palavras no blog?'; 
$lang['settings:blog_use_intro_limit_desc'] = 'A introdução será limitada como texto e terá um limite de palavras, definido posteriormente.'; 

$lang['settings:blog_intro_delimiter'] = 'Delimitador da introdução de postagens'; 
$lang['settings:blog_intro_delimiter_desc'] = 'Adiciona um delimitador ao final do texto da introdução do blog. Ex: ... ou [...]'; 

// custom metrostore

$lang['settings:store_currency_code'] = 'Moeda da loja'; 
$lang['settings:store_currency_code_desc'] = 'Moeda dos produtos da loja. (formato ISO-4217, ex. BRL)'; 

$lang['settings:store_tax_value'] = 'Valor da taxa (%)'; 
$lang['settings:store_tax_value_desc'] = 'Valor percentual de imposto em seu país.'; 

$lang['settings:store_products_limit'] = 'Produtos por página'; 
$lang['settings:store_products_limit_desc'] = 'Quantos produtos devemos exibir por página(0 - configurações gerais de paginação será utilizado)'; 

$lang['settings:store_images_folder'] = 'Pasta de imagem dos produtos'; 
$lang['settings:store_images_folder_desc'] = 'Selecione a pasta onde será salva as imagens dos produtos.'; 

$lang['settings:store_images_width'] = 'Largura máxima das imagens ao fazer upload'; 
$lang['settings:store_images_width_desc'] = 'Digite a largura máxima para redimensionar as imagens ao fazer upload. Mantenha 0 para não redimensionar ao fazer upload.'; 

$lang['settings:store_images_height'] = 'Altura máxima das imagens ao fazer upload'; 
$lang['settings:store_images_height_desc'] = 'Digite a altura máxima para redimensionar as imagens ao fazer upload. Mantenha 0 para não redimensionar ao fazer upload.'; 

$lang['settings:store_images_ratio'] = 'Respeitar proporções da imagem ao redimensioná-las?'; 
$lang['settings:store_images_ratio_desc'] = 'Selecione se você deseja manter as proporções das imagens ao redimensioná-las. Marque Sim para manter as proporções ao redimensionarou Não para forçar o redimensionamento.'; 

$lang['settings:store_login_required'] = 'Exigir login para usar a loja'; 
$lang['settings:store_login_required_desc'] = 'Uma conta de usuário é necessário para acessar, armazenar e usar o carrinho?'; 

$lang['settings:store_ssl_required'] = 'Habilitar o uso SSL no pagamento'; 
$lang['settings:store_ssl_required_desc'] = 'Necessário para processar o pedido e pagamento através de SSL'; 

/*

$lang['settings:form_option_'] = '';
$lang['settings:'] = ''; 

*/