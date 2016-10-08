<?php
class Response {

    public $status;
    public $data;

    function __construct($data, $status = 200) {
        $this->data = (array) $data;
        $this->status = $status;
    }

}
