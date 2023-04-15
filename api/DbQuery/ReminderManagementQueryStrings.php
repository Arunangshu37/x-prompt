<?php
define('CREATE_REMINDER_QUERY', '
    INSERT INTO `reminders`
        (`userId`, `title`, `description`, `isActive`, `createdAt`, `forDateTime`)
    VALUES
        (?,?,?,?,?,?);
');
define('GET_ALL_ACTIVE_REMINDERS_QUERY', '
    SELECT 
        `id`,
        `userId`,
        `title`,
        `description`,
        `isActive`,
        `createdAt`,
        `forDateTime`
    FROM 
        `reminders`
    WHERE 
        `userId` = ? 
');
?>