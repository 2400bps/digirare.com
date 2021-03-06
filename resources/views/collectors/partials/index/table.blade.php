<div class="card mb-4">
    <div class="card-header">
        <span class="lead font-weight-bold">
            {{ __('Top 100') }}
            <small class="ml-1 text-muted">{{ __(title_case($sort)) }}</small>
        </span>
    </div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th scope="col" style="width: 50px">#</th>
                    <th scope="col">{{ __('Address') }}</th>
                    <th scope="col">{{ __('Unique Cards') }}</th>
                    <th scope="col">{{ __('Trades') }}</th>
                    <th scope="col">{{ __('First Card') }}</th>
                    <th scope="col">{{ __('First Seen') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($collectors as $collector)
                <tr>
                    <th scope="row">{{ $loop->iteration }}.</th>
                    <td><a href="{{ $collector->url }}">{{ $collector->xcp_core_address }}</a></td>
                    <td>{{ number_format($collector->card_balances_count) }}</td>
                    <td>{{ number_format($collector->trades_count) }}</td>
                    <td><a href="{{ route('cards.show', ['card' => $collector->firstCard->asset]) }}">{{ $collector->firstCard->asset }}</a></td>
                    <td>{{ $collector->firstCard->confirmed_at->toDateString() }}</td>
                </tr>
                @endforeach
                @if($collectors->count() === 0)
                    <tr>
                        <td colspan="6" class="text-center"><em>{{ __('None Found') }}</em></td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>