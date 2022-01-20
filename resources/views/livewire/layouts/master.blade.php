<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="{{ config('app.name') }}">
    <meta name="keywords" content="{{ config('app.name') }}">
    <meta name="author" content="{{ config('app.name') }}">
    <meta name="generator" content="Ercan Bilgin - https://twitter.com/_ercanbilgin">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"><!-- CSRF Token -->
    <title>{{ config('app.name') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">

    @livewireStyles
    @stack('style')
</head>
<body>

    {{ $slot }}

    <div id="toasts-list" class="position-fixed top-0 end-0 p-3" style="z-index: 99999"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    @livewireScripts
    <script>
        let makeToast = function (params) {
            let toastHtmlId = 'toast-item_' + Math.floor(Math.random() * 100000) + 1
            let toastHtmlClass = '';
            let title = 'Alert';
            let message = '';

            if (typeof params.title !== 'undefined') title = params.title;
            if (typeof params.message !== 'undefined') message = params.message;

            if (typeof params.type !== 'undefined') {
                switch(params.type) {
                    case 'success':
                        toastHtmlClass = 'bg-success text-white';
                        break;
                    case 'danger':
                        toastHtmlClass = 'bg-danger text-white';
                        break;
                    case 'warning':
                        toastHtmlClass = 'bg-warning';
                        break;
                    default:
                        toastHtmlClass = '';
                }
            }

            let html =
                '<div id="' + toastHtmlId + '" class="toast hide mb-2 ' + toastHtmlClass + '" role="alert" aria-live="assertive" aria-atomic="true">' +
                '<div class="toast-header ' + toastHtmlClass + '">' +
                '<strong class="me-auto">' + title + '</strong>' +
                '<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>' +
                '</div>' +
                '<div class="toast-body">' + message + '</div>' +
                '</div>';

            let listEl = document.getElementById('toasts-list');
            listEl.innerHTML = listEl.innerHTML + html;

            let toastElList = [].slice.call(document.querySelectorAll('.toast'))
            let toastList = toastElList.map(function(toastEl) {
                return new bootstrap.Toast(toastEl) // No need for options; use the default options
            });
            //toastList.forEach(toast => toast.show()); // This show them
            toastList.slice(-1).pop().show();
        };

        window.livewire.on('make-toast', params => makeToast(params));
    </script>
    @stack('javascript')
</body>
</html>
