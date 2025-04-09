<main class="main users chart-page" id="skip-target">

<div class="container ">
        <h2 class="main-title">Pengajuan Surat Mahasiswa</h2>
</div>

    <div class="users-table table-wrapper">
        <table class="posts-table">
            <thead>
                <tr class="users-table-info">
                    <th>Type Surat</th>
                    <th>Mahasiswa</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @if ($surats->isEmpty())
                    <tr>
                        <td colspan="4" class="text-center">No data available</td>
                    </tr>
                @else
                    @foreach ($surats as $surat)
                        <tr>
                            <td>
                                <h5>{{ $surat->jenis }} </h5>
                            </td>
                            <td>
                                <h5>{{ $surat->mahasiswa->nama }}</h5>
                            </td>
                            <td>
                                <span class="
                                    {{ $surat->status === 'applied'
                                        ? 'badge-pending'
                                        : ($surat->status === 'rejected'
                                            ? 'badge-trashed'
                                            : ($surat->status === 'finished'
                                                ? 'badge-success'
                                                : 'badge-active')) }}">
                                    {{ ucfirst($surat->status) }}
                                </span>
                            </td>
                            <td>{{ $surat->created_at->format('d M Y') }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</main>