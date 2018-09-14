<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-header">
                <span class="lead font-weight-bold">
                    {{ __('Collectors') }}
                    <small class="ml-1 text-muted">{{ number_format($balances->total()) }} {{ __('Found') }}</small>
                </span>
            </div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 50px">#</th>
                            <th scope="col">{{ __('Address') }}</th>
                            <th scope="col">{{ __('Balance') }}</th>
                            <th scope="col">{{ __('Last Change') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($balances as $balance)
                        <tr>
                            <th scope="row">{{ $loop->iteration + (($request->input('page', 1) - 1) * 100) }}.</th>
                            <td><a href="{{ route('collectors.show', ['collector' => $balance->address]) }}">{{ $balance->address }}</a></td>
                            <td>{{ $token && ! $token->divisible ? number_format($balance->quantity_normalized) : number_format($balance->quantity_normalized, 8) }}</td>
                            <td>{{ $balance->confirmed_at->toDateString() }}</td>
                        </tr>
                        @endforeach
                        @if($balances->count() === 0)
                            <tr>
                                <td colspan="4" class="text-center"><em>{{ __('None Found') }}</em></td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
{!! $balances->links() !!}