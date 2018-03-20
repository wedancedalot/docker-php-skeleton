<?php
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Processor\IntrospectionProcessor;

# Register DB
$di->setShared('db', function () use ($config) {
    $connection = new \Phalcon\Db\Adapter\Pdo\Mysql([
//        'port'     => 3306,
        'host'     => 'db',
        'dbname'   => getenv('DB_NAME'),
        'username' => getenv('DB_USER'),
        'password' => getenv('DB_PASSWORD'),
    ]);

    return $connection;
});

// $di->setShared('querybuilder', function () use ($config) {
//     $conn = new \Pixie\Connection('mysql', [
//         'host'      => 'db',
//         'database'  => getenv('DB_NAME'),
//         'username'  => getenv('DB_USER'),
//         'password'  => getenv('DB_PASSWORD'),
//         'charset'   => 'utf8',
//         'collation' => 'utf8_unicode_ci',
//         'options'   => [
//             PDO::ATTR_EMULATE_PREPARES  => false,
//         ]
//     ]);

//     return $conn->getQueryBuilder();
// });

# Logger
$di->setShared('logger', function () use ($config, $di) {
    $format = new Monolog\Formatter\LineFormatter("[%datetime%] %level_name%: %message% %context%\n");

    $stdout = new StreamHandler('php://stdout', Logger::DEBUG);
    $stdout->setFormatter($format);

    $stream = new StreamHandler(ini_get('error_log'), Logger::DEBUG); // use Logger::WARNING for production
    $stream->setFormatter($format);

    $log = new Logger(__FUNCTION__);
    $log->pushProcessor(new IntrospectionProcessor());
    $log->pushHandler($stdout);
    $log->pushHandler($stream);

    return $log;
});

$di->setShared('crypt', function () use ($config) {
    $crypt = new \Phalcon\Crypt();
    $crypt->setMode(MCRYPT_MODE_CFB);

    return $crypt;
});

# Session
$di->setShared('session', function () use ($config) {
    $params = [];

    if (!empty($config->project->sess_prefix)) {
        $params['uniqueId'] = $config->project->sess_prefix;
    }

    $session = new \Phalcon\Session\Adapter\Files($params);
    $session->start();

    return $session;
});

# Cookies
$di->setShared('cookies', function () {
    $cookies = new \Phalcon\Http\Response\Cookies();
    $cookies->useEncryption(false);

    return $cookies;
});

# Config
$di->setShared('config', $config);