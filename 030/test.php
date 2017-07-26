<?php
function validate()
{
    if (!empty($_SERVER['PHP_AUTH_USER']) && !empty($_SERVER['PHP_AUTH_PW'])) {
        var_dump($_SERVER['PHP_AUTH_USER']);
        var_dump($_SERVER['PHP_AUTH_PW']);

        return true;
    }

    return false;
}

function login()
{
    http_response_code(401);
    header('WWW-Authenticate: Basic realm="My Website"');
    echo "You need to enter a valid username and password.";
    exit();
}

if (!validate()) {
    login();
}

echo '登录成功';
