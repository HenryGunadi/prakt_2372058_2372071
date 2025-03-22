<style>
    .custom-dropdown {
        position: relative;
        display: inline-block;
    }

    .custom-dropdown-button {
        background-color: #6c757d;
        color: white;
        padding: 10px 15px;
        border: none;
        cursor: pointer;
        border-radius: 5px;
        transition: background-color 0.3s ease;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .custom-dropdown-button:hover {
        background-color: #5a6268;
    }

    .custom-dropdown-menu {
        display: none;
        position: absolute;
        background-color: white;
        min-width: 160px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 5px;
        overflow: hidden;
        z-index: 1000;
        opacity: 0;
        transform: translateY(-10px);
        transition: opacity 0.3s ease, transform 0.3s ease;
    }

    .custom-dropdown-menu a {
        display: block;
        padding: 10px;
        color: black;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }

    .custom-dropdown-menu a:hover {
        background-color: #f1f1f1;
    }

    .custom-dropdown.show .custom-dropdown-menu {
        display: block;
        opacity: 1;
        transform: translateY(0);
    }

    .dropdown-icon {
        width: 24px;
        height: 24px;
        transition: transform 0.3s ease;
    }

    .custom-dropdown.show .dropdown-icon {
        transform: rotate(180deg);
    }
</style>

<body class="">
    <div class="p-4">
        <h3 class="text-secondary fs-4 pb-4 fw-normal">Pengajuan Surat</h3>

        <div class="custom-dropdown mb-4">
            <button class="custom-dropdown-button" onclick="toggleDropdown()">
                Pengajuan Surat
                <img src="{{ asset('asset/img/svg/chevron-down.svg') }}" alt="" class="dropdown-icon">
            </button>
            <div class="custom-dropdown-menu" id="dropdownMenu">
                <a onclick="toggleForm(event)" href="#" id="mahasiswa_aktif">Surat
                    Keterangan
                    Mahasiswa
                    Aktif</a>
                <a onclick="toggleForm(event)" href="#" id="mata_kuliah">Surat
                    Pengantar Tugas
                    Mata Kuliah</a>
                <a onclick="toggleForm(event)" href="#" id="ket_lulus">Surat
                    Keterangan
                    Lulus</a>
                <a onclick="toggleForm(event)" href="#" id="hasil_studi">Surat
                    Laporan Hasil
                    Studi</a>
            </div>
        </div>

        <form id="mainForm" class="d-none">
            @csrf

            <h6 class="subtitle mb-2"></h6>

            <div class="mb-3">
                <label for="nrp" class="form-label">NRP</label>
                <input type="text" class="form-control" id="nrp" maxlength='7' name='nrp' readonly
                    value="{{ $user->nrp }}">
            </div>
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama" name='nama' required readonly
                    value="{{ $user->nama }}">
            </div>

            <div id="formFields">
            </div>

            <button type="submit" class="btn btn-primary d-none" id="submitButton">Submit</button>
        </form>

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        let formIsOpen = {
            id: null,
            open: false
        };

        const subtitles = {
            mahasiswa_aktif: `
                Surat Keterangan Mahasiswa Aktif
            `,
            mata_kuliah: `
                Surat Pengantar Tugas Mata Kuliah
            `,
            ket_lulus: `
                Surat Keterangan Lulus
            `,
            hasil_studi: `
                Surat Laporan Hasil Studi
            `
        }

        const forms = {
            mahasiswa_aktif: `
            <input type="hidden" name="form_type" value="mahasiswa_aktif">
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <input type="text" class="form-control" id="alamat" name='alamat' readonly value="{{ $user->alamat }}">
            </div>
            <label for="semester" class="form-label">Semester : </label>
            <input type="text" class="form-control" id="semester" name='semester' readonly value="{{ $user->semester }}">

            <label for="keperluan" class="form-label">Keperluan</label>
            <textarea id="keperluan" cols="30" rows="4" class="form-control mb-3" name="keperluan"></textarea>
        `,
            mata_kuliah: `
            <input type="hidden" name="form_type" value="mata_kuliah">
            <div class="mb-3">
                <label for="mata_kuliah" class="form-label">Mata Kuliah</label>
                <input type="text" class="form-control" id="mata_kuliah" name='mata_kuliah' required>
            </div>
            <label for="subjek" class="form-label">Subjek</label>
            <input type="text" class="form-control mb-3" id="subjek" name='subjek' required>
            <label for="keperluan" class="form-label">Keperluan</label>
            <textarea id="keperluan" cols="30" rows="4" class="form-control mb-3" name='keperluan' required></textarea>
        `,
            ket_lulus: `
            <input type="hidden" name="form_type" value="ket_lulus">
        `,
            hasil_studi: `
            <input type="hidden" name="form_type" value="hasil_studi">

            <label for="keperluan" class="form-label">Keperluan</label>
            <textarea id="keperluan" cols="30" rows="4" class="form-control mb-3" name='keperluan' required></textarea>
        `
        };

        function toggleForm(event) {
            event.preventDefault();
            console.log("im clicked")

            const clickedID = event.target.id;
            const formContainer = document.getElementById("mainForm");
            const submitButton = document.getElementById("submitButton")
            const formField = document.getElementById("formFields");
            const subtitle = document.querySelector(".subtitle"

            )
            if (!formIsOpen.open) {
                formContainer.classList.toggle("d-none")
                submitButton.classList.toggle("d-none")
            }

            formField.innerHTML = forms[clickedID] || "<p>Form tidak ditemukan</p>";
            subtitle.innerHTML = subtitles[clickedID]
            formIsOpen.id = clickedID;
            formIsOpen.open = true;

            toggleDropdown()
        }

        document.getElementById('mainForm').addEventListener('submit', async function(event) {
            event.preventDefault();

            const formData = new FormData(this);
            const formObject = Object.fromEntries(formData.entries());

            try {
                const response = await axios.post('http://127.0.0.1:8000/user/surat', formData);
                alert('Form submitted successfully!');
                console.log(response.data);
            } catch (err) {
                console.error('Error submitting form:', err);
                alert('Failed to submit the form.');
            }
        });

        function toggleDropdown() {
            const dropdown = document.querySelector(".custom-dropdown");
            dropdown.classList.toggle("show");
        }

        document.addEventListener("click", function(event) {
            const dropdown = document.querySelector(".custom-dropdown");
            if (!dropdown.contains(event.target)) {
                dropdown.classList.remove("show");
            }
        });
    </script>
</body>
