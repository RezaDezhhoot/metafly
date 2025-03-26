@use('App\Enums\PageAction')
<div wire:init="init">
    <x-admin.big-loader :loading="$loading" />
    @section('title', __('pages.pages.index',['item' => __('general.sidebar.topics')]) )
    <x-admin.form-control link="{{ route('topic.store',[PageAction::CREATE] ) }}" title="{{__('general.sidebar.topics')}}"/>

    <div class="card card-custom">
        <div class="card-body">
            @include('livewire.includes.advance-table')
            <div class="row">
                <div class="col-12  table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('general.title') }}</th>
                            <th>{{ __('general.actions.actions') }}</th>
                        </tr>
                        </thead>
                        <tbody >
                        @forelse($items as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->title }}</td>
                                <td>
                                    <x-admin.edit-btn href="{{ route('topic.store',[PageAction::UPDATE , $item->id]) }}"/>
                                    <x-admin.delete-btn onclick="deleteItem('{{$item->id}}')"/>
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
                @this.call('remove', id)
                }
            })
        }
    </script>
@endpush
