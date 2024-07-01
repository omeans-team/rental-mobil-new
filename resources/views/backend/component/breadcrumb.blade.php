<h1 class="mt-4">{{ ucfirst(basename(Request::url())) }}</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">{{ ucfirst(basename(Request::url())) }}</li>
</ol>
