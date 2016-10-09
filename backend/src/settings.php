<?php
$c = [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],
    ],
];

/**
 * @SWG\Definition(
 * 	    definition="Error",
 * 		required={"status", "message"},
 *		@SWG\Property(property="status", type="integer"),
 *		@SWG\Property(property="msg", type="string"),
 * 	 )
*/
$c['errorHandler'] = function ($c) {
    return function ($request, $response, $exception) use ($c) {
        $data = [
            'status' => $exception->getCode() == 0 ? 500:$exception->getCode(),
            'msg' => $exception->getMessage()
        ];
        return $c['response']->withStatus($data['status'])
                             ->withHeader('Content-Type', 'application/json')
                             ->write(json_encode($data));
    };
};

return $c;