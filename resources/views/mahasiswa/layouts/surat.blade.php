<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
        <h2 class="main-title">History Surat</h2>
        <div>
            <label for="statusFilter">Filter Status:</label>
            <select id="statusFilter" style="padding: 6px 10px; border-radius: 6px;">
                <option value="all">All</option>
                <option value="applied">Applied</option>
                <option value="rejected">Rejected</option>
                <option value="approved">Approved</option>
            </select>
        </div>
    </div>

    <div class="users-table table-wrapper">
        <table class="posts-table">
            <thead>
                <tr class="users-table-info">
                    <th>
                        <label class="ms-20">
                            Jenis Surat
                        </label>
                    </th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($surats->isEmpty())
                    <tr>
                        <td colspan="5" class="text-center">No data available</td>
                    </tr>
                @else
                    @foreach ($surats as $surat)
                    <tr
                        data-id="{{ $surat->id }}"
                        data-jenis="{{ $surat->jenis }}"
                        data-nama="{{ $surat->mahasiswa->nama ?? '' }}"
                        data-status="{{ strtolower($surat->status) }}"
                        data-tanggal="{{ $surat->created_at->format('d M Y') }}"
                        @if($surat->suratDetails)
                            data-subjek="{{ $surat->suratDetails->subjek }}"
                            data-keperluan="{{ $surat->suratDetails->keperluan }}"
                            data-matkul="{{ $surat->suratDetails->mata_kuliah }}"
                            data-semester="{{ $surat->suratDetails->semester }}"
                        @endif
                        style="cursor: pointer" > 
                            <td>
                                <label class="users-table__checkbox">
                                    <!-- <input type="checkbox" class="check"> -->
                                    <h6>{{ $surat->jenis }}</h6>
                                </label>
                            </td>
                            <td>
                                <span
                                    class="
                                    {{ $surat->status === 'applied'
                                        ? 'badge-pending'
                                        : ($surat->status === 'rejected'
                                            ? 'badge-trashed'
                                            : ($surat->status === 'approved'
                                                ? 'badge-active'
                                                : 'badge-success')) }}">
                                    {{ ucfirst($surat->status) }}
                                </span>
                            </td>
                            <td>{{ $surat->created_at->format('d M Y')}}</td>
                            <td>
                                @if ($surat->status === 'approved')
                                    <span class="text-warning">On Progress</span>
                                @elseif ($surat->status === 'rejected')
                                    <span class="text-danger">Ditolak</span>
                                @elseif ($surat->status === 'finished' && $surat->file_pdf)
                                    <a href="{{ route('mahasiswa.surat.download', $surat->file_pdf) }}" class="btn btn-success" style="font-size: 12px;">Download Surat</a>
                                @else
                                    <span class="text-primary">Waiting</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @endif
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

        <!-- Accept/Reject Form -->
        <form id="actionForm" method="POST">
            @csrf
            <input type="hidden" name="_method" id="methodField" value="POST">
            <input type="hidden" name="surat_id" id="suratIdField">

            <div style="text-align: right;">
                @if ($surat->status === 'applied')
                    <button name="action" value="delete" type="submit"
                        onclick="setFormMethod('DELETE')"
                        style="background-color: #e74c3c; color: white; padding: 8px 14px; border: none; border-radius: 6px; margin-right: 8px;">
                        Delete
                    </button>
                    <button id="openEditModal" name="action" value="edit" type="button"
                        onclick="setFormMethod('PUT')"
                        style="background-color: #2ecc71; color: white; padding: 8px 14px; border: none; border-radius: 6px;">
                        Edit
                    </button>
                @endif
            </div>
        </form>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="modal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color: rgba(0,0,0,0.5); z-index:9999;">
    <div style="background:#fff; width:500px; margin:100px auto; padding:20px; border-radius:10px; position:relative;">
        <span id="closeEditModal" style="position:absolute; top:10px; right:15px; font-size:20px; cursor:pointer;">&times;</span>
        <h3>Edit Surat</h3>
        <form id="editForm" method="POST">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="surat_id" id="editSuratId">

            <!-- Inject dynamic fields here -->
            <div id="dynamicEditFormFields"></div>

            <div style="text-align: right;">
                <button type="submit" class="btn btn-primary">Submit Edit</button>
            </div>
        </form>
    </div>
</div>


<script>
    document.querySelectorAll('.posts-table tbody tr').forEach(row => {
        row.addEventListener('click', () => {
            const jenis = row.dataset.jenis;
            const nama = row.dataset.nama;
            const status = row.dataset.status;
            const tanggal = row.dataset.tanggal;

            document.getElementById('modalJenis').textContent = jenis;
            document.getElementById('modalNama').textContent = nama;
            document.getElementById('modalStatus').textContent = status;
            document.getElementById('modalDate').textContent = tanggal;

            const suratId = row.dataset.id;
            document.getElementById('actionForm').action = `/mahasiswa/edit/${suratId}`;
            document.getElementById('suratIdField').value = suratId;

            setOptionalField("modalSubjek", row.dataset.subjek);
            setOptionalField("modalKeperluan", row.dataset.keperluan);
            setOptionalField("modalMatkul", row.dataset.matkul);
            setOptionalField("modalSemester", row.dataset.semester);

            const buttonContainer = document.querySelector('#actionForm div');
            if (status.toLowerCase() === 'applied') {
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
    
    function setFormMethod(method) {
        document.getElementById('methodField').value = method;
    }

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

    document.getElementById('openEditModal').addEventListener('click', () => {
    // Hide detail modal
        document.getElementById('suratModal').style.display = 'none';

        // Get selected row
        const selectedRow = [...document.querySelectorAll('.posts-table tbody tr')]
            .find(row => row.dataset.id === document.getElementById('suratIdField').value);

        // Get surat ID and jenis
        const suratId = selectedRow.dataset.id;
        const jenis = selectedRow.dataset.jenis;

        // Set surat ID to the form
        document.getElementById('editSuratId').value = suratId;

        // Inject form fields based on jenis
        const fieldsContainer = document.getElementById('dynamicEditFormFields');
        fieldsContainer.innerHTML = forms[jenis] || '';

        // Fill values if exist in dataset
        if (selectedRow.dataset.alamat)
            document.querySelector('#dynamicEditFormFields input[name="alamat"]').value = selectedRow.dataset.alamat;

        if (selectedRow.dataset.semester)
            document.querySelector('#dynamicEditFormFields input[name="semester"]').value = selectedRow.dataset.semester;

        if (selectedRow.dataset.subjek)
            document.querySelector('#dynamicEditFormFields input[name="subjek"]').value = selectedRow.dataset.subjek;

        if (selectedRow.dataset.matkul)
            document.querySelector('#dynamicEditFormFields input[name="mata_kuliah"]').value = selectedRow.dataset.matkul;

        if (selectedRow.dataset.keperluan)
            document.querySelector('#dynamicEditFormFields textarea[name="keperluan"]').value = selectedRow.dataset.keperluan;

        // Show edit modal
        document.getElementById('editModal').style.display = 'block';
    });


    document.getElementById('closeEditModal').addEventListener('click', () => {
        document.getElementById('editModal').style.display = 'none';
    });

</script>