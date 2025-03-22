<div class="users-table table-wrapper">
    <table class="posts-table">
        <thead>
            <tr class="users-table-info">
                <th>
                    <label class="users-table__checkbox ms-20">
                        <input type="checkbox" class="check-all">All
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
                    <tr>
                        <td>
                            <label class="users-table__checkbox">
                                <input type="checkbox" class="check">
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
                        <td>{{ $surat->created_at }}</td>
                        <td>
                            <span class="p-relative">
                                <button class="dropdown-btn transparent-btn" type="button" title="More info">
                                    <div class="sr-only">More info</div>
                                    <i data-feather="more-horizontal" aria-hidden="true"></i>
                                </button>
                                <ul class="users-item-dropdown dropdown">
                                    <li><a href="##">Details</a></li>
                                </ul>
                            </span>
                        </td>
                    </tr>
                @endforeach
            @endif
    </table>
</div>
