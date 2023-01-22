<?php 

function getResponseTemplate($success = true, $messages = [], $content = null) {
    return array(
        "success" => $success,
        "messages" => $messages,
        "content" => $content
    );
}