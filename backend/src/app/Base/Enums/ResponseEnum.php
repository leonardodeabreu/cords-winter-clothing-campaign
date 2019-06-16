<?php

namespace App\Base\Enums;

abstract class ResponseEnum
{
    const UPDATED_SUCCESSFULLY = 'message.response.success.update';
    const FAILED_CREDENTIALS = 'message.response.fail.authenticate.credentials';
    const FAILED_LOGIN = 'message.response.fail.authenticate.login';
    const FAILED_LOGOUT = 'message.response.fail.authenticate.logout';
    const FAILED_REFRESH_TOKEN = 'message.response.fail.authenticate.refresh_token';
    const FAILED_REGISTER = 'message.response.fail.register';
    const FAILED_REGISTER_PLAYER = 'message.response.fail.register_player';
    const SUCCESSFULLY_LOGGED_OUT = 'message.response.success.logged_out';
    const RESOURCE_NOT_FOUND = 'message.response.not_found.resource_not_found';
    const PAGINATE_MUST_APPEAR = 'message.response.fail.fail_paginate';
    const BAD_REQUEST = 'message.response.bad_request';
    const FAILED_HAS_RELATIONSHIP = 'message.response.fail.has_relationship';
    const FAILED_UPLOAD = 'message.response.fail.upload';
    const FAILED_FILE_DELETION = 'message.response.fail.deletion_file';
    const IS_NOT_ALLOWED = 'message.response.unauthorized.is_not_allowed';
}
