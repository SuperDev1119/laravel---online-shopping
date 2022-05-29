@php $push_linkings = App\Models\PushLinking::ordered()->get() @endphp

@if($push_linkings->isNotEmpty())
  <div class="box-home box-home--linking container">
    <h2 class="text-center">{{ _i("À découvrir") }}</h2>
    <div class="box-home--linking--content">
      <div class="row">
        @foreach($push_linkings as $push_linking)
          <div class="col-md-3 col-sm-6 col-xs-12">
            <a href="{{ $push_linking->link }}">{{ $push_linking->title }}</a>
          </div>
        @endforeach
      </div>
    </div>
  </div>
@endif
