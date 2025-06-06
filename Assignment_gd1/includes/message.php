<?php
if (isset($_SESSION['message']) && !empty($_SESSION['message']['success'])) {
    echo "<div class='alert alert-success'>" .
        $_SESSION['message']['success'] .
        "</div>";
} else if (isset($_SESSION['message']) && !empty($_SESSION['message']['error'])) {
    echo "<div class='alert alert-danger'>" .
        $_SESSION['message']['error'] .
        "</div>";
}