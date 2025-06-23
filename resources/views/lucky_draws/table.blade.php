<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table" id="lucky-draws-table">
            <thead>
            <tr>
                <th>User Id</th>
                <th>Random Number</th>
                <th>Result</th>
                <th>Win Amount</th>
                <th colspan="3">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($luckyDraws as $luckyDraw)
                <tr>
                    <td>{{ $luckyDraw->user_id }}</td>
                    <td>{{ $luckyDraw->random_number }}</td>
                    <td>{{ $luckyDraw->result }}</td>
                    <td>{{ $luckyDraw->win_amount }}</td>
                    <td  style="width: 120px">
                        {!! Form::open(['route' => ['luckyDraws.destroy', $luckyDraw->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('luckyDraws.show', [$luckyDraw->id]) }}"
                               class='btn btn-default btn-xs'>
                                <i class="far fa-eye"></i>
                            </a>
                        </div>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="card-footer clearfix">
        <div class="float-right"></div>
    </div>
</div>
