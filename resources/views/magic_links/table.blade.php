<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table" id="magic-links-table">
            <thead>
            <tr>
                <th>Hash</th>
                <th>User Id</th>
                <th>Expires At</th>
                <th>Is Active</th>
                <th colspan="3">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($magicLinks as $magicLink)
                <tr>
                    <td>{{ $magicLink->hash }}</td>
                    <td>{{ $magicLink->user_id }}</td>
                    <td>{{ $magicLink->expires_at }}</td>
                    <td>{{ $magicLink->is_active ? 'Active' : 'Inactive' }}</td>
                    <td  style="width: 120px">
                        {!! Form::open(['route' => ['magicLinks.destroy', $magicLink->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('magicLinks.show', [$magicLink->id]) }}"
                               class='btn btn-default btn-xs'>
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="{{ route('magicLinks.edit', [$magicLink->id]) }}"
                               class='btn btn-default btn-xs'>
                                <i class="far fa-edit"></i>
                            </a>
                            {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                        </div>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="card-footer clearfix">
        <div class="float-right">
            @include('adminlte-templates::common.paginate', ['records' => $magicLinks])
        </div>
    </div>
</div>
