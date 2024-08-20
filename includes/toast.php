<?php  
function set_message($message) {
    $_SESSION["message"] = $message;
}

function get_message() {
    if (isset($_SESSION["message"])) {
        echo '
        <div class="toast mt-4 bottom-0 mb-3 end-0 position-fixed" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto">Afro Diva CMS</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">' . $_SESSION["message"] . '
            </div>
        </div>';

        unset($_SESSION["message"]);
    }
}
?>
