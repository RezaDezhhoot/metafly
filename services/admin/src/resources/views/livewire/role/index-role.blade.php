@use('App\Enums\PageAction')
<div wire:init="init">
    <x-admin.big-loader :loading="$loading" />
    @section('title', __('pages.pages.index',['item' => __('general.sidebar.roles')]) )
    <x-admin.form-control link="{{ route('role.store',[PageAction::CREATE] ) }}" title="{{ __('pages.pages.index',['item' => __('general.sidebar.roles')]) }}"/>
    <div class="card card-custom">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12 table-responsive">
                    <table class="table table-striped table-bordered" id="kt_datatable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('general.title') }}</th>
                            <th>{{ __('general.actions.actions') }}</th>
                        </tr>
                        </thead>
                        <tbody >
                        @forelse($roles as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->name }}</td>
                                <td>
                                    @if(! in_array($item->name,['admin','administrator']))
                                        <x-admin.edit-btn href="{{ route('role.store',[PageAction::UPDATE , $item->id]) }}"/>
                                        <x-admin.delete-btn onclick="deleteItem('{{$item->id}}')"  />
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <td class="text-center" colspan="4">
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
