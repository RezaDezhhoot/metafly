@use('App\Enums\PageAction')
<div wire:init="init">
    <x-admin.big-loader :loading="$loading" />
    @section('title', __('pages.pages.index',['item' => __('general.sidebar.points')]) )
    <x-admin.form-control link="{{ route('point.store',[PageAction::CREATE] ) }}" title="{{__('general.sidebar.points')}}"/>
    <div class="card card-custom">
        <div class="card-body">
            @include('livewire.includes.advance-table')
            <div class="row">
                <div class="col-12  table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('general.id') }}</th>
                            <th>{{ __('general.country') }}</th>
                            <th>{{ __('general.city') }}</th>
                            <th>{{ __('general.actions.actions') }}</th>
                        </tr>
                        </thead>
                        <tbody >
                        @forelse($items as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->country?->label() }}</td>
                                <td>{{ $item->city }}</td>
                                <td>
                                    <x-admin.edit-btn href="{{ route('point.store',[PageAction::UPDATE , $item->id]) }}"/>
                                    <x-admin.delete-btn onclick="deleteItem('{{$item->id}}')"  />
                                </td>
                            </tr>
                        @empty
                            <td class="text-center" colspan="16">
                                {{ __('general.messages.no_data') }}
                            </td>
                        @endforelse
                        </tbody>
                        <tbody wire:loading >
                        <x-admin.big-loader :table="true" width="20" height="20" />
                        </tbody>
                    </table>
                </div>
            </div>
            @if(sizeof($items) > 0)
                {{$items->links('layouts.paginate')}}
            @endif
        </div>
    </div>
</div>
@push('scripts')
    <script>
        function deleteItem(id) {
            Swal.fire({
                title: '{{ __('general.actions.delete_item') }}',
                text: '{{ __('general.messages.delete_item') }}',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: '{{ __('general.actions.no') }}',
                confirmButtonText: '{{ __('general.actions.yes') }}',
            }).then((result) => {
                if (result.value) {
                @this.call('deleteItem', id)
                }
            })
        }
    </script>
@endpush
