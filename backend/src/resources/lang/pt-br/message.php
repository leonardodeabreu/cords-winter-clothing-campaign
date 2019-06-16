<?php

return [
    'response' => [
        'fail'         => [
            'authenticate'      => [
                'credentials'   => 'Usuário ou senha estão incorretos.',
                'inactive_user' => 'Usuário inativo! Contate o administrador do sistema.',
                'login'         => 'Falha ao fazer o login, por favor, tente novamente.',
                'logout'        => 'Falha ao fazer o logout, por favor, tente novamente.',
                'refresh_token' => 'Falha ao atualizar o token, por favor, tente novamente.',
            ],
            'register'          => 'Falha ao cadastrar, por favor, tente novamente.',
            'register_player'   => 'Falha ao cadastrar o usuário, rfid existente.',
            'send_notification' => 'Falha ao enviar a notificação, tente novamente.',
            'fail_paginate'     => 'O request deve conter o índice paginate.',
            'has_relationship'  => 'O objeto possui relacionamento com :relationship',
            'upload'            => 'Falha ao fazer o upload, tente novamente.',
            'deletion_file'     => 'Falha ao excluir arquivo, tente novamente.',
            'email_service'     => 'Falha no serviço de e-mail.',
        ],
        'success'      => [
            'protocol'          => [
                'finished' => 'Atendimento Finalizado com sucesso!',
            ],
            'update'            => 'Atualizado com sucesso.',
            'logged_out'        => 'Você efetuou o logout com sucesso.',
            'send_notification' => 'Notificação enviada com sucesso.',
        ],
        'not_found'    => [
            'resource_not_found' => 'Recurso não encontrado.',
        ],
        'bad_request'  => 'Requisição inválida.',
        'unauthorized' => [
            'delete_user_logged' => 'Não é possível remover o usuário logado.',
            'is_not_allowed'     => 'Você precisa de permissão para executar esta ação.',
        ],
    ],
];
