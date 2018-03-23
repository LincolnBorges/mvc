<?php

namespace Core;

class Error
{

    /**
     * Converte todos os erros em Exceptions usando o ErrorException.
     *
     * @param int $level  Nivel do erro
     * @param string $message  Mensagem de erro
     * @param string $file  Arquivo que ocorreu o erro
     * @param int $line  Linha do arquivo
     *
     * @return void
     */
    public static function errorHandler($level, $message, $file, $line)
    {
        if (error_reporting() !== 0) {  // to keep the @ operator working
            throw new \ErrorException($message, 0, $level, $file, $line);
        }
    }

    /**
     * Exception customizada.
     *
     * @param Exception $exception  The exception
     *
     * @return void
     */
    public static function exceptionHandler($exception)
    {
        // Erro 404 ou 500
        $code = $exception->getCode();
        if ($code != 404) {
            $code = 500;
        }
        http_response_code($code);
        if (\App\Config::SHOW_ERRORS) {
            echo "<h1>Erro Fatal</h1>";
            echo "<p>Exceção: '" . get_class($exception) . "'</p>";
            echo "<p>Mensagem: '" . $exception->getMessage() . "'</p>";
            echo "<p>Ratreio:<pre>" . $exception->getTraceAsString() . "</pre></p>";
            echo "<p>Arquivo '" . $exception->getFile() . "' na linha " . $exception->getLine() . "</p>";
        } else {
            $log = dirname(__DIR__) . '/logs/' . date('Y-m-d') . '.txt';
            ini_set('error_log', $log);

            $message = "Exceção: '" . get_class($exception) . "'";
            $message .= " Mensagem '" . $exception->getMessage() . "'";
            $message .= "\nRatreio: " . $exception->getTraceAsString();
            $message .= "\nArquivo '" . $exception->getFile() . "' na linha " . $exception->getLine();

            error_log($message);
            View::render("$code.html");
        }
    }
}
