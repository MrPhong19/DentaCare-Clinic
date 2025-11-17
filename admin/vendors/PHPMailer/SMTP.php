<?php
namespace PHPMailer\PHPMailer;

class SMTP
{
    private $conn;
    private $timeout = 30;

    public function connect($host, $port) {
        $this->conn = fsockopen($host, $port, $errno, $errstr, $this->timeout);
        if (!$this->conn) return false;
        $this->getReply(); return true;
    }
    public function hello($host) { return $this->cmd('EHLO ' . $host, 250); }
    public function startTLS() { $this->cmd('STARTTLS', 220); return stream_socket_enable_crypto($this->conn, true, STREAM_CRYPTO_METHOD_TLS_CLIENT); }
    public function authenticate($u, $p) {
        $this->cmd('AUTH LOGIN', 334);
        $this->cmd(base64_encode($u), 334);
        $this->cmd(base64_encode($p), 235);
        return true;
    }
    public function mailFrom($from)  { return $this->cmd("MAIL FROM:<$from>", 250); }
    public function recipient($to)   { return $this->cmd("RCPT TO:<$to>", [250,251]); }
    public function data($data)      { $this->cmd('DATA', 354); fputs($this->conn, $data . "\r\n."); return $this->cmd('.', 250); }
    public function quit()           { $this->cmd('QUIT', 221); fclose($this->conn); }

    private function cmd($cmd, $expect) {
        if ($cmd !== '.') fputs($this->conn, $cmd . "\r\n");
        $reply = $this->getReply();
        $code = substr($reply, 0, 3);
        if (!in_array($code, (array)$expect)) return false;
        return true;
    }
    private function getReply() {
        $data = ''; while ($str = fgets($this->conn, 512)) { $data .= $str; if (substr($str, 3, 1) === ' ') break; }
        return $data;
    }
}