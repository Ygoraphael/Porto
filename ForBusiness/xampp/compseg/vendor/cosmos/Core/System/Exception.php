<?php

namespace Cosmos\System;

class Exception {

    private $response;
    private $message;
    private $type;
    private $id;
    private $messageJson;

    function __construct(bool $response, string $message, int $type = null, int $id = null) {
        $this->setResponse($response);
        $this->setMessage($message);
        $this->setType($type);
        $this->setId($id);
        self::setMessageJson();
        self::setMessageSession();
    }

    public function setMessageJson() {
        $this->messageJson = json_encode(['response' => $this->response, 'type' => $this->type, 'message' => $this->message, 'id' => $this->id]);
    }

    public function setMessageSession() {
        $_SESSION['response'] = $this->response;
        $_SESSION['message'] = $this->message;
        $_SESSION['type'] = $this->type;
        $_SESSION['id'] = $this->id;
        session_unset();
    }

    /**
     * @return boolean
     */
    public function isResponse(): bool {
        return $this->response;
    }

    /**
     * @return string
     */
    public function getMessage(): string {
        return $this->message;
    }

    /**
     * @return int
     */
    public function getType(): int {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param boolean $response
     */
    public function setResponse(bool $response) {
        $this->response = $response;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message) {
        $this->message = $message;
    }

    /**
     * @param int $type
     */
    public function setType(int $type = null) {
        $this->type = $type;
    }

    /**
     * @param int $id
     */
    public function setId(int $id = null) {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getMessageJson(): string {
        return $this->messageJson;
    }

}
