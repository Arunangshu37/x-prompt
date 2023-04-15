<?php
define('NOT_FOUND_ERROR', 404);
define('NOT_FOUND_MESSAGE', 'Data request is not found');

define('CONFLICT_ERROR', 409);
define('CONFLICT_MESSAGE', 'There is a problem while handling the request.');

define('SERVER_ERROR', 500);
define('SERVER_ERROR_MESSAGE', 'There is an internal problem that has occured at the backend. Please be patient.');

define('UNAUTHORIZED_ACCESS_ERROR', 401);
define('UNAUTHORIZED_ACCESS_ERROR_MESSAGE', 'Provided information is insufficient to grant access to the resource requested.');

define('FORBIDDEN_ERROR', 403);
define('FORBIDDEN_ERROR_MESSAGE', 'You are not allowed to access this resource unless authenticated');


?>