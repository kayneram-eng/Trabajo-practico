<?php
class Toast {
    public static function success($mensaje) {
        $_SESSION['toast'] = "success|✔️ $mensaje";
    }

    public static function info($mensaje) {
        $_SESSION['toast'] = "info|⚠️ $mensaje ⚠️";
    }

    public static function warning($mensaje) {
        $_SESSION['toast'] = "warning|✏️ $mensaje";
    }

    public static function error($mensaje) {
        $_SESSION['toast'] = "error|🗑️ $mensaje";
    }

    public static function show() {
        // if(isset($_SESSION['toast'])) {
        //     $toast = explode('|', $_SESSION['toast']);
        //     echo "<script>toastr.{$toast[0]}('{$toast[1]}');</script>";
        //     unset($_SESSION['toast']);
        // }
        if(isset($_SESSION['toast'])) {
            $toast = explode('|', $_SESSION['toast']);
            echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        toastr.options = {
                            'closeButton': true,
                            'progressBar': true,
                            'positionClass': 'toast-top-right',
                            'timeOut': '4000'
                        };
                        toastr.{$toast[0]}('{$toast[1]}');
                    });
                  </script>";
            unset($_SESSION['toast']);
        }
    }
}
?>