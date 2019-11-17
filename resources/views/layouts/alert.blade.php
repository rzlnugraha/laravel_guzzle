@if (session('success'))
<div class="alert alert-info alert-block col-lg-12">
    <button type="buton" class="close" data-dismiss="alert">x</button>
    <strong> {!! session('success') !!} </strong>
</div>
@endif
@if (session('error'))
<div class="alert alert-danger alert-block col-lg-12">
    <button type="buton" class="close" data-dismiss="alert">x</button>
    <strong> {!! session('error') !!} </strong>
</div>
@endif