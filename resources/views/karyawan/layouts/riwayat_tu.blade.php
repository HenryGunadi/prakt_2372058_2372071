<style>
    tr.cursor-pointer {
        cursor: pointer;
    }

    .bodys {
        background-color: white; /* Disarankan agar teks terbaca */
    }

    .rowws {
        cursor: pointer;
    }

    .posts-table tbody tr {
        cursor: pointer;
    }

    #statusFilter {
        font-size: 14px;
        border: 1px solid #ccc;
    }

    
</style>

<main class="main users chart-page" id="skip-target">
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
            <h2 class="main-title">Pengajuan Surat Mahasiswa</h2>
        </div>

        @if (session('success'))
        <div style="background-color: #d4edda; color: #155724; padding: 10px 15px; margin-bottom: 20px; border-radius: 6px;">
            {{ session('success') }}
        </div>
        @endif

        <div class="users-table table-wrapper">
            <table class="posts-table">
                <thead>
                    <tr class="users-table-info">
                        <th>Tipe Surat</th>
                        <th>Status</th>
                        <th>Mahasiswa</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody class="bodys">
                    @if ($surats->isEmpty())
                        <tr>
                            <td colspan="4" class="text-center">No data available</td>
                        </tr>
                    @else
                        @foreach ($surats as $surat)
                        @if ($surat->status == 'finished')
                            <tr class="users-table-item {{ $surat->status === 'finished' ? 'rowws' : '' }}"
                                data-id="{{ $surat->id }}"
                                data-jenis="{{ $surat->jenis }}"
                                data-nama="{{ $surat->mahasiswa->nama }}"
                                data-status="{{ strtolower($surat->status) }}"
                                data-tanggal="{{ $surat->created_at->format('d M Y') }}"
                                @if($surat->suratDetails)
                                    data-subjek="{{ $surat->suratDetails->subjek }}"
                                    data-keperluan="{{ $surat->suratDetails->keperluan }}"
                                    data-matkul="{{ $surat->suratDetails->mata_kuliah }}"
                                    data-semester="{{ $surat->suratDetails->semester }}"
                                @endif
                            >
                                <td><h5>{{ $surat->jenis }}</h5></td>
                                <td>
                                    <span class="{{ $surat->status === 'finished' ? 'badge-success' : ($surat->status === 'rejected' ? 'badge-trashed' : ($surat->status === 'finished' ? 'badge-success' : 'badge-active')) }}">
                                        {{ ucfirst($surat->status) }}
                                    </span>
                                </td>
                                <td><h5>{{ $surat->mahasiswa->nama }}</h5></td>
                                <td>{{ $surat->created_at->format('d M Y') }}</td>
                            </tr>
                        @endif
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div id="suratModal" class="modal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color: rgba(0,0,0,0.5); z-index:9999;">
        <div style="background:#fff; width:500px; margin:100px auto; padding:20px; border-radius:10px; position:relative;">
            <span id="closeModal" style="position:absolute; top:10px; right:15px; font-size:20px; cursor:pointer;">&times;</span>
            <h3>Detail Surat</h3>
            <div id="modalContent" style="margin-bottom: 20px;">
                <p><strong>Jenis:</strong> <span id="modalJenis"></span></p>
                <p><strong>Mahasiswa:</strong> <span id="modalNama"></span></p>
                <p><strong>Status:</strong> <span id="modalStatus"></span></p>
                <p><strong>Tanggal:</strong> <span id="modalDate"></span></p>
                <p id="modalSubjek" style="display:none;"><strong>Subjek:</strong> <span></span></p>
                <p id="modalKeperluan" style="display:none;"><strong>Keperluan:</strong> <span></span></p>
                <p id="modalMatkul" style="display:none;"><strong>Mata Kuliah:</strong> <span></span></p>
                <p id="modalSemester" style="display:none;"><strong>Semester:</strong> <span></span></p>
            </div>
            <form id="actionForm" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="surat_id" id="suratIdField">
                <div>
                    <!-- optional buttons or actions here -->
                </div>
            </form>
        </div>
    </div>
</main>

<script>
    document.querySelectorAll('.posts-table tbody tr').forEach(row => {
        row.addEventListener('click', () => {
            console.log('Row clicked:', row);
            const jenis = row.dataset.jenis;
            const nama = row.dataset.nama;
            const status = row.dataset.status;
            const tanggal = row.dataset.tanggal;

            document.getElementById('modalJenis').textContent = jenis;
            document.getElementById('modalNama').textContent = nama;
            document.getElementById('modalStatus').textContent = status;
            document.getElementById('modalDate').textContent = tanggal;

            const suratId = row.dataset.id;
            document.getElementById('actionForm').action = `/karyawan/surat/${suratId}`;
            document.getElementById('suratIdField').value = suratId;

            setOptionalField("modalSubjek", row.dataset.subjek);
            setOptionalField("modalKeperluan", row.dataset.keperluan);
            setOptionalField("modalMatkul", row.dataset.matkul);
            setOptionalField("modalSemester", row.dataset.semester);

            const buttonContainer = document.querySelector('#actionForm div');
            if (status.toLowerCase() === 'finished') {
                buttonContainer.style.display = 'block';
            } else {
                buttonContainer.style.display = 'none';
            }

            document.getElementById('suratModal').style.display = 'block';
        });
    });

    document.getElementById('closeModal').addEventListener('click', () => {
        document.getElementById('suratModal').style.display = 'none';
    });

    function setOptionalField(id, value) {
        const wrapper = document.getElementById(id);
        if (value) {
            wrapper.style.display = "block";
            wrapper.querySelector("span").textContent = value;
        } else {
            wrapper.style.display = "none";
        }
    }

    document.getElementById('statusFilter').addEventListener('change', function () {
        const selectedStatus = this.value;
        document.querySelectorAll('.posts-table tbody tr').forEach(row => {
            const rowStatus = row.dataset.status?.toLowerCase();
            if (selectedStatus === 'all' || rowStatus === selectedStatus) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
