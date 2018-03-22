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
        echo "<h1>Erro Fatal</h1>";
        echo "<p>Exceção: '" . get_class($exception) . "'</p>";
        echo "<p>Mensagem: '" . $exception->getMessage() . "'</p>";
        echo "<p>Ratreio:<pre>" . $exception->getTraceAsString() . "</pre></p>";
        echo "<p>Arquivo '" . $exception->getFile() . "' na linha " .
             $exception->getLine() . "</p>";
    }
}
