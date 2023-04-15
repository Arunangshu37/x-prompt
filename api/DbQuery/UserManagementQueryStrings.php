<?php
    define('GET_USER_BY_USERNAME_QUERY', '
        SELECT 
            `username`, 
            `passwordHash`,
            `name`,
            `roleId`,
            `id`
        FROM 
            `users`
        WHERE 
            `username` = ?
    ');

    define('CREATE_USER_QUERY', '
        INSERT INTO
            `users` (`username`, `passwordHash`, `name`)
        VALUES
            (?,?,?);
    ');
    define('ASSIGN_ROLE_QUERY', '
        UPDATE 
            `users`
        SET 
            `roleId` = ?
        WHERE 
            `id` = ?
    ');
    define('GET_USER_INFO_BY_ID', '
        SELECT 
            `username`,
            `name`
        FROM
            `users`
        WHERE 
            `id` = ?
    ');

?>