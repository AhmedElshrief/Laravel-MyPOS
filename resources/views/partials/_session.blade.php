<!-- Notyfication plugins -->

@if (session('success'))

    <script>

        new Noty({

            theme: 'metroui',
            type: 'success',
            layout: 'topRight',
            text: "{{ session('success') }}",
            timeout: 2500,
            killer: true

        }).show();

    </script>

@endif

