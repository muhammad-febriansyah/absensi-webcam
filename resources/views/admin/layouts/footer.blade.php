@php
    $setting = \App\Models\Setting::first();
@endphp
<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">

            </div>
            <div class="col-sm-6">
                <div class="text-sm-end d-none d-sm-block">
                    <script>
                        document.write(new Date().getFullYear())
                    </script> © {{ $setting->site_name }}.
                </div>
            </div>
        </div>
    </div>
</footer>
