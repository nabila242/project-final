<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - SCRI</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <style>
        :root {
            --bg-dark: #271a0c;
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-dark);
            color: white;
        }
        .glass-nav {
            background: rgba(39, 26, 12, 0.8);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .glass-card {
            background: rgba(39, 26, 12, 0.6);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 16px;
        }
        .nav-pills .nav-link {
            color: #ccc;
            border-radius: 10px;
            margin-bottom: 5px;
            text-align: left;
            padding: 12px 20px;
        }
        .nav-pills .nav-link.active {
            background-color: rgba(245, 158, 11, 0.2);
            color: #f59e0b;
            border-left: 4px solid #f59e0b;
            font-weight: 600;
        }
        .table {
            color: white;
        }
        .table th {
            border-bottom-color: rgba(255,255,255,0.1);
            background: rgba(0,0,0,0.2);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 1px;
        }
        .table td {
            border-bottom-color: rgba(255,255,255,0.05);
            background: transparent;
            vertical-align: middle;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg glass-nav fixed-top py-3">
        <div class="container-fluid px-4">
            <a class="navbar-brand fw-bold text-white" href="#">
                <i class="fa-solid fa-shield text-warning me-2"></i> SCRI Admin Center
            </a>
            
            <div class="d-flex align-items-center">
                <span class="text-muted me-4"><i class="fa-regular fa-user me-2"></i> {{ Auth::user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                        <i class="fa-solid fa-right-from-bracket me-1"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container-fluid" style="padding-top: 100px;">
        <div class="row g-4">
            
            <!-- Sidebar Tabs -->
            <div class="col-md-3 col-lg-2">
                <div class="nav flex-column nav-pills glass-card p-3" id="adminTabs" role="tablist">
                    <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#lexicons">
                        <i class="fa-solid fa-book-open me-2 w-20px"></i> Kamus Sentimen
                    </button>
                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#ports">
                        <i class="fa-solid fa-anchor me-2 w-20px"></i> Manajemen Pelabuhan
                    </button>
                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#articles">
                        <i class="fa-solid fa-newspaper me-2 w-20px"></i> Artikel Pakar
                    </button>
                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#countries">
                        <i class="fa-solid fa-globe me-2 w-20px"></i> Status Negara (API)
                    </button>
                </div>
            </div>

            <!-- Content Area -->
            <div class="col-md-9 col-lg-10">
                <div class="tab-content glass-card p-4 min-vh-100" id="adminTabsContent">
                    
                    <!-- 1. Kamus Sentimen -->
                    <div class="tab-pane fade show active" id="lexicons">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="mb-0">Daftar Kosakata Sentimen</h4>
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#addLexiconModal"><i class="fa-solid fa-plus"></i> Tambah Kosakata</button>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Kosakata</th>
                                        <th>Skor</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($lexicons as $lex)
                                    <tr>
                                        <td>{{ $lex->word }}</td>
                                        <td>
                                            <span class="badge {{ $lex->score > 0 ? 'bg-success' : 'bg-danger' }}">
                                                {{ $lex->score > 0 ? '+' : '' }}{{ $lex->score }}
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-light"><i class="fa-solid fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- 2. Manajemen Pelabuhan -->
                    <div class="tab-pane fade" id="ports">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="mb-0">Manajemen Pelabuhan Logistik</h4>
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#addPortModal"><i class="fa-solid fa-plus"></i> Tambah Pelabuhan</button>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Nama Pelabuhan</th>
                                        <th>Negara</th>
                                        <th>Ukuran</th>
                                        <th>Koordinat (Lat, Lng)</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($ports as $port)
                                    <tr>
                                        <td>{{ $port->name }}</td>
                                        <td>{{ $port->country ? $port->country->name : '-' }}</td>
                                        <td>{{ ucfirst($port->harbor_size) }}</td>
                                        <td>{{ $port->latitude }}, {{ $port->longitude }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-light"><i class="fa-solid fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- 3. Artikel Analisis Pakar -->
                    <div class="tab-pane fade" id="articles">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="mb-0">Artikel Analisis Pakar</h4>
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#addArticleModal"><i class="fa-solid fa-pen"></i> Tulis Artikel</button>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Judul Artikel</th>
                                        <th>Tanggal Publikasi (WIB)</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($articles as $art)
                                    <tr>
                                        <td>{{ $art->title }}</td>
                                        <td>{{ \Carbon\Carbon::parse($art->published_at)->timezone('Asia/Jakarta')->format('d M Y, H:i') }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-light"><i class="fa-solid fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="3" class="text-center text-muted">Belum ada artikel.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- 4. Manajemen Status Negara (API Optimization) -->
                    <div class="tab-pane fade" id="countries">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h4 class="mb-0">Manajemen Status Negara</h4>
                                <small class="text-muted">Matikan negara yang tidak pantau untuk menghemat kuota API harian.</small>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Negara</th>
                                        <th>Region</th>
                                        <th>Status Pantauan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($countries as $c)
                                    <tr>
                                        <td>
                                            <img src="{{ $c->flag_url }}" width="30" class="me-2 rounded">
                                            {{ $c->name }}
                                        </td>
                                        <td>{{ $c->region }}</td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" role="switch" checked>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- MODALS -->
    <!-- Add Lexicon Modal -->
    <div class="modal fade" id="addLexiconModal" tabindex="-1" data-bs-theme="dark">
        <div class="modal-dialog">
            <div class="modal-content glass-card text-white">
                <form action="{{ route('admin.lexicon.store') }}" method="POST">
                    @csrf
                    <div class="modal-header border-secondary">
                        <h5 class="modal-title">Tambah Kosakata Sentimen</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Kosakata</label>
                            <input type="text" name="word" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Sentimen / Skor</label>
                            <select name="type" class="form-select text-white bg-dark" required>
                                <option value="positive">Positif (e.g. +3)</option>
                                <option value="negative">Negatif (e.g. -5)</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Bobot Angka (Weight)</label>
                            <input type="number" name="weight" class="form-control" placeholder="Contoh: 5" required>
                        </div>
                    </div>
                    <div class="modal-footer border-secondary">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning text-white">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Port Modal -->
    <div class="modal fade" id="addPortModal" tabindex="-1" data-bs-theme="dark">
        <div class="modal-dialog">
            <div class="modal-content glass-card text-white">
                <form action="{{ route('admin.port.store') }}" method="POST">
                    @csrf
                    <div class="modal-header border-secondary">
                        <h5 class="modal-title">Tambah Pelabuhan Logistik</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Pelabuhan</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Negara</label>
                            <select name="country_id" class="form-select text-white bg-dark" required>
                                @foreach($countries as $c)
                                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label">Latitude</label>
                                <input type="number" step="0.000001" name="latitude" class="form-control" required>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label">Longitude</label>
                                <input type="number" step="0.000001" name="longitude" class="form-control" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ukuran Pelabuhan</label>
                            <select name="harbor_size" class="form-select text-white bg-dark" required>
                                <option value="large">Large</option>
                                <option value="medium">Medium</option>
                                <option value="small">Small</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer border-secondary">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning text-white">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Article Modal -->
    <div class="modal fade" id="addArticleModal" tabindex="-1" data-bs-theme="dark">
        <div class="modal-dialog modal-lg">
            <div class="modal-content glass-card text-white">
                <form action="{{ route('admin.article.store') }}" method="POST">
                    @csrf
                    <div class="modal-header border-secondary">
                        <h5 class="modal-title">Tulis Artikel Analisis Pakar</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Judul Artikel</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Isi Artikel</label>
                            <textarea name="content" class="form-control" rows="6" required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label">Terkait Negara</label>
                                <select name="country_id" class="form-select text-white bg-dark">
                                    <option value="">(Opsional) Pilih Negara</option>
                                    @foreach($countries as $c)
                                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label">Tingkat Risiko</label>
                                <select name="risk_level" class="form-select text-white bg-dark">
                                    <option value="low">Low</option>
                                    <option value="medium">Medium</option>
                                    <option value="high">High</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-secondary">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning text-white">Publikasikan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
