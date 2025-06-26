
@extends('content.05.menu_akun')

@section('title', 'Lain Mata')

@section('breadcrumbs')

@endsection

@section('content')
<div class="content mt-3">
    @csrf
        <div class="animated fadeIn">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <strong>Data Akun Lain Mata</strong>
                    <div class="d-flex align-items-center">
                        <ol type="button" class="breadcrumb rounded mb-1 mr-3">
                            <li><a href="{{ route('akun.keseluruhan.tabel') }}">Beranda</a></li>
                        </ol>
                        <button type="button" class="btn btn-success rounded mb-1" data-toggle="modal" data-target="#exampleModal">
                            <i class="fa fa-plus"></i> Tambah
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Akun Lain Mata</h5>
                        <button type="button" class="fa fa-times" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="{{ route('akun.submit') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row form-group">
                                <label for="role_id" class="col-md-4 text-md-center">Role</label>
                                <div class="col col-md-7">
                                    <select name="role_id" id="role_id" class="form-control @error('role_id') is-invalid @enderror">
                                        <option value="">Pilih Role...</option>
                                        @foreach ($roles as $role)
                                            {{-- TAMBAHKAN data-rolename DI SINI --}}
                                            <option value="{{ $role->id }}" data-rolename="{{ strtolower($role->nama) }}">{{ $role->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('role_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row form-group" id="kecamatan-wrapper">
                                <label for="kecamatan_id" class="col-md-4 text-md-center">Kecamatan</label>
                                <div class="col-md-7">
                                    <select name="kecamatan_id" id="kecamatan_id" class="form-control">
                                        @foreach ($kecamatan as $kec)
                                            <option value="{{ $kec->id_kecamatan }}">{{ $kec->nama_kecamatan }}</option>
                                        @endforeach
                                    </select>
                                    @error('kecamatan_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row form-group">
                                <label for="nama_pengguna" class="col-md-4 text-md-center">Nama</label>
                                <div class="col col-md-7">
                                    <input name="nama_pengguna" type="text" id="nama_pengguna" class="form-control @error ('nama_pengguna') is-invalid @enderror" value="{{ old('nama_pengguna') }}">
                                    @error('nama_pengguna')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row form-group">
                                <label for="no_kontak" class="col-md-4 text-md-center">Nomor Kontak</label>
                                <div class="col col-md-7">
                                    <input name="no_kontak" type="text" id="no_kontak" class="form-control @error ('no_kontak') is-invalid @enderror" value="{{ old('no_kontak') }}">
                                    @error('no_kontak')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row form-group">
                                <label for="username" class="col-md-4 text-md-center">Username</label>
                                <div class="col col-md-7">
                                    <input name="username" type="text" id="username" class="form-control @error ('username') is-invalid @enderror" value="{{ old('username') }}">
                                    @error('username')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row form-group">
                                <label for="password" class="col-md-4 text-md-center">Password</label>
                                <div class="col col-md-7">
                                    <input name="password" type="text" id="password" class="form-control @error ('password') is-invalid @enderror" value="{{ old('password') }}"></div>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-success">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const roleSelect = document.getElementById('role_id');
                const kecamatanWrapper = document.getElementById('kecamatan-wrapper');
                const kecamatanSelect = document.getElementById('kecamatan_id');

                function toggleKecamatan() {
                    const selectedOption = roleSelect.options[roleSelect.selectedIndex];
                    const selectedRoleName = selectedOption.dataset.rolename; 

                    if (selectedRoleName === 'admin') {
                        kecamatanWrapper.style.display = 'flex'; 
                        kecamatanSelect.setAttribute('required', 'required'); 
                    } else {
                        kecamatanWrapper.style.display = 'none'; 
                        kecamatanSelect.removeAttribute('required'); 
                        kecamatanSelect.value = ''; 
                    }
                }

                toggleKecamatan();

                roleSelect.addEventListener('change', toggleKecamatan);

                @if ($errors->any())
                    $('#exampleModal').modal('show');
                    toggleKecamatan();
                @endif
            });
        </script>

        <div class="card-body table-responsive">
            <div class="row mb-4 align-items-stretch">
                @foreach ($jumlah_per_role as $role => $jumlah)
                    <div class="col mb-3">
                        <div class="card h-100 text-white 
                            @if ($role == 'admin') bg-primary
                            @elseif ($role == 'tamu') bg-warning
                            @elseif ($role == 'pimpinan') bg-success
                            @elseif ($role == 'teknisi') bg-danger
                            @elseif ($role == 'super admin') bg-danger
                            @else bg-secondary
                            @endif
                        rounded">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="fw-bold">Jumlah {{ ucfirst($role) }}</div>
                                    <h3>{{ $jumlah }}</h3>
                                </div>
                                <div>
                                    @if ($role == 'admin')
                                        <i class="fa fa-user-shield fa-2x"></i>
                                    @elseif ($role == 'tamu')
                                        <i class="fa fa-user fa-2x"></i>
                                    @elseif ($role == 'pimpinan')
                                        <i class="fa fa-user-tie fa-2x"></i>
                                    @elseif ($role == 'teknisi')
                                        <i class="fa fa-tools fa-2x"></i>
                                    @elseif ($role == 'super admin')
                                        <i class="fa fa-user-cog fa-2x"></i>
                                    @else
                                        <i class="fa fa-users fa-2x"></i>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="card-body" style="overflow-x: auto;">
                <div class="mb-3 d-flex justify-content-end">
                    <label class="mr-2 mt-1">Filter Role:</label>
                    <select id="filterRole" class="form-control w-auto">
                        <option value="">Semua</option>
                        @foreach ($roles as $role)
                            <option value="{{ strtolower($role->nama) }}">{{ ucfirst($role->nama) }}</option>
                        @endforeach
                    </select>
                </div>
                <table id="bootstrap-data-table" class="table table-bordered" style="min-width: 1000px;">
                    <thead>
                        <tr style="text-align:center;">
                            <th>No</th>
                            <th>Role</th>
                            <th>Nama</th>
                            <th>Nama Instansi</th>
                            <th>Jabatan</th>
                            <th>Kecamatan</th>
                            <th>Username</th>                             
                            <th>Aksi</th>                               
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pengguna as $id=>$db)
                            <tr data-role="{{ strtolower($db->role->nama) }}">
                                <td style="text-align:center;">{{ $id+1 }}</td>
                                <td style="text-align:center; vertical-align: middle;">{{ $db->role->nama }}</td>
                                <td>{{ $db->nama_pengguna }}</td>
                                <td>{{ $db->kecamatan->nama_kecamatan ?? '-' }}</td>
                                <td>{{ $db->nama_instansi ?? '-' }}</td>
                                <td>{{ $db->jabatan ?? '-' }}</td>
                                <td style="text-align:center; vertical-align: middle;">{{ $db->username }}</td>
                                <td style="text-align:center; vertical-align: middle;">
                                    <div class="d-flex justify-content-center gap-1">
                                        <button type="button" class="btn btn-info btn-sm rounded" data-toggle="modal" data-target="#modalReview{{ $db->id_pengguna }}">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-warning btn-sm rounded" data-toggle="modal" data-target="#editModal{{ $db->id_pengguna }}">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <form action="{{ route('akun.hapus', $db->id_pengguna) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus akun ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm rounded">
                                                <i class="fa fa-close"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            <!-- Modal Review Pengguna -->
                            <div class="modal fade" id="modalReview{{ $db->id_pengguna }}" tabindex="-1" aria-labelledby="modalLabel{{ $db->id_pengguna }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">

                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalLabel{{ $db->id_pengguna }}">Detail Pengguna</h5>
                                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Tutup"></button>
                                        </div>

                                        <div class="modal-body">
                                            <div class="container">

                                                {{-- Baris 1 --}}
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <div class="d-flex">
                                                            <strong class="me-2" style="min-width: 120px;">Nama:</strong>
                                                            <span>{{ $db->nama_pengguna }}</span>
                                                        </div>
                                                        <div class="d-flex">
                                                            <strong class="me-2" style="min-width: 120px;">NIK:</strong>
                                                            <span>{{ $db->nik }}</span>
                                                        </div>
                                                        <div class="d-flex">
                                                            <strong class="me-2" style="min-width: 120px;">Nama Instansi:</strong>
                                                            <span>{{ $db->nama_instansi }}</span>
                                                        </div>
                                                        <div class="d-flex">
                                                            <strong class="me-2" style="min-width: 120px;">Jabatan:</strong>
                                                            <span>{{ $db->jabatan }}</span>
                                                        </div>
                                                        <div class="d-flex">
                                                            <strong class="me-2" style="min-width: 120px;">No. Kontak:</strong>
                                                            @if ($db->no_kontak)
                                                                @php
                                                                    // Format nomor ke internasional (62)
                                                                    $noWa = preg_replace('/[^0-9]/', '', $db->no_kontak);
                                                                    if (substr($noWa, 0, 1) === '0') {
                                                                        $noWa = '62' . substr($noWa, 1);
                                                                    }
                                                                @endphp
                                                                <a href="https://wa.me/{{ $noWa }}" target="_blank" style="color: #25D366; text-decoration: none;">
                                                                    {{ $db->no_kontak }}
                                                                </a>
                                                            @else
                                                                <span>-</span>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="d-flex">
                                                            <strong class="me-2" style="min-width: 120px;">Username:</strong>
                                                            <span>{{ $db->username }}</span>
                                                        </div>
                                                        <div class="d-flex">
                                                            <strong class="me-2" style="min-width: 120px;">Role:</strong>
                                                            <span>{{ $db->role->nama }}</span>
                                                        </div>
                                                        <div class="d-flex">
                                                            <strong class="me-2" style="min-width: 120px;">Kecamatan:</strong>
                                                            <span>{{ $db->kecamatan->nama_kecamatan ?? '-' }}</span>
                                                        </div>
                                                        <div class="d-flex">
                                                            <strong class="me-2" style="min-width: 120px;">Email:</strong>
                                                            <span>{{ $db->email ?? '-' }}</span>
                                                        </div>
                                                        <div class="d-flex">
                                                            <strong class="me-2" style="min-width: 120px;">Auth Type:</strong>
                                                            <span>{{ $db->auth_type ?? '-' }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <!-- Modal Edit -->
                            <div class="modal fade" id="editModal{{ $db->id_pengguna }}" tabindex="-1" aria-labelledby="editModalLabel{{ $db->id_pengguna }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <form method="post" action="{{ route('akun.edit', $db->id_pengguna) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Akun</h5>
                                                <button type="button" class="close" data-dismiss="modal">
                                                    <span>&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="role_id">Role</label>
                                                    <select name="role_id" id="role_id" class="form-control" required>
                                                        @foreach ($roles as $role)
                                                            <option value="{{ $role->id }}"
                                                                data-rolename="{{ strtolower($role->nama) }}"
                                                                {{ $role->id == $db->role_id ? 'selected' : '' }}>
                                                                {{ $role->nama }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-group" id="kecamatan-wrapper" style="display: none;">
                                                    <label for="kecamatan_id">Kecamatan</label>
                                                        <select name="kecamatan_id" id="kecamatan_id" class="form-control">
                                                            @foreach ($kecamatan as $kec)
                                                                <option value="{{ $kec->id_kecamatan }}"
                                                                    {{ $kec->id_kecamatan == $db->kecamatan_id ? 'selected' : '-' }}>
                                                                    {{ $kec->nama_kecamatan }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="nama_pengguna">Nama</label>
                                                    <input type="text" name="nama_pengguna" class="form-control"
                                                        value="{{ old('nama_pengguna', $db->nama_pengguna) }}" required>
                                                </div>

                                                <div class="form-group">
                                                    <label for="no_kontak">Nomor Kontak</label>
                                                    <input type="text" name="no_kontak" class="form-control"
                                                        value="{{ old('no_kontak', $db->no_kontak) }}" required>
                                                </div>

                                                <!-- Username -->
                                                <div class="form-group">
                                                    <label for="username">Username</label>
                                                    <input type="text" name="username" class="form-control"
                                                        value="{{ old('username', $db->username) }}" required>
                                                </div>
                                                <!-- Password -->
                                                <div class="form-group">
                                                    <label for="password">Password</label>
                                                    <input type="text" name="password" class="form-control"
                                                        value="{{ old('password') }}">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>    
                        @endforeach
                    </tbody>
                </table>
            </div>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
            <script>
                $(document).ready(function () {
                    $('#bootstrap-data-table').DataTable({
                        "paging": true,       // pagination aktif
                        "searching": true,    // fitur pencarian aktif
                        "ordering": true,     // fitur sorting aktif
                        "order": [],          // default: tidak ada sorting aktif
                        "columnDefs": [
                            { "orderable": false, "targets": [7] }
                        ],
                        "language": {
                            decimal: ",",
                            thousands: ".",
                            emptyTable: "Tidak ada data yang tersedia pada tabel",
                            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                            infoEmpty: "Menampilkan 0 sampai 0 dari 0 entri",
                            infoFiltered: "(disaring dari _MAX_ entri keseluruhan)",
                            infoPostFix: "",
                            lengthMenu: "Tampilkan _MENU_ entri",
                            loadingRecords: "Memuat...",
                            processing: "Memproses...",
                            search: "Cari:",
                            zeroRecords: "Tidak ditemukan data yang sesuai",
                            paginate: {
                                first: "Pertama",
                                last: "Terakhir",
                                next: "Berikutnya",
                                previous: "Sebelumnya"
                            }
                        }
                    });
                });

                document.addEventListener('DOMContentLoaded', function () {
                    const modals = document.querySelectorAll('[id^="editModal"]'); // Ambil semua modal edit

                    modals.forEach(modal => {
                        const roleSelect = modal.querySelector('[name="role_id"]');
                        const kecamatanWrapper = modal.querySelector('#kecamatan-wrapper');
                        const kecamatanSelect = modal.querySelector('[name="kecamatan_id"]');
                        const nomorKontakInput = modal.querySelector('[name="nomor_kontak"]');

                        function toggleKecamatanField() {
                            const selectedOption = roleSelect.options[roleSelect.selectedIndex];
                            const selectedRoleName = selectedOption.dataset.rolename;

                            console.log('Selected Role Name:', selectedRoleName); // debug output

                            if (selectedRoleName === 'admin') {
                                kecamatanWrapper.style.display = 'flex';
                                kecamatanSelect.setAttribute('required', 'required');

                                if (kecamatanSelect.value === '-') {
                                    kecamatanSelect.value = '';
                                }

                                if (nomorKontakInput && nomorKontakInput.value === '-') {
                                    nomorKontakInput.value = '';
                                }
                            } else {
                                kecamatanWrapper.style.display = 'none';
                                kecamatanSelect.removeAttribute('required');
                                kecamatanSelect.value = '-';

                                if (nomorKontakInput && nomorKontakInput.value.trim() === '') {
                                    nomorKontakInput.value = '-';
                                }
                            }
                        }

                        // Event saat ganti role
                        roleSelect.addEventListener('change', toggleKecamatanField);

                        // Event saat modal ditampilkan
                        $(modal).on('shown.bs.modal', function () {
                            toggleKecamatanField();
                        });
                    });
                    
                    document.getElementById('filterRole').addEventListener('change', function () {
                        const selectedRole = this.value.toLowerCase();
                        const rows = document.querySelectorAll('#bootstrap-data-table tbody tr');

                        rows.forEach(row => {
                            const rowRole = row.getAttribute('data-role');
                            row.style.display = (selectedRole === '' || rowRole === selectedRole) ? '' : 'none';
                        });
                    });
                });
            </script>
        </div>
</div>
@endsection