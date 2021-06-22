{{-- @extends('layouts.admin')
@section('styles')
<style>
.has-error {
    border-radius: .40px !important;
    border-color: rgb(185, 74, 72) !important;
}
</style>
@endsection
@section('content')
<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">
        <a class="btn btn-secondary" href="{{ route('admin.files.index') }}">
            {{ trans('global.back') }}
        </a>
    </div>
</div>
@livewire('create-file-component', ['series' => $series], key($series->id))
@endsection

@push('scripts')
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })

    function showExistingInfo() {
        $('#card-boay-section').slideDown(500, function(){
            $('#card-boay-section').slideDown(500);
        });
        $('.toggle-show-card').css("display", $('.toggle-show-card').css("display") === 'none' ? '' : 'none');
        $('.toggle-hide-card').css("display", $('.toggle-hide-card').css("display") === 'none' ? '' : 'none');
    }

    function showCard() {
        $('#card-boay-section').slideDown(500, function(){
            $('#card-boay-section').slideDown(500);
        });
        $('.toggle-show-card').css("display", $('.toggle-show-card').css("display") === 'none' ? '' : 'none');
        $('.toggle-hide-card').css("display", $('.toggle-hide-card').css("display") === 'none' ? '' : 'none');
    }

    function hideCard() {
        $('#card-boay-section').slideUp(500, function(){
            $('#card-boay-section').slideUp(500);
        });
        $('.toggle-show-card').css("display", $('.toggle-show-card').css("display") === 'none' ? '' : 'none');
        $('.toggle-hide-card').css("display", $('.toggle-hide-card').css("display") === 'none' ? '' : 'none');
    }

    function show() {
        $('#section').slideDown(500, function(){
            $('#section').slideDown(500);
        });
        $('.toggle-show').css("display", $('.toggle-show').css("display") === 'none' ? '' : 'none');
        $('.toggle-hide').css("display", $('.toggle-hide').css("display") === 'none' ? '' : 'none');
    }

    function hide() {
        $('#section').slideUp(500, function(){
            $('#section').slideUp(500);
        });
        $('.toggle-show').css("display", $('.toggle-show').css("display") === 'none' ? '' : 'none');
        $('.toggle-hide').css("display", $('.toggle-hide').css("display") === 'none' ? '' : 'none');
    }

    function showSeg1() {
        $('#section1').slideDown(500, function(){
            $('#section1').slideDown(500);
        });
        $('.toggle-show1').css("display", $('.toggle-show1').css("display") === 'none' ? '' : 'none');
        $('.toggle-hide1').css("display", $('.toggle-hide1').css("display") === 'none' ? '' : 'none');
    }

    function hideSeg1() {
        $('#section1').slideUp(500, function(){
            $('#section1').slideUp(500);
        });
        $('.toggle-show1').css("display", $('.toggle-show1').css("display") === 'none' ? '' : 'none');
        $('.toggle-hide1').css("display", $('.toggle-hide1').css("display") === 'none' ? '' : 'none');
    }

</script>
<script>
    $(document).ready(function(){
        $('#seg_break').click(function(){
            if($(this).prop("checked") == true){
                $('#break').slideDown(500, function(){
                    $('#break').slideDown(500);
                });
            }
            else if($(this).prop("checked") == false){
                $('#break').slideUp(500, function(){
                    $('#break').slideUp(500);
                });
                // $('#break').css("display", $('#break').css("display") === 'none' ? '' : 'none');
            }
        });
    });
</script>
@endpush --}}