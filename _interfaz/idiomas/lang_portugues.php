<?php
/**************************************************************************************
*             CATALOGO DE PRODUCTOS - PROYECTO CATALOGO DONETBUSINESS V1.0            *
***************************************************************************************
* Archivo: config.php                                                           *
* Descripcion: Configuración de todas la variables del sistema.                       *
***************************************************************************************
*                                                                                     *
*    AUTOR    : LEONARDO FORERO                        a8888b.                        *
*    EMAIL    : leofor@hotmail.com                    d888888b.                       *
*    WEBSITE  : www.micrositios.net                   8P"YP"Y88                       *
*    COPY     : Julio 10 - 2002                       8|o||o|88                       *
*                                                     8'    .88                       *
*      MICROSITIOS LTDA.                              8`._.' Y8.                      *
*      CLL 98 N 14-17 OF.305                         d/      `8b.                     *
*      BOGOTA, COLOMBIA                            .dP   .     Y8b.                   *
*      Tels.(571)6183770 (571)6183396             d8:'   "   `::88b.                  *
*                                                d8"           `Y88b                  *
*                                               :8P     '       :888                  *
*                                                8a.    :      _a88P                  *
*                                              ._/"Yaa_ :    .| 88P|                  *
*                                              \    YP"      `| 8P  `.                *
*                                              /     \._____.d|    .'                 *
*                                              `--..__)888888P`._.'                   *
*                                                                                     *
******************************************************************leofor@hotmail.com***/
// Modifique UNICAMENTE la informacion entre parentesis DESPUES de la coma
// NO modifique la palabra en mayúsculas

// Archivo restriccion.php
define("_R_IDIOMA", 'portuguese');
define("_ROT_PAGINA_INEXISTENTE" ,"A página que você deseja visualizar possivelmente está desativada<br>Entre em contato com o administrador do site");
define("_ROT_MENSAJE_RESTRICCION","Página restringida nível");
define("_ROT_PAGINA_RESTRINGIDA" ,sprintf(str_replace("  "," ","<ul>
        <li>Para utilizar os serviços do nosso portal, você deve criar a sua própria conta <a href=index.php?idcategoria=%s><span class=tpl_titulo_mensaje_error><strong>aqui</strong></span></a>
        <li><strong>Username</strong> e <strong>senha</strong> será enviada automaticamente para o seu e-mail.
        </ul>"),_SREGISTRO));

// Idioma principal del documento
define("_ROT_LANG", "pt");

// Archivo funciones.php
define("_ROT_SUBMENU"    ,"");
define("_ROT_SUBMENU_LINEA","");
define("_ROT_SUBMENU_MARCA","");
define("_ROT_SUBMENU_PUBLICACIONES","<strong>HOME</strong>");
define("_ROT_VER_MAS","Ler Notícia");
define("_ROT_BOLETIN_TXT_1","Digite seu e-mail para receber a nossa newsletter.");

define("_ROT_ENCUESTA1"   ,"Escolha uma opção e vote!");
define("_ROT_ENCUESTA2"   ,"Os resultados da votação");
define("_ROT_ENCUESTA3"   ,"Número total de votos");
define("_ROT_REDIRECCION","Você foi automaticamente redirecionado para outra seção do site");
define("_ROT_DOWNLOAD"   ,"Clique no link para abrir o arquivo.<br>Para salvar em seu disco rígido clique<br>Com o botão direito e escolha<br> \"Salvar destino como ...\"<br>");
define("_ROT_CADUCIDAD"  ,"Apesar de esta informação não seja considerado válido, ainda está no arquivo do site");

define("_ROT_ADMIN_DOCUMENTOS"     ,"Document Manager");
// Archivo contacto.php
define("_ROT_ADVERTENCIA"          ,"ADVERTÊNCIA");
define("_ROT_ERROR"                ,"ERRO");
define("_ROT_CONFIRMACION"         ,"CONFIRMAÇÃO");
define("_ROT_CONTACTO_NOMBRE"      ,"Nome Completo:");
define("_ROT_CONTACTO_NOMBRE_ERROR","Nome desaparecidas");
define("_ROT_CONTACTO_EMAIL"      ,"e-mail:");
define("_ROT_CONTACTO_EMAIL_ERROR1","Desaparecidas e-mail");
define("_ROT_CONTACTO_EMAIL_ERROR2","A sintaxe do e-mail está incorreto");
define("_ROT_CONTACTO_EMPRESA"      ,"Actividade / Escritório / Profissão:");
define("_ROT_CONTACTO_EMPRESA_ERROR","Os ativos");
define("_ROT_CONTACTO_CARGO"      ,"Posição:");
define("_ROT_CONTACTO_CARGO_ERROR","Faltando posição (job)");
define("_ROT_CONTACTO_DIRECCION"      ,"Cidade / País:");
define("_ROT_CONTACTO_DIRECCION_ERROR","Faltando Endereço");
define("_ROT_CONTACTO_TELEFONOS"      ,"Telefone:");
define("_ROT_CONTACTO_TELEFONOS_ERROR","Faltando telefone");
define("_ROT_CONTACTO_COMENTA"      ,"Comentários:");
define("_ROT_CONTACTO_COMENTA_ERROR","Faltando comentários");
define("_ROT_CONTACTO",              "<ul><li>Estamos interessados em seus comentários, sugestões e perguntas.
                                     <li>O <span id=\"fieldRequired\">destacadas</span> campos são obrigatórios.</ul>");
define("_ROT_CONTACTO_ADVERTENCIA","NÃO enviar o formulário!<br>Confira as informações");
define("_ROT_CONTACTO_REQUERIDO","(Necessário)");

define("_ROT_CONTACTO_ENVIO_CONFIRMA"   ,"A mensagem foi enviada <strong>%s</strong>, muito obrigado por seu interesse");
define("_ROT_CONTACTO_ENVIO_ERROR","A mensagem não pôde ser enviado aos <strong>%s</strong>,<br>Tente novamente mais tarde ou usar o seu cliente habitual e-mail");

// Archivo certificado.php

define("_ROT_CERTIFICADO_NOMBRE"      ,"Nome Completo:");
define("_ROT_CERTIFICADO_NOMBRE_ERROR","Nome desaparecidas");
define("_ROT_CERTIFICADO_EMAIL"      ,"e-mail:");
define("_ROT_CERTIFICADO_EMAIL_ERROR1","Desaparecidas e-mail");
define("_ROT_CERTIFICADO_EMAIL_ERROR2","A sintaxe do e-mail está incorreto");
define("_ROT_CERTIFICADO_FECHA"      ,"Application Data:");
define("_ROT_CERTIFICADO_FECHA_ERROR","Missing Data");
define("_ROT_CERTIFICADO_CEDULA"      ,"Cartão ou Código:");
define("_ROT_CERTIFICADO_CEDULA_ERROR","Faltando Card ou código");
define("_ROT_CERTIFICADO_TIPO"      ,"Tipo de Pedido:");
define("_ROT_CERTIFICADO_TIPO_ERROR","Falta o tipo de pedido");
define("_ROT_CERTIFICADO_DESTINO"      ,"Destino Certificação:");
define("_ROT_CERTIFICADO_DESTINO_ERROR","Desaparecido o alvo Certificação");
define("_ROT_CERTIFICADO_APELLIDO"      ,"Nome Completo:");
define("_ROT_CERTIFICADO_APELLIDO_ERROR","Faltando Nome");
define("_ROT_CERTIFICADO_TELEFONOS"      ,"Recorrente Telefone:");
define("_ROT_CERTIFICADO_TELEFONOS_ERROR","Faltando telefone");
define("_ROT_CERTIFICADO_DIRECCION"      ,"Endereço:");
define("_ROT_CERTIFICADO_DIRECCION_ERROR","Faltando Endereço");
define("_ROT_CERTIFICADOS","<br>Preencha o formulário e prima Enviar");
define("_ROT_CERTIFICADO_ADVERTENCIA","Confira as informações");
define("_ROT_CERTIFICADO_REQUERIDO","(Necessário)");

// Archivo acreedores.php

define("_ROT_ACREEDORES"                     ,"CREDORES");
define("_ROT_ACREEDORES_TIPOIDENTIFICACION"  ,"Model ID:");
define("_ROT_ACREEDORES_IDENTIFICACION"      ,"ID:");
define("_ROT_ACREEDORES_IDENTIFICACION_ERROR","Identificação fracasso");
define("_ROT_ACREEDORES_CLAVE"               ,"Chave:");
define("_ROT_ACREEDORES_REQUERIDO"           ,"(Necessário)");


// Archivo registro_evento.php
define("_ROT_REGISTRO_FORMA_PAGO_ERROR"      ,"Você deve selecionar um método de pagamento");
define("_ROT_REGISTRO_YA_ESTA_REGISTRADO1"   ,"Você já está registrado para esse evento");
define("_ROT_REGISTRO_YA_ESTA_REGISTRADO2"   ,"Irá ser enviada uma conta de e-mail <strong>%s</strong> com instruções detalhadas para concluir o processo de registo");
define("_ROT_REGISTRO_YA_ESTA_REGISTRADO3"   ,"Se você quiser cancelar ou modificar sua inscrição para este evento por favor ligue para nós");
define("_ROT_REGISTRO_EVENTO_ADVERTENCIA1"   ,"Quando você pressiona o botão OK só pode modificar ou cancelar a sua inscrição por telefone");
define("_ROT_REGISTRO_EVENTO_ADVERTENCIA2"   ,"Depois de concluir sua inscrição, você receberá um e-mail de confirmação e detalhes do processo de registo");
define("_ROT_REGISTRO_EVENTO_ADVERTENCIA3"   ,"Esta operação está abrangida pelo decreto é válido como XXXX e dddd");
define("_ROT_INFO"                           ,"INFORMAÇÃO");


// Archivo registro.php

define("_ROT_REGISTRO","<ul><li>O registro permite que você obtenha mais informações sobre os nossos eventos
                            <li>O registo é <strong>LIVRE</strong>
                            <li>Seu nome de usuário ea senha será enviada para o e-mail fornecido
                            <li>O <span id=\"fieldRequired\">destacadas</span> campos são obrigatórios.</ul>");
define("_ROT_MICUENTA"                           ,"Esta é a sua informação pessoal, lembre-se de mudar sua senha periodicamente.<br>O <span id=\"fieldRequired\">destacadas</span> campos são obrigatórios.");
define("_ROT_MICUENTA_ACTUALIZACION"             ,"CONFIRMAÇÃO!");
define("_ROT_REGISTRO_USERNAME"                  ,"Nome de usuário:");
define("_ROT_REGISTRO_USERNAME_ERROR"            ,"Falta o nome de usuário");
define("_ROT_REGISTRO_NOMBRE"                    ,"Nome:");
define("_ROT_REGISTRO_NOMBRE_ERROR"              ,"Falta o nome");
define("_ROT_REGISTRO_PASSWORD_ACTUAL"           ,"Senha atual:");
define("_ROT_REGISTRO_PASSWORD1"                 ,"Senha:");
define("_ROT_REGISTRO_PASSWORD2"                 ,"Confirmar senha:");
define("_ROT_REGISTRO_PASSWORD_EXITO"            ,"Senha alterada com sucesso!");
define("_ROT_REGISTRO_PASSWORD_ERROR1"           ,"Faltando Senha");
define("_ROT_REGISTRO_PASSWORD_ERROR2"           ,"Falta de confirmação senha");
define("_ROT_REGISTRO_PASSWORD_ERROR3"           ,"A senha ea confirmação não coincidem");
define("_ROT_REGISTRO_PASSWORD_ERROR4"           ,"Não foi possível alterar a senha.");
define("_ROT_REGISTRO_PASSWORD_ERROR5"           ,"Não coincidir com a senha atual, por favor, verifique!");
define("_ROT_REGISTRO_APELLIDO"                  ,"Apelido:");
define("_ROT_REGISTRO_APELLIDO_ERROR"            ,"Falta Apelido");
define("_ROT_REGISTRO_EMAIL"                     ,"e-mail:");
define("_ROT_REGISTRO_EMAIL_ERROR1"              ,"Desaparecidas e-mail");
define("_ROT_REGISTRO_EMAIL_ERROR2"              ,"A sintaxe do e-mail está incorreto");
define("_ROT_REGISTRO_EMAIL_ERROR3"              ,"A sintaxe do e-mail de contacto para o pagamento é incorrecto");
define("_ROT_REGISTRO_EMPRESA"                   ,"Nome da Empresa (nome da empresa):");
define("_ROT_REGISTRO_EMPRESA_ERROR"             ,"A falta");
define("_ROT_REGISTRO_CIUDAD"                    ,"Cidade:");
define("_ROT_REGISTRO_CIUDAD_ERROR"              ,"Faltando Cidade");
define("_ROT_REGISTRO_PAIS"                      ,"País:");
define("_ROT_REGISTRO_PAIS_ERROR"                ,"Faltando país");
define("_ROT_REGISTRO_PROFESION"                 ,"Profissão:");
define("_ROT_REGISTRO_PROFESION_ERROR"           ,"Faltando ocupação");
define("_ROT_REGISTRO_TELEFONO"                  ,"Telefone:");
define("_ROT_REGISTRO_TELEFONO_EMPRESA"          ,"Telefones:<ul class=texto_mini><li>Você pode escrever mais, se desejar<li>Digite extensão<li>Não escreva indicativa</ul>");
define("_ROT_REGISTRO_FAX_EMPRESA"               ,"Fax:");
define("_ROT_REGISTRO_TELEFONO_ERROR"            ,"Faltando telefone");
define("_ROT_REGISTRO_DIRECCION"                 ,"Endereço:");
define("_ROT_REGISTRO_DIRECCION_ERROR"           ,"Ausência de gestão");
define("_ROT_REGISTRO_CARGO"                     ,"Posição:");
define("_ROT_REGISTRO_EVENTOS"                   ,"Assuntos sobre os quais você gostaria de receber mais informações:");
define("_ROT_REGISTRO_EMPRESA_NIT"               ,"Nit:");
define("_ROT_REGISTRO_EMPRESA_ACTIVIDAD"         ,"Actividade Económica:");

define("_ROT_REGISTRO_EMPRESA_MEDIO"             ,"Meios através dos quais ele tomou conhecimento de nossos eventos:");
define("_ROT_REGISTRO_EMPRESA_MEDIO_OTRO"        ,"Se você optou por outro, por favor, escreva o que foi:");

define("_ROT_REGISTRO_REQUERIDO"    ,"(Necessário)");
define("_ROT_REGISTRO_CORREO"       ,"Para receber informações de nós por e-mail?");
define("_ROT_REGISTRO_RED"          ,"Assinar a Rede de Mídia para a Paz");
define("_ROT_REGISTRO_ADVERTENCIA"  ,"Confira as informações");
define("_ROT_REGISTRO_ADVERTENCIA2"  ,"Sua informação não foi atualizada");
define("_ROT_REGISTRO_EXISTENTE"    ,"Já é um utilizador registado com esse e-mail. Por favor, use outro.");
define("_ROT_REGISTRO_EXISTENTE2"    ,"Já é um utilizador registado com esse nome de usuário. Por favor, use outro.");
define("_ROT_REGISTRO_EXITO"        ,"Suas informações foram atualizadas com êxito");

define("_ROT_REGISTRO_RECORDAR","<strong>¿Já está registado, mas se esqueceu seu nome de usuário ou senha?</strong><br>Digite o e-mail com que você se registrou.");

// Archivo buscar.php
define("_ROT_BUSCAR"            ,"Buscar");
define("_ROT_BUSCAR_TXT"            ,"A pesquisa é limitada<br>As informações contidas nesta página.");
define("_ROT_BUSCAR_PALABRA"    ,"Keyword");
define("_ROT_BUSCAR_RESULTADOS" ,"%s foram encontrados resultados relacionados <span style=\"color:green;\"><em>%s</em></span>");
define("_ROT_BUSCAR_ADVERTENCIA","Não foi possível fazer a pesquisa!<br>Confira as informações");
define("_ROT_BUSCAR_ADVERTENCIA_MENSAJE"      ,"A palavra para procurar deve ter três ou mais letras");


//Variable en MostrarCuentele
define("_ROT_CUEN_TIT","Conte a um amigo");
define("_ROT_CUEN_MEN1","E-mail:");
define("_ROT_CUEN_MEN2","E-mail de seu amigo:");
define("_ROT_CUEN_CUERPO","Envia o seguinte comentário:\n\n");
define("_ROT_CUEN_CUERPO1","Caro amigo:\nObrigado por recomendar.\nContinuar a convidar seus amigos para fazer parte deste projecto.\nAtenciosamente,\nVirtual Team Navegantes.");
define("_ROT_CUEN_CUERPO2","Marque esta página");
define("_ROT_CUEN_CUERPO3","Obrigado por recomendar");
define("_ROT_CUEN_CUERPO4","\nendereço de e-mail:");
define("_ROT_CUEN_NOTIFICACION","Aviso: Recomendação da página");
define("_ROT_CUEN_ENVIADO","Mensagem enviada.<br>Obrigado");
define("_ROT_RECOMENDAR_NOTICIA","Recomende esta notícia");

// Variables para Emisoras
define("_ROT_EMISORA_NOMBRE","Nome");
define("_ROT_EMISORA_RESUMEN","Descrição");
define("_ROT_EMISORA_IDENTIFICACION","Identificação");
define("_ROT_EMISORA_URL","Website");
define("_ROT_EMISORA_EMAIL","e-mail");

// Variables para Login
define("_ROT_LOGIN","Digite seu nome de usuário e senha");
define("_ROT_LOGIN_USUARIO"    ,"Nome de usuário:");
define("_ROT_LOGIN_PASSWORD"   ,"Senha:");

// Variables para Mapa
define("_ROT_MAPA_GENERAL"     ,"Geral");
define("_ROT_MAPA_DETALLADO"   ,"Detalhamento");
define("_ROT_MAPA_COMPLETO"    ,"Campos");

// Variables Edición
define("_ROT_EDICION"            ,"O <span id=\"fieldRequired\">destacadas</span> campos são obrigatórios.");
define("_ROT_EDICION_ERROR"      ,"Nome da categoria é requerido");
define("_ROT_EDICION_ANTETITULO" ,"Pré-título:");
define("_ROT_EDICION_NOMBRE"     ,"Nome:");
define("_ROT_EDICION_SUBTITULO"  ,"Subtítulo:");
define("_ROT_EDICION_RESUMEN" ,"Resumo:");
define("_ROT_EDICION_CONTENIDO"  ,"Conteúdo:");
define("_ROT_EDICION_AUTOR"      ,"Autor:");
define("_ROT_EDICION_IMAGEN"     ,"Imagem:");
define("_ROT_EDICION_ACTIVA"     ,"Ativa:");
define("_ROT_EDICION_ORDEN"      ,"Ordem:");
define("_ROT_EDICION_FECHA1"     ,"Data de criação / modificação:");
define("_ROT_EDICION_FECHA2"     ,"Home Data Máxima:");
define("_ROT_EDICION_FECHA3"     ,"Data 3:");
define("_ROT_EDICION_RESTRINGIDA","Restringir a todos os usuários exceto:");
define("_ROT_EDICION_TIPOSECCION","Principais Tipo:");
define("_ROT_EDICION_TIPOSECCION_SUB","Tipo Subcategorias:");
define("_ROT_EDICION_TEMPLATE"   ,"Modelo Gráficos:");
define("_ROT_EDICION_PLANTILLA"   ,"Modelo Gráficos:");
define("_ROT_EDICION_CRITERIO_ORDENA"   ,"Ordenação das subcategorias:");
define("_ROT_EDICION_TIPO_ORDENA"   ,"Tipo de organização das subcategorias:");
define("_ROT_EDICION_NUMERO_SUB"   ,"Número máximo de subcategorias por página:");
define("_ROT_EDICION_ESROOT"   ,"Home é:");
define("_ROT_EDICION_NUMERO_SUB_INFO"   ,"Deixe 0 herdar o valor");
define("_ROT_EDICION_ENBUSQUEDA"	,'Visível em Pesquisa:');
define("_ROT_EDICION_ENMAPA"	,'Visível no Mapa do Site:');
define("_ROT_EDICION_IDIOMA"	,'Língua Categoria:');
define("_ROT_EDICION_ESRSS"     ,"Es RSS:");
define("_ROT_INDEXAR"     ,"Indexar Archivo:");

define("_ROT_EDICION_VOLVER"   ,"Clique aqui para retornar ao modo normal");
define("_ROT_SUBMENU_EDICION"   ,"Subcategorias");

//Encuestas
define("_ROT_ENCUESTA"   ,"Pesquisa");
define("_ROT_ENCUESTA_RESULTADO"   ,"Resultados");
define("_ROT_ENCUESTA_VOTAR"   ,"Votar");

/**
 * FOROS
 **/
define("_ROT_FORO_RESPUESTA"	,"Você está respondendo a:");
define("_ROT_FORO_AUTOR"		,"Escrito por:");
define("_ROT_FORO_NOMBRE"       ,"Nome:");
define("_ROT_FORO_RESPONDER"	,"Responder");

/**
 * Variables Licitaciones
 **/
define("_ROT_LICITACION_OBJETO","Objeto");
define("_ROT_LICITACION_ESTADOS","Membros");
define("_ROT_LICITACION_CUANTIA","Valor");
define("_ROT_LICITACION_FECHA_APERTURA","Open Data");
define("_ROT_LICITACION_FECHA_CIERRE","Encerramento Data & Hora");
define("_ROT_LICITACION_ORDENADOR_GASTO","Computador Expense");
define("_ROT_LICITACION_UNIDADES_TACTICAS","Unidades Táticas");
define("_ROT_LICITACION_VINCULO","Related File");

/**
 * Campañas
 **/
define("_ROT_CONOZCAMAS","Saiba mais sobre a campanha");

/**
 * Quejas y Reclamos
 **/
define("_ROT_QUEJAS"            ,"Neste lugar você pode escrever as suas queixas, reclamações e denúncias,
 		   						  serão recebidas pela Inspecção-Geral do Corpo. <br><br>
			   					  Por favor, introduza as seguintes informações e pressione o botão Enviar.
								  (Os dados marcados com * são obrigatórios)<br><br>Esta página não está a receber estas mensagens e como um mediador, não tinha competência para agir, as pessoas que utilizam este serviço são responsáveis, perante a veracidade e exactidão das suas alegações, se falsas ou imprecisas relatórios, pode ser instaurado contra ele em processos criminais a ser trouxe a conta.
								  Quando as queixas ou reclamações cumprir os requisitos especificados na lei, para o exercício do direito de petição será tratada como tal nos termos da legislação aplicável ao direito.<br><br>O <span id=\"fieldRequired\">destacadas</span> campos são obrigatórios");
define("_ROT_QUEJAS_NOMBRE", "Nombre(s)");
define("_ROT_QUEJAS_NOMBRE_ERROR", "Nome está vazio.");
define("_ROT_QUEJAS_APELLIDO", "Sobrenome");
define("_ROT_QUEJAS_APELLIDO_ERROR", "Último nome está vazio.");
define("_ROT_QUEJAS_IDENTIFICACION", "Identificação");
define("_ROT_QUEJAS_IDENTIFICACION_ERROR", "A identificação pode ser apenas caracteres numéricos.");
define("_ROT_QUEJAS_DIRECCION", "Endereço");
define("_ROT_QUEJAS_TELEFONO", "Telefone");
define("_ROT_QUEJAS_CORREO", "Email");
define("_ROT_QUEJAS_CORREO_ERROR1", "E-mail está vazio.");
define("_ROT_QUEJAS_CORREO_ERROR2", "De e-mail inválido. ");
define("_ROT_QUEJAS_PAIS", "País");
define("_ROT_QUEJAS_CIUDAD", "Cidade");
define("_ROT_QUEJAS_LABEL", "Denúncia ou queixa");
define("_ROT_QUEJAS_LABEL_ERROR", "Você deve digitar uma queixa ou reclamação.");

define("_ROT_QUEJAS_ENVIO_CONFIRMA", "Denúncia enviada com sucesso.");
define("_ROT_QUEJAS_ENVIO_ERROR", "Houve um erro no envio da denúncia, por favor, tente novamente mais tarde.");

/**
 * VISITA
 **/
define("_ROT_VISITA"            ,"En este lugar usted puede solicitar los servicios de la Banda Sinfónica, esta solicitud sera recibida por la Dirección de la Escuela Militar de Aviación.
								 <br>O <span id=\"fieldRequired\">destacadas</span> campos são obrigatórios");

define("_ROT_VISITA_NOMBRE_INSTITUCION", "Nombre Institución");
define("_ROT_VISITA_NOMBRE_INSTITUCION_ERROR", "Nombre de la instituion se encuentra vacio.");

define("_ROT_VISITA_NOMBRE", "Nombre Solicitante");
define("_ROT_VISITA_NOMBRE_ERROR", "Nombre se encuentra vacio.");
define("_ROT_VISITA_APELLIDO", "Apellidos Solicitante");
define("_ROT_VISITA_APELLIDO_ERROR", "Apellido se encuentra vacio.");
define("_ROT_VISITA_IDENTIFICACION", "Identificación");
define("_ROT_VISITA_IDENTIFICACION_ERROR", "La identificación solo puede tener caracteres numéricos.");
define("_ROT_VISITA_DIRECCION", "Dirección");
define("_ROT_VISITA_TELEFONO", "Teléfono");
define("_ROT_VISITA_CORREO", "Correo Electrónico");
define("_ROT_VISITA_CORREO_ERROR1", "Correo se encuentra vacio.");
define("_ROT_VISITA_CORREO_ERROR2", "Correo no válido. ");

define("_ROT_VISITA_NOMBRE_EVENTO", "Nombre del Evento");
define("_ROT_VISITA_NOMBRE_EVENTO_ERROR", "Nombre del Evento se encuentra vacio.");

define("_ROT_VISITA_FECHA_EVENTO", "Fecha del Evento");
define("_ROT_VISITA_FECHA_EVENTO_ERROR", "Fecha del Evento se encuentra vacio.");

define("_ROT_VISITA_HORA_EVENTO", "Hora del Evento");
define("_ROT_VISITA_HORA_EVENTO_ERROR", "Hora del Evento se encuentra vacio.");

define("_ROT_VISITA_PAIS", "País");
define("_ROT_VISITA_CIUDAD", "Ciudad");
define("_ROT_VISITA_LABEL", "Observaciones");
define("_ROT_VISITA_LABEL_ERROR", "Debe ingresar Observaciones.");

define("_ROT_VISITA_ENVIO_CONFIRMA", "Queja enviada exitosamente.");
define("_ROT_VISITA_ENVIO_ERROR", "Hubo un error en el envio de la queja, por favor intente mas tarde.");

/**
 * Suscripciones
 **/
define("_ROT_SUSCRIPCION_NOMBRE_ERROR", "Falta o Campo Nome");
define("_ROT_SUSCRIPCION_APELLIDO_ERROR", "Falta o campo Sobrenome");
define("_ROT_SUSCRIPCION_CC_ERROR", "Falta o campo de identificação, ou há caracteres inválidos");
define("_ROT_SUSCRIPCION_EMAIL_ERROR", "Falta o E-mail");
define("_ROT_SUSCRIPCION_EMAIL_ERROR2", "A direção de E-mail não é válida");
define("_ROT_SUSCRIPCION_TELEFONO_ERROR", "Falta o Telefone ou há caracteres inválidos");
define("_ROT_SUSCRIPCION_DIRECCION_ERROR", "Falta o Endereço");
define("_ROT_SUSCRIPCION_CIUDAD_ERROR", "Falta a Cidade");
define("_ROT_SUSCRIPCION_FECHA_SUSCRIPCION_ERROR", "Falta a data na qual deseja se cadastrar");
define("_ROT_SUSCRIPCION_TIEMPO_SUSCRIPCION_ERROR", "Falta o tempo de seu cadastro");
define("_ROT_SUSCRIPCION_COMENTARIO_ERROR", "Falta o comentário");

define("_ROT_SUSCRIPCION_ENVIO_CONFIRMA", "Sua mensagem foi enviada corretamente");
define("_ROT_SUSCRIPCION_ENVIO_ERROR", "A mensagem não pôde ser enviada. Tente novamente mais tarde.");

/**
 * Servicios (Visitas)
 **/
define("_ROT_SERVICIO_NOMBRE_INSTITUCION_ERROR", "Falta o Campo 'Nome da Instituição'");
define("_ROT_SERVICIO_NOMBRE_SOLICITANTE_ERROR", "Falta o Campo 'Nome do Solicitante'");
define("_ROT_SERVICIO_APELLIDO_SOLICITANTE_ERROR", "Falta o Campo 'Sobrenome do Solicitante'");
define("_ROT_SERVICIO_DIRECCION_ERROR", "Falta o Campo 'Endereço'");
define("_ROT_SERVICIO_TELEFONO_ERROR", "Falta o Campo 'Telefone'. Insira somente números.");
define("_ROT_SERVICIO_CORREO_ERROR", "Falta o Campo 'E-mail'");
define("_ROT_SERVICIO_CORREO_ERROR2", "O endereço de e-mail não é válido");
define("_ROT_SERVICIO_PAIS_ERROR", "Falta o Campo 'País'");
define("_ROT_SERVICIO_CIUDAD_ERROR", "Falta o Campo 'Cidade'");
define("_ROT_SERVICIO_NOMBRE_EVENTO_ERROR", "Falta o Campo 'Nome do Evento'");
define("_ROT_SERVICIO_FECHA_EVENTO_ERROR", "Falta o Campo 'Data do Evento'");

/**
 * Formato de datetotext
 **/
define('FORMAT_DATETOTEXT', '%B %d, %Y');

/**
 * Rotulos de los Meses de las Fechas del Filtro Avanzado
 **/
define("_ROT_FILTRO_BUSCAR", "Pesquisar");
define("_ROT_FILTRO_FECHA", "Todas as datas");
define("_ROT_FILTRO_FECHA_ENERO", "Janeiro");
define("_ROT_FILTRO_FECHA_FEBRERO", "Fevereiro");
define("_ROT_FILTRO_FECHA_MARZO", "Março");
define("_ROT_FILTRO_FECHA_ABRIL", "Abril");
define("_ROT_FILTRO_FECHA_MAYO", "Maio");
define("_ROT_FILTRO_FECHA_JUNIO", "Junho");
define("_ROT_FILTRO_FECHA_JULIO", "Julho");
define("_ROT_FILTRO_FECHA_AGOSTO", "Agosto");
define("_ROT_FILTRO_FECHA_SEPTIEMBRE", "Setembro");
define("_ROT_FILTRO_FECHA_OCTUBRE", "Outubro");
define("_ROT_FILTRO_FECHA_NOVIEMBRE", "Novembro");
define("_ROT_FILTRO_FECHA_DICIEMBRE", "Dezembro");

// Cabezote
define("_ROT_GO_CONTENT","Ir para conteúdo");
define("_ROT_INICIO","Início");
define("_ROT_SEL_IDIOMAS","Seleccione Idioma");
define("_ROT_IDIOMAS", 'Idiomas');
define("_ROT_DESCARGA","Este site utiliza o Macromedia Flash para apresentar alguns conteúdos. Você pode baixar o plugin");
define("_ROT_AQUI","Aqui");
define("_ROT_HORA_LEGAL", "Hora Legal Colombiana");
define("_ROT_NOSCRIPT", "Seu navegador não suporta JavaScript!");
define("_ROT_NAV_TOOLS", "Ferramentas barra de navegação");
define("_ROT_SKIP_TOOLS", "Saltar barra de navegação");
define("_ROT_END_TOOLS", "Fim navegação barra ferramentas");

define("_ROT_IMAGENES", "Imagens");
define("_ROT_VIDEO", "Vídeo");
define("_ROT_AUDIO", "Áudio");


// Laterales
define("_ROT_MENU_INST","Menu<span> Institucional</span>");
define("_ROT_MENU_INSTITUCIONAL","Menu Principal");
define("_ROT_NAV_INST","Institucional navegação");
define("_ROT_SKIP_INST","Passar à navegação Institucional");
define("_ROT_END_OF","Assim");
define("_ROT_END_MENU_INST","Fim do Menu Institucional");
define("_ROT_GO_TO","Ir para");
define("_ROT_AMPLIAR_NOTA","Ampliar nota");


define("_ROT_RECOMENDADOS","Recomendado Secções");
define("_ROT_NAV_RECOMENDADOS","Barra de navegação secções recomendada");
define("_ROT_SKIP_RECOMENDADOS","Skip navigation bar secções recomendada");
define("_ROT_END_RECOMENDADOS","Fim navegação barra secções recomendada");
define("_ROT_ENLACES","Links Institucionais");
define("_ROT_INCORPORACIONES","Adições");
define("_ROT_VIDEOS","Vídeos");
define("_ROT_PREGUNTAS","FAQ");
define("_ROT_CATEGORIA_DESTACADA","Categoria");

// Menu usuario
define("_ROT_MENU_USER","Menu Utilizador");
define("_ROT_NAV_USER", "User menu");
define("_ROT_SKIP_USER", "Saltar el men&uacute; de navegaci&oacute;n del usuario");
define("_ROT_END_MENU_USER", "End User Menu");
define("_ROT_ADMIN", "Administraci&oacute;n");
define("_ROT_VER_PAGINA", "Ver p&aacute;gina");
define("_ROT_EDITAR_PAGINA", "Editar esta p&aacute;gina");
define("_ROT_MI_PORTAL", "Mi portal");
define("_ROT_TERMINAR_SESION", "Terminar Sesi&oacute;n");

// Nube
define("_ROT_TAG_CLOUD", "Tag Cloud");
define("_ROT_RELATED_TAGS", "Most Viewed");
define("_ROT_NAV_CLOUD", "Barra de navegação do tag cloud");
define("_ROT_SKIP_CLOUD", "Saltar barra de navegação a tag cloud");
define("_ROT_END_CLOUD", "Fim da barra de navegação tag cloud");

// Migas
define("_ROT_BREAD_CRUMBS", "MIGAŠ");
define("_ROT_NAV_BREAD_CRUMBS", "Barra de navegação para MIGAŠ");
define("_ROT_BREAD_CRUMBS_HERE", "Você está aqui:");
define("_ROT_SKIP_BREAD_CRUMBS", "Passar para navegação barra MIGAŠ");
define("_ROT_END_BREAD_CRUMBS", "Fim barra de navegação para MIGAŠ");

// Home y Home Generico
define("_ROT_CONTENT","Conteúdo");
define("_ROT_AUTOR","Por");
define("_ROT_VERMAS_HOME","Mais informações");
define("_ROT_VERMAS","Veja mais");
define("_ROT_AMPLIAR","Ampliar");
define("_ROT_PUBLICADO","Publicado");
define("_ROT_ACTUALIZACION","Última Atualização");
define("_ROT_END_SECTION","Fim da seção");

// Pie
define("_ROT_DESTACADOS","Destaques");
define("_ROT_NAV_HIGHLIGHTS","Barra de navegação secções destacadas");
define("_ROT_SKIP_HIGHLIGHTS","Skip navigation bar secções destacadas");
define("_ROT_END_HIGHLIGHTS","Fim navegação barra secções destacadas");
define("_ROT_INSTITUCIONES","Instituições estatais");
define("_ROT_NAV_INSTITUCIONES","Barra de navegação das instituições do Estado");
define("_ROT_SKIP_INSTITUCIONES","Passar as instituições do Estado");
define("_ROT_END_INSTITUCIONES", "Fim das instituições estatais");
define("_ROT_INFO_COMPANY","Informação Entidade");
define("_ROT_DEVELOPED","Portal Desarrollado por");
define("_ROT_GOTO","Ir à página");
define("_ROT_LOGO","Logo de la empresa Micrositios Ltda.");


// Default
define("_ROT_IMAGEN","Ampliar Imagem");
define("_ROT_AMPLIAR_IMAGEN","Ver imagem no tamanho original");
define("_ROT_SUBCATEGORIAS","Links relacionados");
define("_ROT_UTILIDADES","Utilitários");
define("_ROT_INICIO_PAGINA","Vá para o topo desta página");
define("_ROT_IMPRIMIR","Ver em formato amigável da impressora");
define("_ROT_ENVIAR_AMIGO","Recomendar a um amigo esta seção");

// Lista en cuadros
define("_ROT_SUMMARY","Sínteses organizados em categorias com fotos");

// Galeria de imagenes
define("_ROT_VERIMAGEN","Ver Imagem");
define("_ROT_TITLE_IMAGEN","Ver imagem completa");
define("_ROT_INFORMACION","Informação");
define("_ROT_TITLE_INFORMACION","Ir para a categoria");

// Galeria de audio
define("_ROT_ESCUCHAR","Ouvir");

// Galeria de video
define("_ROT_VER_VIDEO","Ver Video");

// Paginacion
define("_ROT_PAGER","Pager");
define("_ROT_NAV_PAGER","Navigation Bar Pager");
define("_ROT_SKIP_PAGER", "Skip navigation bar Pager");
define("_ROT_END_PAGER", "Fim Pager Navigation Bar");
define("_ROT_PRIMERO","Primeiro");
define("_ROT_ANTERIOR","Anterior");
define("_ROT_SIGUIENTE","Próximo");
define("_ROT_ULTIMO","Último");

// Descarga
define("_ROT_DESCARGAR","Descargar");

// url con marco
define("_ROT_VOLVER","Volver");

// Calendario
define("_ROT_CALENDARIO_MESES","Selecione o mês para ver Eventos");
?>