<footer class="py-4 bg-light mt-auto">
    <div class="container-fluid px-4">
        <div class="d-flex align-items-center justify-content-between small">
            <div class="text-muted">Copyright &copy;
                <a href="{{ App\Models\Setting::where('slug', 'website-url')->get()->first()->description }}" target="_blank">{{ App\Models\Setting::where('slug', 'nama-toko')->get()->first()->description }}</a> {{ date('Y') }}
            </div>
            <div>
                {{-- <a href="#">Privacy Policy</a>
                &middot;
                <a href="#">Terms &amp; Conditions</a> --}}
            </div>
        </div>
    </div>
</footer>
